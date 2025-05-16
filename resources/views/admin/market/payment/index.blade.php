@extends('admin.layouts.master')

@section('head-tag')
<title>{{$title}}</title>
@endsection

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb text-center">
        <li class="breadcrumb-item font-size-12"><a href="{{route('admin.home')}}">خانه</a></li>
        <li class="breadcrumb-item font-size-12"><a href="{{route('admin.home')}}"> بخش فروش</a></li>
        <li class="breadcrumb-item active font-size-12" aria-current="page">{{$title}}</li>
    </ol>
</nav>
<section class="row">
    <section class="col-12">
        <section class="main-body-container">
            <section class="main-body-container-header">
                <h4>{{$title}}</h4>
            </section>
            <section class="d-flex justify-content-between align-items-center my-4">
                <a href="" class="btn btn-primary btn-sm disabled">ایجاد پرداخت جدید</a>
                <div class="width-16-rem">
                    <input type="text" class="form-control form-control-sm form-text" name="" id="" placeholder="جستجو">
                </div>
            </section>
            <section class="table-responsive">
                <table class="table table-striped table-info text-center">

                    <thead>
                        <tr>
                            <th>#</th>
                            <th>کد تراکنش</th>
                            <th>پرداخت کننده</th>
                            <th>مبلغ پرداخت</th>
                            <th>وضعیت پرداخت</th>
                            <th>بانک</th>
                            <th>نوع پرداخت</th>

                            <th class="max-width-16-rem text-center"><i class="fa fa-cogs ml-1"></i>تنظیمات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($payments as $payment)
                        <tr>
                            <th>{{$loop->iteration}}</th>
                            <td>{{$payment->paymentable->transaction_id ?? '-'}}</td>
                            <td>{{$payment->user->fullName}}</td>
                            <td>{{number_format($payment->amount)}} تومان</td>
                            <td>@if ($payment->status == 0)
                                    <section id="{{$payment->id}}_Approved">
                                        <i class="fa fa-times-circle text-warning"></i>
                                        <span class="approved-info"> پرداخت نشده</span>
                                    </section>
                                @elseif($payment->status == 1)
                                    <section id="{{$payment->id}}_Approved">
                                        <i class="fa fa-check-circle text-success"></i>
                                        <span class="approved-info"> پرداخت شده</span>
                                    </section>
                                    @elseif($payment->status == 2)
                                    <section id="{{$payment->id}}_Approved">
                                        <i class="fa fa-times-circle text-danger"></i>
                                        <span class="approved-info"> باطل شده</span>
                                    </section>
                                    @else
                                    <section id="{{$payment->id}}_Approved">
                                        <i class="fa fa-reply text-primary"></i>
                                        <span class="approved-info"> مرجوع شده</span>
                                    </section>
                                @endif
                                </td>
                            <td>{{$payment->paymentable->gateway ?? '-'}}</td>
                            <td>@if ($payment->type == 1)
                            آفلاین
                            @elseif($payment->type == 2)
                            در محل
                            @else
                            آنلاین
                            @endif
                        </td>
                            <td class="text-left width-22-rem">
                                <a class="btn btn-sm btn-info" href="{{route('admin.market.payment.show', $payment->id)}}"><i class="fa fa-eye ml-1"></i>مشاهده</a>
                                <a class="btn btn-sm btn-danger" href="{{route('admin.market.payment.canceled', $payment->id)}}"><i class="fa fa-trash ml-1"></i>باطل کردن</a>
                                <a class="btn btn-sm btn-warning" href="{{route('admin.market.payment.returned', $payment->id)}}"><i class="fa fa-reply ml-1"></i>برگرداندن</a>
                               
                            </td>
                        </tr>
                        @endforeach                      
                    </tbody>
                </table>
            </section>
        </section>
    </section>
</section>
@endsection