@extends('admin.layouts.master')

@section('head-tag')
<title>ایجاد کاربر ادمین</title>
{!! htmlScriptTagJsApi([#logopreview
    'callback_then' => 'callbackThen',
    'callback_catch' => 'callbackCatch',
    ]) !!}
@endsection

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb text-center">
        <li class="breadcrumb-item font-size-12"><a href="{{route('admin.home')}}">خانه</a></li>
        <li class="breadcrumb-item font-size-12"><a href="{{route('admin.home')}}"> بخش کاربران</a></li>
        <li class="breadcrumb-item font-size-12"><a href="{{route('admin.user.admin-user.index')}}">کاربران ادمین</a>
        </li>
        <li class="breadcrumb-item active font-size-12" aria-current="page">ایجاد کاربر ادمین</li>
    </ol>
</nav>
<section class="row">
    <section class="col-12">
        <section class="main-body-container">
            <section class="main-body-container-header">
                <h4>ایجاد کاربر ادمین</h4>
            </section>
            <section class="d-flex justify-content-between align-items-center my-4">
                <a class="btn btn-dark btn-sm" href="{{route('admin.user.admin-user.index')}}">بازگشت</a>

            </section>
            <section>
                <form action="{{route('admin.user.admin-user.store')}}" method="post" enctype="multipart/form-data">
                    <section class="row">
                        @csrf
                        <section class="col-12 col-md-6 py-2">
                            <div class="form-group">
                                <label for="first_name">نام</label>
                                <input class="form-control form-control-sm" value="{{old('first_name')}}" type="text"
                                    name="first_name" id="first_name">
                            </div>
                            @error('first_name')
                                <span class="alert_required text-danger" role="alert"><strong>{{$message}}</strong></span>
                            @enderror
                        </section>
                        <section class="col-12 col-md-6 py-2">
                            <div class="form-group">
                                <label for="last_name">نام خانوادگی</label>
                                <input class="form-control form-control-sm" value="{{old('last_name')}}" type="text"
                                    name="last_name" id="last_name">
                            </div>
                            @error('last_name')
                                <span class="alert_required text-danger" role="alert"><strong>{{$message}}</strong></span>
                            @enderror
                        </section>
                        <section class="col-12 col-md-6 py-2">
                            <div class="form-group">
                                <label for="email">ایمیل</label>
                                <input class="form-control form-control-sm" value="{{old('email')}}" type="email"
                                    name="email" id="email">
                            </div>
                            @error('email')
                                <span class="alert_required text-danger" role="alert"><strong>{{$message}}</strong></span>
                            @enderror
                        </section>
                        <section class="col-12 col-md-6 py-2">
                            <div class="form-group">
                                <label for="mobile">شماره موبایل</label>
                                <input class="form-control form-control-sm" value="{{old('mobile')}}" type="number"
                                    name="mobile" id="mobile">
                            </div>
                            @error('mobile')
                                <span class="alert_required text-danger" role="alert"><strong>{{$message}}</strong></span>
                            @enderror
                        </section>
                        <section class="col-12 col-md-6 py-2">
                            <div class="form-group">
                                <label for="password">کلمه عبور</label>
                                <input class="form-control form-control-sm" value="{{old('password')}}" type="password"
                                    name="password" id="password">
                            </div>
                            @error('password')
                                <span class="alert_required text-danger" role="alert"><strong>{{$message}}</strong></span>
                            @enderror
                        </section>
                        <section class="col-12 col-md-6 py-2">
                            <div class="form-group">
                                <label for="password_confirmation">تکرار کلمه عبور</label>
                                <input class="form-control form-control-sm" type="password"
                                    value="{{old('password_confirmation')}}" name="password_confirmation"
                                    id="password_confirmation">
                            </div>
                            @error('password_confirmation')
                                <span class="alert_required text-danger" role="alert"><strong>{{$message}}</strong></span>
                            @enderror
                        </section>
                        <section class="col-12 col-md-6 py-2">

                            <div class="form-group">
                                <section class="row">
                                    <section class="col-12 col-md-6 py-2">
                                        <label for="files-logo" class="btn btn-primary mt-4 mx-5">بارگذاری تصویر
                                            آواتار</label>
                                        <input type="file" onchange="readURL(this, '#logopreview')"
                                            class="form-control form-control-sm visibility-hidden"
                                            name="profile_photo_path" id="files-logo">
                                    </section>
                                    <section class="col-12 col-md-6 py-2">
                                        <img class="preUpload-preview-img"
                                            src="{{asset('admin-assets/images/avatar-2.jpg')}}" alt="" id="logopreview">
                                    </section>
                                </section>
                            </div>
                            @error('profile_photo_path')
                                <span class="alert_required text-danger" role="alert"><strong>{{$message}}</strong></span>
                            @enderror
                        </section>

                        <section class="col-12 col-md-6 py-2">
                            <div class="form-group">
                                <label for="activation">وضعیت فعالسازی کاربر</label>
                                <select class="form-control form-control-sm" name="activation" id="activation">
                                    <option value="1" @if (old('activation') == 1) selected @endif>فعال</option>
                                    <option value="2" @if (old('activation') == 2) selected @endif>غیرفعال</option>
                                </select>
                            </div>
                            @error('activation')
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
                            <button type="submit" class="btn btn-success btn-sm">ثبت</button>
                        </div>
                    </section>
                </form>
            </section>
        </section>
    </section>
</section>
@endsection