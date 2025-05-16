@extends('admin.layouts.master')

@section('head-tag')
<title>ادمین های تیکت ها</title>
@endsection

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb text-center">
        <li class="breadcrumb-item font-size-12"><a href="{{route('admin.home')}}">خانه</a></li>
        <li class="breadcrumb-item font-size-12"><a href="{{route('admin.home')}}"> بخش تیکت ها</a></li>
        <li class="breadcrumb-item active font-size-12" aria-current="page">ادمین ها</li>
    </ol>
</nav>
<section class="row">
    <section class="col-12">
        <section class="main-body-container">
            <section class="main-body-container-header">
                <h4>بخش ادمین های تیکت ها</h4>
            </section>
            @include('admin.alerts.alert-section.success')
            <section class="d-flex justify-content-end align-items-center my-4">

                <form method="GET" action="{{route('admin.ticket.admin.search')}}" class="max-width-16-rem">
                    <input type="text" class="form-control form-control-sm form-text" name="search" id="" placeholder="جستجو">
                </form>
            </section>
            <section class="table-responsive">
                <table class="table table-striped table-info text-center">

                <thead>
                        <tr>
                            <th>#</th>
                            <th>نام ادمین</th>
                            <th>ایمیل ادمین</th>
                            <th class="max-width-16-rem text-center"><i class="fa fa-cogs ml-1"></i>تنظیمات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($admins as $key => $admin)
                        <tr>
                       
                            <th>{{$key += 1}}</th>
                          <td>{{$admin->fullName}}</td>
                          <td>{{$admin->email}}</td>
                            <td class="text-left width-8-rem">
                                <a href="{{route('admin.ticket.admin.set', $admin->id)}}" class="btn btn-sm  {{$admin->ticketAdmin == null ? 'btn-success' : 'btn-danger'}}"><i class="fa fa-cog ml-1"></i>
                            {{$admin->ticketAdmin == null ? 'اضافه' : 'حذف'}}
                            </a>
                              
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