@extends('admin.layouts.master')

@section('head-tag')
<title>فرم کالا</title>
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
        <li class="breadcrumb-item active font-size-12" aria-current="page">فرم کالا</li>
    </ol>
</nav>
<section class="row">
    <section class="col-12">
        <section class="main-body-container">
            <section class="main-body-container-header">
                <h4>فرم کالا</h4>
            </section>
            
            <section class="d-flex justify-content-between align-items-center my-4">
                <section>
                <a class="btn btn-dark btn-sm" href="{{route('admin.market.product.index')}}">بازگشت</a>
                <a class="btn btn-primary btn-sm text-white" data-toggle="modal" data-target="#product-{{$product->id}}">ایجاد فرم کالا</a>
            </section>
                <section class="modal fade" id="product-{{ $product->id }}"
                    tabindex="-1" aria-labelledby="property-create-label"
                    aria-hidden="true">
                    <section class="modal-dialog">
                        <section class="modal-content">
                            <section class="modal-header">
                                <h5 class="modal-title" id="property-create-label"><i
                                        class="fa fa-plus"></i>ایجاد فرم کالای جدید</h5>
                                        <button type="button" class="close p-0 m-0" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                          </button>
                            </section>
                          
                            <section class="modal-body">
                                <form class="row" id="product-create-property-form"
                                    action="{{route('admin.market.product.properties.store', $product)}}"
                                    method="post">
                                    @csrf

                                    <section class="col-12 mb-3">
                                        <label for="name"
                                            class="form-label mb-1">
                                            نام ویژگی
                                             </label>
                                        <input type="text"
                                            class="form-control form-control-sm"
                                            id="name"
                                            name="name">
                                     
                                    </section>
                                    <section class="col-12 mb-3">
                                        <label for="unit"
                                            class="form-label mb-1">
                                            واحد اندازه گیری
                                             </label>
                                        <input type="text"
                                            class="form-control form-control-sm"
                                            id="unit"
                                            name="unit">
                                      
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
                <form method="GET" action="{{route('admin.market.product.properties-search', $product)}}" class="max-width-16-rem">
                    <input type="text" class="form-control form-control-sm form-text" name="search" id="" placeholder="جستجو">
                </form>
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
                            <th>نام فرم</th>
                            <th>واحد اندازه گیری فرم</th>
                            <th>متعلق به دسته</th>
                            <th class="max-width-16-rem text-center"><i class="fa fa-cogs ml-1"></i>تنظیمات</th>
                        </tr>
                    </thead>
                    <tbody>
                       
                        @foreach ($category_attributes as $category_attribute)
                        <tr>
                            <th>{{convertEnglishToPersian($loop->iteration)}}</th>
                            <td>{{$category_attribute->name}}</td>
                            <td>{{$category_attribute->unit}}</td>
                            <td>{{$category_attribute->category->name}}</td>
                            <td class="width-22-rem text-left">
                                <a class="btn btn-success btn-sm text-white" href="{{route('admin.market.product.properties.values',['product'=> $product,'attribute'=> $category_attribute] )}}"><i class="fa fa-edit ml-1"></i>مقادیر</a>
                                <a class="btn btn-sm btn-warning text-white" data-toggle="modal" data-target="#edit-property-{{$category_attribute->id}}"><i class="fa fa-pencil-alt ml-1"></i>ویرایش</a>
                                <form class="d-inline" action="{{route('admin.market.property.destroy', $category_attribute->id)}}" method="POST">
                                            @csrf
                                            @method('delete')
                                        <button type="submit" class="btn btn-sm btn-danger delete"><i class="fa fa-trash"></i> حذف</button>
                                        </form>
                            </td>
              
                            <section class="modal fade" id="edit-property-{{ $category_attribute->id}}"
                                tabindex="-1" aria-labelledby="property-edit-label"
                                aria-hidden="true">
                                <section class="modal-dialog">
                                    <section class="modal-content">
                                        <section class="modal-header">
                                            <h5 class="modal-title" id="property-edit-label"><i
                                                    class="fa fa-plus"></i>ویرایش ویژگی</h5>
                                                    <button type="button" class="close p-0 m-0" data-dismiss="modal" aria-label="Close">
                                                        <span class="p-2" aria-hidden="true">&times;</span>
                                                      </button>
                                        </section>
                                      
                                        <section class="modal-body">
                                            <form class="row"
                                                action="{{route('admin.market.product.properties.update', ['attribute'=>$category_attribute, 'product'=>$product])}}"
                                                method="post">
                                                @csrf
                                                @method('put')
                                           
                                         
                                                <section class="col-12 mb-3">
                                                    <label for="name"
                                                        class="form-label mb-1">
                                                        نام ویژگی
                                                         </label>
                                                    <input type="text"
                                                        class="form-control form-control-sm"
                                                        id="name"
                                                        value="{{ $category_attribute->name }}"
                                                        name="name">
                                                  
                                                </section>
                                                <section class="col-12 mb-3">
                                                    <label for="unit"
                                                        class="form-label mb-1">
                                                        واحد اندازه گیری
                                                         </label>
                                                    <input type="text"
                                                        class="form-control form-control-sm"
                                                        id="unit"
                                                        value="{{$category_attribute->unit}}"
                                                        name="unit">
                                                  
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