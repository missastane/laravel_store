@extends('admin.layouts.master')

@section('head-tag')
<link rel="stylesheet" href="{{asset('admin-assets/jalalidatepicker/persian-datepicker.min.css')}}">
<title>ایجاد کوپن تخفیف جدید</title>
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
        <li class="breadcrumb-item font-size-12"><a href="{{route('admin.market.discount.copan')}}">کوپن تخفیف</a></li>
        <li class="breadcrumb-item active font-size-12" aria-current="page">ایجاد کوپن تخفیف جدید</li>
    </ol>
</nav>
<section class="row">
    <section class="col-12">
        <section class="main-body-container">
            <section class="main-body-container-header">
                <h4>ایجاد کوپن تخفیف جدید</h4>
            </section>
            <section class="d-flex justify-content-between align-items-center my-4">
                <a class="btn btn-dark btn-sm" href="{{route('admin.market.discount.copan')}}">بازگشت</a>

            </section>
            <section>
                <form action="{{route('admin.market.discount.copan.store')}}" method="post">
                    <section class="row">
                        @csrf
                        <section class="col-12 py-2">
                            <div class="form-group">
                                <label for="code">کد کوپن</label>
                                <input class="form-control form-control-sm" value="{{old('code')}}" type="text"
                                    name="code" id="code">
                            </div>
                            @error('code')
                                <span class="alert_required text-danger" role="alert"><strong>{{$message}}</strong></span>
                            @enderror
                        </section>
                        <section class="col-12 col-md-6 py-2">
                            <div class="form-group">
                                <label for="amount_type">نوع تخفیف</label>
                                <select class="form-control form-control-sm" name="amount_type" id="amount_type">
                                    <option value="2" @if (old('amount_type') == 2) selected @endif>درصدی</option>
                                    <option value="1" @if (old('amount_type') == 1) selected @endif>به تومان</option>
                                </select>
                            </div>
                            @error('amount_type')
                                <span class="alert_required text-danger" role="alert"><strong>{{$message}}</strong></span>
                            @enderror
                        </section>
                        <section class="col-12 col-md-6 py-2">
                            <div class="form-group">
                                <label for="amount">میزان تخفیف</label>
                                <input class="form-control form-control-sm" type="text" value="{{old('amount')}}"
                                    name="amount" id="amount">
                            </div>
                            @error('amount')
                                <span class="alert_required text-danger" role="alert"><strong>{{$message}}</strong></span>
                            @enderror
                        </section>

                        <section class="col-12 col-md-6 py-2">
                            <div class="form-group">
                                <label for="type">نوع کوپن</label>
                                <select class="form-control form-control-sm" name="type" id="type">
                                    <option value="2" @if (old('type') == 2) selected @endif>عمومی</option>
                                    <option value="1" @if (old('type') == 1) selected @endif>اختصاصی برای کاربر</option>
                                </select>
                            </div>
                            @error('type')
                                <span class="alert_required text-danger" role="alert"><strong>{{$message}}</strong></span>
                            @enderror
                        </section>
                        <section class="col-12 col-md-6 py-2 d-none" id="type-private">
                            <div class="form-group">
                                <label for="user_id">کاربر</label>
                                <select class="form-control form-control-sm" name="user_id" id="user_id">
                                    <option value="" selected disabled>انتخاب کاربران</option>
                                    @foreach ($users as $user)
                                        <option value="{{$user->id}}" @if (old('user_id') == $user->id) selected @endif>
                                            {{$user->fullName}}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('user_id')
                                <span class="alert_required text-danger" role="alert"><strong>{{$message}}</strong></span>
                            @enderror
                        </section>
                        <section class="col-12 col-md-6 py-2">
                            <div class="form-group">
                                <label for="discount_ceiling">حداکثر تخفیف</label>
                                <input class="form-control form-control-sm" type="text"
                                    value="{{old('discount_ceiling')}}" name="discount_ceiling" id="discount_ceiling">
                            </div>
                            @error('discount_ceiling')
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
                            </div>
                        </section>
                    </section />
                </form>
            </section>
        </section>
    </section>
</section>
@endsection
@section('script')
<script>
    $("#type").change(function () {
        debugger
        var selected_option = $('#type').val();
        if (selected_option === '1') {
            $('#type-private').removeClass('d-none');

        }
        if (selected_option != '1') {
            $("#type-private").addClass('d-none');

        }
    })
</script>
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