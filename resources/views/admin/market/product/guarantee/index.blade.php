@extends('admin.layouts.master')

@section('head-tag')
<title>مدیریت گارانتی های {{$product->name}}</title>
@endsection

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb text-center">
        <li class="breadcrumb-item font-size-12"><a href="{{route('admin.home')}}">خانه</a></li>
        <li class="breadcrumb-item font-size-12"><a href="{{route('admin.home')}}"> بخش فروش</a></li>
        <li class="breadcrumb-item active font-size-12" aria-current="page">مدیریت گارانتی های {{$product->name}}</li>
    </ol>
</nav>
<section class="row">
    <section class="col-12">
        <section class="main-body-container">
            <section class="main-body-container-header">
                <h4>مدیریت گارانتی های {{$product->name}}</h4>
            </section>
            <section class="d-flex justify-content-between align-items-center my-4">
                <section>
                    <a class="btn btn-dark btn-sm" href="{{route('admin.market.product.index')}}">بازگشت</a>
                    <a href="{{route('admin.market.product-guarantee.create', $product->id)}}"
                        class="btn btn-primary btn-sm">افزودن گارانتی جدید</a>
                </section>
                <form method="GET" action="{{route('admin.market.product-guarantee.search', $product)}}"
                    class="max-width-16-rem">
                    <input type="text" class="form-control form-control-sm form-text" name="search" id=""
                        placeholder="جستجو">
                </form>
            </section>
            <section class="table-responsive">
                <table class="table table-striped table-info text-center vertical-middle">

                    <thead>
                        <tr>
                            <th>#</th>
                            <th>نام گارانتی</th>
                            <th>افزایش قیمت</th>
                            <th>وضعیت</th>

                            <th class="max-width-8-rem text-center"><i class="fa fa-cogs ml-1"></i>تنظیمات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($product->guarantees()->get()->toArray() != null)

                                                    @php
                                                        if (session('guaurantee')) {

                                                            $guarantees = request()->session()->get('guaurantee');
                                                            request()->session()->forget('guaurantee');
                                                        } else {
                                                            $guarantees = $product->guarantees;
                                                        }
                                                    @endphp
                                                    @foreach ($guarantees as $guarantee)
                                                        <tr class="vertical-middle">
                                                            <th>{{$loop->iteration}}</th>
                                                            <td>{{$guarantee->name}}</td>
                                                            <td>{{number_format($guarantee->price_increase)}} تومان</td>
                                                            <td>
                                                                @if ($guarantee->status == 2)
                                                                    <span id="{{$product->id}}"><i
                                                                            class="text-danger fa fa-toggle-off pointer {{$guarantee->id}} status"
                                                                            onclick="changeActivation({{$guarantee->id}}, '.status')"
                                                                            data-url="{{route('admin.market.product-guarantee.status', ['product' => $product->id, 'guarantee' => $guarantee->id])}}"
                                                                            id="{{$guarantee->id}}"></i><b class="info">غیرفعال</b></span>
                                                                @else
                                                                    <span id="{{$product->id}}"><i
                                                                            class="text-success fa fa-toggle-on pointer {{$guarantee->id}} status"
                                                                            onclick="changeActivation({{$guarantee->id}}, '.status')"
                                                                            data-url="{{route('admin.market.product-guarantee.status', ['product' => $product->id, 'guarantee' => $guarantee->id])}}"
                                                                            id="{{$guarantee->id}}"></i> <b class="info">فعال</b></span>
                                                                @endif
                                                            </td>

                                                            <td class="width-16-rem text-left">
                                                                <a class="btn btn-sm btn-warning"
                                                                    href="{{route('admin.market.product-guarantee.edit', ['product' => $product->id, 'guarantee' => $guarantee->id])}}"><i
                                                                        class="fa fa-pencil-alt ml-1"></i>ویرایش</a>
                                                                <form class="d-inline"
                                                                    action="{{route('admin.market.product-guarantee.destroy', ['product' => $product->id, 'guarantee' => $guarantee->id])}}"
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

    function changeActivation(id, class_name) {
        debugger
        var element = $("." + id + class_name);
        var url = element.attr('data-url');
        var info = element.parent().children('.info');
        $.ajax({
            url: url,
            type: "GET",
            success: function (response) {
                debugger;
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
        debugger;
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