@extends('admin.layouts.master')

@section('head-tag')
<title>ایجاد صفحه جدید</title>
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
        <li class="breadcrumb-item font-size-12"><a href="{{route('admin.content.page.index')}}">صفحه ساز</a></li>
        <li class="breadcrumb-item active font-size-12" aria-current="page">ایجاد صفحه جدید</li>
    </ol>
</nav>
<section class="row">
    <section class="col-12">
        <section class="main-body-container">
            <section class="main-body-container-header">
                <h4>ایجاد صفحه جدید</h4>
            </section>
            <section class="d-flex justify-content-between align-items-center my-4">
                <a class="btn btn-dark btn-sm" href="{{route('admin.content.page.index')}}">بازگشت</a>
                
            </section>
            <section>
            <form action="{{route('admin.content.page.store')}}" method="post">
                <section class="row">
                    @csrf
                    <section class="col-12 col-md-6">
                    <div class="form-group">
                        <label for="title">عنوان صفحه</label> 
                        <input class="form-control form-control-sm" value="{{old('title')}}" type="text" name="title" id="title">
                    </div>
                    @error('title')
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
                        <section class="col-12 py-2">
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
                    <section class="col-12">
                    <div class="form-group">
                    <label for="body">محتوی</label>
                  <textarea name="body" id="body" rows="5">{{old('body')}}</textarea>
                  
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