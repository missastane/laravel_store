@extends('admin.layouts.master')

@section('head-tag')
<title>ایجاد بنر</title>
{!! htmlScriptTagJsApi([#logopreview
    'callback_then' => 'callbackThen',
    'callback_catch' => 'callbackCatch',
    ]) !!}
@endsection

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb text-center">
        <li class="breadcrumb-item font-size-12"><a href="{{route('admin.home')}}">خانه</a></li>
        <li class="breadcrumb-item font-size-12"><a href="{{route('admin.home')}}"> بخش محتوی</a></li>
        <li class="breadcrumb-item font-size-12"><a href="{{route('admin.content.banner.index')}}">بنر</a></li>
        <li class="breadcrumb-item active font-size-12" aria-current="page">ایجاد بنر</li>
    </ol>
</nav>
<section class="row">
    <section class="col-12">
        <section class="main-body-container">
            <section class="main-body-container-header">
                <h4>ایجاد بنر</h4>
            </section>
            <section class="d-flex justify-content-between align-items-center my-4">
                <a class="btn btn-dark btn-sm" href="{{route('admin.content.banner.index')}}">بازگشت</a>

            </section>
            <section>
            <form action="{{route('admin.content.banner.store')}}" method="post" enctype="multipart/form-data">
                    <section class="row">
                        @csrf
                       
                        <section class="col-12 col-md-6 py-2">
                            <div class="form-group">
                                <label for="title">عنوان بنر</label>
                                <input class="form-control form-control-sm" value="{{old('title')}}" type="text" name="title"
                                    id="title">
                            </div>
                            @error('title')
                                <span class="alert_required text-danger" role="alert"><strong>{{$message}}</strong></span>
                            @enderror
                        </section>
                        <section class="col-12 col-md-6 py-2">
                            <div class="form-group">
                                <label for="url">ادرس لینک بنر</label>
                                <input title="نمونه آدرس معتبر : https://www.google.com/everything یا http://google.com/everything" class="form-control form-control-sm" value="{{old('url')}}" type="text" name="url"
                                    id="url">
                            </div>
                            @error('url')
                                <span class="alert_required text-danger" role="alert"><strong>{{$message}}</strong></span>
                            @enderror
                        </section>

                        <section class="col-12 py-2 col-md-6">
                            <div class="form-group">
                                <label for="position">موقعیت بنر</label>
                                <select class="form-control form-control-sm" name="position" id="position">
                                    @foreach ($positions as $key => $value)
                                    <option value="{{$key}}" @if(old('position') == $key) selected @endif>{{$value}}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('position')
                                <span class="alert_required text-danger" role="alert"><strong>{{$message}}</strong></span>
                            @enderror
                        </section>
                        <section class="col-12 py-2 col-md-6">
                            <div class="form-group">
                                <label for="status">وضعیت</label>
                                <select class="form-control form-control-sm" name="status" id="status">
                                    <option value="1" @if(old('status') == 1) selected @endif>فعال</option>
                                    <option value="2" @if(old('status') == 2) selected @endif>غیرفعال</option>
                                </select>
                            </div>
                            @error('status')
                                <span class="alert_required text-danger" role="alert"><strong>{{$message}}</strong></span>
                            @enderror
                        </section>
                      
                        </section>
                        <section class="col-12 mt-2 py-2">
                            <div class="form-group">
                                <section class="row">
                                    <section class="col-12 col-md-6">
                                        <label for="files-logo" class="btn btn-primary mt-4 mx-5">بارگذاری تصویر</label>
                                        <input type="file" onchange="readURL(this, '#logopreview')"
                                            class="form-control form-control-sm visibility-hidden" name="image"
                                            id="files-logo">
                                    </section>
                                    <section class="col-12 col-md-6">
                                        <img class="preUpload-preview-img"
                                            src="{{asset('admin-assets/images/samsung-a53.jpg')}}" alt="" id="logopreview">
                                    </section>
                                </section>
                            </div>
                            @error('image')
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
@section('script')
<script>

    $(document).ready(function () {
        $('.js-example-basic-single').select2({
            tags: true,
            placeholder: 'لطفا تگ های خود را وارد نمایید ...'
        });
    });
</script>
@endsection