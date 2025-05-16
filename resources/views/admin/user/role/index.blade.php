@extends('admin.layouts.master')

@section('head-tag')
<title>نقش های کاربران</title>
@endsection

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb text-center">
        <li class="breadcrumb-item font-size-12"><a href="{{route('admin.home')}}">خانه</a></li>
        <li class="breadcrumb-item font-size-12"><a href="{{route('admin.home')}}"> بخش کاربران</a></li>
        <li class="breadcrumb-item active font-size-12" aria-current="page">سطوح دسترسی</li>
    </ol>
</nav>
<section class="row">
    <section class="col-12">
        <section class="main-body-container">
            <section class="main-body-container-header">
                <h4>نقش ها</h4>
            </section>
            <section class="d-flex justify-content-between align-items-center my-4">
                <a href="{{route('admin.user.role.create')}}" role="button" class="btn btn-primary btn-sm">ایجاد نقش جدید</a>
                <form method="GET" action="{{route('admin.user.role.search')}}" class="width-16-rem">
                    <input type="text" class="form-control form-control-sm form-text" name="search" id="" placeholder="جستجوی نقش">
                </form>
            </section>
            <section class="table-responsive">
                <table class="table table-striped table-info text-center">

                    <thead>
                        <tr>
                            <th>#</th>
                            <th>نام نقش</th>
                            <th>دسترسی ها</th>
                            <th class="max-width-16-rem text-center"><i class="fa fa-cogs ml-1"></i>تنظیمات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($roles as $key=>$role)
                        <tr>
                            <th>{{$key + 1}}</th>
                            <td>{{$role->name}}</td>
                           <td>
                            @if (!empty($role->permissions()->get()->toArray()))
                            @foreach ($role->permissions as $number=> $permission)
                         <p>{{$number+1}}- {{$permission->name}}</p>
                         @endforeach
                         @else
                         <span class="text-danger">برای این نقش هیچ دسترسی تعریف نشده است</span>
                            @endif
                        
                           </td>
                            <td class="text-left width-22-rem">
                                <a href="{{route('admin.user.role.permission-form', $role->id)}}" class="btn btn-sm btn-success"><i class="fa fa-edit ml-1"></i>دسترسی ها</a>
                                <a href="{{route('admin.user.role.edit', $role->id)}}" class="btn btn-sm btn-warning"><i class="fa fa-pencil-alt ml-1"></i>ویرایش</a>
                                
                                <form class="d-inline"
                                        action="{{route('admin.user.role.destroy', $role->id)}}"
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
@include('admin.alerts.sweetalert.delete-confirm', ['className' => 'delete'])
@endsection