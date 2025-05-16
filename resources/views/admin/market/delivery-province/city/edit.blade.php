@extends('admin.layouts.master')

@section('head-tag')
<title>ویرایش شهر</title>
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
        <li class="breadcrumb-item font-size-12"><a href="{{route('admin.market.delivery-province.cities', $city->province)}}">مناطق تحت پوشش ارسال</a></li>
        <li class="breadcrumb-item active font-size-12" aria-current="page">ویرایش شهر</li>
    </ol>
</nav>
<section class="row">
    <section class="col-12">
        <section class="main-body-container">
            <section class="main-body-container-header">
                <h4>ویرایش شهر</h4>
            </section>
            <section class="d-flex justify-content-between align-items-center my-4">
                <a class="btn btn-dark btn-sm" href="{{route('admin.market.delivery-province.cities', $city->province)}}">بازگشت</a>
                
            </section>
            <section>
            <form action="{{route('admin.market.delivery-city.update', $city->id)}}" method="post">
                <section class="row">
                    @csrf
                    @method('put')
                    <section class="col-12 col-md-6 py-2">
                    <div class="form-group">
                        <label for="name">نام</label> 
                        <input class="form-control form-control-sm" value="{{old('name', $city->name)}}" type="text" name="name" id="name">
                    </div>
                    @error('name')
                                <span class="alert_required text-danger" role="alert"><strong>{{$message}}</strong></span>
                            @enderror
                </section>
                    
                <section class="col-12 col-md-6 d-flex mt-3 flex-column align-items-center justify-content-md-center">
                    {!! htmlFormSnippet() !!}
                    @if($errors->has('g-recaptcha-response'))
                    <div style="margin-right:1rem !important">
                     @error('g-recaptcha-response')
                             <span class="alert_required text-danger mt-md-0 mt-1" role="alert"><strong>{{$message}}</strong></span>
                         @enderror
                         </div>
                         @endif
                    </section>
                   
                    <section class="col-12 mt-4">
                    <div class="form-group">
                        <button type="submit" class="btn btn-warning btn-sm mt-3">ویرایش</button>
                    </div></section>
                </section/>
            </form>
            </section>
        </section>
    </section>
</section>
@endsection