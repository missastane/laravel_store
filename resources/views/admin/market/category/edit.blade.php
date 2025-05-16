@extends('admin.layouts.master')

@section('head-tag')
<title>ویرایش دسته بندی</title>
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
        <li class="breadcrumb-item font-size-12"><a href="{{route('admin.market.category.index')}}">دسته بندی</a></li>
        <li class="breadcrumb-item active font-size-12" aria-current="page">ویرایش دسته بندی</li>
    </ol>
</nav>
<section class="row">
    
    <section class="col-12">
        <section class="main-body-container">
            <section class="main-body-container-header">
                <h4>ویرایش دسته بندی محصولات</h4>
            </section>
            <section class="d-flex justify-content-between align-items-center my-4">
                <a class="btn btn-dark btn-sm" href="{{route('admin.market.category.index')}}">بازگشت</a>

            </section>
            <section>
                <form action="{{route('admin.market.category.update', $category->id)}}" method="post" enctype="multipart/form-data">
                    <section class="row">
                    @csrf
                    @method('put')
                        <section class="col-12 col-md-6 py-2">
                            <div class="form-group">
                                <label for="name">نام دسته</label>
                                <input class="form-control form-control-sm" type="text" value="{{old('name', $category->name)}}"
                                    name="name" id="name">
                            </div>
                            @error('name')
                                <span class="alert_required text-danger" role="alert"><strong>{{$message}}</strong></span>
                            @enderror
                        </section>
                        <section class="col-12 col-md-6 py-2">
                            <div class="form-group">
                                <label for="parent_id">دسته والد</label>
                                <select class="form-control form-control-sm" name="parent_id" id="parent_id">
                                    <option value="" @if (old('parent_id',$category->parent_id) == null) selected
                                    @endif>-</option>
                                    @foreach ($productCategories as $productCategory)
                                        <option value="{{$productCategory->id}}" @if (old('parent_id', $category->parent_id) == $productCategory->id) selected
                                        @endif>{{$productCategory->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('parent_id')
                                <span class="alert_required text-danger" role="alert"><strong>{{$message}}</strong></span>
                            @enderror
                        </section>
                        <section class="col-12 py-2">
                            <div class="form-group">
                                <label for="description">توضیح دسته</label>
                                <textarea class="form-control form-control-sm" name="description" id="description"
                                    rows="4">{{old('description',$category->description)}}</textarea>
                            </div>
                            @error('description')
                                <span class="alert_required text-danger" role="alert"><strong>{{$message}}</strong></span>
                            @enderror
                        </section>
                        <section class="col-12 py-2 my-4">
                            <div class="form-group">
                                <section class="row">
                                    <section class="col-12 py-2 col-md-7 mt-1">
                                        <label for="files-logo" class="btn btn-primary mt-5 mx-5">بارگذاری تصویر
                                            شاخص دسته</label>
                                        <input type="file" onchange="readURL(this, '#logopreview')"
                                            class="form-control form-control-sm visibility-hidden" name="image"
                                            id="files-logo">
                                    </section>
                                    <section class="col-12 py-2 col-md-5">
                                        <img class="preUpload-preview-img-large"
                                        src="{{asset($category->image['indexArray'][$category->image['currentImage']])}}" alt="{{$category->name}}"
                                            id="logopreview">

                                    </section>
                                </section>
                            </div>
                            @error('image')
                                <span class="alert_required text-danger" role="alert"><strong>{{$message}}</strong></span>
                            @enderror
                            <section class="row mt-4">
                                @php
                                    $number = 1;
                                @endphp

                                <section class="col-12">
                                    <label for="">لطفا ابعاد تصویر را انتخاب فرمایید</label>
                                </section>
                                @foreach($category->image['indexArray'] as $key => $value)                    
                                                                <section class="col-md-{{(6 / $number)}}">
                                                                    <div class="form-check">
                                                                        <input type="radio" class="form-check-input" value="{{$key}}"
                                                                            name="currentImage" id="{{$number}}" @if ($category->image['currentImage'] == $key) checked @endif>
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
                        <section class="col-12 py-2 col-md-6">
                            <div class="form-group">
                                <label for="status">وضعیت</label>
                                <select class="form-control form-control-sm" name="status" id="status">
                                    <option value="1" @if(old('status',$category->status) == 1) selected @endif>فعال</option>
                                    <option value="2" @if(old('status',$category->status) == 2) selected @endif>غیرفعال</option>
                                </select>
                            </div>
                            @error('status')
                                <span class="alert_required text-danger" role="alert"><strong>{{$message}}</strong></span>
                            @enderror
                        </section>
                        <section class="col-12 py-2 col-md-6">
                            <div class="form-group">
                                <label for="show_in_menu">امکان نمایش در منو</label>
                                <select class="form-control form-control-sm" name="show_in_menu" id="show_in_menu">
                                    <option value="1" @if(old('show_in_menu',$category->show_in_menu) == 1) selected @endif>فعال</option>
                                    <option value="2" @if(old('show_in_menu',$category->show_in_menu) == 2) selected @endif>غیرفعال</option>
                                </select>
                            </div>
                            @error('show_in_menu')
                                <span class="alert_required text-danger" role="alert"><strong>{{$message}}</strong></span>
                            @enderror
                        </section>
                        <section class="col-12 py-2">
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