@extends('admin.layouts.master')

@section('head-tag')
<title>ویرایش تنظیمات سایت</title>
{!! htmlScriptTagJsApi([#logopreview
    'callback_then' => 'callbackThen',
    'callback_catch' => 'callbackCatch',
    ]) !!}
@endsection

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb text-center">
        <li class="breadcrumb-item font-size-12"><a href="{{route('admin.home')}}">خانه</a></li>
        <li class="breadcrumb-item font-size-12"><a href="{{route('admin.home')}}"> بخش تنظیمات</a></li>
        <li class="breadcrumb-item font-size-12"><a href="{{route('admin.setting.index')}}">تنظیمات سایت</a></li>
        <li class="breadcrumb-item active font-size-12" aria-current="page">ویرایش تنظیمات سایت</li>
    </ol>
</nav>
<section class="row">
    <section class="col-12 py-2">
        <section class="main-body-container">
            <section class="main-body-container-header">
                <h4>ویرایش تنظیمات سایت</h4>
            </section>
            <section class="d-flex justify-content-between align-items-center my-4">
                <a class="btn btn-dark btn-sm" href="{{route('admin.setting.index')}}">بازگشت</a>

            </section>
            <section>
                <form action="{{route('admin.setting.update')}}" method="post" enctype="multipart/form-data">
                    <section class="row">
                        @csrf
{{method_field('put')}}
                        <section class="col-12 py-2">
                            <div class="form-group">
                                <label for="title">عنوان</label>
                                <input class="form-control form-control-sm" value="{{old('title', $setting->title)}}" type="text" name="title" id="title">
                            </div>
                            @error('title')
                                <span class="alert_required text-danger" role="alert"><strong>{{$message}}</strong></span>
                            @enderror
                        </section>
                        <section class="col-12 py-2">
                            <div class="form-group">
                                <label for="description">توضیحات</label>
                                <input class="form-control form-control-sm" name="description" id="descrption" type="text" value="{{old('description', $setting->description)}}">
                               
                            </div>
                            @error('description')
                                <span class="alert_required text-danger" role="alert"><strong>{{$message}}</strong></span>
                            @enderror
                        </section>

                        <section class="col-12">
                            <div class="form-group">
                               
                                <label for="keywords">کلمات کلیدی</label>
                                <select class="form-control form-control-sm js-example-basic-single" multiple="multiple"
                                    name="keywords[]">
                                    @if(old('keywords'))
                                        @for($i = 0; $i < count(old('keywords')); $i++)
                                            <option value="{{ old('keywords')[$i] }}" @if(in_array(old('keywords')[$i], old('keywords')))
                                            selected @endif>{{old('keywords')[$i]}}</option>
                                        @endfor
                                    @else
                                        @for($i = 0; $i < count($keywords); $i++)
                                            <option value="{{ $keywords[$i] }}" @if(in_array($keywords[$i], $keywords)) selected @endif>
                                                {{$keywords[$i]}}</option>
                                        @endfor
                                    @endif
                                </select>
                            </div>
                            @error('keywords')
                                <span class="alert_required text-danger" role="alert"><strong>{{$message}}</strong></span>
                            @enderror
                        </section>
                        <section class="col-12 py-2 my-4">
                            <div class="form-group">
                                <section class="row">
                                    <section class="col-12 py-2 col-md-7 mt-1">
                                        <label for="files-logo" class="btn btn-primary mt-5 mx-5">بارگذاری لوگو
                                             </label>
                                        <input type="file" onchange="readURL(this, '#logopreview')"
                                            class="form-control form-control-sm visibility-hidden" name="logo"
                                            id="files-logo">
                                    </section>
                                    <section class="col-12 py-2 col-md-5">
                                        <img class="preUpload-preview-img-large" 
                                      
                                                src="{{asset('admin-assets/images/samsung-a53.jpg')}}" 
                                            alt=""
                                            id="logopreview">

                                    </section>
                                </section>
                            </div>
                            @error('logo')
                                <span class="alert_required text-danger" role="alert"><strong>{{$message}}</strong></span>
                            @enderror
                          
                        </section>
                        <section class="col-12 py-2 my-4">
                            <div class="form-group">
                                <section class="row">
                                    <section class="col-12 py-2 col-md-7 mt-1">
                                        <label for="files-icon" class="btn btn-primary mt-5 mx-5">بارگذاری آیکن
                                             </label>
                                        <input type="file" onchange="readURL(this, '#iconpreview'); uploaderButton();"
                                            class="form-control form-control-sm visibility-hidden" name="icon"
                                            id="files-icon">
                                    </section>
                                    
                                    <section class="col-12 py-2 col-md-5">
                                        <img class="preUpload-preview-img-large" 
                                       
                                          src="{{asset('admin-assets/images/samsung-a53.jpg')}}"
                                             alt=""
                                            id="iconpreview">

                                    </section>
                                </section>
                            </div>
                            @error('icon')
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
<script>

    $(document).ready(function () {
        $('.js-example-basic-single').select2({
            tags: true,
            placeholder: 'لطفا کلمات کلیدی سایت خود را وارد نمایید ...'
        });
    });
</script>
@endsection