@extends('admin.layouts.master')

@section('head-tag')
<title>کاربران ادمین</title>
@endsection

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb text-center">
        <li class="breadcrumb-item font-size-12"><a href="{{route('admin.home')}}">خانه</a></li>
        <li class="breadcrumb-item font-size-12"><a href="{{route('admin.home')}}"> بخش کاربران</a></li>
        <li class="breadcrumb-item active font-size-12" aria-current="page">کاربران ادمین</li>
    </ol>
</nav>
<section class="row">
    <section class="col-12">
        <section class="main-body-container">
            <section class="main-body-container-header">
                <h4>کاربران ادمین</h4>
            </section>
            <section class="d-flex justify-content-between align-items-center my-4">
                <a href="{{route('admin.user.admin-user.create')}}" role="button" disabled
                    class="btn btn-primary btn-sm">ایجاد ادمین جدید</a>
                <form method="GET" action="{{route('admin.user.admin-user.search')}}" class="width-16-rem">
                    <input type="text" class="form-control form-control-sm form-text" name="search" id="" placeholder="جستجو">
                </form>
            </section>
            <section class="table-responsive">
                <table class="table table-striped table-info text-center">

                    <thead>
                        <tr>
                            <th>#</th>
                            <th>نام</th>
                            <th>نام خانوادگی</th>
                            <th>تصویر</th>
                            <th>نقش</th>
                            <th>دسترسی</th>
                            <th>ایمیل و شماره موبایل</th>
                           
                         
                            <th>وضعیت</th>
                            <th>وضعیت فعالسازی</th>
                            <th class="max-width-16-rem text-center"><i class="fa fa-cogs ml-1"></i>تنظیمات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($admins as $key => $admin)
                            <tr>
                                <th>{{$key += 1}}</th>
                                <td>{{$admin->first_name}}</td>
                                <td>{{$admin->last_name}}</td>
                                <td><img class="notification-img" src="{{asset($admin->profile_photo_path)}}" alt=""></td>
                                <td>
                                    @forelse ($admin->roles as $num => $role)
                                    <p>{{$num+1}}- {{$role->name}}</p>
                                    @empty
                                    <span class="text-danger">نقشی یافت نشد</span>
                                    @endforelse
                                </td>
                                <td>
                                    @forelse ($admin->permissions as $num => $permission)
                                    <p>{{$num+1}}- {{$permission->name}}</p>
                                    @empty
                                    <span class="text-danger">دسترسی یافت نشد</span>
                                    @endforelse
                                </td>
                                <td>
                                    <p class="text-center">{{$admin->mobile}}</p>
                                    <p >{{$admin->email}}</p>
                                </td>
                                
                                <td>
                                    @if ($admin->status == 2)
                                        <span><i class="text-danger fa fa-toggle-off pointer {{$admin->id}} status"
                                                onclick="changeActivation({{$admin->id}}, '.status')"
                                                data-url="{{route('admin.user.admin-user.status', $admin->id)}}"
                                                id="{{$admin->id}}"></i><b class="info">غیرفعال</b></span>
                                    @else
                                        <span><i class="text-success fa fa-toggle-on pointer {{$admin->id}} status"
                                                onclick="changeActivation({{$admin->id}}, '.status')"
                                                data-url="{{route('admin.user.admin-user.status', $admin->id)}}"
                                                id="{{$admin->id}}"></i> <b class="info">فعال</b></span>
                                    @endif
                                </td>
                                <td>
                                    @if ($admin->activation == 2)
                                        <span><i class="text-danger fa fa-toggle-off pointer {{$admin->id}} activation"
                                                onclick="changeActivation({{$admin->id}}, '.activation')"
                                                data-url="{{route('admin.user.admin-user.activation', $admin->id)}}"
                                                id="{{$admin->id}}"></i><b class="info">غیرفعال</b></span>
                                    @else
                                        <span><i class="text-success fa fa-toggle-on pointer {{$admin->id}} activation"
                                                onclick="changeActivation({{$admin->id}}, '.activation')"
                                                data-url="{{route('admin.user.admin-user.activation', $admin->id)}}"
                                                id="{{$admin->id}}"></i> <b class="info">فعال</b></span>
                                    @endif
                                </td>
                                <td class="text-left width-22-rem">
                                    <a href="{{route('admin.user.admin-user.permissions', $admin->id)}}" class="btn btn-sm btn-success"><i class="fa fa-edit ml-1"></i>دسترسی</a>
                                    <a href="{{route('admin.user.admin-user.roles', $admin->id)}}" class="btn btn-sm btn-info"><i class="fa fa-edit ml-1"></i>نقش</a>
                                    <a href="{{route('admin.user.admin-user.edit', $admin->id)}}" class="btn btn-sm btn-warning"><i class="fa fa-pencil-alt ml-1"></i>ویرایش</a>
                                    <form class="d-inline"
                                        action="{{route('admin.user.admin-user.destroy', $admin->id)}}"
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