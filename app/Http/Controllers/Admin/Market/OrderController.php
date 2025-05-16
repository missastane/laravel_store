<?php

namespace App\Http\Controllers\Admin\Market;

use App\Http\Controllers\Controller;
use App\Models\Market\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function all()
    {
        $orders = Order::orderBy('created_at', 'desc')->simplePaginate(15);
        $title = 'همه سفارش ها';
        return view('admin.market.order.index', compact('orders', 'title'));
    }
    public function newOrder()
    {
        $orders = Order::where('order_status', 0)->orderBy('created_at', 'desc')->simplePaginate(15);
        $title = 'سفارش های جدید';
        foreach ($orders as $order) {
            $order->order_status = 1;
            $result = $order->save();
        }
        return view('admin.market.order.index', compact('orders', 'title'));
    }
    public function sendingOrder()
    {
        $orders = Order::where('delivery_status', 1)->orderBy('created_at', 'desc')->simplePaginate(15);
        $title = 'سفارش های در حال ارسال';
        return view('admin.market.order.index', compact('orders', 'title'));
    }
    public function unpaidOrder()
    {
        $orders = Order::where('payment_status', 0)->orderBy('created_at', 'desc')->simplePaginate(15);
        $title = 'سفارش های پرداخت نشده';
        return view('admin.market.order.index', compact('orders', 'title'));
    }
    public function canceledOrder()
    {
        $orders = Order::where('order_status', 4)->orderBy('created_at', 'desc')->simplePaginate(15);
        $title = 'سفارش های باطل شده';
        return view('admin.market.order.index', compact('orders', 'title'));
    }
    public function returnedOrder()
    {
        $orders = Order::where('order_status', 5)->orderBy('created_at', 'desc')->simplePaginate(15);
        $title = 'سفارش های مرجوع شده';
        return view('admin.market.order.index', compact('orders', 'title'));
    }
    public function create()
    {
        // 
    }
    public function show(Order $order)
    {
        return view('admin.market.order.show', compact('order'));
    }
    public function detail(Order $order)
    {
        return view('admin.market.order.detail', compact('order'));
    }
    public function store()
    {

    }
    public function changeSendStatus(Order $order)
    {
        switch ($order->delivery_status) {
            case 0:
                $order->delivery_status = 1;
                break;
            case 1:
                $order->delivery_status = 2;
                break;
            case 2:
                $order->delivery_status = 3;
                break;
            default:
                $order->delivery_status = 0;
        }
        $order->save();
        return back();

    }
    public function changeOrderStatus(Order $order)
    {
        switch ($order->order_status) {
            case 1:
                $order->order_status = 2;
                break;
            case 2:
                $order->order_status = 3;
                break;
            case 3:
                $order->order_status = 4;
                break;
            case 4:
                $order->order_status = 5;
                break;
            
            default:
                $order->order_status = 1;
        }
        $order->save();
        return back();
    }
    public function cancelOrder(Order $order)
    {
        $order->order_status = 4;
        $order->save();
        return back();
    }
    
    public function postalTrackingCode(Order $order,Request $request)
    {
       
        $request->validate([
            'postal_tracking_code'=>'required|max:20|min:20'
        ]);
        $inputs['postal_tracking_code'] = $request->postal_tracking_code;

        $order->update(['postal_tracking_code'=> $inputs['postal_tracking_code']]);
        return back()->with('swal-success', 'کد رهگیری با موفقیت ثبت شد. در صورت تمایل می توانید ویرایش کنید');

    }
    
}
