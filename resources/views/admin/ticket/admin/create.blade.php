@extends('admin.layouts.master')

@section('head-tag')
<title>ایجاد دسته بندی</title>
@endsection

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb text-center">
        <li class="breadcrumb-item font-size-12"><a href="{{route('admin.home')}}">خانه</a></li>
        <li class="breadcrumb-item font-size-12"><a href="{{route('admin.home')}}"> بخش تیکت ها</a></li>
        <li class="breadcrumb-item font-size-12"><a href="{{route('admin.ticket.category.index')}}">دسته بندی</a></li>
        <li class="breadcrumb-item active font-size-12" aria-current="page">ایجاد دسته بندی</li>
    </ol>
</nav>
<section class="row">
    <section class="col-12">
        <section class="main-body-container">
            <section class="main-body-container-header">
                <h4>ایجاد دسته بندی برای تیکت ها</h4>
            </section>
            <section class="d-flex justify-content-between align-items-center my-4">
                <a class="btn btn-dark btn-sm" href="{{route('admin.ticket.category.index')}}">بازگشت</a>

            </section>
           
            <section>
                <form action="{{route('admin.ticket.category.store')}}" method="post">
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
