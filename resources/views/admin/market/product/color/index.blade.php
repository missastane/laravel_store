@extends('admin.layouts.master')

@section('head-tag')
<title>مدیریت رنگ های {{$product->name}}</title>
<style>
    .dot{
        height: 35px;
        width: 75px;
        border-radius: 50%;
        display: inline-block;
        text-align: center;
        line-height: 35px;
        color: white;
    }
</style>
@endsection

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb text-center">
        <li class="breadcrumb-item font-size-12"><a href="{{route('admin.home')}}">خانه</a></li>
        <li class="breadcrumb-item font-size-12"><a href="{{route('admin.home')}}"> بخش فروش</a></li>
        <li class="breadcrumb-item active font-size-12" aria-current="page">مدیریت رنگ های {{$product->name}}</li>
    </ol>
</nav>
<section class="row">
    <section class="col-12">
        <section class="main-body-container">
            <section class="main-body-container-header">
                <h4>مدیریت رنگ های {{$product->name}}</h4>
            </section>
            <section class="d-flex justify-content-between align-items-center my-4">
          <section>
          <a class="btn btn-dark btn-sm" href="{{route('admin.market.product.index')}}">بازگشت</a>
                <a href="{{route('admin.market.product-color.create', $product->id)}}"
                    class="btn btn-primary btn-sm">افزودن رنگ جدید</a>
          </section>
                    
                <form method="GET" action="{{route('admin.market.product-color.search', $product)}}" class="max-width-16-rem">
                    <input type="text" class="form-control form-control-sm form-text" name="search" id="" placeholder="جستجو">
                </form>
            </section>
            <section class="table-responsive">
                <table class="table table-striped table-info text-center vertical-middle">

                    <thead>
                        <tr>
                            <th>#</th>
                            <th>نام رنگ</th>
                            <th>کد رنگ</th>
                            <th>افزایش قیمت</th>
                            <th>وضعیت</th>
                            <th class="max-width-8-rem text-center"><i class="fa fa-cogs ml-1"></i>تنظیمات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($product->colors()->get()->toArray() != null)
                        {{-- @php
                        if (session('colors')) {

                            $colors = request()->session()->get('colors');
                            request()->session()->forget('colors');
                        } else {
                            $colors = $product->colors;
                        }
                    @endphp --}}

                            @foreach ($product->colors as $color)
                                <tr class="vertical-middle">
                                    <th>{{$loop->iteration}}</th>
                                    <td>{{$color->color_name}}</td>
                                    <td><span class="dot" style="background-color:{{$color->color}}">{{$color->color}}</span></td>
                                    <td>{{number_format($color->price_increase)}} تومان</td>
                                    <td>
                                        @if ($color->status == 2)
                                            <span><i class="text-danger fa fa-toggle-off pointer"
                                                    onclick="changeStatus({{$color->id}})"
                                                    data-url="{{route('admin.market.product-color.status', ['product' => $product->id, 'color' => $color->id])}}"
                                                    id="{{$color->id}}"></i><b class="info">غیرفعال</b></span>
                                        @else
                                            <span><i class="text-success fa fa-toggle-on pointer"
                                                    onclick="changeStatus({{$color->id}})"
                                                    data-url="{{route('admin.market.product-color.status', ['product' => $product->id, 'color' => $color->id])}}"
                                                    id="{{$color->id}}"></i> <b class="info">فعال</b></span>
                                        @endif
                                    </td>

                                    <td class="width-16-rem text-left">
                                        <a class="btn btn-sm btn-warning"
                                            href="{{route('admin.market.product-color.edit', ['product' => $product->id, 'color' => $color->id])}}"><i
                                                class="fa fa-pencil-alt ml-1"></i>ویرایش</a>
                                        <form class="d-inline"
                                            action="{{route('admin.market.product-color.destroy', ['product' => $product->id, 'color' => $color->id])}}"
                                            method="post">
                                            @csrf
                                            {{method_field('delete')}}
                                            <button class="btn btn-sm btn-danger delete"><i
                                                    class="fa fa-trash-alt ml-1"></i>حذف</button>
                                        </form>

                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </section>
        </section>
    </section>
</section>
@endsection
@section('script')
<script type="text/javascript">

    function changeStatus(id) {
        debugger
        var element = $("#" + id);
        var url = element.attr('data-url');
        var info = element.parent().children('.info');
        $.ajax({
            url: url,
            type: "GET",
            success: function (response) {
                
                if (response.status) {
                    if (response.checked) {
                        element.removeClass('text-danger');
                        element.removeClass('fa-toggle-off');
                        element.addClass('text-success');
                        element.addClass('fa-toggle-on');
                        info.text('فعال');
                        showStatusResponse(response.message);
                    }
                    else {

                        element.removeClass('text-success');
                        element.removeClass('fa-toggle-on');
                        element.addClass('text-danger');
                        element.addClass('fa-toggle-off');
                        info.text('غیرفعال');
                        showStatusResponse(response.message);
                    }
                }
                else {
                    showErrorResponse(response.message);
                }
            },
            error: function () {
                showErrorResponse('عملیات با خطا مواجه شد');
            }

        })
    }



    function showStatusResponse(response) {
      
        var toastSuccess = '<section class="toast" data-delay="5000">\n' +
            '<section class="toast-body py-3 d-flex bg-success text-white">\n' +
            '<strong class="ml-auto">' + response + '</strong>\n' +
            '<button type="button" class="mr-2 close" data-dismiss="toast" aria-label="Close">\n' +
            '<span aria-hidden="true">&times;</span>\n' +
            '</button>\n' +
            '</section>\n' +
            '</section>';
        $('.toast-wrapper').append(toastSuccess);
        $('.toast').toast('show').delay(5500).queue(function () {
            $(this).remove();
        });
    }

    function showErrorResponse(response) {
        var toastDanger = ' <section class="toast" data-delay="5000">\n' +
            '<section class="toast-body py-3 d-flex bg-danger text-white">\n' +
            '<strong class="ml-auto">' + response + '</strong>\n' +
            '<button type="button" class="mr-2 close" data-dismiss="toast" aria-label="Close">\n' +
            '<span aria-hidden="true">&times;</span>\n' +
            '</button>\n' +
            '</section>\n' +
            '</section>';
        $('.toast-wrapper').append(toastDanger);
        $('.toast').toast('show').delay(5500).queue(function () {
            $(this).remove();
        });
    }

</script>
@include('admin.alerts.sweetalert.delete-confirm', ['className' => 'delete'])
@endsection