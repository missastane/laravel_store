@extends('admin.layouts.master')

@section('head-tag')
<title>ویرایش تصویر {{$product->name}}</title>
{!! htmlScriptTagJsApi([#logopreview
    'callback_then' => 'callbackThen',
    'callback_catch' => 'callbackCatch',
    ]) !!}
@endsection

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb text-center">
        <li class="breadcrumb-item font-size-12"><a href="{{route('admin.home')}}">خانه</a></li>
        <li class="breadcrumb-item font-size-12"><a href="{{route('admin.home')}}"> بخش فروش</a></li>
        <li class="breadcrumb-item font-size-12"><a
                href="{{route('admin.market.product-color.index', $product->id)}}">مدیریت تصاویر {{$product->name}}</a>
        </li>
        <li class="breadcrumb-item active font-size-12" aria-current="page">ویرایش تصویر {{$product->name}}</li>
    </ol>
</nav>
<section class="row">

    <section class="col-12">
        <section class="main-body-container">
            <section class="main-body-container-header">
                <h4>ویرایش تصویر {{$product->name}}</h4>
            </section>
            <section class="d-flex justify-content-between align-items-center my-4">
                <a class="btn btn-dark btn-sm"
                    href="{{route('admin.market.product-color.index', $product->id)}}">بازگشت</a>

            </section>
            <section>
            <form action="{{route('admin.market.gallery.update', ['product' => $product->id, 'gallery' => $gallery->id])}}" method="post" enctype="multipart/form-data">
                    <section class="row">
                    @csrf
                    @method('put')
                    <section class="col-12 col-md-6 py-2">
                            <div class="form-group">
                                <section class="row">
                                    <section class="col-12 py-2 col-md-7">
                                        <label for="files-logo" class="btn btn-primary mt-4 mx-5">بارگذاری تصویر
                                             </label>
                                        <input type="file" onchange="readURL(this, '#logopreview')"
                                            class="form-control form-control-sm visibility-hidden" name="image"
                                            id="files-logo">
                                    </section>
                                    <section class="col-12 py-2 col-md-5">
                                        <img class="preUpload-preview-img-large"
                                            src="{{asset($gallery->image['indexArray'][$gallery->image['currentImage']])}}" alt=""
                                            id="logopreview">

                                    </section>
                                </section>
                            </div>
                            @error('image')
                                <span class="alert_required text-danger" role="alert"><strong>{{$message}}</strong></span>
                            @enderror
                        </section>                    
                        <section class="col-12 col-md-4 mt-5 py-2">
                            <div class="form-group">
                                <label for="name">نام</label>
                                <input class="form-control form-control-sm" type="text" value="{{old('name',$gallery->name)}}"
                                    name="name" id="name">
                            </div>
                            @error('name')
                                <span class="alert_required text-danger" role="alert"><strong>{{$message}}</strong></span>
                            @enderror
                        </section>
                        <section class="col-12 d-flex mt-3 flex-md-row flex-column align-items-center justify-content-md-center">
                            {!! htmlFormSnippet() !!}
                           
                            @if($errors->has('g-recaptcha-response'))
                            <div style="margin-right:1rem !important">
                             @error('g-recaptcha-response')
                                     <span class="alert_required text-danger mt-md-0 mt-1" role="alert"><strong>{{$message}}</strong></span>
                                 @enderror
                                 </div>
                                 @endif
                            </section>
                        <div class="col-12 col-md-2 mt-4 py-2">
                            <button type="submit" class="btn btn-warning btn-sm mt-5">ویرایش</button>
                        </div>
                    </section>
                </form>
            </section>
        </section>
    </section>
</section>
@endsection