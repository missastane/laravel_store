<?php

namespace App\Http\Controllers\Admin\Notify;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Notify\SMSRequest;
use App\Http\Services\Message\MessageService;
use App\Http\Services\Message\SMS\SmsService;
use App\Jobs\SendSMSToUsers;
use App\Models\Notify\SMS;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class SmsController extends Controller
{
    public function index()
    {
        $msgs = SMS::orderBy('created_at', 'desc')->simplePaginate(15);
        return view('admin.notify.sms.index', compact('msgs'));
    }
    public function search(Request $request)
    {
        $msgs = SMS::where('title', 'LIKE', "%" . $request->search . "%")->orWhere('body', 'LIKE', "%" . $request->search . "%")->orderBy('title')->get();
        return view('admin.notify.sms.index', compact('msgs'));
    }

    public function create()
    {
        return view('admin.notify.sms.create');
    }

    public function store(SMSRequest $request)
    {
        date_default_timezone_set('Iran');
        $realTimestamp = substr($request['published_at'], 0, 10);
        $request['published_at'] = date("Y-m-d H:i:s", (int) $realTimestamp);
        $inputs = $request->all();
        $sms = SMS::create($inputs);
        if ($sms) {
            return redirect()->route('admin.notify.sms.index')->with('swal-success', 'پیامک با عنوان ' . $sms->title . ' با موفقیت افزوده شد');
        }
        return redirect()->route('admin.notify.sms.create')->with('swal-error', 'مشکلی پیش آمده است. لطفا مجددا امتحان کنید');

    }

    public function status(SMS $sms)
    {
        $sms->status = $sms->status == 1 ? 2 : 1;
        $result = $sms->save();
        if ($result) {
            if ($sms->status == 1) {
                return response()->json([
                    'status' => true,
                    'checked' => true,
                    'message' => 'وضعیت با موفقیت فعال شد'
                ]);
            } else {
                return response()->json([
                    'status' => true,
                    'checked' => false,
                    'message' => 'وضعیت با موفقیت غیرفعال شد'
                ]);
            }
        } else {
            return response()->json([
                'status' => false,
                'message' => 'عملیات با خطا مواجه شد. دوباره امتحان کنید'
            ]);
        }
    }

    public function edit(SMS $sms)
    {
        return view('admin.notify.sms.edit', compact('sms'));
    }

    public function update(SMSRequest $request, SMS $sms)
    {
        date_default_timezone_set('Iran');
        $realTimestamp = substr($request['published_at'], 0, 10);
        $request['published_at'] = date("Y-m-d H:i:s", (int) $realTimestamp);
        $inputs = $request->all();
        $result = $sms->update($inputs);
        if ($result) {
            return redirect()->route('admin.notify.sms.index')->with('swal-success', 'پیامک با عنوان ' . $sms->title . ' با موفقیت ویرایش شد');
        }
        return redirect()->route('admin.notify.sms.edit', $sms->id)->with('swal-error', 'مشکلی پیش آمده است. لطفا مجددا امتحان کنید');
    }

    public function destroy(SMS $sms)
    {
        $result = $sms->delete();
        if ($result) {
            return redirect()->route('admin.notify.sms.index')->with('swal-success', 'پیامک با عنوان ' . $sms->title . ' با موفقیت حذف شد');
        }
        return redirect()->route('admin.notify.sms.index')->with('swal-error', 'مشکلی پیش آمده است. لطفا مجددا امتحان کنید');
    }

    public function sendSms(SMS $sms)
    {
        // dd($sms);
        SendSMSToUsers::dispatch($sms);
        return back()->with('swal-success', 'ارسال پیامک با موفقیت انجام شد');
    }
}
