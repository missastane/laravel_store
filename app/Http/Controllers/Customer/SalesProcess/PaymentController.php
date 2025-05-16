<?php

namespace App\Http\Controllers\Customer\SalesProcess;

use App\Http\Controllers\Controller;
use App\Http\Services\Payment\PaymentService;
use App\Models\Market\CartItem;
use App\Models\Market\CashPayment;
use App\Models\Market\Copan;
use App\Models\Market\Delivery;
use App\Models\Market\OfflinePayment;
use App\Models\Market\OnlinePayment;
use App\Models\Market\Order;
use App\Models\Market\OrderItem;
use App\Models\Market\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    public function payment()
    {
        $user = auth()->user();
        $cartItems = CartItem::where('user_id', $user->id)->get();
        $order = Order::where('user_id', auth()->user()->id)->where('order_status', 0)->first();
        return view('customer.sales-process.payment', compact('cartItems', 'order'));
    }

    public function copanDisount(Request $request)
    {
        $request->validate([
            'copan_id' => 'required|exists:copans,code'
        ]);

        $copan = Copan::where([['code', $request->copan_id], ['status', 1], ['end_date', '>', now()], ['start_date', '<', now()]])->first();
        if ($copan != null) {
            if ($copan->user_id != null) {
                $copan = Copan::where([['code', $request->copan_id], ['status', 1], ['end_date', '>', now()], ['start_date', '<', now()], ['user_id', auth()->user()->id]])->first();
                if ($copan == null) {
                    return redirect()->back()->with('toast-error', 'شما مجوز استفاده از این کد تخفیف را ندارید');
                }
            }
            $order = Order::where('user_id', auth()->user()->id)->where('order_status', 0)->where('copan_id', null)->first();

            if ($order) {
                if ($copan->amount_type == 2) {
                    $copanDiscountAmount = $order->order_final_amount * ($copan->amount / 100);
                    if ($copanDiscountAmount > $copan->discount_ceiling) {
                        $copanDiscountAmount = $copan->discount_ceiling;
                    }

                } else {
                    $copanDiscountAmount = $copan->amount;
                    if ($copanDiscountAmount > $copan->discount_ceiling) {
                        $copanDiscountAmount = $copan->discount_ceiling;
                    }
                }

                $delivery = Delivery::find($order->delivery_id);
                $order->update([
                    'copan_id' => $copan->id,
                    'order_copan_discount_amount' => $copanDiscountAmount,
                    'copan_object' => json_encode($copan),
                    'order_total_products_discount_amount' => $order->order_total_products_discount_amount + $copanDiscountAmount,
                    'order_final_amount' => ($order->order_final_amount + $delivery->amount) - $copanDiscountAmount
                ]);
                if ($copan->type == 1) {
                    $copan->update(['status' => 2]);
                }
                return redirect()->back()->with('toast-success', 'کد تخفیف با موفقیت اعمال شد');
            } else {
                return redirect()->back()->with('toast-error', 'کد تخفیف نامعتبر بوده یا قبلا استفاده شده است');
            }
        } else {
            return redirect()->back()->with('toast-error', 'کد تخفیف نامعتبر بوده یا قبلا استفاده شده است');
        }

    }
    public function createOrderItem($orderId)
    {
        $user = auth()->user();
        $cartItems = CartItem::where('user_id', $user->id)->get();
        DB::transaction(function () use ($cartItems, $orderId) {

            foreach ($cartItems as $cartItem) {
                OrderItem::create([
                    'order_id' => $orderId,
                    'product_id' => $cartItem->product_id,
                    'product_object' => $cartItem->product,
                    'amazing_sale_id' => $cartItem->product->activeAmazingSale()->id ?? null,
                    'amazing_sale_object' => $cartItem->product->activeAmazingSale() ?? null,
                    'amazing_sale_discount_amount' => empty($cartItem->product->activeAmazingSale()) ? 0 : ($cartItem->product->activeAmazingSale()->percentage / 100) * $cartItem->cartItemProductPrice(),
                    'number' => $cartItem->number,
                    'final_product_price' => empty($cartItem->product->activeAmazingSale()) ? $cartItem->cartItemProductPrice() : $cartItem->cartItemProductPrice() - ($cartItem->product->activeAmazingSale()->percentage / 100) * $cartItem->cartItemProductPrice(),
                    'final_total_price' => (empty($cartItem->product->activeAmazingSale()) ? $cartItem->cartItemProductPrice() : $cartItem->cartItemProductPrice() - ($cartItem->product->activeAmazingSale()->percentage / 100) * $cartItem->cartItemProductPrice()) * $cartItem->number,
                    'color_id' => $cartItem->color_id,
                    'guarantee_id' => $cartItem->guarantee_id
                ]);
                $cartItem->delete();
            }
        });

    }
    public function paymentSubmit(Request $request, PaymentService $paymentService)
    {
        $request->validate([
            'payment_type' => 'required',
            'cash_receiver' => 'nullable',
        ]);

        $user = auth()->user();
        $order = Order::where('user_id', $user->id)->where('order_status', 0)->first();
       
        $cashReceiver = null;
        switch ($request->payment_type) {
            case '1':
                $targetModel = OnlinePayment::class;
                $type = 0;
                break;
            case '2':
                $targetModel = OfflinePayment::class;
                $type = 1;
                break;
            case '3':
                $targetModel = CashPayment::class;
                $type = 2;
                $cashReceiver = $request->cash_receiver ?? null;
                break;
            default:
                return redirect()->back()->with('toast-error', 'خطا');
        }


        // dd($order->order_final_amount);
        $paymented = $targetModel::create([
            'amount' => $order->order_final_amount,
            'user_id' => $user->id,
            'pay_date' => now(),
            'gateway' => 'زرین پال',
            'transaction_id' => null,
            'status' => 1,
            'cash_receiver' => $request->cash_receiver
        ]);


        $payment = Payment::create([
            'amount' => $order->order_final_amount,
            'user_id' => $user->id,
            'pay_date' => now(),
            'type' => $type,
            'paymentable_type' => $targetModel,
            'paymentable_id' => $paymented->id,
            'status' => 1
        ]);

        if ($request->payment_type == 1) {
            $paymentService->zarinpal($order->order_final_amount, $order, $paymented);
        }


        $order->update([
            'order_status' => 3,
            'payment_status' => 1,
            'payment_object' => json_encode($paymented),
            'payment_type' => $type,
            'payment_id' => $paymented->id
        ]);


      $this->createOrderItem($order->id);


        return redirect()->route('customer.home')->with('toast-success', "$user->fullName" . ' عزیز، سفارش شما با موفقیت ثبت شد');

    }
    public function paymentCallback(Order $order, OnlinePayment $onlinePayment, PaymentService $paymentService)
    {
        $user = auth()->user();
        $amount = $onlinePayment->amount;
        $result = $paymentService->zarinpalVerify($amount, $onlinePayment);
       
        $this->createOrderItem($order->id);
        if ($result['success']) {

            $order->update([
                'order_status' => 3,
                'payment_status' => 1,
                'payment_object' => json_encode($onlinePayment),
                'payment_type' => 0,
                'payment_id' => $onlinePayment->id
            ]);

            return redirect()->route('customer.home')->with('toast-success', "$user->fullName" . ' عزیز، پرداخت سفارش شما با موفقیت انجام و در اسرع وقت پیگیری خواهد شد');
        } else {
            $order->update([
                'order_status' => 2,
                'payment_status' => 0
            ]);
            return redirect()->route('customer.home')->with('toast-error', "$user->fullName" . ' عزیز، ثبت سفارش شما با خطا مواجه شد. لطفا مجددا تلاش کنید');
        }
    }
}
