@extends('admin.layouts.master')

@section('head-tag')
<title>تنظیمات</title>
@endsection

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb text-center">
        <li class="breadcrumb-item font-size-12"><a href="{{route('admin.home')}}">خانه</a></li>
        <li class="breadcrumb-item font-size-12"><a href="{{route('admin.home')}}"> بخش تنظیمات</a></li>
        <li class="breadcrumb-item active font-size-12" aria-current="page">تنظیمات</li>
    </ol>
</nav>
<section class="row">
    <section class="col-12">
        <section class="main-body-container">
            <section class="main-body-container-header">
                <h4>بخش تنظیمات</h4>
            </section>
            <section class="d-flex justify-content-between align-items-center my-4">
                <a href="" class="btn btn-primary btn-sm disabled">ایجاد تنظیمات جدید</a>
               
            </section>
            <section class="table-responsive">
                <table class="table table-striped table-info text-center">

                    <thead>
                        <tr>
                            <th>#</th>
                            <th>عنوان سایت</th>
                            <th>توضیحات سایت</th>
                            <th>کلمات کلیدی سایت</th>
                            <th>لوگوی سایت</th>
                            <th>آیکن سایت</th>
                           
                            
                            <th class="max-width-16-rem text-center"><i class="fa fa-cogs ml-1"></i>تنظیمات</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th>1</th>
                            <td>{{$setting->title}}</td>
                            <td>{{$setting->description}}</td>
                            <td>{{$setting->keywords}}</td>
                            <td><img class="notification-img" src="{{asset($setting->logo)}}" alt=""></td>
                            <td><img class="notification-img" src="{{asset($setting->icon)}}" alt=""></td>
                            <td class="width-8-rem text-left">
                                <a class="btn btn-sm btn-warning" href="{{route('admin.setting.edit')}}"><i class="fa fa-pencil-alt ml-1"></i>ویرایش</a>
                              
                                
                            </td>
                        </tr>
                       
                    </tbody>
                </table>
            </section>
        </section>
    </section>
</section>
@endsection