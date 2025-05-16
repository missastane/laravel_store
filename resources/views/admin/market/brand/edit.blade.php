@extends('admin.layouts.master')

@section('head-tag')
<title>ویرایش برند</title>
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
        <li class="breadcrumb-item font-size-12"><a href="{{route('admin.market.brand.index')}}">برند</a></li>
        <li class="breadcrumb-item active font-size-12" aria-current="page">ویرایش برند</li>
    </ol>
</nav>
<section class="row">
    <section class="col-12">
        <section class="main-body-container">
            <section class="main-body-container-header">
                <h4>ویرایش برند برای محصولات</h4>
            </section>
            <section class="d-flex justify-content-between align-items-center my-4">
                <a class="btn btn-dark btn-sm" href="{{route('admin.market.brand.index')}}">بازگشت</a>

            </section>
            <section>
                <form action="{{route('admin.market.brand.update', $brand->id)}}" method="post" enctype="multipart/form-data">
                    <section class="row">
                        @csrf
                        @method('put')
                        <section class="col-12 col-md-6 py-2">
                            <div class="form-group">
                                <label for="persian_name">نام فارسی برند</label>
                                <input class="form-control form-control-sm" value="{{old('persian_name', $brand->persian_name)}}" type="text" name="persian_name"
                                    id="persian_name">
                            </div>
                            @error('persian_name')
                                <span class="alert_required text-danger" role="alert"><strong>{{$message}}</strong></span>
                            @enderror
                        </section>
                        <section class="col-12 col-md-6 py-2">
                            <div class="form-group">
                                <label for="original_name">نام اورجینال برند</label>
                                <input class="form-control form-control-sm" value="{{old('original_name',$brand->original_name)}}" type="text" name="original_name"
                                    id="original_name">
                            </div>
                            @error('original_name')
                                <span class="alert_required text-danger" role="alert"><strong>{{$message}}</strong></span>
                            @enderror
                        </section>

                      
                        <section class="col-12 py-2 col-md-6">
                            <div class="form-group">
                                <label for="status">وضعیت</label>
                                <select class="form-control form-control-sm" name="status" id="status">
                                    <option value="1" @if(old('status', $brand->status) == 1) selected @endif>فعال</option>
                                    <option value="2" @if(old('status', $brand->status) == 2) selected @endif>غیرفعال</option>
                                </select>
                            </div>
                            @error('status')
                                <span class="alert_required text-danger" role="alert"><strong>{{$message}}</strong></span>
                            @enderror
                        </section>
                        <section class="col-12 col-md-6 py-2">
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
                        <section class="col-12 mt-2 py-2">
                            <div class="form-group">
                                <section class="row">
                                    <section class="col-12 col-md-6">
                                        <label for="files-logo" class="btn btn-primary mt-4 mx-5">بارگذاری لوگو</label>
                                        <input type="file" onchange="readURL(this, '#logopreview')"
                                            class="form-control form-control-sm visibility-hidden" name="logo"
                                            id="files-logo">
                                    </section>
                                    <section class="col-12 col-md-6">
                                        <img class="preUpload-preview-img"
                                            src="{{asset($brand->logo['indexArray'][$brand->logo['currentImage']])}}" alt="{{$brand->persian_name}}" id="logopreview">
                                    </section>
                                </section>
                            </div>
                            @error('logo')
                                <span class="alert_required text-danger" role="alert"><strong>{{$message}}</strong></span>
                            @enderror
                            <section class="row mt-4">
                                @php
                                    $number = 1;
                                @endphp

                                <section class="col-12">
                                    <label for="">لطفا ابعاد تصویر را انتخاب فرمایید</label>
                                </section>
                                @foreach($brand->logo['indexArray'] as $key => $value)                    
                                                                <section class="col-md-{{(6 / $number)}}">
                                                                    <div class="form-check">
                                                                        <input type="radio" class="form-check-input" value="{{$key}}"
                                                                            name="currentImage" id="{{$number}}" @if ($brand->logo['currentImage'] == $key) checked @endif>
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
                    </section />
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