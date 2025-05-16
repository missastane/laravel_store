@extends('admin.layouts.master')

@section('head-tag')
<title>مقادیر {{$attribute->name}} برای گروه {{$attribute->category->name}}</title>
@endsection

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb text-center">
        <li class="breadcrumb-item font-size-12"><a href="{{route('admin.home')}}">خانه</a></li>
        <li class="breadcrumb-item font-size-12"><a href="{{route('admin.home')}}"> بخش فروش</a></li>
        <li class="breadcrumb-item active font-size-12" aria-current="page">مقادیر {{$attribute->name}} برای گروه
            {{$attribute->category->name}}</li>
    </ol>
</nav>
<section class="row">
    <section class="col-12">
        <section class="main-body-container">
            <section class="main-body-container-header">
                <h4>مقادیر {{$attribute->name}} برای گروه {{$attribute->category->name}}</h4>
            </section>
            <section class="d-flex justify-content-between align-items-center my-4">
                <section>
                    <a class="btn btn-dark btn-sm" href="{{route('admin.market.property.index')}}">بازگشت</a>
                    <a class="btn btn-primary btn-sm"
                        href="{{route('admin.market.property-value.create', $attribute->id)}}">ایجاد مقدار جدید</a>
                </section>
                
            </section>
            <section class="table-responsive">
                <table class="table table-striped table-info text-center">

                    <thead>
                        <tr>
                            <th>#</th>
                            <th>برای محصول</th>
                            <th>مقدار</th>
                            <th>میزان افزایش قیمت</th>
                            <th>نوع</th>
                            <th class="max-width-16-rem text-center"><i class="fa fa-cogs ml-1"></i>تنظیمات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($attribute->values as $category_value)
                            <tr>
                                <th>{{convertEnglishToPersian($loop->iteration)}}</th>
                                <td>{{$category_value->product->name}}</td>
                                <td>{{json_decode($category_value->value)->value}}</td>
                                <td>{{priceFormat(json_decode($category_value->value)->price_increase)}} تومان</td>
                                <td>{{$category_value->type == 1 ? 'چند گزینه ای' : 'تک انتخابی'}}</td>
                                <td class="width-22-rem text-left">
                                    <a class="btn btn-sm btn-warning"
                                        href="{{route('admin.market.property-value.edit', ['attribute' => $attribute->id, 'value' => $category_value->id])}}"><i
                                            class="fa fa-pencil-alt ml-1"></i>ویرایش</a>
                                    <form class="d-inline"
                                        action="{{route('admin.market.property-value.destroy', ['attribute' => $attribute->id, 'value' => $category_value->id])}}"
                                        method="POST">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" class="btn btn-sm btn-danger delete"><i
                                                class="fa fa-trash"></i> حذف</button>
                                    </form>
                                </td>
                            </tr>

                        @endforeach

                    </tbody>
                </table>
            </section>
        </section>
    </section>
</section>
@endsection
@section('script')
@include('admin.alerts.sweetalert.delete-confirm', ['className' => 'delete'])
@endsection