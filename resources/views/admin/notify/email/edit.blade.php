@extends('admin.layouts.master')

@section('head-tag')
<link rel="stylesheet" href="{{asset('admin-assets/jalalidatepicker/persian-datepicker.min.css')}}">
<title>ویرایش اطلاعیه ایمیلی</title>
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
        <li class="breadcrumb-item font-size-12"><a href="{{route('admin.notify.email.index')}}">اطلاعیه ایمیلی</a></li>
        <li class="breadcrumb-item active font-size-12" aria-current="page">ویرایش اطلاعیه ایمیلی</li>
    </ol>
</nav>
<section class="row">
    <section class="col-12 py-2">
        <section class="main-body-container">
            <section class="main-body-container-header">
                <h4>ویرایش اطلاعیه ایمیلی</h4>
            </section>
            <section class="d-flex justify-content-between align-items-center my-4">
                <a class="btn btn-dark btn-sm" href="{{route('admin.notify.email.index')}}">بازگشت</a>
                
            </section>
            <section>
            <form action="{{route('admin.notify.email.update', $email->id)}}" method="post">
                <section class="row">
                    @csrf
                    {{method_field('put')}}
                    <section class="col-12 py-2 col-md-4">
                    <div class="form-group">
                        <label for="subject">عنوان ایمیل</label> 
                        <input class="form-control form-control-sm" value="{{old('subject', $email->subject)}}" type="text" name="subject" id="subject">
                    </div>
                    @error('subject')
                                <span class="alert_required text-danger" role="alert"><strong>{{$message}}</strong></span>
                            @enderror
                </section>
                    <section class="col-12 py-2 col-md-4">
                    <div class="form-group">
                        <label for="published_at">تاریخ انتشار</label> 
                        <input class="form-control form-control-sm d-none"  type="text" name="published_at" id="published_at">
                                <input class="form-control form-control-sm" value="{{old('published_at', $email->published_at)}}" type="text" id="published_at_view">
                            </div>
                            @error('published_at')
                                <span class="alert_required text-danger" role="alert"><strong>{{$message}}</strong></span>
                            @enderror
                        </section>
                        <section class="col-12 py-2 col-md-4">
                            <div class="form-group">
                                <label for="status">وضعیت</label>
                                <select class="form-control form-control-sm" name="status" id="status">
                                    <option value="1" @if(old('status', $email->status) == 1) selected  @endif>فعال</option>
                                    <option value="2" @if(old('status', $email->status) == 2) selected  @endif>غیرفعال</option>
                                </select>
                            </div>
                            @error('status')
                                <span class="alert_required text-danger" role="alert"><strong>{{$message}}</strong></span>
                            @enderror
                        </section>
                    <section class="col-12 py-2">
                    <div class="form-group">
                    <label for="body">متن ایمیل</label>
                  <textarea class="form-control form-control-sm" name="body" id="body" rows="5">{{old('body', $email->body)}}</textarea>
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
                        <button type="submit" class="btn btn-warning btn-sm">ویرایش</button>
                    </div>
                </section>
            </form>
            </section>
        </section>
    </section>
</section>
@endsection
@section('script')
<script src="{{asset('admin-assets/ckeditor/ckeditor.js')}}"></script>
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
<script>
CKEDITOR.replace('body');
</script>
@endsection
