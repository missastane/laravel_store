<?php

namespace App\Http\Controllers\Admin\Notify;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Notify\EmailRequest;
use App\Http\Services\Message\Email\EmailService;
use App\Http\Services\Message\MessageService;
use App\Jobs\SendMailToUsers;
use App\Models\Notify\Email;
use App\Models\User;
use Illuminate\Http\Request;

class EmailController extends Controller
{
    public function index()
    {
        $emails = Email::orderBy('created_at')->simplePaginate(15);
        return view('admin.notify.email.index', compact('emails'));
    }

    public function search(Request $request)
    {
        $emails = Email::where('subject', 'LIKE', "%" . $request->search . "%")->orWhere('body', 'LIKE', "%" . $request->search . "%")->orderBy('subject')->get();
        return view('admin.notify.email.index', compact('emails'));
    }
    public function create()
    {
        return view('admin.notify.email.create');
    }

    public function store(EmailRequest $request)
    {
        date_default_timezone_set('Iran');
        $realTimestamp = substr($request['published_at'], 0, 10);
        $request['published_at'] = date("Y-m-d H:i:s", (int) $realTimestamp);
        $inputs = $request->all();
        $email = Email::create($inputs);
        if ($email) {
            return redirect()->route('admin.notify.email.index')->with('swal-success', 'ایمیل با عنوان ' . $email->subject . ' با موفقیت افزوده شد');
        }
        return redirect()->route('admin.notify.email.create')->with('swal-error', 'مشکلی پیش آمده است. لطفا مجددا امتحان کنید');
    }

    public function show(Email $email)
    {
        return view('admin.notify.email.show', compact('email'));
    }

    public function status(Email $email)
    {
        $email->status = $email->status == 1 ? 2 : 1;
        $result = $email->save();
        if ($result) {
            if ($email->status == 1) {
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


    public function edit(Email $email)
    {
        return view('admin.notify.email.edit', compact('email'));
    }

    public function update(EmailRequest $request, Email $email)
    {
        date_default_timezone_set('Iran');
        $realTimestamp = substr($request['published_at'], 0, 10);
        $request['published_at'] = date("Y-m-d H:i:s", (int) $realTimestamp);
        $inputs = $request->all();
        $result = $email->update($inputs);
        if ($result) {
            return redirect()->route('admin.notify.email.index')->with('swal-success', 'ایمیل با عنوان ' . $email->subject . ' با موفقیت ویرایش شد');
        }
        return redirect()->route('admin.notify.email.edit', $email->id)->with('swal-error', 'مشکلی پیش آمده است. لطفا مجددا امتحان کنید');
    }

    public function destroy(Email $email)
    {
        $result = $email->delete();
        if ($result) {
            return redirect()->route('admin.notify.email.index')->with('swal-success', 'ایمیل با عنوان ' . $email->subject . ' با موفقیت حذف شد');
        }
        return redirect()->route('admin.notify.email.index')->with('swal-error', 'مشکلی پیش آمده است. لطفا مجددا امتحان کنید');
    }

    public function sendMail(Email $email)
    {
        SendMailToUsers::dispatch($email);
        return back()->with('swal-success', 'ایمیل ' . $email->subject . ' با موفقیت ارسال شد');
    }
}
