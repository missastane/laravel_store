@extends('admin.layouts.master')

@section('head-tag')
<title>ویرایش نقش</title>
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
        <li class="breadcrumb-item font-size-12"><a href="{{route('admin.user.role.index')}}">نقش های کاربران</a></li>
        <li class="breadcrumb-item active font-size-12" aria-current="page">ویرایش نقش</li>
    </ol>
</nav>
<section class="row">
    <section class="col-12">
        <section class="main-body-container">
            <section class="main-body-container-header">
                <h4>ویرایش نقش</h4>
            </section>
            <section class="d-flex justify-content-between align-items-center my-4">
                <a class="btn btn-dark btn-sm" href="{{route('admin.user.role.index')}}">بازگشت</a>

            </section>
            <section class="border-top py-4">
                <form action="{{route('admin.user.role.update', $role->id)}}" method="post">
                    <section class="row">
                        @csrf
                        @method('put')
                        <section class="col-12 col-md-5 py-2">
                            <div class="form-group">
                                <label for="name">عنوان نقش</label>
                                <input class="form-control form-control-sm" value="{{old('name', $role->name)}}" type="text" name="name" id="name">
                            </div>
                            @error('name')
                                <span class="alert_required text-danger" role="alert"><strong>{{$message}}</strong></span>
                            @enderror
                        </section>
                        <section class="col-12 col-md-5 py-2">
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
                        <section class="col-12 py-2 col-md-10">
                            <div class="form-group">
                                <label for="description">توضیح نقش</label>
                                <input class="form-control form-control-sm" value="{{old('description', $role->description)}}" type="text" name="description" id="description">
                            </div>
                            @error('description')
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
                        <section class="col-12 py-2 col-md-2">
                            <button type="submit" class="btn btn-warning btn-sm mt-2-rem">ویرایش</button>
                    </section>
            </section>
          
            </form>
        </section>
      
    </section>
</section>
</section>
@endsection