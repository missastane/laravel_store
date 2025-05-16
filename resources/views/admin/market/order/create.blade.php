@extends('admin.layouts.master')

@section('head-tag')
<title>ایجاد کوپن تخفیف جدید</title>
@endsection

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb text-center">
        <li class="breadcrumb-item font-size-12"><a href="{{route('admin.home')}}">خانه</a></li>
        <li class="breadcrumb-item font-size-12"><a href="{{route('admin.home')}}"> بخش فروش</a></li>
        <li class="breadcrumb-item font-size-12"><a href="{{route('admin.market.discount.copan')}}">کوپن تخفیف</a></li>
        <li class="breadcrumb-item active font-size-12" aria-current="page">ایجاد کوپن تخفیف جدید</li>
    </ol>
</nav>
<section class="row">
    <section class="col-12">
        <section class="main-body-container">
            <section class="main-body-container-header">
                <h4>ایجاد کوپن تخفیف جدید</h4>
            </section>
            <section class="d-flex justify-content-between align-items-center my-4">
                <a class="btn btn-dark btn-sm" href="{{route('admin.market.discount.copan')}}">بازگشت</a>
                
            </section>
            <section>
            <form action="" method="post">
                <section class="row">
                    <section class="col-12 col-md-4">
                    <div class="form-group">
                        <label for="name">کد کوپن</label> 
                        <input class="form-control form-control-sm" type="text" name="" id="name">
                    </div></section>
                    <section class="col-12 col-md-4">
                    <div class="form-group">
                        <label for="name">درصد تخفیف</label> 
                        <input class="form-control form-control-sm" type="number" name="" id="name">
                    </div>
                    </section>
                    <section class="col-12 col-md-4">
                    <div class="form-group">
                        <label for="name">عنوان مناسبت</label> 
                        <input class="form-control form-control-sm" type="text" name="" id="name">
                    </div>
                    </section><section class="col-12 col-md-4">
                    <div class="form-group">
                        <label for="name">نوع کوپن</label> 
                        <select class="form-control form-control-sm" name="" id="">
                            <option value="">عمومی</option>
                            <option value="">مخصوص</option>
                        </select>
                    </div>
                    </section><section class="col-12 col-md-4">
                    <div class="form-group">
                        <label for="name">حداکثر تخفیف</label> 
                        <input class="form-control form-control-sm" type="number" name="" id="name">
                    </div>
                    </section><section class="col-12 col-md-4">
                    <div class="form-group">
                        <label for="name">تاریخ شروع</label> 
                        <input class="form-control form-control-sm" type="text" name="" id="name">
                    </div>
                    </section><section class="col-12 col-md-4">
                    <div class="form-group">
                        <label for="name">تاریخ پایان</label> 
                        <input class="form-control form-control-sm" type="text" name="" id="name">
                    </div>
                    </section>
                    <section class="col-12">
                    <div class="form-group">
                        <button type="submit" class="btn btn-success btn-sm float-left">ثبت</button>
                    </div></section>
                </section/>
            </form>
            </section>
        </section>
    </section>
</section>
@endsection