@extends('admin.layouts.master')

@section('head-tag')
<title>ایجاد دسته بندی</title>

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
        <li class="breadcrumb-item font-size-12"><a href="{{route('admin.content.category.index')}}">دسته بندی</a></li>
        <li class="breadcrumb-item active font-size-12" aria-current="page">ایجاد دسته بندی</li>
    </ol>
</nav>
<section class="row">
    <section class="col-12">
        <section class="main-body-container">
            <section class="main-body-container-header">
                <h4>ایجاد دسته بندی برای پست ها</h4>
                <h3 class="text-danger d-none" id="recaptcha_error">اعتبارسنجی کپچا با خطا روبرو شد</h3>
            </section>
            <section class="d-flex justify-content-between align-items-center my-4">
                <a class="btn btn-dark btn-sm" href="{{route('admin.content.category.index')}}">بازگشت</a>

            </section>
           
            <section>
                <form action="{{route('admin.content.category.store')}}" method="post" enctype="multipart/form-data" id="create_postCategory">
                    @csrf
                  
                    <section class="row">
                        <section class="col-12 col-md-6 py-2">
                            <div class="form-group">
                                <label for="name">نام دسته</label>
                                <input class="form-control form-control-sm" value="{{old('name')}}" type="text"
                                    name="name" id="name">
                            </div>
                            @error('name')
                                <span class="alert_required text-danger" role="alert"><strong>{{$message}}</strong></span>
                            @enderror
                        </section>
                       
                        <section class="col-12 col-md-6 py-2">
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
                        <section class="col-12">
                            <div class="form-group">
                                <label for="description">توضیحات</label>
                                <textarea class="form-control form-control-sm" 
                                    name="description" id="description">{{old('description')}}</textarea>
                            </div>
                            @error('description')
                                <span class="alert_required text-danger" role="alert"><strong>{{$message}}</strong></span>
                            @enderror
                        </section>
                        <section class="col-12 col-md-6 py-2">
                            <div class="form-group">
                                <label for="tags">برچسب ها</label>
                                <select class="form-control form-control-sm js-example-basic-single" 
                                    multiple="multiple" name="tags[]">
                                   
                                         @if(old('tags'))
                                        @for($i =0;$i < count(old('tags'));$i++)
                                            <option value="{{ old('tags')[$i] }}" @if(in_array(old('tags')[$i],old('tags'))) selected @endif>{{old('tags')[$i]}}</option>
                                           @endfor
                                           @endif 
                                </select>
                            </div>
                            @error('tags')
                                <span class="alert_required text-danger" role="alert"><strong>{{$message}}</strong></span>
                            @enderror
                        </section>
                        <section class="col-12 col-md-6 py-2 mt-md-1">
                            <div class="form-group">
                                <section class="row">
                                    <section class="col-6 py-2">
                                        <label for="files-logo" class="btn btn-primary mt-4 mx-5">بارگذاری تصویر</label>
                                        <input type="file" onchange="readURL(this, '#logopreview')"
                                            class="form-control form-control-sm visibility-hidden" name="image"
                                            id="files-logo">
                                    </section>

                                    <section class="col-6 py-2">
                                        <img class="preUpload-preview-img"
                                            src="{{asset('admin-assets/images/avatar-2.jpg')}}" alt="" id="logopreview">
                                    </section>
                                </section>
                            </div>
                            @error('image')
                                <span class="alert_required text-danger" role="alert"><strong>{{$message}}</strong></span>
                            @enderror
                        </section>
                       <section class="col-12 d-flex flex-md-row flex-column align-items-center justify-content-md-center">
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
<script src="{{asset('admin-assets/ckeditor/ckeditor.js')}}"></script>
<script>
    CKEDITOR.replace('description');
</script>
<script>

    $(document).ready(function () {
        $('.js-example-basic-single').select2({
            tags: true,
            placeholder: 'لطفا تگ های خود را وارد نمایید ...'
        });
    });
</script>

@endsection