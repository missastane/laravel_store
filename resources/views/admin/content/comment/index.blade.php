@extends('admin.layouts.master')

@section('head-tag')
<title>نظرات پست ها</title>
@endsection

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb text-center">
        <li class="breadcrumb-item font-size-12"><a href="{{route('admin.home')}}">خانه</a></li>
        <li class="breadcrumb-item font-size-12"><a href="{{route('admin.home')}}"> بخش محتوی</a></li>
        <li class="breadcrumb-item active font-size-12" aria-current="page">نظرات</li>
    </ol>
</nav>
<section class="row">
    <section class="col-12">
        <section class="main-body-container">
            <section class="main-body-container-header">
                <h4>نظرات پست ها</h4>
            </section>
            <section class="d-flex justify-content-between align-items-center my-4">
                <a class="btn btn-primary btn-sm disabled">ایجاد نظر جدید</a>
                <form method="GET" action="{{route('admin.content.comment.search')}}" class="max-width-16-rem">
                    <input type="text" class="form-control form-control-sm form-text" name="search" id="" placeholder="جستجو در متن نظر">
                </form>
            </section>
            <section class="table-responsive">
                <table class="table table-striped table-info text-center">

                    <thead>
                        <tr>
                            <th>#</th>
                            <th>متن نظر</th>
                            <th>پاسخ به</th>
                            <th>نویسنده نظر</th>
                            <th>عنوان پست</th>
                            <th>وضعیت تأیید</th>
                            <th>وضعیت نظر</th>
                            <th class="max-width-16-rem text-center"><i class="fa fa-cogs ml-1"></i>تنظیمات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($comments as $key => $comment)


                            <tr>
                                <th>{{$key += 1}}</th>
                                <td>{{Str::limit($comment->body, 10)}}</td>
                                <td>{{$comment->parent ? Str::limit($comment->parent->body,15) : '-'}}</td>
                                <td>{{$comment->user->fullName}}</td>
                                <td>{{$comment->commentable->title}}</td>
                                <td>@if ($comment->approved == 2)
                                    <section id="{{$comment->id}}_Approved">
                                        <i class="fa fa-times-circle text-danger"></i>
                                        <span class="approved-info"> تأیید نشده</span>
                                    </section>
                                @else
                                    <section id="{{$comment->id}}_Approved">
                                        <i class="fa fa-check-circle text-success"></i>
                                        <span class="approved-info"> تأیید شده</span>
                                    </section>
                                @endif
                                </td>
                                <td>
                                    @if ($comment->status == 2)
                                        <span><i class="text-danger fa fa-toggle-off pointer"
                                                onclick="changeStatus({{$comment->id}})"
                                                data-url="{{route('admin.content.comment.status', $comment->id)}}"
                                                id="{{$comment->id}}"></i><b class="info">غیرفعال</b></span>
                                    @else
                                        <span><i class="text-success fa fa-toggle-on pointer"
                                                onclick="changeStatus({{$comment->id}})"
                                                data-url="{{route('admin.content.comment.status', $comment->id)}}"
                                                id="{{$comment->id}}"></i> <b class="info">فعال</b></span>
                                    @endif
                                </td>
                                <td class="width-16-rem text-left">
                                    <a class="btn btn-sm btn-info"
                                        href="{{route('admin.content.comment.show', $comment->id)}}"><i
                                            class="fa fa-eye ml-1"></i>نمایش</a>
                                    @if ($comment->approved == 2)
                                        <a id="{{$comment->id}}_approved" class="btn btn-sm btn-success text-white"
                                            onclick="approved({{$comment->id}})"
                                            data-approved-url="{{route('admin.content.comment.approved', $comment->id)}}"><i
                                                class="fa fa-check-circle ml-1"></i><span
                                                id="{{$comment->id}}_approved-info">تأیید</span></a>
                                    @else
                                        <a class="btn btn-sm btn-danger text-white" onclick="approved({{$comment->id}})"
                                            id="{{$comment->id}}_approved"
                                            data-approved-url="{{route('admin.content.comment.approved', $comment->id)}}"><i
                                                class="fa fa-times-circle ml-1"></i>
                                            <span id="{{$comment->id}}_approved-info">عدم تأیید</span>
                                        </a>
                                    @endif
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
@endsection