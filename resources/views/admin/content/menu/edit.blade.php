@extends('admin.layouts.master')

@section('head-tag')
<title>ویرایش منو</title>
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
        <li class="breadcrumb-item font-size-12"><a href="{{route('admin.content.menu.index')}}">منو</a></li>
        <li class="breadcrumb-item active font-size-12" aria-current="page">ویرایش منو</li>
    </ol>
</nav>
<section class="row">
    <section class="col-12">
        <section class="main-body-container">
            <section class="main-body-container-header">
                <h4>ویرایش منو</h4>
            </section>
            <section class="d-flex justify-content-between align-items-center my-4">
                <a class="btn btn-dark btn-sm" href="{{route('admin.content.menu.index')}}">بازگشت</a>
                
            </section>
            <section>
            <form action="{{route('admin.content.menu.update', $menu->id)}}" method="post">
                <section class="row">
                    @csrf
                    {{method_field('put')}}
                    <section class="col-12 col-md-6 py-2">
                    <div class="form-group">
                        <label for="name">نام منو</label> 
                        <input class="form-control form-control-sm" value="{{old('name', $menu->name)}}" type="text" name="name" id="name">
                    </div>
                    @error('name')
                                <span class="alert_required text-danger" role="alert"><strong>{{$message}}</strong></span>
                            @enderror
                </section>
                    <section class="col-12 col-md-6 py-2">
                    <div class="form-group">
                    <label for="parent_id">منوی والد</label>
                   <select class="form-control form-control-sm" name="parent_id" id="parent_id">
                   <option value="" 
                   @if(old('parent_id', $menu->parent_id) == null) 
                   selected 
                   @endif >-</option>
                    @foreach ($parentMenus as $parentMenu)
                    <option value="{{$parentMenu->id}}" @if(old('parent_id', $menu->parent_id) == $parentMenu->id) selected @endif >{{$parentMenu->name}}</option>
                    @endforeach
                   </select>
                    </div>
                    @error('parent_id')
                                <span class="alert_required text-danger" role="alert"><strong>{{$message}}</strong></span>
                            @enderror
                </section>
                    <section class="col-12 col-md-6 py-2">
                    <div class="form-group">
                        <label for="url">لینک منو</label> 
                        <input title="نمونه آدرس معتبر : https://www.google.com/everything یا http://google.com/everything" class="form-control form-control-sm" value="{{old('url', $menu->url)}}" type="text" name="url" id="url">
                    </div>
                    @error('url')
                                <span class="alert_required text-danger" role="alert"><strong>{{$message}}</strong></span>
                            @enderror
                </section>
                    <section class="col-12 col-md-6 py-2">
                            <div class="form-group">
                                <label for="status">وضعیت</label>
                                <select class="form-control form-control-sm" name="status" id="status">
                                    <option @if (old('status', $menu->status) == 1)
                                    selected
                                    @endif value="1">فعال</option>
                                    <option @if (old('status', $menu->status) == 2)
                                    selected
                                    @endif value="2">غیرفعال</option>
                                </select>
                            </div>
                            @error('status')
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