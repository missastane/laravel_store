@extends('admin.layouts.master')

@section('head-tag')
<title>دسته بندی پست ها</title>
@endsection

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb text-center">
        <li class="breadcrumb-item font-size-12"><a href="{{route('admin.home')}}">خانه</a></li>
        <li class="breadcrumb-item font-size-12"><a href="{{route('admin.home')}}"> بخش محتوی</a></li>
        <li class="breadcrumb-item active font-size-12" aria-current="page">دسته بندی</li>
    </ol>
</nav>
<section class="row">
    <section class="col-12">
        <section class="main-body-container">
            <section class="main-body-container-header">
                <h4>بخش دسته بندی پست ها</h4>
            </section>
            @include('admin.alerts.alert-section.success')
            <section class="d-flex justify-content-between align-items-center my-4">
                <a class="btn btn-primary btn-sm" href="{{route('admin.content.category.create')}}">ایجاد دسته جدید</a>

                <form method="GET" action="{{route('admin.content.category.search')}}" class="max-width-16-rem">
                    <input type="text" class="form-control form-control-sm form-text" name="search" id="" placeholder="جستجو">
                </form>
            </section>
            <section class="table-responsive">
                <table class="table table-striped table-info text-center">

                    <thead>
                        <tr>
                            <th>#</th>
                            <th>نام</th>
                            <th>توضیحات</th>
                            <th>اسلاگ</th>
                            <th>تصویر</th>
                            <th>تگ ها</th>
                            <th>وضعیت</th>
                            <th class="max-width-16-rem text-center"><i class="fa fa-cogs ml-1"></i>تنظیمات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($postCategories as $key => $postCategory)
                            <tr>
                                <th>{{$key += 1}}</th>
                                <td>{{$postCategory->name}}</td>
                                <td>{{$postCategory->description}}</td>
                                <td>{{$postCategory->slug}}</td>
                                <td>
                                   
                                    <img src="{{asset($postCategory->image['indexArray'][$postCategory->image['currentImage']])}}" class="notification-img" alt="">
                                  
                                </td>
                                <td>{{$postCategory->tags}}</td>
                                <td>
                                    @if ($postCategory->status == 2)
                                        <span><i class="text-danger fa fa-toggle-off pointer"
                                                onclick="changeStatus({{$postCategory->id}})"
                                                data-url="{{route('admin.content.category.status', $postCategory->id)}}"
                                                id="{{$postCategory->id}}"></i><b class="info">غیرفعال</b></span>
                                    @else
                                        <span><i class="text-success fa fa-toggle-on pointer"
                                                onclick="changeStatus({{$postCategory->id}})"
                                                data-url="{{route('admin.content.category.status', $postCategory->id)}}"
                                                id="{{$postCategory->id}}"></i> <b class="info">فعال</b></span>
                                    @endif
                                </td>
                                <td class="width-16-rem text-left">
                                    <a class="btn btn-sm btn-warning"
                                        href="{{route('admin.content.category.edit', $postCategory->id)}}"><i
                                            class="fa fa-pencil-alt ml-1"></i>ویرایش</a>
                                    <form class="d-inline"
                                        action="{{route('admin.content.category.destroy', $postCategory->id)}}"
                                        method="post">
                                        @csrf
                                        {{method_field('delete')}}
                                        <button type="submit" class="btn btn-sm btn-danger delete"><i
                                                class="fa fa-trash-alt ml-1"></i>حذف</button>
                                    </form>

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
        var elementValue = $(this).attr('id');
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