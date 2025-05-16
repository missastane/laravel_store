@extends('admin.layouts.master')

@section('head-tag')
<title>کالاها</title>
@endsection

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb text-center">
        <li class="breadcrumb-item font-size-12"><a href="{{route('admin.home')}}">خانه</a></li>
        <li class="breadcrumb-item font-size-12"><a href="{{route('admin.home')}}"> بخش فروش</a></li>
        <li class="breadcrumb-item active font-size-12" aria-current="page">کالاها</li>
    </ol>
</nav>
<section class="row">
    <section class="col-12">
        <section class="main-body-container">
            <section class="main-body-container-header">
                <h4>کالاها</h4>
            </section>
            <section class="d-flex justify-content-between align-items-center my-4">
                <a href="{{route('admin.market.product.create')}}"  class="btn btn-primary btn-sm">افزودن کالای جدید</a>
                <form method="GET" action="{{route('admin.market.product.search')}}" class="max-width-16-rem">
                    <input type="text" class="form-control form-control-sm form-text" name="search" id="" placeholder="جستجو">
                </form>
            </section>
            <section class="table-responsive">
                <table class="table table-striped table-info text-center vertical-middle">

                    <thead>
                        <tr>
                            <th>#</th>
                            <th>نام کالا</th>
                            <th>تصویر کالا</th>
                            <th>قیمت</th>
                            <th>وزن</th>
                            <th>دسته</th>
                            <th>فرم</th>
                            <th>وضعیت</th>
                            
                            

                            <th class="max-width-8-rem text-center"><i class="fa fa-cogs ml-1"></i>تنظیمات</th>
                        </tr>
                    </thead>
                    <tbody>                 
                     @foreach ($products as $product)
                     <tr class="vertical-middle">
                            <th>{{$loop->iteration}}</th>
                          <td>{{$product->name}}</td>
                          <td><img  class="notification-img" src="{{asset($product->image['indexArray'][$product->image['currentImage']])}}" alt=""></td>
                          <td>{{priceFormat($product->price)}} تومان</td>
                          <td>{{convertEnglishToPersian($product->weight)}}</td>
                          <td>{{$product->category->name}}</td>
                          <td>نمایشگر</td>
                          <td>
                                    @if ($product->status == 2)
                                        <span><i class="text-danger fa fa-toggle-off pointer"
                                                onclick="changeStatus({{$product->id}})"
                                                data-url="{{route('admin.market.product.status', $product->id)}}"
                                                id="{{$product->id}}"></i><b class="info">غیرفعال</b></span>
                                    @else
                                        <span><i class="text-success fa fa-toggle-on pointer"
                                                onclick="changeStatus({{$product->id}})"
                                                data-url="{{route('admin.market.product.status', $product->id)}}"
                                                id="{{$product->id}}"></i> <b class="info">فعال</b></span>
                                    @endif
                                </td>

                            <td class="width-8-rem text-left">
                                <div class="">
                                    <a class="btn btn-success btn-sm btn-block dorpdown-toggle" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-expanded="false">
                                        <i class="fa fa-tools"></i> عملیات
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                        <a href="{{route('admin.market.gallery.index', $product->id)}}" class="dropdown-item text-right header-profile-link"><i class="fa fa-images"></i> گالری</a>
                                        <a href="{{route('admin.market.product-color.index', $product->id)}}" class="dropdown-item text-right header-profile-link"><i class="fa fa-palette"></i>مدیریت رنگ ها</a>
                                        <a href="{{route('admin.market.product-guarantee.index', $product->id)}}" class="dropdown-item text-right header-profile-link"><i class="fa fa-shield-alt"></i>گارانتی</a>
                                        <a href="{{route('admin.market.product.properties', $product->id)}}" class="dropdown-item text-right header-profile-link"><i class="fa fa-edit"></i> فرم کالا</a>
                                        <a href="{{route('admin.market.product.edit', $product->id)}}" class="dropdown-item text-right header-profile-link"><i class="fa fa-edit"></i> ویرایش</a>
                                        <form action="{{route('admin.market.product.destroy', $product->id)}}" method="POST">
                                            @csrf
                                            @method('delete')
                                        <button type="submit" class="dropdown-item text-right header-profile-link delete"><i class="fa fa-window-close"></i> حذف</button>
                                        </form>
                                        
                                    </div>
                                </div>
                              
                               
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
@section('script')
<script type="text/javascript">

    function changeStatus(id) {
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


    function approved(id) {
        
        const button = $('#' + id + '_approved');
        const button_icon = button.children('i');
        const url = button.attr('data-approved-url');
        const approved_icon = $('#' + id + '_Approved').children('.fa');
        const approved_info_span = $('#' + id + '_Approved').children('.approved-info');
        const approved_info = $('#' + id + '_approved-info');
        $.ajax({
            url: url,
            type: "GET",
            success: function (response) {
               
                if (response.status) {
                    if (response.checked) {

                        button.removeClass('btn-success');
                        button.addClass('btn-danger');
                        button_icon.removeClass('fa-check-circle');
                        button_icon.addClass('fa-times-circle');
                        approved_info.text('عدم تأیید');
                        approved_icon.removeClass('text-danger fa-times-circle');
                        approved_icon.addClass('text-success fa-check-circle');
                        approved_info_span.text('تأیید شده');
                        showStatusResponse(response.message);
                    }
                    else {
                        button.removeClass('btn-danger');
                        button.addClass('btn-success');
                        button_icon.removeClass('fa-times-circle');
                        button_icon.addClass('fa-check-circle');
                        approved_info.text('تأیید');
                        approved_icon.removeClass('text-success fa-check-circle');
                        approved_icon.addClass('text-danger fa-times-circle');
                        approved_info_span.text('تأیید نشده');

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