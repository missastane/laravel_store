@extends('admin.layouts.master')

@section('head-tag')
<title>جزئیات سفارش</title>
@endsection

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb text-center">
        <li class="breadcrumb-item font-size-12"><a href="{{route('admin.home')}}">خانه</a></li>
        <li class="breadcrumb-item font-size-12"><a href="{{route('admin.home')}}"> بخش فروش</a></li>
        <li class="breadcrumb-item active font-size-12" aria-current="page">جزئیات سفارش</li>
    </ol>
</nav>
<section class="row">
    <section class="col-12">
        <section class="main-body-container">
            <section class="main-body-container-header">
                <h4>جزئیات سفارش</h4>
            </section>
            <section class="d-flex justify-content-between align-items-center my-4">
                <section class="float-right">
                    <a href="{{route('admin.market.order.show', $order->id)}}"
                        class="btn btn-dark text-white btn-sm">بازگشت</a>
                    <a id="print" class="btn btn-sm btn-danger text-white">چاپ</a>

                </section>
                <div class="max-width-16-rem">
                    <input type="text" class="form-control form-control-sm form-text" name="" id="" placeholder="جستجو">
                </div>
            </section>
            <section class="table-responsive" id="printable">
               
                <table class="table table-striped table-info text-center">

                    <thead>
                    <h4>جزئیات فاکتور شماره {{$order->id}}</h4>
                        <tr>

                            <th>#</th>
                            <th>نام محصول</th>
                            <th>تعداد</th>
                            <th>قیمت محصول</th>
                            <th>مبلغ تخفیف فروش فوق العاده</th>
                            <th>قیمت محصول با کسر تخفیف</th>
                            <th>مبلغ نهایی</th>
                            <th>رنگ</th>
                            <th>گارانتی</th>
                            <th>ویژگی</th>



                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($order->orderItems as $orderItem)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$orderItem->product->name ?? '-'}}</td>
                                <td>{{$orderItem->number ?? '-'}}</td>
                                <td>{{$orderItem->product->price ? number_format($orderItem->product->price) : '0'}} تومان</td>
                                <td>{{$orderItem->amazing_sale_discount_amount ? number_format($orderItem->amazing_sale_discount_amount) : '0'}}
                                    تومان</td>
                                <td>{{$orderItem->final_product_price ? number_format($orderItem->final_product_price) : '0'}}
                                    تومان</td>
                                <td>{{$orderItem->final_total_price ? number_format($orderItem->final_total_price) : '0'}}
                                    تومان</td>
                                <td>{{$orderItem->color->color_name ?? '-'}}</td>
                                <td>{{$orderItem->guarantee->name ?? '-'}}</td>
                               @if ($orderItem->selectedAttributes)
                               <td>
                                    @forelse($orderItem->selectedAttributes as $selectedAttribute)
                                        <p> {{$selectedAttribute->attribute->name ?? '-'}}
                                            :
                                            {{$selectedAttribute->value ?? '-'}} {{$selectedAttribute->attribute->unit ?? '-'}}
                                        </p>
                                    @empty
                                        -
                                    @endforelse
                                </td>
                               @endif
                            </tr>
                        @endforeach

                      <table class="table table-striped table-info table-bordered" style="margin-top:-1rem">
                      <tr>
                            <th class="px-4">مجموع کل مبالغ</th>
                            <td class="text-left font-weight-bolder px-4">
                                {{number_format($order->order_final_amount - $order->order_discount_amount) ?? '0'}}
                                تومان</td>
                        </tr>
                      </table>
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