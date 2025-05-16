<?php

namespace App\Http\Controllers\Customer\Profile;

use App\Http\Controllers\Controller;
use App\Http\Requests\Customer\Profile\UpdateProfileRequest;
use App\Http\Services\Message\Email\EmailService;
use App\Http\Services\Message\MessageService;
use App\Http\Services\Message\SMS\SmsService;
use App\Models\Otp;
use App\Models\User;
use DateInterval;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;

class ProfileController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        return view('customer.profile.index', compact('user'));
    }

    public function update(UpdateProfileRequest $request)
    {
        $inputs = [
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'national_code' => $request->national_code,
        ];

        $user = auth()->user();
        $user->update($inputs);
        return back()->with('toast-success', 'حساب کاربری شما با موفقیت ویرایش شد');
    }


    public function createOtp($input, $type, $userId)
    {
        // create otp code
        $otpCode = rand(111111, 999999);
        $token = Str::random(60);
        $otpInputs = [
            'token' => $token,
            'user_id' => $userId,
            'otp_code' => $otpCode,
            'login_id' => $input,
            'type' => $type
        ];

        $newOtp = Otp::create($otpInputs);
        return $newOtp;
    }
    public function checkOldOtp($input, $type)
    {
        $oldOtp = Otp::where('login_id', $input)->where('used', 0)->orderBy('created_at', 'desc')->first();
        if ($oldOtp) {

            $minutes_to_add = 2;
            $expired = new DateTime($oldOtp->created_at);
            $expired->add(new DateInterval('PT' . $minutes_to_add . 'M'));
            $now = new DateTime();
            $timer = ((new \Carbon\Carbon($oldOtp->created_at))->addMinutes(2)->timestamp - \Carbon\Carbon::now()->timestamp) * 1000;

            if ($now < $expired) {
                return redirect()->route('customer.profile.user-contact-confirm', $oldOtp->token)->with('timer', $timer);
            }

        }
    }

    public function sendEmail($input, $code)
    {
        $emailService = new EmailService();
        $details = [
            'title' => 'ایمیل فعال سازی حساب کاربری',
            'body' => "کد فعال سازی حساب کاربری شما : $code"
        ];
        $emailService->setDetails($details);
        $emailService->setFrom('noreply@example.com', 'amazon');
        $emailService->setSubject('کد احراز هویت');
        $emailService->setTo($input);
        $messageService = new MessageService($emailService);
        $messageService->send();
    }

    public function sendSms($input, $code)
    {
        $smsService = new SmsService();
        $smsService->setFrom(Config::get('sms.otp_from'));
        $smsService->setTo(['0' . $input]);
        $smsService->setText("مجموعه آمازون\n کد تأیید شما : $code");
        $smsService->setIsFlash(true);
        $messageService = new MessageService($smsService);
        $messageService->send();
    }

    public function emailConfirm(Request $request)
    {
        $request->validate([
            'email' => 'required|min:11|max:64|email'
        ]);
        $inputs = $request->all();
       
        // check id is email or not;
        if (filter_var($inputs['email'], FILTER_VALIDATE_EMAIL)) {
            $type = 1;  //id is an email            
            $oldUser = User::where('email', $inputs['email'])->first();
            if($oldUser)
            {
                return to_route('customer.profile.index')->with('toast-error', 'اطلاعات تکراری است');
            } 
        }
        $user = auth()->user();
        // if otp was sent; don't resend it until expired
        $this->checkOldOtp($inputs['email'], $type);
        $otp = $this->createOtp($inputs['email'], $type, $user->id);

        // send mail to confirm new email
        $this->sendEmail($inputs['email'], $otp->otp_code);
        return redirect()->route('customer.profile.user-contact-confirm', $otp->token);
    }

    public function mobileConfirm(Request $request)
    {
        $request->validate([
            'mobile' => 'required|min:11|max:11'
        ]);
        $inputs = $request->all();

        if (preg_match('/^(\+98|98|0)9\d{9}$/', $request->mobile)) {
            $type = 0;

            // all mobile number are in one format 9** *** ****
            $inputs['mobile'] = ltrim($request->mobile, '0');
            $inputs['mobile'] = substr($inputs['mobile'], 0, 2) === '98' ? substr($inputs['mobile'], 2) : $inputs['mobile'];
            $inputs['mobile'] = str_replace('+98', '', $inputs['mobile']);
            $oldUser = User::where('mobile', $inputs['mobile'])->first();
            if($oldUser)
            {
                return to_route('customer.profile.index')->with('toast-error', 'اطلاعات تکراری است');
            }

        } else {
            $errorText = 'شناسه ورودی شما ایمیل یا شماره موبایل نیست';
            return back()->with('errors', $errorText);
        }
        $user = auth()->user();
        // if otp was sent; don't resend it until expired
        $this->checkOldOtp($inputs['mobile'], $type);
        $otp = $this->createOtp($inputs['mobile'], $type, $user->id);

        // send sms to confirm new mobile
        $this->sendSms($inputs['mobile'], $otp->otp_code);
        return redirect()->route('customer.profile.user-contact-confirm', $otp->token);
    }

    public function userCantactConfirmForm($token)
    {
        $otp = Otp::where('token', $token)->first();
        if (empty($otp)) {
            return redirect()->route('customer.profile.index')->withErrors(['mobile' => 'آدرس وارد شده معتبر نیست']);
        }
        return view('customer.profile.user-contact-confirm-form', compact('token', 'otp'));
    }

    public function userCantactConfirm($token, Request $request)
    {
        $inputs = $request->all();
        $otp = Otp::where('token', $token)->where('used', 0)->where('created_at', '>=', Carbon::now()->subMinute(2)->toDateTimeString())->first();
        if (empty($otp)) {
            return redirect()->route('customer.profile.user-contact-confirm-form', $token)->withErrors(['id' => 'آدرس وارد شده معتبر نیست']);
        }
        // if otp code missmatch:
        if ($otp->otp_code !== $inputs['otp']) {
            return redirect()->route('customer.profile.user-contact-confirm-form', $token)->withErrors(['otp' => 'کد وارد شده صحیح نیست']);
        }
        // if everything is ok:
        $otp->update(['used' => 1]);
        $user = $otp->user()->first();
        if ($otp->type == 0) {
            $user->update(['mobile_verified_at' => Carbon::now(), 'mobile' => $otp->login_id]);
        } elseif ($otp->type == 1) {
            $user->update(['email_verified_at' => Carbon::now(), 'email' => $otp->login_id]);
        }
        Auth::login($user);
        return redirect()->route('customer.profile.index')->with('toast-success', 'شماره موبایل با موفقیت تغییر کرد');
    }

    public function profileResendOtp($token)
    {

        $otp = Otp::where('token', $token)->where('created_at', '<=', Carbon::now()->subMinute(2)->toDateTimeString())->first();
        if (empty($otp)) {
            return redirect()->route('customer.profile.index', $token)->withErrors(['id' => 'آدرس وارد شده معتبر نیست']);
        }

        $user = $otp->user()->first();
        // create otp code
        $newOtp = $this->createOtp($otp->login_id,$otp->type,$user->id);

        // send sms or email

        if ($otp->type == 0) {
            // send sms
           $this->sendSms($newOtp->login_id, $newOtp->otp_code);

        } elseif ($otp->type == 1) {
           $this->sendEmail($newOtp->login_id, $newOtp->otp_code);
        }
        return redirect()->route('customer.profile.user-contact-confirm-form', $token);
    }
}
