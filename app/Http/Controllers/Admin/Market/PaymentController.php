<?php

namespace App\Http\Controllers\Admin\Market;

use App\Http\Controllers\Controller;
use App\Models\Market\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function all()
    {
        $payments = Payment::orderBy('created_at', 'desc')->simplePaginate(15);
        $title = 'تمامی پرداخت ها';
        return view('admin.market.payment.index', compact('payments','title'));
    }
    public function online()
    {
        $payments = Payment::where('paymentable_type', 'App\Models\Market\OnlinePayment')->get();
        $title = 'پرداخت های آنلاین';
        return view('admin.market.payment.index', compact('payments','title'));
    }
    public function offline()
    {
        $payments = Payment::where('paymentable_type', 'App\Models\Market\OfflinePayment')->get();
        $title = 'پرداخت های آفلاین';
        return view('admin.market.payment.index', compact('payments','title'));
    }
    public function cash()
    {
        $payments = Payment::where('paymentable_type', 'App\Models\Market\CashPayment')->get();
        $title = 'پرداخت های در محل';
        return view('admin.market.payment.index', compact('payments','title'));
    }

    public function show(Payment $payment)
    {
        return view('admin.market.payment.show', compact('payment'));
        
    }
    public function canceled(Payment $payment)
    {
        $payment->status = 2;
        $payment->save();
        return redirect()->route('admin.market.payment.all')->with('swal-success', 'تغییرات با موفقیت اعمال شد');
    }


    public function returned(Payment $payment)
    {
        $payment->status = 3;
        $payment->save();
        return redirect()->route('admin.market.payment.all')->with('swal-success', 'تغییرات با موفقیت اعمال شد');
    }
}
