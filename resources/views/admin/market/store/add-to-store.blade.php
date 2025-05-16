@extends('admin.layouts.master')

@section('head-tag')
<title>افزایش موجودی</title>
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
        <li class="breadcrumb-item font-size-12"><a href="{{route('admin.market.store.index')}}">انبار</a></li>
        <li class="breadcrumb-item active font-size-12" aria-current="page">افزایش موجودی</li>
    </ol>
</nav>
<section class="row">
    <section class="col-12">
        <section class="main-body-container">
            <section class="main-body-container-header">
                <h4>افزایش موجودی</h4>
            </section>
            <section class="d-flex justify-content-between align-items-center my-4">
                <a class="btn btn-dark btn-sm" href="{{route('admin.market.store.index')}}">بازگشت</a>

            </section>
            <section>
                <form action="{{route('admin.market.store.store', $product->id)}}" method="post">
                    <section class="row">
                        @csrf
                        <section class="col-12 col-md-5 py-2">
                            <div class="form-group">
                                <label for="receiver">نام تحویل گیرنده</label>
                                <input class="form-control form-control-sm" type="text" value="{{old('receiver')}}" name="receiver" id="receiver">
                            </div>
                            @error('receiver')
                                <span class="alert_required text-danger" role="alert"><strong>{{$message}}</strong></span>
                            @enderror
                        </section>
                        <section class="col-12 col-md-5 py-2">
                            <div class="form-group">
                                <label for="deliverer">نام تحویل دهنده</label>
                                <input class="form-control form-control-sm" type="text" value="{{old('deliverer')}}" name="deliverer" id="deliverer">
                            </div>
                            @error('deliverer')
                                <span class="alert_required text-danger" role="alert"><strong>{{$message}}</strong></span>
                            @enderror
                        </section>
                      
                       
                        <section class="col-12 col-md-2 py-2">
                            <div class="form-group">
                                <label for="marketable_number">تعداد</label>
                                <input class="form-control form-control-sm" type="number" value="{{old('marketable_number')}}" name="marketable_number" id="marketable_number">
                            </div>
                            @error('marketable_number')
                                <span class="alert_required text-danger" role="alert"><strong>{{$message}}</strong></span>
                            @enderror
                        </section>
                        <section class="col-12 py-2">
                            <div class="form-group">
                                <label for="description">توضیحات</label>
                                <textarea rows="4" class="form-control form-control-sm" name="description" id="description">{{old('description')}}</textarea>
                            </div>
                            @error('description')
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
                       
                        <div class="col-12 mt-2">
                            <button type="submit" class="btn btn-primary btn-sm">ثبت</button>
                        </div>
                    </section />
                </form>
            </section>
        </section>
    </section>
</section>
@endsection
