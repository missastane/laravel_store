@extends('admin.layouts.master')

@section('head-tag')
<title>مشاهده فاکتور</title>
@endsection

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb text-center">
        <li class="breadcrumb-item font-size-12"><a href="{{route('admin.home')}}">خانه</a></li>
        <li class="breadcrumb-item font-size-12"><a href="{{route('admin.home')}}"> بخش فروش</a></li>
        <li class="breadcrumb-item active font-size-12" aria-current="page">مشاهده فاکتور</li>
    </ol>
</nav>
<section class="row">
    <section class="col-12">
        <section class="main-body-container">
            <section class="main-body-container-header">
                <h4>مشاهده فاکتور</h4>
            </section>
            <section class="float-right">
                <a href="{{route('admin.market.order.all')}}" class="btn btn-sm btn-dark text-white">بازگشت</a>

            </section>
            <section class="float-left">
                <a href="" id="print" class="btn btn-sm btn-dark text-white">چاپ</a>
                <a href="{{route('admin.market.orde.detail', $order->id)}}"
                    class="btn btn-sm btn-info text-white">جزئیات</a>

            </section>
            <section class="table-responsive" id="printable">

                <h2 class="text-center">فاکتور</h2>
                <table class="table table-striped text-center">


                    <tbody>

                        <tr class="table-primary">
                            <th>شناسه سفارش</th>
                            <td class="text-left font-weight-bolder">{{$order->id}}</td>

                        </tr>
                        <tr class="border-bottom">
                            <th>نام مشتری</th>
                            <td class="text-left font-weight-bolder">{{$order->user->fullName ?? '-'}}</td>
                        </tr>
                        <tr class="border-bottom">
                            <th>استان</th>
                            <td class="text-left font-weight-bolder">{{$order->address->city->province->name ?? '-'}}
                            </td>
                        </tr>
                        <tr class="border-bottom">
                            <th>شهر</th>
                            <td class="text-left font-weight-bolder">{{$order->address->city->name ?? '-'}}</td>
                        </tr>
                        <tr class="border-bottom">
                            <th>آدرس مشتری</th>
                            <td class="text-left font-weight-bolder">{{$order->address->address ?? '-'}}</td>
                        </tr>
                        <tr class="border-bottom">
                            <th>واحد</th>
                            <td class="text-left font-weight-bolder">{{$order->address->unit ?? '-'}}</td>
                        </tr>
                        <tr class="border-bottom">
                            <th>پلاک</th>
                            <td class="text-left font-weight-bolder">{{$order->address->no ?? '-'}}</td>
                        </tr>
                        <tr class="border-bottom">
                            <th>کد پستی</th>
                            <td class="text-left font-weight-bolder">{{$order->address->postal_code ?? '-'}}</td>
                        </tr>
                        <tr class="border-bottom">
                            <th>نام گیرنده</th>
                            <td class="text-left font-weight-bolder">{{$order->address->recipient_first_name ?? '-'}}
                            </td>
                        </tr>
                        <tr class="border-bottom">
                            <th>نام خانوادگی گیرنده</th>
                            <td class="text-left font-weight-bolder">{{$order->address->recipient_last_name ?? '-'}}
                            </td>
                        </tr>
                        <tr class="border-bottom">
                            <th>شماره موبایل</th>
                            <td class="text-left font-weight-bolder">{{$order->address->mobile ?? '-'}}</td>
                        </tr>
                        <tr class="border-bottom">
                            <th>نوع پرداخت</th>
                            <td class="text-left font-weight-bolder">{{$order->payment_type_value ?? '-'}}</td>
                        </tr>
                        <tr class="border-bottom">
                            <th>وضعیت پرداخت</th>
                            <td class="text-left font-weight-bolder">{{$order->payment_status_value ?? '-'}}</td>
                        </tr>
                        <tr class="border-bottom">
                            <th>بانک</th>
                            <td class="text-left font-weight-bolder">{{$order->payment->gateway ?? '-'}}</td>
                        </tr>
                        <tr class="border-bottom">
                            <th>هزینه ارسال</th>
                            <td class="text-left font-weight-bolder">{{number_format($order->delivery->amount) ?? '0'}}
                                تومان</td>
                        </tr>
                        <tr class="border-bottom">
                            <th>وضعیت ارسال</th>
                            <td class="text-left font-weight-bolder">{{$order->delivery_status_value ?? '-'}}</td>
                        </tr>
                        <tr class="border-bottom">
                            <th>تاریخ ارسال</th>
                            <td class="text-left font-weight-bolder">
                                {{jalalidate($order->delivery_date, 'Y-m-d H:i:s') ?? '-'}}
                            </td>
                        </tr>
                        <tr class="border-bottom">
                            <th>کوپن استفاده شده در این خرید</th>
                            <td class="text-left font-weight-bolder">{{$order->copan->code ?? '-'}}</td>
                        </tr>
                        <tr class="border-bottom">
                            <th>مبلغ کوپن استفاده شده در این خرید</th>
                            <td class="text-left font-weight-bolder">{{$order->copan->amount ?? '-'}}
                                @if ($order->copan->amount_type ?? '')

                                    @if($order->copan->amount_type == 1)
                                        تومان
                                    @elseif($order->copan->amount_type == 2)
                                        %
                                    @endif
                                @endif
                            </td>
                        </tr>
                        <tr class="border-bottom">
                            <th>تخفیف عمومی استفاده شده</th>
                            <td class="text-left font-weight-bolder">{{$order->commonDiscount->title ?? '-'}}</td>
                        </tr>
                        <tr class="border-bottom">
                            <th>مبلغ تخفیف عمومی استفاده شده</th>
                            <td class="text-left font-weight-bolder">{{$order->commonDiscount->percentage ?? '0'}} %
                            </td>
                        </tr>
                        <tr class="border-bottom">
                            <th>مجموع مبلغ تخفیف همه محصولات</th>
                            <td class="text-left font-weight-bolder">
                                {{number_format($order->order_total_products_discount_amount) ?? '0'}} تومان
                            </td>
                        </tr>
                        <tr class="border-bottom">
                            <th>مجموع مبلغ تمامی تخفیفات</th>
                            <td class="text-left font-weight-bolder">
                                {{number_format($order->order_discount_amount) ?? '0'}} تومان
                            </td>
                        </tr>

                        <tr class="border-bottom">
                            <th>مجموع مبلغ سفارش(بدون تخفیف)</th>
                            <td class="text-left font-weight-bolder">
                                {{number_format($order->order_final_amount) ?? '0'}} تومان
                            </td>
                        </tr>

                        <tr class="border-bottom">
                            <th>مبلغ نهایی با محاسبه تخفیفات</th>
                            <td class="text-left font-weight-bolder">
                                {{number_format($order->order_final_amount - $order->order_discount_amount) ?? '0'}}
                                تومان
                            </td>
                        </tr>
                        <tr class="border-bottom">
                            <th>وضعیت سفارش</th>
                            <td class="text-left font-weight-bolder">{{$order->order_status_value ?? '-'}}</td>
                        </tr>
                    </tbody>
                </table>
            </section>
        </section>
    </section>
</section>
@endsection
@section('script')
<script>
    var printBtn = document.getElementById('print');
    printBtn.addEventListener('click', function () {
        printContent('printable');
    })

    function printContent(el) {
        var restorePage = $('body').html();
        var printContent = $('#' + el).clone();
        $('body').empty().html(printContent);
        window.print();
        $('body').html(restorePage);
    }
</script>
@endsection