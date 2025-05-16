<?php

namespace App\Http\Controllers\Customer\SalesProcess;

use App\Http\Controllers\Controller;
use App\Http\Requests\Customer\UserProfileRequest;
use App\Http\Services\Message\Email\EmailService;
use App\Http\Services\Message\MessageService;
use App\Http\Services\Message\SMS\SmsService;
use App\Models\Market\CartItem;
use App\Models\Otp;
use DateInterval;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
class ProfileCompletionController extends Controller
{
    public function profileCompletion()
    {
        $user = Auth::user();
        $cartItems = CartItem::where('user_id', $user->id)->get();
        return view('customer.sales-process.profile-completion', compact('cartItems', 'user'));
    }

    public function updateProfile(UserProfileRequest $request)
    {
        $national_code = convertArabicToEnglish($request->national_code);
        $national_code = convertPersianToEnglish($national_code);
        $user = Auth::user();
        $inputs = [
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'national_code' => $request->national_code,

        ];
        if (isset($request->mobile) && empty($user->mobile)) {
            $mobile = convertArabicToEnglish($request->mobile);
            $mobile = convertPersianToEnglish($mobile);

            if (preg_match('/^(\+98|98|0)9\d{9}$/', $mobile)) {
                $type = 0; //0 => mobile
                $mobile = ltrim($mobile, '0');
                $mobile = substr($mobile, 0, 2) === '98' ? substr($mobile, 2) : $mobile;
                $mobile = str_replace('+98', '', $mobile);
                $login_id = $mobile;
                $inputs['mobile'] = $mobile;
            } else {
                $error_text = 'فرمت شماره موبایل معتبر نیست';
                return redirect()->back()->withErrors(['mobile' => $error_text]);
            }
            if (isset($request->email) && empty($user->email)) {
                $type = 1; //0 => email
                $email = convertArabicToEnglish($request->email);
                $email = convertPersianToEnglish($email);
                $login_id = $email;
                $inputs['email'] = $email;
            }
            $inputs = array_filter($inputs);

            if (!empty($inputs)) {
                $user->update($inputs);
            }

            // if otp was sent; don't resend it until expired
            if ($type == 0) {
                $oldOtp = Otp::where('login_id', $inputs['mobile'])->where('used', 0)->orderBy('created_at', 'desc')->first();
            } else {
                $oldOtp = Otp::where('login_id', $inputs['email'])->where('used', 0)->orderBy('created_at', 'desc')->first();

            }
            // dd($oldOtp);
            if ($oldOtp) {
                $minutes_to_add = 2;
                $expired = new DateTime($oldOtp->created_at);
                $expired->add(new DateInterval('PT' . $minutes_to_add . 'M'));
                $now = new DateTime();
                $timer = ((new \Carbon\Carbon($oldOtp->created_at))->addMinutes(2)->timestamp - \Carbon\Carbon::now()->timestamp) * 1000;

                if ($now < $expired) {
                    return redirect()->route('customer.sales-process.profile-info-confirm-form', $oldOtp->token)->with('timer', $timer);
                }
            }
            // create otp code
            $otpCode = rand(111111, 999999);
            $token = Str::random(60);
            $otpInputs = [
                'token' => $token,
                'user_id' => $user->id,
                'otp_code' => $otpCode,
                'login_id' => $login_id,
                'type' => $type
            ];
            Otp::create($otpInputs);

            // send sms or email

            if ($type == 0 && !isset($user->mobile_verified_at)) {
                // send sms
                $smsService = new SmsService();
                $smsService->setFrom(Config::get('sms.otp_from'));
                $smsService->setTo(['0' . $user->mobile]);
                $smsService->setText("مجموعه آمازون\n کد تأیید شما : $otpCode");
                $smsService->setIsFlash(true);

                $messageService = new MessageService($smsService);

            } elseif ($type == 1 && !isset($user->email_verified_at)) {
                $emailService = new EmailService();
                $details = [
                    'title' => 'ایمیل فعال سازی حساب کاربری',
                    'body' => "کد فعال سازی حساب کاربری شما : $otpCode"
                ];
                $emailService->setDetails($details);
                $emailService->setFrom('noreply@example.com', 'amazon');
                $emailService->setSubject('کد احراز هویت');
                $emailService->setTo($user->email);
                $messageService = new MessageService($emailService);

            }
            $messageService->send();
            return redirect()->route('customer.sales-process.profile-info-confirm-form', $token);
        }
        $info = array_filter($inputs);
        $user->update($info);
        return redirect()->route('customer.sales-process.address-and-delivery');


    }

    public function confirmProfileInfoForm($token)
    {
        $otp = Otp::where('token', $token)->where('used', 0)->first();
        $user = Auth::user();
        $cartItems = CartItem::where('user_id', $user->id)->get();
        if (empty($otp)) {
            return redirect()->route('customer.sales-process.profile-completion', ['user' => $user, 'cartItems' => $cartItems])->withErrors(['mobile' => 'آدرس وارد شده معتبر نیست']);
        }
        return view('customer.sales-process.profile-info-confirm', compact('token', 'otp', 'user', 'cartItems'));
    }

    public function confirmProfileInfo($token, Request $request)
    {
        $request->validate([
            'otp' => 'required|min:6|max:6'
        ]);
        $inputs = $request->all();
        $user = Auth::user();
        $cartItems = CartItem::where('user_id', $user->id)->get();
        $otp = Otp::where('token', $token)->where('used', 0)->where('created_at', '>=', Carbon::now()->subMinute(2)->toDateTimeString())->first();
        if (empty($otp)) {
            return redirect()->route('customer.sales-process.profile-completion', ['user' => $user, 'cartItems' => $cartItems, $token])->withErrors(['mobile' => 'آدرس وارد شده معتبر نیست']);
        }
        // if otp code missmatch:
        if ($otp->otp_code !== $inputs['otp']) {
            return redirect()->route('customer.sales-process.profile-completion', ['user' => $user, 'cartItems' => $cartItems, $token])->withErrors(['otp' => 'کد وارد شده صحیح نیست']);
        }
        // if everything is ok:
        $otp->update(['used' => 1]);
        $confirmedUser = $otp->user()->first();
        if ($otp->type == 0 && empty($confirmedUser->mobile_verified_at)) {
            $confirmedUser->update(['mobile_verified_at' => Carbon::now()]);
        } elseif ($otp->type == 1 && empty($confirmedUser->email_verified_at)) {
            $confirmedUser->update(['email_verified_at' => Carbon::now()]);
        }
        // dd('hi');
        return redirect()->route('customer.sales-process.address-and-delivery');
        // dd('salam');
    }


    public function resendOtp($token)
    {
        $otp = Otp::where('token', $token)->where('used', 0)->where('created_at', '<=', Carbon::now()->subMinute(2)->toDateTimeString())->first();
        $user = Auth::user();
        $cartItems = CartItem::where('user_id', $user->id)->get();
        if (empty($otp)) {
            return redirect()->route('customer.sales-process.profile-completion', ['user' => $user, 'cartItems' => $cartItems, $token])->withErrors(['mobile' => 'آدرس وارد شده معتبر نیست']);
        }
        $user = $otp->user()->first();
        // create otp code
        $otpCode = rand(111111, 999999);
        $token = Str::random(60);
        $otpInputs = [
            'token' => $token,
            'user_id' => $user->id,
            'otp_code' => $otpCode,
            'login_id' => $otp->login_id,
            'type' => $otp->type
        ];
        Otp::create($otpInputs);

        // send sms or email

        if ($otp->type == 0 && !isset($user->mobile_verified_at)) {
            // send sms
            $smsService = new SmsService();
            $smsService->setFrom(Config::get('sms.otp_from'));
            $smsService->setTo(['0' . $user->mobile]);
            $smsService->setText("مجموعه آمازون\n کد تأیید شما : $otpCode");
            $smsService->setIsFlash(true);

            $messageService = new MessageService($smsService);

        } elseif ($otp->type == 1 && !isset($user->email_verified_at)) {
            $emailService = new EmailService();
            $details = [
                'title' => 'ایمیل فعال سازی حساب کاربری',
                'body' => "کد فعال سازی حساب کاربری شما : $otpCode"
            ];
            $emailService->setDetails($details);
            $emailService->setFrom('noreply@example.com', 'amazon');
            $emailService->setSubject('کد احراز هویت');
            $emailService->setTo($otp->login_id);
            $messageService = new MessageService($emailService);

        }
        $messageService->send();
        return redirect()->route('customer.sales-process.profile-info-confirm-form', $token);
    }
}
