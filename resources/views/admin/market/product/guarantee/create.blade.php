@extends('admin.layouts.master')

@section('head-tag')
<title>افزودن گارانتی برای {{$product->name}}</title>
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
        <li class="breadcrumb-item font-size-12"><a href="{{route('admin.market.product-guarantee.index', $product->id)}}">مدیریت گارانتی های {{$product->name}}</a></li>
        <li class="breadcrumb-item active font-size-12" aria-current="page">افزودن گارانتی برای {{$product->name}}</li>
    </ol>
</nav>
<section class="row">
    
    <section class="col-12">
        <section class="main-body-container">
            <section class="main-body-container-header">
                <h4>افزودن گارانتی جدید {{$product->name}}</h4>
            </section>
            <section class="d-flex justify-content-between align-items-center my-4">
                <a class="btn btn-dark btn-sm" href="{{route('admin.market.product-guarantee.index', $product->id)}}">بازگشت</a>

            </section>
            <section>
                <form action="{{route('admin.market.product-guarantee.store', $product->id)}}" method="post">
                    <section class="row">
                    @csrf
                                               
                        <section class="col-12 col-md-5 py-2">
                            <div class="form-group">
                                <label for="name">نام گارانتی</label>
                                <input class="form-control form-control-sm" type="text" value="{{old('name')}}"
                                    name="name" id="name">
                            </div>
                            @error('name')
                                <span class="alert_required text-danger" role="alert"><strong>{{$message}}</strong></span>
                            @enderror
                        </section>
                        <section class="col-12 col-md-5 py-2">
                            <div class="form-group">
                                <label for="price_increase">افزایش قیمت</label>
                                <input class="form-control form-control-sm" type="text" value="{{old('price_increase')}}"
                                    name="price_increase" id="price_increase">
                            </div>
                            @error('price_increase')
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
                        <div class="col-12 col-md-2 mt-4">
                            <button type="submit" class="btn btn-success btn-sm mt-3">ثبت</button>
                        </div>
                    </section>
                </form>
            </section>
        </section>
    </section>
</section>
@endsection