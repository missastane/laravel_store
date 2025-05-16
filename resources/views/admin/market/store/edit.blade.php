@extends('admin.layouts.master')

@section('head-tag')
<title>اصلاح موجودی</title>
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
        <li class="breadcrumb-item active font-size-12" aria-current="page">اصلاح موجودی</li>
    </ol>
</nav>
<section class="row">
    <section class="col-12">
        <section class="main-body-container">
            <section class="main-body-container-header">
                <h4>اصلاح موجودی</h4>
            </section>
            <section class="d-flex justify-content-between align-items-center my-4">
                <a class="btn btn-dark btn-sm" href="{{route('admin.market.store.index')}}">بازگشت</a>

            </section>
            <section>
                <form action="{{route('admin.market.store.update', $product->id)}}" method="post">
                    <section class="row">
                        @csrf
                        @method('put')
                        <section class="col-12 col-md-4 py-2">
                            <div class="form-group">
                                <label for="marketable_number">تعداد قابل فروش</label>
                                <input class="form-control form-control-sm" type="number"
                                    value="{{old('marketable_number', $product->marketable_number)}}"
                                    name="marketable_number" id="marketable_number">
                            </div>
                            @error('marketable_number')
                                <span class="alert_required text-danger" role="alert"><strong>{{$message}}</strong></span>
                            @enderror
                        </section>
                        <section class="col-12 col-md-4 py-2">
                            <div class="form-group">
                                <label for="sold_number">تعداد فروخته شده</label>
                                <input class="form-control form-control-sm" type="number"
                                    value="{{old('sold_number', $product->sold_number)}}" name="sold_number"
                                    id="sold_number">
                            </div>
                            @error('sold_number')
                                <span class="alert_required text-danger" role="alert"><strong>{{$message}}</strong></span>
                            @enderror
                        </section>


                        <section class="col-12 col-md-4 py-2">
                            <div class="form-group">
                                <label for="frozen_number">تعداد رزرو</label>
                                <input class="form-control form-control-sm" type="number"
                                    value="{{old('frozen_number', $product->frozen_number)}}" name="frozen_number"
                                    id="frozen_number">
                            </div>
                            @error('frozen_number')
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
                            <button type="submit" class="btn btn-warning btn-sm">اصلاح موجودی</button>
                        </div>
                    </section>
                </form>
            </section>
        </section>
    </section>
</section>
@endsection