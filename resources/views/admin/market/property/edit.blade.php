@extends('admin.layouts.master')

@section('head-tag')
<title>ویرایش فرم</title>
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
        <li class="breadcrumb-item font-size-12"><a href="{{route('admin.market.property.index')}}">فرم</a></li>
        <li class="breadcrumb-item active font-size-12" aria-current="page">ویرایش فرم</li>
    </ol>
</nav>
<section class="row">
    <section class="col-12">
        <section class="main-body-container">
            <section class="main-body-container-header">
                <h4>ویرایش فرم</h4>
            </section>
            <section class="d-flex justify-content-between align-items-center my-4">
                <a class="btn btn-dark btn-sm" href="{{route('admin.market.property.index')}}">بازگشت</a>
                
            </section>
            <section>
            <form action="{{route('admin.market.property.update', $attribute->id)}}" method="post">
                <section class="row">
                    @csrf
                    @method('put')
                    <section class="col-12 col-md-6">
                    <div class="form-group">
                        <label for="name">نام فرم</label> 
                        <input class="form-control form-control-sm" type="text" value="{{old('name', $attribute->name)}}" name="name" id="name">
                    </div>
                    @error('name')
                                <span class="alert_required text-danger" role="alert"><strong>{{$message}}</strong></span>
                            @enderror
                </section>
                    <section class="col-12 col-md-6">
                    <div class="form-group">
                        <label for="unit">واحد اندازه گیری</label> 
                        <input class="form-control form-control-sm" value="{{old('unit', $attribute->unit)}}" type="text" name="unit" id="unit">
                    </div>
                    @error('unit')
                                <span class="alert_required text-danger" role="alert"><strong>{{$message}}</strong></span>
                            @enderror
                </section>
                    <section class="col-12 col-md-6">
                    <div class="form-group">
                    <label for="category_id">متعلق به دسته</label>
                   <select class="form-control form-control-sm" name="category_id" id="category_id">
                    <option value="" selected disabled>انتخاب دسته</option>
                    @foreach ($categories as $category)
                    <option value="{{$category->id}}" @if ($category->id == old('category_id',$attribute->category_id))
                    selected 
                    @endif>{{$category->name}}</option>
                    @endforeach
                   
                   </select>
                    </div>
                    @error('category_id')
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
                    <div class="col-12 col-md-6 mt-4">
                        <button type="submit" class="btn btn-warning btn-sm mt-2">ویرایش</button>
                    </div>
                </section>
            </form>
            </section>
        </section>
    </section>
</section>
@endsection