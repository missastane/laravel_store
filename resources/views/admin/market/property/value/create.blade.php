@extends('admin.layouts.master')

@section('head-tag')
<title>ایجاد مقدار جدید برای {{$attribute->name}}</title>
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
        <li class="breadcrumb-item font-size-12"><a href="{{route('admin.market.property-value.index', $attribute->id)}}">مقادیر {{$attribute->name}} برای گروه {{$attribute->category->name}}</a></li>
        <li class="breadcrumb-item active font-size-12" aria-current="page">ایجاد مقدار جدید برای {{$attribute->name}}</li>
    </ol>
</nav>
<section class="row">
    <section class="col-12">
        <section class="main-body-container">
            <section class="main-body-container-header">
                <h4>ایجاد مقدار جدید برای {{$attribute->name}}</h4>
            </section>
            <section class="d-flex justify-content-between align-items-center my-4">
                <a class="btn btn-dark btn-sm" href="{{route('admin.market.property-value.index', $attribute->id)}}">بازگشت</a>
                
            </section>
            <section>
            <form action="{{route('admin.market.property-value.store', $attribute->id)}}" method="post">
                <section class="row">
                    @csrf
                    <section class="col-12 col-md-6 py-2">
                    <div class="form-group">
                    <label for="product_id">محصول</label>
                   <select class="form-control form-control-sm" name="product_id" id="product_id">
                    <option value="" selected disabled>انتخاب محصول از گروه {{$attribute->category->name}}</option>
                    @foreach ($attribute->category->products as $product)
                    <option value="{{$product->id}}" @if ($product->id == old('product_id'))
                    selected 
                    @endif>{{$product->name}}</option>
                    @endforeach
                   
                   </select>
                    </div>
                    @error('product_id')
                                <span class="alert_required text-danger" role="alert"><strong>{{$message}}</strong></span>
                            @enderror
                </section>
                    <section class="col-12 col-md-6 py-2">
                    <div class="form-group">
                        <label for="value">مقدار</label> 
                        <input class="form-control form-control-sm" type="text" value="{{old('value')}}" name="value" id="value">
                    </div>
                    @error('value')
                                <span class="alert_required text-danger" role="alert"><strong>{{$message}}</strong></span>
                            @enderror
                </section>
                    <section class="col-12 col-md-6 py-2">
                    <div class="form-group">
                        <label for="price_increase">میزان افزایش قیمت</label> 
                        <input class="form-control form-control-sm" type="text" value="{{old('price_increase')}}" name="price_increase" id="price_increase">
                    </div>
                    @error('price_increase')
                                <span class="alert_required text-danger" role="alert"><strong>{{$message}}</strong></span>
                            @enderror
                </section>
                
                <section class="col-12 py-2 col-md-6">
                            <div class="form-group">
                                <label for="type">نوع</label>
                                <select class="form-control form-control-sm" name="type" id="type">
                                    <option value="1" @if(old('type') == 1) selected @endif>چند گزینه ای</option>
                                    <option value="2" @if(old('type') == 2) selected @endif>تک انتخابی</option>
                                </select>
                            </div>
                            @error('type')
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
                    <div class="col-12 mt-3">
                        <button type="submit" class="btn btn-success btn-sm mt-2">ثبت</button>
                    </div>
                </section>
            </form>
            </section>
        </section>
    </section>
</section>
@endsection