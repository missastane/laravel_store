@extends('admin.layouts.master')

@section('head-tag')
<title>انبار</title>
@endsection

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb text-center">
        <li class="breadcrumb-item font-size-12"><a href="{{route('admin.home')}}">خانه</a></li>
        <li class="breadcrumb-item font-size-12"><a href="{{route('admin.home')}}"> بخش فروش</a></li>
        <li class="breadcrumb-item active font-size-12" aria-current="page">انبار</li>
    </ol>
</nav>
<section class="row">
    <section class="col-12">
        <section class="main-body-container">
            <section class="main-body-container-header">
                <h4>انبار</h4>
            </section>
            <section class="d-flex justify-content-between align-items-center my-4">
                <button disabled class="btn btn-primary btn-sm">افزودن انبار جدید</button>
                <form method="GET" action="{{route('admin.market.store.search')}}" class="max-width-16-rem">
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
                            <th>تعداد قابل فروش</th>
                            <th>تعداد رزرو شده</th>
                            <th>تعداد فروخته شده</th>




                            <th class="max-width-8-rem text-center"><i class="fa fa-cogs ml-1"></i>تنظیمات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $product)
                            <tr class="vertical-middle">
                                <th>{{$loop->iteration}}</th>
                                <td>{{$product->name}}</td>
                                <td><img class="notification-img" src="{{asset($product->image['indexArray'][$product->image['currentImage']])}}"
                                        alt=""></td>
                                <td>{{$product->marketable_number}}</td>
                                <td>{{$product->frozen_number}}</td>
                                <td>{{$product->sold_number}}</td>
                                <td class="width-22-rem text-left">
                                    <a class="btn btn-sm btn-success" href="{{route('admin.market.store.addToStore', $product->id)}}"><i
                                            class="fa fa-plus-circle ml-1"></i>افزایش موجودی</a>
                                    <a class="btn btn-sm btn-warning" href="{{route('admin.market.store.edit', $product->id)}}"><i class="fa fa-pencil-alt ml-1"></i>اصلاح
                                        موجودی</a>


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