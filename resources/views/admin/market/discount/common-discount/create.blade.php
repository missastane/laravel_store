@extends('admin.layouts.master')

@section('head-tag')
<link rel="stylesheet" href="{{asset('admin-assets/jalalidatepicker/persian-datepicker.min.css')}}">
<title>ایجاد تخفیف عمومی</title>
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
        <li class="breadcrumb-item font-size-12"><a href="{{route('admin.market.discount.commonDiscount')}}">تخفیف عمومی</a></li>
        <li class="breadcrumb-item active font-size-12" aria-current="page">ایجاد تخفیف عمومی</li>
    </ol>
</nav>
<section class="row">
    <section class="col-12">
        <section class="main-body-container">
            <section class="main-body-container-header">
                <h4>ایجاد تخفیف عمومی</h4>
            </section>
            <section class="d-flex justify-content-between align-items-center my-4">
                <a class="btn btn-dark btn-sm" href="{{route('admin.market.discount.commonDiscount')}}">بازگشت</a>
                
            </section>
            <section>
            <form action="{{route('admin.market.discount.commonDiscount.store')}}" method="post">
                <section class="row">
                    @csrf
                <section class="col-12 col-md-6 py-2">
                    <div class="form-group">
                        <label for="title">عنوان مناسبت</label> 
                        <input class="form-control form-control-sm" value="{{old('title')}}" type="text" name="title" id="title">
                    </div>
                    @error('title')
                                <span class="alert_required text-danger" role="alert"><strong>{{$message}}</strong></span>
                            @enderror
                    </section>
                    <section class="col-12 col-md-6 py-2">
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
                        <label for="discount_ceiling">حداکثر تخفیف</label> 
                        <input class="form-control form-control-sm" type="text" value="{{old('discount_ceiling')}}" name="discount_ceiling" id="discount_ceiling">
                    </div>
                    @error('discount_ceiling')
                                <span class="alert_required text-danger" role="alert"><strong>{{$message}}</strong></span>
                            @enderror
                    </section>
                    <section class="col-12 col-md-6 py-2">
                    <div class="form-group">
                        <label for="minimal_order_amount">حداقل میزان سفارش</label> 
                        <input class="form-control form-control-sm" type="text" value="{{old('minimal_order_amount')}}" name="minimal_order_amount" id="minimal_order_amount">
                    </div>
                    @error('minimal_order_amount')
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