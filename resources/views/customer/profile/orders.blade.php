@extends('customer.layouts.master-two-cols')
@section('head-tag')
<title>سفارش های من</title>
@endsection

@section('content')
 <!-- start body -->
 <section class="">
        <section id="main-body-two-col" class="container-xxl body-container">
            <section class="row">
          @include('customer.profile.layouts.sidebar')
              
                <main id="main-body" class="main-body col-md-9">
                    <section class="content-wrapper bg-white p-3 rounded-2 mb-2">

                        <!-- start vontent header -->
                        <section class="content-header">
                            <section class="d-flex justify-content-between align-items-center">
                                <h2 class="content-header-title">
                                    <span>تاریخچه سفارشات</span>
                                </h2>
                                <section class="content-header-link">
                                    <!--<a href="#">مشاهده همه</a>-->
                                </section>
                            </section>
                        </section>
                        <!-- end vontent header -->


                        <section class="d-flex justify-content-center my-4">
                            <a class="btn btn-outline-primary btn-sm mx-1" href="{{route('customer.profile.orders')}}">همه سفارشات</a>
                            <a class="btn btn-secondary btn-sm mx-1" href="{{route('customer.profile.orders', 'type=0')}}">بررسی نشده</a>
                            <a class="btn btn-info btn-sm mx-1" href="{{route('customer.profile.orders', 'type=1')}}">در انتظار تأیید</a>
                            <a class="btn btn-warning btn-sm mx-1" href="{{route('customer.profile.orders', 'type=2')}}">تأیید نشده</a>
                            <a class="btn btn-success btn-sm mx-1" href="{{route('customer.profile.orders', 'type=3')}}">تأیید شده</a>
                            <a class="btn btn-danger btn-sm mx-1" href="{{route('customer.profile.orders', 'type=4')}}">باطل شده</a>
                            <a class="btn btn-dark btn-sm mx-1" href="{{route('customer.profile.orders', 'type=5')}}">مرجوع شده</a>
                        </section>


                        <!-- start content header -->
                        <section class="content-header mb-3">
                            <section class="d-flex justify-content-between align-items-center">
                                <h2 class="content-header-title content-header-title-small">
                                {{$orders->first()->orderStatusValue ?? ''}}
                                </h2>
                                <section class="content-header-link">
                                    <!--<a href="#">مشاهده همه</a>-->
                                </section>
                            </section>
                        </section>
                        <!-- end content header -->


                        <section class="order-wrapper">

                        @forelse($orders as $order)
                            <section class="order-item">
                                <section class="d-flex justify-content-between">
                                    <section>
                                        <section class="order-item-date"><i class="fa fa-calendar-alt"></i>{{jalalidate($order->created_at)}}</section>
                                        <section class="order-item-id"><i class="fa fa-id-card-alt"></i>کد سفارش : {{$order->id}}</section>
                                        <section class="order-item-id"><i class="fa fa-id-card-alt"></i>مبلغ سفارش : {{priceFormat($order->order_final_amount)}} تومان</section>
                                        <section class="order-item-id"><i class="fa fa-id-card-alt"></i>میزان تخفیف : {{priceFormat($order->order_discount_amount + $order->order_copan_discount_amount + $order->order_common_discount_amount)}} تومان</section>
                                        <section class="order-item-status"><i class="fa fa-clock"></i>وضعیت پرداخت : {{$order->PaymentStatusValue}}</section>
                                        <section class="order-item-status"><i class="fa fa-envelope"></i>وضعیت ارسال : {{$order->deliveryStatusValue}}</section>
                                        @if($order->delivery_status == 2 || $order->delivery_status == 3)
                                        <section class="order-item-status"><i class="fa fa-envelope"></i>کد رهگیری پستی : {{$order->postal_tracking_code}}</section>
                                       @endif
                                        <section class="order-item-products">
                                            @foreach ($order->orderItems()->get() as $orderItem)
                                            <a href="{{route('customer.market.product', $orderItem->product)}}"><img src="{{asset(json_decode($orderItem->product_object)->image->indexArray->medium)}}" alt="{{$orderItem->product->name}}">
                                            @if (isset($orderItem->color_id))
                                            <section class="product-colors-item" style="background-color: {{$orderItem->color->color}}"></section>
                                            @endif
                                        </a>
                                                                        
                                            @endforeach
                                            
                                            
                                        </section>
                                    </section>
                                    <section class="order-item-link"><a class="btn btn-info text-white" href="{{route('customer.profile.order-factor', $order)}}">مشاهده فاکتور</a></section>
                                    @if ($order->payment_status != 1)
                                    <section class="order-item-link"><a href="#">پرداخت سفارش</a></section>
                                    @endif
                                </section>
                            </section>

                         @empty
<section class="order-item">
    <section>
        <p>سفارشی یافت نشد</p>
    </section>
</section>
                         @endforelse

                        </section>


                    </section>
                </main>
            </section>
        </section>
    </section>
    <!-- end body -->
@endsection