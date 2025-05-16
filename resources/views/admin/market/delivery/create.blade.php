@extends('admin.layouts.master')

@section('head-tag')
<title>ایجاد روش جدید ارسال محصول</title>
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
        <li class="breadcrumb-item font-size-12"><a href="{{route('admin.market.delivery.index')}}">روش های ارسال</a></li>
        <li class="breadcrumb-item active font-size-12" aria-current="page">ایجاد روش جدید ارسال محصول</li>
    </ol>
</nav>
<section class="row">
    <section class="col-12">
        <section class="main-body-container">
            <section class="main-body-container-header">
                <h4>ایجاد روش جدید برای ارسال محصولات</h4>
            </section>
            <section class="d-flex justify-content-between align-items-center my-4">
                <a class="btn btn-dark btn-sm" href="{{route('admin.market.delivery.index')}}">بازگشت</a>
                
            </section>
            <section>
            <form action="{{route('admin.market.delivery.store')}}" method="post">
                <section class="row">
                    @csrf
                    <section class="col-12 col-md-6 py-2">
                    <div class="form-group">
                        <label for="name">نام</label> 
                        <input class="form-control form-control-sm" value="{{old('name')}}" type="text" name="name" id="name">
                    </div>
                    @error('name')
                                <span class="alert_required text-danger" role="alert"><strong>{{$message}}</strong></span>
                            @enderror
                </section>
                    <section class="col-12 col-md-6 py-2">
                    <div class="form-group">
                        <label for="amount">هزینه ارسال</label> 
                        <input class="form-control form-control-sm" type="number" value="{{old('amount')}}" name="amount" id="amount">
                    </div>
                    @error('amount')
                                <span class="alert_required text-danger" role="alert"><strong>{{$message}}</strong></span>
                            @enderror
                    </section>
                    <section class="col-12 col-md-6 py-2">
                    <div class="form-group">
                        <label for="delivery_time">مدت زمان ارسال</label> 
                        <input class="form-control form-control-sm" type="number" value="{{old('delivery_time')}}" name="delivery_time" id="delivery_time">
                    </div>
                    @error('delivery_time')
                                <span class="alert_required text-danger" role="alert"><strong>{{$message}}</strong></span>
                            @enderror
                    </section>
                    <section class="col-12 col-md-6 py-2">
                    <div class="form-group">
                        <label for="delivery_time_unit">واحد مدت زمان ارسال</label> 
                        <input class="form-control form-control-sm" type="text" value="{{old('delivery_time_unit')}}" name="delivery_time_unit" id="delivery_time_unit">
                    </div>
                    @error('delivery_time_unit')
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
                    <section class="col-12">
                    <div class="form-group">
                        <button type="submit" class="btn btn-success btn-sm float-left">ثبت</button>
                    </div></section>
                </section/>
            </form>
            </section>
        </section>
    </section>
</section>
@endsection