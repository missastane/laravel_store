@extends('admin.layouts.master')

@section('head-tag')
<link rel="stylesheet" href="{{asset('admin-assets/jalalidatepicker/persian-datepicker.min.css')}}">
<title>ویرایش فایل اطلاعیه ایمیلی</title>
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
        <li class="breadcrumb-item font-size-12"><a href="{{route('admin.notify.email-file.index', $file->public_mail_id)}}">فایل اطلاعیه ایمیلی</a></li>
        <li class="breadcrumb-item active font-size-12" aria-current="page">ویرایش فایل اطلاعیه ایمیلی</li>
    </ol>
</nav>
<section class="row">
    <section class="col-12 py-2">
        <section class="main-body-container">
            <section class="main-body-container-header">
                <h4>ویرایش فایل اطلاعیه ایمیلی</h4>
            </section>
            <section class="d-flex justify-content-between align-items-center my-4">
                <a class="btn btn-dark btn-sm" href="{{route('admin.notify.email-file.index', $file->public_mail_id)}}">بازگشت</a>
                
            </section>
            <section>
            <form action="{{route('admin.notify.email-file.update', $file->id)}}" method="post" enctype="multipart/form-data">
                <section class="row">
                    @csrf
                   {{method_field('put')}}
                   <section class="col-12 py-2">
                    <div class="form-group">
                                <label for="status">وضعیت</label>
                                <select class="form-control form-control-sm" name="status" id="status">
                                    <option value="1" @if(old('status', $file->status) == 1) selected  @endif>فعال</option>
                                    <option value="2" @if(old('status', $file->status) == 2) selected  @endif>غیرفعال</option>
                                </select>
                            </div>
                            @error('status')
                                <span class="alert_required text-danger" role="alert"><strong>{{$message}}</strong></span>
                            @enderror
                        </section>
                    <section class="col-md-6 py-4">
                            <div class="form-group">
                                <section class="row">
                                    <section class="col-12 col-md-7">
                                        <label for="file" class="btn btn-primary mx-5">بارگذاری فایل
                                             ایمیل</label>
                                             <div class="mt-1 p-2 border rounded bg-danger text-white mx-3 d-none" id="file-upload-filename"></div>
                                        <input type="file" 
                                            class="form-control form-control-sm visibility-hidden" name="file"
                                            id="file">
                                    </section>
                                   
                                </section>
                            </div>
                            @error('file')
                                <span class="alert_required text-danger" role="alert"><strong>{{$message}}</strong></span>
                            @enderror
                        </section>
                        <section class="col-12 col-md-6 py-4">
                            <div class="form-group">
                                <label for="path">سطح دسترسی فایل</label>
                                <select class="form-control form-control-sm" name="path" id="path">
                                    <option @if (old('path') == 1)
                                    selected
                                    @endif value="1">اختصاصی</option>
                                    <option @if (old('path') == 2)
                                    selected
                                    @endif value="2">عمومی</option>
                                </select>
                            </div>
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
<script>
    var input = document.getElementById( 'file' );
var infoArea = document.getElementById( 'file-upload-filename' );

input.addEventListener( 'change', showFileName );

function showFileName( event ) {
  debugger
  // the change event gives us the input it occurred in 
  var input = event.srcElement;
  
  // the input has an array of files in the `files` property, each one has a name that you can use. We're just using the name here.
  var fileName = input.files[0].name;
  
  infoArea.classList.remove('d-none');
  // use fileName however fits your app best, i.e. add it into a div
  infoArea.textContent = 'نام فایل انتخاب شده: ' + fileName;
}

</script>
@endsection
