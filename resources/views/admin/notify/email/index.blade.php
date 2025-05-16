@extends('admin.layouts.master')

@section('head-tag')
<title>اطلاعیه ایمیلی</title>
@endsection

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb text-center">
        <li class="breadcrumb-item font-size-12"><a href="{{route('admin.home')}}">خانه</a></li>
        <li class="breadcrumb-item font-size-12"><a href="{{route('admin.home')}}"> بخش اطلاع رسانی</a></li>
        <li class="breadcrumb-item active font-size-12" aria-current="page">اطلاعیه ایمیلی</li>
    </ol>
</nav>
<section class="row">
    <section class="col-12">
        <section class="main-body-container">
            <section class="main-body-container-header">
                <h4>بخش اطلاعیه ایمیلی</h4>
            </section>
            <section class="d-flex justify-content-between align-items-center my-4">
                <a class="btn btn-primary btn-sm" href="{{route('admin.notify.email.create')}}">ایجاد اطلاعیه ایمیلی
                    جدید</a>
                <form method="GET" action="{{route('admin.notify.email.search')}}" class="max-width-16-rem">
                    <input type="text" class="form-control form-control-sm form-text" name="search" id="" placeholder="جستجو">
                </form>
            </section>
            <section class="table-responsive">
                <table class="table table-striped table-info text-center">

                    <thead>
                        <tr>
                            <th>#</th>
                            <th>عنوان اطلاعیه</th>
                            <th>خلاصه متن اطلاعیه</th>
                            <th>تاریخ ارسال</th>
                            <th>وضعیت</th>
                            <th class="max-width-16-rem text-center"><i class="fa fa-cogs ml-1"></i>تنظیمات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($emails as $key => $email)
                            <tr>
                               
                                <th>{{$key+=1}}</th>
                                <td>{{$email->subject}}</td>
                                <td>{{Str::limit(strip_tags($email->body))}}</td>
                                <td>{{jalalidate($email->published_at)}}</td>
                                <td>
                                    @if ($email->status == 2)
                                        <span><i class="text-danger fa fa-toggle-off pointer"
                                                onclick="changeStatus({{$email->id}})"
                                                data-url="{{route('admin.notify.email.status', $email->id)}}"
                                                id="{{$email->id}}"></i><b class="info">غیرفعال</b></span>
                                    @else
                                        <span><i class="text-success fa fa-toggle-on pointer"
                                                onclick="changeStatus({{$email->id}})"
                                                data-url="{{route('admin.notify.email.status', $email->id)}}"
                                                id="{{$email->id}}"></i> <b class="info">فعال</b></span>
                                    @endif
                                </td>
                                <td class="width-22-rem text-left">
                                
                                <a class="btn btn-sm btn-info" href="{{route('admin.notify.email.show', $email->id)}}"><i
                                class="fa fa-eye ml-1"></i>جزئیات</a>
                                    <a class="btn btn-sm btn-warning" href="{{route('admin.notify.email.edit', $email->id)}}"><i
                                            class="fa fa-pencil-alt ml-1"></i>ویرایش</a>
                                            <form class="d-inline"
                                        action="{{route('admin.notify.email.destroy', $email->id)}}"
                                        method="post">
                                        @csrf
                                        {{method_field('delete')}}
                                        <button type="submit" class="btn btn-sm btn-danger delete"><i
                                                class="fa fa-trash-alt ml-1"></i>حذف</button>
                                    </form>
                                    <a href="{{route('admin.notify.email.send', $email)}}" class="btn btn-sm btn-primary">ارسال</a>
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
        debugger
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