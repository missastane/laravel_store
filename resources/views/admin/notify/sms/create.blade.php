@extends('admin.layouts.master')

@section('head-tag')
<link rel="stylesheet" href="{{asset('admin-assets/jalalidatepicker/persian-datepicker.min.css')}}">
<title>ایجاد اطلاعیه پیامکی جدید</title>
{!! htmlScriptTagJsApi([#logopreview
    'callback_then' => 'callbackThen',
    'callback_catch' => 'callbackCatch',
    ]) !!}
@endsection

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb text-center">
        <li class="breadcrumb-item font-size-12"><a href="{{route('admin.home')}}">خانه</a></li>
        <li class="breadcrumb-item font-size-12"><a href="{{route('admin.home')}}"> بخش اطلاع رسانی</a></li>
        <li class="breadcrumb-item font-size-12"><a href="{{route('admin.notify.sms.index')}}">اطلاعیه پیامکی</a></li>
        <li class="breadcrumb-item active font-size-12" aria-current="page">ایجاد اطلاعیه پیامکی جدید</li>
    </ol>
</nav>
<section class="row">
    <section class="col-12 py-2">
        <section class="main-body-container">
            <section class="main-body-container-header">
                <h4>ایجاد اطلاعیه پیامکی جدید</h4>
            </section>
            <section class="d-flex justify-content-between align-items-center my-4">
                <a class="btn btn-dark btn-sm" href="{{route('admin.notify.sms.index')}}">بازگشت</a>
                
            </section>
            <section>
            <form action="{{route('admin.notify.sms.store')}}" method="post">
                <section class="row">
                    @csrf
                    <section class="col-12 py-2 col-md-4">
                    <div class="form-group">
                        <label for="title">عنوان پیامک</label> 
                        <input class="form-control form-control-sm" value="{{old('title')}}" type="text" name="title" id="title">
                    </div>
                    @error('title')
                                <span class="alert_required text-danger" role="alert"><strong>{{$message}}</strong></span>
                            @enderror
                </section>
                    <section class="col-12 py-2 col-md-4">
                    <div class="form-group">
                        <label for="published_at">تاریخ انتشار</label> 
                        <input class="form-control form-control-sm d-none"  type="text" name="published_at" id="published_at">
                                <input class="form-control form-control-sm" value="{{old('published_at')}}" type="text" id="published_at_view">
                            </div>
                            @error('published_at')
                                <span class="alert_required text-danger" role="alert"><strong>{{$message}}</strong></span>
                            @enderror
                        </section>
                    <section class="col-12 py-2 col-md-4 py-2">
                            <div class="form-group">
                                <label for="status">وضعیت</label>
                                <select class="form-control form-control-sm" name="status" id="status">
                                    <option @if (old('status') == 1)
                                    selected
                                    @endif value="1">فعال</option>
                                    <option @if (old('status') == 2)
                                    selected
                                    @endif value="2">غیرفعال</option>
                                </select>
                            </div>
                            @error('status')
                                <span class="alert_required text-danger" role="alert"><strong>{{$message}}</strong></span>
                            @enderror
                        </section>
                    <section class="col-12 py-2">
                    <div class="form-group">
                    <label for="body">متن پیامک</label>
                  <textarea class="form-control form-control-sm" name="body" id="body" rows="5">{{old('body')}}</textarea>
                    </div>
                    @error('body')
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
                    <div class="col-12 py-2 mt-2">
                        <button type="submit" class="btn btn-success btn-sm">ثبت</button>
                    </div>
                </section/>
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
$(document).ready(function()
{
    $("#published_at_view").persianDatepicker({

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
    altField: '#published_at'

    })

});
</script>
@endsection
