@extends('admin.layouts.master')

@section('head-tag')
<title>نمایش پرسش و پاسخ</title>
@endsection

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb text-center">
        <li class="breadcrumb-item font-size-12"><a href="{{route('admin.home')}}">خانه</a></li>
        <li class="breadcrumb-item font-size-12"><a href="{{route('admin.home')}}"> بخش محتوی</a></li>
        <li class="breadcrumb-item font-size-12"><a href="{{route('admin.content.faq.index')}}">پرسش و پاسخات</a></li>
        <li class="breadcrumb-item active font-size-12" aria-current="page">نمایش پرسش و پاسخ</li>
    </ol>
</nav>
<section class="row">
    <section class="col-12">
    <section class="main-body-container">
            <section class="main-body-container-header">
                <h4>نمایش پرسش و پاسخ</h4>
            </section>
            <section class="d-flex justify-content-between align-items-center my-4">
                <a class="btn btn-dark btn-sm" href="{{route('admin.content.faq.index')}}">بازگشت</a>

            </section>
            <section class="card mb-2">
                <section class="card-header bg-custom-yellow text-white">
                    پرسش
                </section>
                <section class="w-100 py-2 px-3 mt-3 mb-2">
                    <h5 class="card-title"><b>{{$faq->question}}</b></h5>
                </section>

            </section>
            <section class="card mb-2">
                <section class="card-header bg-custom-pink text-white">
                    وضعیت
                </section>
                <section class="w-100 py-2 px-3 mt-3 mb-2">
                    <h5 class="card-title">@if ($faq->status == 1)
                    <b><i class="fa fa-check-square text-success"></i> فعال</b>
                    @else
                    <b><i class="fa fa-times-circle text-danger"></i> غیرفعال</b>

                    @endif
                </h5>
                </section>

            </section>
            <section class="card mb-2">
                <section class="card-header bg-custom-green text-white">
                    تگ ها
                </section>
                <section class="w-100 py-2 px-3 mt-3 mb-2">
                    <p class="card-text text-secondary font-size-14">{{$faq->tags}}</p>
                </section>

            </section>
            <section>
                <section class="row">
                    <section class="bg-custom-blue text-white w-100 mx-3 rounded py-1">
                        <h5 class="py-1 pr-3 vertical-middle">پاسخ</h5>
                    </section>
                    <section class="col-12">


                        <section class="height-auto font-size-14 text-secondary border border-top-0 rounded p-3">
                            {!!$faq->answer!!}</section>
                        </div>
                    </section>


                </section />

            </section>
        </section>
    </section>
</section>
@endsection