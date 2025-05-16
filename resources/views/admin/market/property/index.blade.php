@extends('admin.layouts.master')

@section('head-tag')
<title>فرم کالا</title>
@endsection

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb text-center">
        <li class="breadcrumb-item font-size-12"><a href="{{route('admin.home')}}">خانه</a></li>
        <li class="breadcrumb-item font-size-12"><a href="{{route('admin.home')}}"> بخش فروش</a></li>
        <li class="breadcrumb-item active font-size-12" aria-current="page">فرم کالا</li>
    </ol>
</nav>
<section class="row">
    <section class="col-12">
        <section class="main-body-container">
            <section class="main-body-container-header">
                <h4>فرم کالا</h4>
            </section>
            <section class="d-flex justify-content-between align-items-center my-4">
                <a class="btn btn-primary btn-sm" href="{{route('admin.market.property.create')}}">ایجاد فرم کالا</a>
                <form method="GET" action="{{route('admin.market.property.search')}}" class="max-width-16-rem">
                    <input type="text" class="form-control form-control-sm form-text" name="search" id="" placeholder="جستجو">
                </form>
            </section>
            <section class="table-responsive">
                <table class="table table-striped table-info text-center">

                    <thead>
                        <tr>
                            <th>#</th>
                            <th>نام فرم</th>
                            <th>واحد اندازه گیری فرم</th>
                            <th>متعلق به دسته</th>
                            <th class="max-width-16-rem text-center"><i class="fa fa-cogs ml-1"></i>تنظیمات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($category_attributes as $category_attribute)
                        <tr>
                            <th>{{convertEnglishToPersian($loop->iteration)}}</th>
                            <td>{{$category_attribute->name}}</td>
                            <td>{{$category_attribute->unit}}</td>
                            <td>{{$category_attribute->category->name}}</td>
                            <td class="width-22-rem text-left">
                                <a class="btn btn-sm btn-success" href="{{route('admin.market.property-value.index', $category_attribute->id)}}"><i class="fa fa-edit ml-1"></i>مقادیر</a>
                                <a class="btn btn-sm btn-warning" href="{{route('admin.market.property.edit', $category_attribute->id)}}"><i class="fa fa-pencil-alt ml-1"></i>ویرایش</a>
                                <form class="d-inline" action="{{route('admin.market.property.destroy', $category_attribute->id)}}" method="POST">
                                            @csrf
                                            @method('delete')
                                        <button type="submit" class="btn btn-sm btn-danger delete"><i class="fa fa-trash"></i> حذف</button>
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