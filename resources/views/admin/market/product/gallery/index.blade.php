@extends('admin.layouts.master')

@section('head-tag')
<title>مدیریت تصاویر {{$product->name}}</title>
@endsection

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb text-center">
        <li class="breadcrumb-item font-size-12"><a href="{{route('admin.home')}}">خانه</a></li>
        <li class="breadcrumb-item font-size-12"><a href="{{route('admin.home')}}"> بخش فروش</a></li>
        <li class="breadcrumb-item active font-size-12" aria-current="page">مدیریت تصاویر {{$product->name}}</li>
    </ol>
</nav>
<section class="row">
    <section class="col-12">
        <section class="main-body-container">
            <section class="main-body-container-header">
                <h4>مدیریت تصاویر {{$product->name}}</h4>
            </section>
            <section class="d-flex justify-content-between align-items-center my-4">
          <section>
          <a class="btn btn-dark btn-sm" href="{{route('admin.market.product.index')}}">بازگشت</a>
          <a href="{{route('admin.market.gallery.create', $product->id)}}"
                    class="btn btn-primary btn-sm">افزودن تصویر جدید</a>
          </section>
                <form method="GET" action="{{route('admin.market.gallery.search', $product)}}" class="max-width-16-rem">
                    <input type="text" class="form-control form-control-sm form-text" name="search" id="" placeholder="جستجو">
                </form>
            </section>
            <section class="table-responsive">
                <table class="table table-striped table-info text-center vertical-middle">

                    <thead>
                        <tr>
                            <th>#</th>
                            <th>نام</th>
                            <th>تصویر</th>
                           
                           <th class="max-width-8-rem text-center"><i class="fa fa-cogs ml-1"></i>تنظیمات</th>
                        </tr>
                    </thead>
                    <tbody>  
                        @if ($product->images()->get()->toArray() != null)
                        @php
                        if (session('images')) {

                            $images = request()->session()->get('images');
                            request()->session()->forget('images');
                        } else {
                            $images = $product->images;
                        }
                    @endphp
                                      
                     @foreach ($images as $gallery)
                     <tr class="vertical-middle">
                            <th>{{$loop->iteration}}</th>
                          <td>{{$gallery->name}}</td>
                          <td><img class="notification-img" src="{{asset($gallery->image['indexArray'][$gallery->image['currentImage']])}}" alt=""></td>
                          

                            <td class="width-16-rem text-left">
                            <a class="btn btn-sm btn-warning" href="{{route('admin.market.gallery.edit',  ['product'=> $product->id,'gallery'=> $gallery->id])}}"><i class="fa fa-pencil-alt ml-1"></i>ویرایش</a>
                            <form class="d-inline" action="{{route('admin.market.gallery.destroy', ['product'=> $product->id,'gallery'=> $gallery->id])}}" method="post">
                            @csrf
                            {{method_field('delete')}}
                            <button class="btn btn-sm btn-danger delete"><i class="fa fa-trash-alt ml-1"></i>حذف</button>
                            </form>
                               
                            </td>
                        </tr>
                     @endforeach
                     @endif
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