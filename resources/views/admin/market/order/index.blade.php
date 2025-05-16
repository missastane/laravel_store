@extends('admin.layouts.master')

@section('head-tag')
    <title>{{ $title }}</title>
@endsection

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb text-center">
            <li class="breadcrumb-item font-size-12"><a href="{{ route('admin.home') }}">خانه</a></li>
            <li class="breadcrumb-item font-size-12"><a href="{{ route('admin.home') }}"> بخش فروش</a></li>
            <li class="breadcrumb-item active font-size-12" aria-current="page">{{ $title }}</li>
        </ol>
    </nav>
    <section class="row">
        <section class="col-12">
            <section class="main-body-container">
                <section class="main-body-container-header">
                    <h4>{{ $title }}</h4>
                </section>
                <section class="d-flex justify-content-between align-items-center my-4">
                    <a href="" class="btn btn-primary btn-sm disabled ">ایجاد سفارش جدید</a>
            
                </section>
                <section class="table-responsive">
                    <table class="table table-striped table-info text-center">

                        <thead>
                            <tr>
                                <th>#</th>
                                <th>کد سفارش</th>
                                <th>مبلغ سفارش</th>
                                <th>مجموع تمامی تخفیفات</th>
                                <th>مبلغ نهایی</th>
                                <th>وضعیت پرداخت</th>
                                <th>شیوه پرداخت</th>
                                <th>بانک</th>
                                <th>وضعیت ارسال</th>
                                <th>شیوه ارسال</th>
                                <th>وضعیت سفارش</th>

                                <th class="max-width-8-rem text-center"><i class="fa fa-cogs ml-1"></i>تنظیمات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $order)
                                <tr>
                                    <th>{{ $loop->iteration }}</th>
                                    <td>{{ $order->id }}</td>
                                    <td>{{ number_format($order->order_final_amount) }} تومان</td>
                                    <td>{{ number_format($order->order_discount_amount) }} تومان</td>
                                    <td>{{ number_format($order->order_final_amount - $order->order_discount_amount) }}
                                        تومان</td>
                                    <td>
                                        @if ($order->payment_status == 0)
                                            <section id="{{ $order->id }}_Approved">
                                                <i class="fa fa-times-circle text-warning"></i>
                                                <span class="approved-info"> پرداخت نشده</span>
                                            </section>
                                        @elseif($order->payment_status == 1)
                                            <section id="{{ $order->id }}_Approved">
                                                <i class="fa fa-credit-card text-success"></i>
                                                <span class="approved-info"> پرداخت شده</span>
                                            </section>
                                        @elseif($order->payment_status == 2)
                                            <section id="{{ $order->id }}_Approved">
                                                <i class="fa fa-times-circle text-danger"></i>
                                                <span class="approved-info"> باطل شده</span>
                                            </section>
                                        @else
                                            <section id="{{ $order->id }}_Approved">
                                                <i class="fa fa-reply text-primary"></i>
                                                <span class="approved-info"> مرجوع شده</span>
                                            </section>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($order->paymentable_type == 1)
                                            آفلاین
                                        @elseif($order->paymentable_type == 2)
                                            در محل
                                        @else
                                            آنلاین
                                        @endif
                                    </td>
                                    <td>{{ $order->payment->paymentable->gateway ?? '-' }}</td>
                                    <td>
                                        @if ($order->delivery_status == 0)
                                            <section id="{{ $order->id }}">
                                                <i class="fa fa-exclamation-circle text-danger"></i>
                                                <span class="approved-info"> ارسال نشده </span>
                                            </section>
                                        @elseif($order->delivery_status == 1)
                                            <section id="{{ $order->id }}">
                                                <i class="fa fa-paper-plane text-secondary"></i>
                                                <span class="approved-info">در حال ارسال </span>
                                            </section>
                                        @elseif($order->delivery_status == 2)
                                            <section id="{{ $order->id }}">
                                                <i class="fa fa-envelope text-primary"></i>
                                                <span class="approved-info"> ارسال شده</span>
                                            </section>
                                        @else
                                            <section id="{{ $order->id }}">
                                                <i class="fa fa-check-circle text-success"></i>
                                                <span class="approved-info"> تحویل داده شده</span>
                                            </section>
                                        @endif
                                    </td>

                                    <td>{{ $order->delivery->name }}</td>

                                    <td>
                                        @if ($order->order_status == 1)
                                            <section id="{{ $order->id }}">
                                                <i class="fa spinner-grow spinner-grow-sm text-info"></i>
                                                <span class="approved-info"> در انتظار تأیید</span>
                                            </section>
                                        @elseif($order->order_status == 2)
                                            <section id="{{ $order->id }}">
                                                <i class="fa fa-times-circle text-warning"></i>
                                                <span class="approved-info"> تأیید نشده</span>
                                            </section>
                                        @elseif($order->order_status == 3)
                                            <section id="{{ $order->id }}">
                                                <i class="fa fa-check-circle text-success"></i>
                                                <span class="approved-info"> تأیید شده</span>
                                            </section>
                                        @elseif($order->order_status == 4)
                                            <section id="{{ $order->id }}_Approved">
                                                <i class="fa fa-times-circle text-danger"></i>
                                                <span class="approved-info"> باطل شده</span>
                                            </section>
                                        @elseif($order->order_status == 5)
                                            <section id="{{ $order->id }}_Approved">
                                                <i class="fa fa-reply text-primary"></i>
                                                <span class="approved-info"> مرجوع شده</span>
                                            </section>
                                        @else
                                            <section id="{{ $order->id }}_Approved">
                                                <i class="fa fa-exclamation-circle text-danger"></i>
                                                <span class="approved-info"> دیده نشده</span>
                                            </section>
                                        @endif
                                    </td>


                                    <td class="text-left" class="dropdown">
                                        <div>
                                            <a class="btn btn-success btn-sm btn-block dorpdown-toggle" role="button"
                                                id="dropdownMenuLink" data-toggle="dropdown" aria-expanded="false">
                                                <i class="fa fa-tools"></i> عملیات
                                            </a>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                                <a href="{{ route('admin.market.order.show', $order->id) }}"
                                                    class="dropdown-item text-right header-profile-link"><i
                                                        class="fa fa-images"></i> مشاهده فاکتور</a>
                                                <a href="{{ route('admin.market.order.changeSendStutus', $order->id) }}"
                                                    class="dropdown-item text-right header-profile-link"><i
                                                        class="fa fa-truck-moving"></i> تغییر وضعیت ارسال</a>
                                                        <a href="{{ route('admin.market.order.changeOrderStutus', $order->id) }}"
                                                            class="dropdown-item text-right header-profile-link"><i
                                                                class="fa fa-edit"></i> تغییر وضعیت سفارش</a>
                                                        <a href=" {{ route('admin.market.order.cancelOrder', $order->id) }}"
                                                            class="dropdown-item text-right header-profile-link"><i
                                                                class="fas fa-trash-alt"></i> باطل کردن سفارش</a>
        
                                                @if ($order->delivery_status == 2 || $order->delivery_status == 3)
                                                    <a data-toggle="modal" data-target="#postal_tracking_code-{{$order->id}}" class="dropdown-item text-right header-profile-link">
                                                       <i class="fa fa-envelope"></i>ورود کد رهگیری پستی</a>
                                                            
                                                   
                                                @endif
                                               
                                            </div>
                                        </div>

                                    </td>
                                    <section class="modal fade" id="postal_tracking_code-{{ $order->id }}"
                                        tabindex="-1" aria-labelledby="postal-tracking-code-label"
                                        aria-hidden="true">
                                        <section class="modal-dialog">
                                            <section class="modal-content">
                                                <section class="modal-header">
                                                    <h5 class="modal-title" id="postal-tracking-code-label"><i
                                                            class="fa fa-plus"></i>ورود کد رهگیری پستی</h5>
                                                            <button type="button" class="close p-0 m-0" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                              </button>
                                                </section>
                                                <section class="modal-body">
                                                    <form class="row" id="postal_tracking_code-form"
                                                        action="{{ route('admin.market.order.postalTrackingCode', $order->id) }}"
                                                        method="post">
                                                        @csrf
                                                        @method('put')



                                                        <section class="col-12 mb-3">
                                                            <label for="postal_code"
                                                                class="form-label mb-1">کد
                                                                رهگیری پستی</label>
                                                            <input type="text"
                                                                class="form-control form-control-sm"
                                                                id="postal_code"
                                                                value="{{ old('postal_tracking_code', $order->postal_tracking_code) }}"
                                                                name="postal_tracking_code">
                                                            @error('postal_tracking_code')
                                                                <span
                                                                    class="alert_required text-danger p-1 rounded"
                                                                    role="alert">
                                                                    <strong>
                                                                        {{ $message }}
                                                                    </strong>
                                                                </span>
                                                            @enderror
                                                        </section>

                                                        <section class="modal-footer border-0 py-1">
                                                            <button type="submit"
                                                                class="btn btn-sm btn-primary">
                                                                ثبت</button>
                                                            <button type="button"
                                                                class="btn btn-sm btn-danger"
                                                                data-bs-dismiss="modal">بستن</button>
                                                        </section>
                                                    </form>
                                                </section>
                                            </section>
                                        </section>
                                    </section>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </section>
            </section>
        </section>
    </section>
@endsection
@section('script')
<script type="text/javascript">


    </script>
@endsection
