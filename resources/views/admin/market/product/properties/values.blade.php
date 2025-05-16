@extends('admin.layouts.master')

@section('head-tag')
<title>مقادیر {{$attribute->name}} برای {{$product->name}}</title>
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
        <li class="breadcrumb-item active font-size-12" aria-current="page">مقادیر {{$attribute->name}} برای
            {{$product->name}}</li>
    </ol>
</nav>
<section class="row">
    <section class="col-12">
        <section class="main-body-container">
            <section class="main-body-container-header">
                <h4>مقادیر {{$attribute->name}} برای {{$product->name}}</h4>
            </section>
            <section class="d-flex justify-content-between align-items-center my-4">
                <section>
                    <a class="btn btn-dark btn-sm" href="{{route('admin.market.product.properties', $product)}}">بازگشت</a>
                    <a class="btn btn-primary btn-sm text-white" data-toggle="modal" data-target="#product-values-{{$product->id}}"
                        ">ایجاد مقدار جدید</a>
                        <section class="modal fade" id="product-values-{{ $product->id }}"
                            tabindex="-1" aria-labelledby="property-create-label"
                            aria-hidden="true">
                            <section class="modal-dialog">
                                <section class="modal-content">
                                    <section class="modal-header">
                                        <h5 class="modal-title" id="property-create-label"><i
                                                class="fa fa-plus"></i>ایجاد مقدار جدید</h5>
                                                <button type="button" class="close p-0 m-0" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                  </button>
                                    </section>
                                    <section class="modal-body">
                                        <form class="row" id="product-create-property-form"
                                            action="{{route('admin.market.product.properties.store-value',['product'=> $product,'attribute'=> $attribute])}}"
                                            method="post">
                                            @csrf
        
                                            <section class="col-12 mb-3">
                                                <div class="form-group">
                                                    <label for="value">مقدار</label> 
                                                    <input class="form-control form-control-sm" type="text" name="value" id="value">
                                                </div>
                                             
                                            </section>
                                            <section class="col-12 mb-3">
                                                <div class="form-group">
                                                    <label for="price_increase">میزان افزایش قیمت</label> 
                                                    <input class="form-control form-control-sm" type="text" name="price_increase" id="price_increase">
                                                </div>
                                               
                                            </section>
                                            <section class="col-12 mb-3">
                                                <div class="form-group">
                                                    <label for="type">نوع</label>
                                                    <select class="form-control form-control-sm" name="type" id="type">
                                                        <option value="1" @if(old('type') == 1) selected @endif>چند گزینه ای</option>
                                                        <option value="2" @if(old('type') == 2) selected @endif>تک انتخابی</option>
                                                    </select>
                                                </div>
                                              
                                            </section>
                                            <section class="col-12 d-flex mb-3 flex-md-row flex-column align-items-center justify-content-md-center">
                                                {!! htmlFormSnippet() !!}
                                                </section>
                                            <section class="modal-footer border-0 py-1">
                                                <button type="submit"
                                                    class="btn btn-sm btn-primary">
                                                    ثبت</button>
                                                <button type="button"
                                                    class="btn btn-close btn-sm btn-danger"
                                                    data-dismiss="modal">بستن</button>
                                            </section>
                                        </form>
                                    </section>
                                </section>
                            </section>
                        </section>
                </section>
                
            </section>
            @if ($errors->any())
            <div class="my-2 border rounded bg-danger text-white p-2 text-center">
                <button type="button" class="float-left btn btn-close bg-white" onclick="$(this).parent().addClass('d-none')">
                    <span aria-hidden="true">&times;</span>
                  </button>
            <h5 class="font-weight-bold text-center">خطا</h5>
            
            @foreach ($errors->all() as $error)
            
            <span
            class="p-1 rounded d-block"
            role="alert">
            <strong>
                {{$loop->iteration.'- '.$error }}
            </strong>
        </span>
    
            @endforeach
           
        </div>
         @endif
            <section class="table-responsive">
                <table class="table table-striped table-info text-center">

                    <thead>
                        <tr>
                            <th>#</th>
                            <th>مقدار</th>
                            <th>میزان افزایش قیمت</th>
                            <th>نوع</th>
                            <th class="max-width-16-rem text-center"><i class="fa fa-cogs ml-1"></i>تنظیمات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($attribute->values->where('product_id', $product->id) as $category_value)
                            <tr>
                                <th>{{convertEnglishToPersian($loop->iteration)}}</th>
                                <td>{{json_decode($category_value->value)->value}}</td>
                                <td>{{priceFormat(json_decode($category_value->value)->price_increase)}} تومان</td>
                                <td>{{$category_value->type == 1 ? 'چند گزینه ای' : 'تک انتخابی'}}</td>
                                <td class="width-22-rem text-left">
                                    <a class="btn btn-sm btn-warning" data-toggle="modal" data-target="#property-value-{{ $category_value->id}}"><i class="fa fa-pencil-alt ml-1"></i>ویرایش</a>
                                       
                                            
                                    <form class="d-inline"
                                        action="{{route('admin.market.property-value.destroy', ['attribute' => $attribute->id, 'value' => $category_value->id])}}"
                                        method="POST">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" class="btn btn-sm btn-danger delete"><i
                                                class="fa fa-trash"></i> حذف</button>
                                    </form>
                                </td>
                                <section class="modal fade" id="property-value-{{ $category_value->id}}"
                                    tabindex="-1" aria-labelledby="value-update-label"
                                    aria-hidden="true">
                                    <section class="modal-dialog">
                                        <section class="modal-content">
                                            <section class="modal-header">
                                                <h5 class="modal-title" id="value-update-label"><i
                                                        class="fa fa-plus"></i>ویرایش مقدار</h5>
                                                        <button type="button" class="close p-0 m-0" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                          </button>
                                            </section>
                                            <section class="modal-body">
                                                <form class="row" id="product-create-property-form"
                                                    action="{{route('admin.market.product.properties.update-value', $category_value)}}"
                                                    method="post">
                                                    @csrf
                                             @method('put')
                                                <section class="col-12 mb-3">
                                                    <div class="form-group">
                                                        <label for="value">مقدار</label> 
                                                        <input class="form-control form-control-sm" type="text" value="{{json_decode($category_value->value)->value}}" name="value" id="value">
                                                    </div>
                                                 
                                                </section>
                                                <section class="col-12 mb-3">
                                                    <div class="form-group">
                                                        <label for="price_increase">میزان افزایش قیمت</label> 
                                                        <input class="form-control form-control-sm" type="text" value="{{json_decode($category_value->value)->price_increase}}" name="price_increase" id="price_increase">
                                                    </div>
                                                 
                                                </section>
                                                
                                                <section class="col-12 mb-3">
                                                            <div class="form-group">
                                                                <label for="type">نوع</label>
                                                                <select class="form-control form-control-sm" name="type" id="type">
                                                                    <option value="1" @if($category_value->type == 1) selected @endif>چند گزینه ای</option>
                                                                    <option value="2" @if($category_value->type == 2) selected @endif>تک انتخابی</option>
                                                                </select>
                                                            </div>
                                                          
                                                        </section>
                                                        <section class="col-12 d-flex mb-3 flex-md-row flex-column align-items-center justify-content-md-center">
                                                            {!! htmlFormSnippet() !!}
                                                            </section>
                                                    <section class="modal-footer border-0 py-1">
                                                        <button type="submit"
                                                            class="btn btn-sm btn-primary">
                                                            ثبت</button>
                                                        <button type="button"
                                                            class="btn btn-sm btn-danger"
                                                            data-dismiss="modal">بستن</button>
                                                    </section>
                                                </form>
                                            </section>
                                        </section>
                                    </section>
                                </section>
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