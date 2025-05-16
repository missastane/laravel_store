@extends('admin.layouts.master')

@section('head-tag')
<title>نمایش پرداخت</title>
@endsection

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb text-center">
        <li class="breadcrumb-item font-size-12"><a href="{{route('admin.home')}}">خانه</a></li>
        <li class="breadcrumb-item font-size-12"><a href="{{route('admin.home')}}"> بخش فروش</a></li>
        <li class="breadcrumb-item font-size-12"><a href="{{route('admin.market.payment.all')}}">پرداخت ها</a></li>
        <li class="breadcrumb-item active font-size-12" aria-current="page">نمایش پرداخت</li>
    </ol>
</nav>
<section class="row">
    <section class="col-12">
        <section class="main-body-container">
            <section class="main-body-container-header">
                <h4>نمایش پرداخت</h4>
            </section>
            <section class="d-flex justify-content-between align-items-center my-4">
                <a class="btn btn-dark btn-sm" href="{{route('admin.market.payment.all')}}">بازگشت</a>

            </section>
            <section class="card mb-2">
                <section class="card-header bg-custom-yellow text-white">
                    پرداخت کننده : {{$payment->user->fullName}}
                </section>
                <section class="w-100 mt-3 mb-2 p-2">
                    <section class="d-md-flex flex-column">
                        <h5 class="card-title"><b>مبلغ : </b>{{number_format($payment->amount)}} تومان</h5>
                        <p><b>شماره پرداخت : </b>{{$payment->paymentable->transaction_id ?? '-'}}</p>
                        <p><b>تاریخ پرداخت : </b>{{jalalidate($payment->paymentable->pay_date) ?? '-'}}</p>
                        <p><b>درگاه پرداخت : </b>{{$payment->paymentable->gateway ?? '-'}}</p>
                        <p><b>وضعیت پرداخت : </b>@if ($payment->status == 0)
                            <i class="fa fa-times-circle text-warning"></i>
                            <span class="approved-info"> پرداخت نشده</span>
                        @elseif($payment->status == 1)
                            <i class="fa fa-check-circle text-success"></i>
                            <span class="approved-info"> پرداخت شده</span>
                        @elseif($payment->status == 2)
                            <i class="fa fa-times-circle text-danger"></i>
                            <span class="approved-info"> باطل شده</span>
                        @else
                            <i class="fa fa-reply text-primary"></i>
                            <span class="approved-info"> مرجوع شده</span>
                        @endif
                        </p>
                        <p><b>نوع پرداخت : </b>@if ($payment->type == 1)
                            آفلاین
                            @elseif($payment->type == 2)
                            در محل
                            @else
                            آنلاین
                            @endif
                        </p>
                        <p><b>دریافت کننده مبلغ نقدی : </b>{{$payment->paymentable->cash_receiver ?? '-'}}</p>
                        <p><b></b></p>

                    </section>
                </section>
            </section>
            @endsection