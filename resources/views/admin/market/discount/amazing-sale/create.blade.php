@extends('admin.layouts.master')

@section('head-tag')
<link rel="stylesheet" href="{{asset('admin-assets/jalalidatepicker/persian-datepicker.min.css')}}">
<title>افزودن به فروش شگفت انگیز</title>
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
        <li class="breadcrumb-item font-size-12"><a href="{{route('admin.market.discount.amazingSale')}}">فروش شگفت
                انگیز</a></li>
        <li class="breadcrumb-item active font-size-12" aria-current="page">افزودن به فروش شگفت انگیز</li>
    </ol>
</nav>
<section class="row">
    <section class="col-12">
        <section class="main-body-container">
            <section class="main-body-container-header">
                <h4>افزودن کالا به فروش شگفت انگیز</h4>
            </section>
            <section class="d-flex justify-content-between align-items-center my-4">
                <a class="btn btn-dark btn-sm" href="{{route('admin.market.discount.amazingSale')}}">بازگشت</a>

            </section>
            <section>
                <form action="{{route('admin.market.discount.amazingSale.store')}}" method="post">
                    <section class="row">
                        @csrf
                        <section class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="product_id">نام کالا</label>
                                <select class="form-control form-control-sm" name="product_id" id="product_id">
                                    <option value="" selected disabled>انتخاب محصول</option>
                                    @foreach ($products as $product)
                                        <option value="{{$product->id}}" @if (old('product_id') == $product->id) selected
                                        @endif>{{$product->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('product_id')
                                <span class="alert_required text-danger" role="alert"><strong>{{$message}}</strong></span>
                            @enderror
                        </section>
                        <section class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="percentage">درصد تخفیف</label>
                                <input class="form-control form-control-sm" value="{{old('percentage')}}" type="text" name="percentage" id="percentage">
                            </div>
                            @error('percentage')
                                <span class="alert_required text-danger" role="alert"><strong>{{$message}}</strong></span>
                            @enderror
                        </section>
                        <section class="col-12 col-md-6 py-2">
                            <div class="form-group">
                                <label for="start_date">تاریخ شروع</label>
                                <input class="form-control form-control-sm d-none" type="text" name="start_date"
                                    id="start_date">
                                <input class="form-control form-control-sm" value="{{old('start_date')}}" type="text"
                                    id="start_date_view">
                            </div>
                            @error('start_date')
                                <span class="alert_required text-danger" role="alert"><strong>{{$message}}</strong></span>
                            @enderror
                        </section>
                        <section class="col-12 col-md-6 py-2">
                            <div class="form-group">
                                <label for="end_date">تاریخ پایان</label>
                                <input class="form-control form-control-sm d-none" type="text" name="end_date" id="end_date">
                                <input class="form-control form-control-sm" value="{{old('end_date')}}" type="text"
                                id="end_date_view">
                            </div>
                            @error('end_date')
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
                        <button type="submit" class="btn btn-success btn-sm">ثبت</button>
                    </div></section>
                    </section>
                </form>
            </section>
        </section>
    </section>
</section>
@endsection
@section('script')
<script src="{{asset('admin-assets/jalalidatepicker/persian-date.min.js')}}"></script>
<script src="{{asset('admin-assets/jalalidatepicker/persian-datepicker.min.js')}}"></script>
<script>
    $(document).ready(function () {
        $("#start_date_view").persianDatepicker({

            format: 'YYYY-MM-DD HH:mm:ss',
            toolbox: {
                calendarSwitch: {
                    enabled: true
                }
            },
            timePicker: {
                enabled: true,
            },
            observer: true,
            altField: '#start_date'

        })

        $("#end_date_view").persianDatepicker({

            format: 'YYYY-MM-DD HH:mm:ss',
            toolbox: {
                calendarSwitch: {
                    enabled: true
                }
            },
            timePicker: {
                enabled: true,
            },
            observer: true,
            altField: '#end_date'

        })

    });
</script>
@endsection