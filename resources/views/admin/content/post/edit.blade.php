@extends('admin.layouts.master')

@section('head-tag')
<link rel="stylesheet" href="{{asset('admin-assets/jalalidatepicker/persian-datepicker.min.css')}}">
<title>ویرایش پست</title>
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
        <li class="breadcrumb-item font-size-12"><a href="{{route('admin.content.post.index')}}">پست ها</a></li>
        <li class="breadcrumb-item active font-size-12" aria-current="page">ویرایش پست</li>
    </ol>
</nav>
<section class="row">
    <section class="col-12 py-2">
        <section class="main-body-container">
            <section class="main-body-container-header">
                <h4>ویرایش پست</h4>
            </section>
            <section class="d-flex justify-content-between align-items-center my-4">
                <a class="btn btn-dark btn-sm" href="{{route('admin.content.post.index')}}">بازگشت</a>

            </section>
            <section>
                <form action="{{route('admin.content.post.update', $post->id)}}" method="post" enctype="multipart/form-data">
                    <section class="row">
                        @csrf
{{method_field('put')}}
                        <section class="col-12 col-md-6 py-2">
                            <div class="form-group">
                                <label for="title">عنوان پست</label>
                                <input class="form-control form-control-sm" value="{{old('title', $post->title)}}" type="text" name="title" id="title">
                            </div>
                            @error('title')
                                <span class="alert_required text-danger" role="alert"><strong>{{$message}}</strong></span>
                            @enderror
                        </section>
                        <section class="col-12 py-2 col-md-6">
                            <div class="form-group">
                                <label for="author_id">نویسنده</label>
                                <select class="form-control form-control-sm" name="author_id" id="author_id">
                                    <option value="1">نویسنده</option>
                                </select>
                            </div>
                            
                        </section>
                        <section class="col-12 py-2 col-md-6">
                            <div class="form-group">
                                <label for="commentable">آیا اجازه ثبت نظر داشته باشد؟</label>
                                <select class="form-control form-control-sm" name="commentable" id="commentable">
                                    <option value="1"  value="1" @if(old('commentable', $post->commentable) == 1) selected  @endif>بله</option>
                                    <option value="2" @if(old('commentable', $post->commentable) == 1) selected  @endif>خیر</option>
                                </select>
                            </div>
                            @error('commentable')
                                <span class="alert_required text-danger" role="alert"><strong>{{$message}}</strong></span>
                            @enderror
                        </section>
                        <section class="col-12 py-2 col-md-6">
                            <div class="form-group">
                                <label for="status">وضعیت</label>
                                <select class="form-control form-control-sm" name="status" id="status">
                                    <option value="1" @if(old('status', $post->status) == 1) selected  @endif>فعال</option>
                                    <option value="2" @if(old('status', $post->status) == 2) selected  @endif>غیرفعال</option>
                                </select>
                            </div>
                            @error('status')
                                <span class="alert_required text-danger" role="alert"><strong>{{$message}}</strong></span>
                            @enderror
                        </section>
                        <section class="col-12 py-2 col-md-6">
                            <div class="form-group">
                                <label for="post_category_id">انتخاب دسته</label>
                                <select class="form-control form-control-sm" name="post_category_id" id="post_category_id">
                                  <option disabled selected value="">لطفا دسته بندی پست را انتخاب نمایید</option>
                                @foreach ($postCategories as $postCategory)
                                <option @if (old('post_category_id', $post->post_category_id) == $postCategory->id)
                                selected
                                @endif value="{{$postCategory->id}}">{{$postCategory->name}}</option>
                                   
                                   @endforeach
                                </select>
                            </div>
                            @error('post_category_id')
                                <span class="alert_required text-danger" role="alert"><strong>{{$message}}</strong></span>
                            @enderror
                        </section>
                     
                        <section class="col-12 py-2 col-md-6">
                            <div class="form-group">
                                <label for="published_at">تاریخ انتشار</label>
                                <input class="form-control form-control-sm d-none"  type="text" name="published_at" id="published_at">
                                <input class="form-control form-control-sm" value="{{old('published_at', $post->published_at)}}" type="text" id="published_at_view">
                            </div>
                            @error('published_at')
                                <span class="alert_required text-danger" role="alert"><strong>{{$message}}</strong></span>
                            @enderror
                        </section>
                        <section class="col-12">
                            <div class="form-group">
                                <label for="tags">برچسب ها</label>
                                <select class="form-control form-control-sm js-example-basic-single" multiple="multiple"
                                    name="tags[]">
                                    @if(old('tags'))
                                        @for($i = 0; $i < count(old('tags')); $i++)
                                            <option value="{{ old('tags')[$i] }}" @if(in_array(old('tags')[$i], old('tags')))
                                            selected @endif>{{old('tags')[$i]}}</option>
                                        @endfor
                                    @else
                                        @for($i = 0; $i < count($tags); $i++)
                                            <option value="{{ $tags[$i] }}" @if(in_array($tags[$i], $tags)) selected @endif>
                                                {{$tags[$i]}}</option>
                                        @endfor
                                    @endif
                                </select>
                            </div>
                            @error('tags')
                                <span class="alert_required text-danger" role="alert"><strong>{{$message}}</strong></span>
                            @enderror
                        </section>
                        <section class="col-12 py-2 my-4">
                            <div class="form-group">
                                <section class="row">
                                    <section class="col-12 py-2 col-md-7 mt-1">
                                        <label for="files-logo" class="btn btn-primary mt-5 mx-5">بارگذاری تصویر
                                            شاخص پست</label>
                                        <input type="file" onchange="readURL(this, '#logopreview')"
                                            class="form-control form-control-sm visibility-hidden" name="image"
                                            id="files-logo">
                                    </section>
                                    <section class="col-12 py-2 col-md-5">
                                        <img class="preUpload-preview-img-large" @if($post->image)   
                                                src="{{asset($post->image['indexArray'][$post->image['currentImage']])}}"
                                        @endif
                                            src="{{asset('admin-assets/images/samsung-a53.jpg')}}" alt=""
                                            id="logopreview">

                                    </section>
                                </section>
                            </div>
                            @error('image')
                                <span class="alert_required text-danger" role="alert"><strong>{{$message}}</strong></span>
                            @enderror
                            <section class="row mt-3">
                                @php
                                    $number = 1;
                                @endphp

                                <section class="col-12">
                                    <label for="">لطفا ابعاد تصویر را انتخاب فرمایید</label>
                                </section>
                                @foreach($post->image['indexArray'] as $key => $value)                    
                                                                <section class="col-md-{{(6 / $number)}}">
                                                                    <div class="form-check">
                                                                        <input type="radio" class="form-check-input" value="{{$key}}"
                                                                            name="currentImage" id="{{$number}}" @if ($post->image['currentImage'] == $key) checked @endif>
                                                                        <label for="{{$number}}" class="form-check-label mx-2">
                                                                            <img src="{{asset($value)}}" class="w-100" alt="">
                                                                        </label>
                                                                    </div>
                                                                </section>
                                                                @php
                                                                    $number++;
                                                                @endphp
                                @endforeach

                            </section>
                        </section>
                        <section class="col-12 py-2">
                            <div class="form-group">
                                <label for="summary">خلاصه</label>
                                <textarea class="form-control form-control-sm" name="summary" id="summary" rows="7">{{old('summary', $post->summary)}}</textarea>
                            </div>
                            @error('summary')
                                <span class="alert_required text-danger" role="alert"><strong>{{$message}}</strong></span>
                            @enderror
                        </section>
                        <section class="col-12 py-2">
                            <div class="form-group">
                                <label for="body">متن اصلی پست</label>
                                <textarea class="form-control form-control-sm" name="body" id="body" rows="12">{{old('body', $post->body)}}</textarea>
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
    CKEDITOR.replace('summary');
    CKEDITOR.replace('body');
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