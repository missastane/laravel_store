@extends('admin.layouts.master')

@section('head-tag')
<title>{{$title}}</title>
@endsection

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb text-center">
        <li class="breadcrumb-item font-size-12"><a href="{{route('admin.home')}}">خانه</a></li>
        <li class="breadcrumb-item font-size-12"><a href="{{route('admin.home')}}"> بخش تیکت</a></li>
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
                <a href="" role="button" class="btn btn-primary btn-sm disabled ">ایجاد تیکت جدید</a>
                <form method="GET" action="{{route('admin.ticket.search')}}" class="width-16-rem">
                    <input type="text" class="form-control form-control-sm form-text" name="search" id="" placeholder="جستجوی عنوان تیکت">
                </form>
            </section>
            <section class="table-responsive">
                <table class="table table-striped table-info text-center">

                    <thead>
                        <tr>
                            <th>#</th>
                            <th>نویسنده تیکت</th>
                            <th>عنوان تیکت</th>
                            <th>دسته تیکت</th>
                            <th>اولویت تیکت</th>
                            <th>ارجاع شده به</th>
                            <th>تیکت مرجع</th>
                            <th class="max-width-16-rem text-center"><i class="fa fa-cogs ml-1"></i>تنظیمات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($tickets as $ticket)
                        <tr>
                            
                            <th>{{$loop->iteration}}</th>
                            <td>{{$ticket->user->fullName}}</td>
                            <td>{{$ticket->subject}}</td>
                            <td>{{$ticket->category->name}}</td>
                            <td>{{$ticket->priority->name}}</td>
                            <td>{{$ticket->admin ? $ticket->admin->user->fullName : 'نامشخص'}}</td>
                            <td>{{$ticket->parent == null ? '-' : $ticket->parent->subject}}</td>
                            <td class="text-left width-16-rem">
                                <a href="{{route('admin.ticket.show',$ticket->id)}}" class="btn btn-sm btn-info"><i class="fa fa-eye ml-1"></i>مشاهده</a>
                                <a onclick="changeStatus({{$ticket->id}})" data-url="{{route('admin.ticket.change',$ticket->id)}}" id="{{$ticket->id}}" class="btn btn-sm btn-{{$ticket->status == 1 ? 'success' : 'danger'}} text-white"><i class="fa fa-{{$ticket->status == 1 ? 'check-circle' : 'times-circle'}} ml-1"></i>
                               <span class="info"> {{$ticket->status == 1 ? 'باز کردن' : 'بستن'}}</span>
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
        debugger
        var element = $("#" + id);
        var elementChild = element.children('.fa');
        var url = element.attr('data-url');
        var info = element.children('.info');
        $.ajax({
            url: url,
            type: "GET",
            success: function (response) {
                debugger;
                if (response.status) {
                    if (response.checked) {
                        element.removeClass('btn-danger');
                        elementChild.removeClass('fa-times-circle');
                        element.addClass('btn-success');
                        elementChild.addClass('fa-check-circle');
                        info.text('باز کردن');
                        showStatusResponse(response.message);
                    }
                    else {

                        element.removeClass('btn-success');
                        elementChild.removeClass('fa-check-circle');
                        element.addClass('btn-danger');
                        elementChild.addClass('fa-times-circle');
                        info.text('بستن');
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
@endsection