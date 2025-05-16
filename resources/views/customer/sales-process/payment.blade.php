@extends('customer.layouts.master-two-cols')
@section('head-tag')
<title>انتخاب نوع پرداخت</title>
@endsection

@section('content')

<!-- start cart -->
<section class="mb-4">
    <section class="container-xxl">
        <section class="row">
            <section class="col">
                <!-- start vontent header -->
                <section class="content-header">
                    <section class="d-flex justify-content-between align-items-center">
                        <h2 class="content-header-title">
                            <span>انتخاب نوع پرداخت </span>
                        </h2>
                        <section class="content-header-link">
                            <!--<a href="#">مشاهده همه</a>-->
                        </section>
                    </section>
                </section>

                <section class="row mt-4">
                    <section class="col-md-9">
                        <section class="content-wrapper bg-white p-3 rounded-2 mb-4">

                            <!-- start vontent header -->
                            <section class="content-header mb-3">
                                <section class="d-flex justify-content-between align-items-center">
                                    <h2 class="content-header-title content-header-title-small">
                                        کد تخفیف
                                    </h2>
                                    <section class="content-header-link">
                                        <!--<a href="#">مشاهده همه</a>-->
                                    </section>
                                </section>
                            </section>

                            <section class="payment-alert alert alert-primary d-flex align-items-center p-2"
                                role="alert">
                                <i class="fa fa-info-circle flex-shrink-0 me-2"></i>
                                <secrion>
                                    کد تخفیف خود را در این بخش وارد کنید.
                                </secrion>
                            </section>
                            <form action="{{route('customer.sales-process.copan-discount')}}" method="post">
                                <section class="row">
                                    @csrf
                                    <section class="col-md-5">
                                        <section class="input-group input-group-sm my-1">
                                            <input type="text" name="copan_id" class="form-control" placeholder="کد تخفیف را وارد کنید">
                                            <button class="btn btn-primary" type="submit">اعمال کد</button>
                                        </section>
                                        @error('copan_id')
                                            <span class="alert_required text-danger p-1 rounded my-1" role="alert">
                                                <strong>
                                                    {{ $message }}
                                                </strong>
                                            </span>
                                        @enderror
                                    </section>

                                </section>
                            </form>
                        </section>


                        <section class="content-wrapper bg-white p-3 rounded-2 mb-4">

                            <!-- start vontent header -->
                            <section class="content-header mb-3">
                                <section class="d-flex justify-content-between align-items-center">
                                    <h2 class="content-header-title content-header-title-small">
                                        انتخاب نوع پرداخت
                                    </h2>
                                    <section class="content-header-link">
                                        <!--<a href="#">مشاهده همه</a>-->
                                    </section>
                                </section>
                            </section>
                            <section class="payment-select">

                                <section class="payment-alert alert alert-primary d-flex align-items-center p-2"
                                    role="alert">
                                    <i class="fa fa-info-circle flex-shrink-0 me-2"></i>
                                    <secrion>
                                        برای پیشگیری از انتقال ویروس کرونا پیشنهاد می کنیم روش پرداخت اینترنتی رو پرداخت
                                        کنید.
                                    </secrion>
                                </section>

                                <form action="{{route('customer.sales-process.payment-submit')}}" method="post" id="order-payment">
                                    @csrf
                                <input type="radio" name="payment_type" value="1" id="d1" />
                                <label for="d1" class="col-12 col-md-4 payment-wrapper mb-2 pt-2">
                                    <section class="mb-2">
                                        <i class="fa fa-credit-card mx-1"></i>
                                        پرداخت آنلاین
                                    </section>
                                    <section class="mb-2">
                                        <i class="fa fa-calendar-alt mx-1"></i>
                                        درگاه پرداخت زرین پال
                                    </section>
                                </label>

                                <section class="mb-2"></section>

                                <input type="radio" name="payment_type" value="2" id="d2" />
                                <label for="d2" class="col-12 col-md-4 payment-wrapper mb-2 pt-2">
                                    <section class="mb-2">
                                        <i class="fa fa-id-card-alt mx-1"></i>
                                        پرداخت آفلاین
                                    </section>
                                    <section class="mb-2">
                                        <i class="fa fa-calendar-alt mx-1"></i>
                                        حداکثر در 2 روز کاری بررسی می شود
                                    </section>
                                </label>

                                <section class="mb-2"></section>

                                <input type="radio" name="payment_type" value="3" id="cash_payment" />
                                <label for="cash_payment" class="col-12 col-md-4 payment-wrapper mb-2 pt-2">
                                    <section class="mb-2">
                                        <i class="fa fa-money-check mx-1"></i>
                                        پرداخت در محل
                                    </section>
                                    <section class="mb-2">
                                        <i class="fa fa-calendar-alt mx-1"></i>
                                        پرداخت به پیک هنگام دریافت کالا
                                    </section>
                                </label>
                                </form>

                            </section>
                        </section>




                    </section>
                    <section class="col-md-3">
                        <section class="content-wrapper bg-white p-3 rounded-2 cart-total-price">
                        @php
                                $totalProductPrice = 0;
                                $totalDiscount = 0;
                            @endphp

                            @foreach($cartItems as $cartItem)
                                                        @php
                                                            $totalProductPrice += $cartItem->cartItemProductPrice() * $cartItem->number;
                                                            $totalDiscount += $cartItem->cartItemProductDiscount() * $cartItem->number;
                                                        @endphp
                            @endforeach

                            <section class="d-flex justify-content-between align-items-center">
                                <p class="text-muted">قیمت کالاها ({{ $cartItems->count() }})</p>
                                <p class="text-muted"><span
                                id="total_product_price">{{ priceFormat($totalProductPrice) }}</span> تومان</p>
                            </section>
                            <section class="border-bottom mb-3"></section>
                            @if($totalDiscount != 0)
                            <section class="d-flex justify-content-between align-items-center">
                                <p class="text-muted">تخفیف شگفت انگیز کالاها</p>
                                <p class="text-danger">
                                <span
                                id="total_discount">{{ priceFormat($totalDiscount) }}</span> تومان
                                </p>
                            </section>
                            @endif
                            @if($order->commonDiscount != null)
                            
                            <section class="d-flex justify-content-between align-items-center">
                                <p class="text-muted">تخفیف عمومی سفارش</p>
                                <p class="text-danger">
                                <span
                                id="total_discount">{{ priceFormat($order->order_common_discount_amount)}}</span> تومان
                                </p>
                            </section>
                            @endif
                            @if($order->copan != null)
                            
                            <section class="d-flex justify-content-between align-items-center">
                                <p class="text-muted">تخفیف شامل شده از کد تخفیف</p>
                                <p class="text-danger">
                                <span
                                id="total_discount">{{ priceFormat($order->order_copan_discount_amount)}}</span> تومان
                                </p>
                            </section>
                           
                            @endif
                           @if ($order->copan != null | $order->commonDiscount != null | $totalDiscount != 0)
                           <section class="border-bottom mb-3"></section>
                           @endif
                            
                            <section class="d-flex justify-content-between align-items-center">
                                <p class="text-muted">مجموع تخفیف اعمال شده</p>
                                <p class="text-danger fw-bolder">
                                <span
                                        id="total_price">{{ priceFormat($order->order_discount_amount + $order->order_copan_discount_amount + $order->order_common_discount_amount) }}</span>
                                    تومان
                                </p>
                            </section>
                            <section class="d-flex justify-content-between align-items-center">
                                <p class="text-muted">جمع سبد خرید با اعمال تخفیف</p>
                                <p class="fw-bolder">
                                <span
                                        id="total_price">{{ priceFormat($sum = $totalProductPrice - ($totalDiscount + $order->order_common_discount_amount + $order->order_copan_discount_amount)) }}</span>
                                    تومان
                                </p>
                            </section>
                            <section class="border-bottom mb-3"></section>
                            <section class="d-flex justify-content-between align-items-center">
                                <p class="text-muted">هزینه ارسال</p>
                                <p class="text-warning">
                                <span
                                        id="total_price">{{ priceFormat($order->delivery_amount) }}</span>
                                    تومان
                                </p>
                            </section>

                           

                            <p class="my-3">
                                <i class="fa fa-info-circle me-1"></i> کاربر گرامی کالاها بر اساس نوع ارسالی که انتخاب
                                می کنید در مدت زمان ذکر شده ارسال می شود.
                            </p>

                            <section class="border-bottom mb-3"></section>

                            <section class="d-flex justify-content-between align-items-center">
                                <p class="text-muted">مبلغ قابل پرداخت</p>
                                <p class="fw-bold">
                                <span
                                        id="total_price">{{ priceFormat($sum + $order->delivery_amount) }}</span>
                                    تومان
                                </p>
                            </section>

                            <section class="">
                                <section id="payment-button"
                                    class="text-warning border border-warning text-center py-2 pointer rounded-2 d-block">
                                    نوع پرداخت را انتخاب کن</section>
                                <button id="final-level" onclick="document.getElementById('order-payment').submit()" class="btn btn-danger w-100 d-none">ثبت نهایی سفارش 
                                    </button>
                            </section>

                        </section>
                    </section>
                </section>
            </section>
        </section>

    </section>
</section>
<!-- end cart -->

@endsection
@section('scripts')

<script>
    $(document).ready(function() {
        $('#cash_payment').click(function(){
            var newDiv = document.createElement('div');
            newDiv.classList.add('col-md-4');
            newDiv.innerHTML = `
            <section class="input-group input-group-sm">
            <input name="cash_receiver" type="text" class="form-control form-control-sm w-50" form="order-payment" placeholder="نام و نام خانوادگی دریافت کننده">
            </section>
            `;
            document.getElementsByClassName('content-wrapper')[1].appendChild(newDiv);
        })
    });
</script>

@endsection