@extends('customer.layouts.master-one-col')
@section('head-tag')
<title>محصولات فروشگاه آمازون</title>
@endsection

@section('content')

<!-- start body -->
<section class="">
    <section id="main-body-two-col" class="container-xxl body-container">
        <section class="row">
            <aside id="sidebar" class="sidebar col-md-3">

            <form action="{{route('customer.products', request()->category ? request()->category : null)}}" method="get">
                <section class="content-wrapper bg-white p-3 rounded-2 mb-3">
                    <!-- start sidebar nav-->
                        <input type="hidden" name="sort" value="{{request()->sort}}">
                        <section class="sidebar-nav">
                            <section class="sidebar-nav-item">
                     @include('customer.layouts.partials.categories', ['categories' => $categories])
                      </section>
                    </section>
                        <!--end sidebar nav-->
                </section>

                <section class="content-wrapper bg-white p-3 rounded-2 mb-3">
                    <section class="content-header mb-3">
                        <section class="d-flex justify-content-between align-items-center">
                            <h2 class="content-header-title content-header-title-small">
                                جستجو در نتایج
                            </h2>
                            <section class="content-header-link">
                                <!--<a href="#">مشاهده همه</a>-->
                            </section>
                        </section>
                    </section>

                    <section class="">
                        <input class="sidebar-input-text" value="{{request()->search}}" name="search" type="text"
                            placeholder="جستجو بر اساس نام، برند ...">
                    </section>
                </section>

                <section class="content-wrapper bg-white p-3 rounded-2 mb-3">
                    <section class="content-header mb-3">
                        <section class="d-flex justify-content-between align-items-center">
                            <h2 class="content-header-title content-header-title-small">
                                برند
                            </h2>
                            <section class="content-header-link">
                                <!--<a href="#">مشاهده همه</a>-->
                            </section>
                        </section>
                    </section>

                    <section class="sidebar-brand-wrapper">
                        @foreach ($brands as $brand)
                        <section class="form-check sidebar-brand-item">
                            <input class="form-check-input" name="brands[]" @if (isset(request()->brands))
                                {{in_array($brand->id, request()->brands) ? 'checked' : ''}} @endif type="checkbox"
                                value="{{$brand->id}}" id="{{$brand->id}}">
                            <label class="form-check-label d-flex justify-content-between" for="{{$brand->id}}">
                                <span>{{$brand->persian_name}}</span>
                                <span>{{$brand->original_name}}</span>
                            </label>
                        </section>

                        @endforeach
                        <section>
                            @error('brands.*')
                                <span class="alert_required text-danger" role="alert"><strong
                                        class="font-size-12">{{$message}}</strong></span>
                            @enderror
                        </section>


                    </section>
                </section>



                <section class="content-wrapper bg-white p-3 rounded-2 mb-3">
                    <section class="content-header mb-3">
                        <section class="d-flex justify-content-between align-items-center">
                            <h2 class="content-header-title content-header-title-small">
                                محدوده قیمت
                            </h2>
                            <section class="content-header-link">
                                <!--<a href="#">مشاهده همه</a>-->
                            </section>
                        </section>
                    </section>
                    <section class="sidebar-price-range d-flex justify-content-between">

                        <section class="p-1"><input type="text" placeholder="قیمت از ..." name="min_price"
                                value="{{request()->min_price}}"></section>

                        <section class="p-1"><input type="text" placeholder="قیمت تا ..." name="max_price"
                                value="{{request()->max_price}}"></section>

                    </section>
                    <section>
                        <div class="mt-1">
                            @error('min_price')
                                <span class="alert_required text-danger" role="alert"><strong
                                        class="font-size-12">{{$message}}</strong></span>
                            @enderror
                        </div>
                        <div class="mt-1">
                            @error('max_price')
                                <span class="alert_required text-danger" role="alert"><strong
                                        class="font-size-12">{{$message}}</strong></span>
                            @enderror
                        </div>
                    </section>
                </section>



                <section class="content-wrapper bg-white p-3 rounded-2 mb-3">
                    <section class="sidebar-filter-btn d-grid gap-2">
                        <button class="btn btn-danger" type="submit">اعمال فیلتر</button>
                    </section>

                </section>
                </form>

            </aside>
            <main id="main-body" class="main-body col-md-9">
                
                <section class="content-wrapper bg-white p-3 rounded-2 mb-2">
                    
                    <section class="filters mb-3">
                      
                       @if(request()->except('sort') != null && count(array_filter(request()->except('sort'))) > 1 || request()->category != null && count(array_filter(request()->except('sort'))) > 0)
                       
            <a class="btn btn-sm btn-warning" href="{{route('customer.products')}}">حذف همه فیلترها</a>
            @endif
   
                        @if(request()->search)
                        <span class="d-inline-block border p-1 rounded bg-light">نتیجه جستجو برای : <span
                                class="badge bg-info text-dark">"{{request()->search}}"</span>
                                <a class="text-secondary" href="{{route('customer.products', ['search' => null, 'sort' => request()->sort, 'min_price' => request()->min_price, 'max_price' => request()->max_price, 'brands' => request()->brands,'category' => request()->category ? request()->category : null])}}" class="ms-1"><span class="fa fa-times"></span></a>
                            </span>
                                @endif
                         @if(request()->brands)       
                        <span class="d-inline-block border p-1 rounded bg-light">برند : <span
                                class="badge bg-info text-dark">"
                                @php
                                   
                                        $searchedBrands = [];
                                        foreach (request()->brands as $brand) {
                                            $searchedBrand = $brands->find($brand)->persian_name;
                                            array_push($searchedBrands, $searchedBrand);
                                        }
                                        $searchedBrands = implode("، ", array_values($searchedBrands));
                                    
                                @endphp
                          
                                @if (!empty($searchedBrands))
                                    {{$searchedBrands}}
                                @endif
                                "</span>
                                <a class="text-secondary" href="{{route('customer.products', ['search' => request()->search, 'sort' => request()->sort, 'min_price' => request()->min_price, 'max_price' => request()->max_price, 'brands' => null,'category' => request()->category ? request()->category : null])}}" class="ms-1"><span class="fa fa-times"></span></a>
                            </span>
                                @endif
                         @if(request()->category)       
                        <span class="d-inline-block border p-1 rounded bg-light">دسته : <span
                                class="badge bg-info text-dark">"{{request()->category ? request()->category->name : null}}"</span>
                                <a class="text-secondary" href="{{route('customer.products', ['search' => request()->search, 'sort' => request()->sort, 'min_price' => request()->min_price, 'max_price' => request()->max_price, 'brands' => request()->brands,'category' => null])}}" class="ms-1"><span class="fa fa-times"></span></a>
                            </span>
                                @endif
                        @if(request()->min_price)        
                        <span class="d-inline-block border p-1 rounded bg-light">قیمت از : <span
                                class="badge bg-info text-dark">{{priceFormat(request()->min_price)}}
                                تومان</span>
                                <a class="text-secondary" href="{{route('customer.products', ['search' => request()->search, 'sort' => request()->sort, 'min_price' => null, 'max_price' => request()->max_price, 'brands' => request()->brands,'category' => request()->category ? request()->category : null])}}" class="ms-1"><span class="fa fa-times"></span></a>
                            </span>
                                @endif
                                @if(request()->max_price)          
                        <span class="d-inline-block border p-1 rounded bg-light">قیمت تا : <span
                                class="badge bg-info text-dark">{{priceFormat(request()->max_price)}}
                                تومان</span>
                                <a class="text-secondary" href="{{route('customer.products', ['search' => request()->search, 'sort' => request()->sort, 'min_price' => request()->min_price, 'max_price' => null, 'brands' => request()->brands,'category' => request()->category ? request()->category : null])}}" class="ms-1"><span class="fa fa-times"></span></a>
                            </span>
                                        @endif
                    </section>
                    <section class="sort ">
                        <span>مرتب سازی بر اساس : </span>
                        <a class="btn {{request()->sort == 1 ? 'btn-info' : ''}} btn-sm px-1 py-0"
                            href="{{route('customer.products', ['search' => request()->search, 'sort' => '1', 'min_price' => request()->min_price, 'max_price' => request()->max_price, 'brands' => request()->brands,'category' => request()->category ? request()->category : null])}}">جدیدترین</a>
                        <!-- <a class="btn btn-light btn-sm px-1 py-0">محبوب ترین</a> -->
                        <a class="btn {{request()->sort == 2 ? 'btn-info' : ''}} btn-sm px-1 py-0"
                            href="{{route('customer.products', ['search' => request()->search, 'sort' => '2', 'min_price' => request()->min_price, 'max_price' => request()->max_price, 'brands' => request()->brands,'category' => request()->category ? request()->category : null])}}">گران
                            ترین</a>
                        <a class="btn {{request()->sort == 3 ? 'btn-info' : ''}} btn-sm px-1 py-0"
                            href="{{route('customer.products', ['search' => request()->search, 'sort' => '3', 'min_price' => request()->min_price, 'max_price' => request()->max_price, 'brands' => request()->brands,'category' => request()->category ? request()->category : null])}}">ارزان
                            ترین</a>
                        <a class="btn {{request()->sort == 4 ? 'btn-info' : ''}} btn-sm px-1 py-0"
                            href="{{route('customer.products', ['search' => request()->search, 'sort' => '4', 'min_price' => request()->min_price, 'max_price' => request()->max_price, 'brands' => request()->brands,'category' => request()->category ? request()->category : null])}}">پربازدیدترین</a>
                        <a class="btn {{request()->sort == 5 ? 'btn-info' : ''}} btn-sm px-1 py-0"
                            href="{{route('customer.products', ['search' => request()->search, 'sort' => '5', 'min_price' => request()->min_price, 'max_price' => request()->max_price, 'brands' => request()->brands,'category' => request()->category ? request()->category : null])}}">پرفروش
                            ترین</a>
                    </section>


                    <section class="main-product-wrapper row my-4">

                        @forelse ($products as $product)
                            <section class="col-md-3 p-0">
                                <section class="product">
                                    {{-- <section class="product-add-to-cart"><a href="#" data-bs-toggle="tooltip"
                                            data-bs-placement="left" title="افزودن به سبد خرید"><i
                                                class="fa fa-cart-plus"></i></a></section> --}}
                                    <section class="product-add-to-favorite"><a href="#" data-bs-toggle="tooltip"
                                            data-bs-placement="left" title="افزودن به علاقه مندی"><i
                                                class="fa fa-heart"></i></a></section>
                                    <a class="product-link" target="_blank" href="{{route('customer.market.product', $product)}}">
                                        <section class="product-image">
                                            <img class="" src="{{asset($product->image['indexArray']['medium'])}}"
                                                alt="{{$product->name}}">
                                        </section>
                                        <section class="product-colors"></section>
                                        <section class="product-name">
                                            <h3 class="text-center">{{$product->name}}</h3>
                                        </section>
                                        
                                        <section class="product-price-wrapper">
                                            @if($product->activeAmazingSale())
                                            <section class="product-discount d-flex">
                                                <span
                                                    class="product-old-price">{{priceFormat($product->price)}}
                                                    تومان</span>
                                                <span class="product-discount-amount">{{$product->activeAmazingSale()->percentage}}%</span>
                                            </section>
                                           
                                            <section class="product-price">{{priceFormat($product->price - $product->price * ($product->activeAmazingSale()->percentage / 100))}} تومان</section>
                                            @else
                                            <section class="product-price">{{priceFormat($product->price)}} تومان</section>

                                            @endif
                                        </section>
                                        @if ($product->colors->count() > 0)
                                            <section class="product-colors">
                                                @foreach ($product->colors as $color)
                                                    <section class="product-colors-item"
                                                        style="background-color: {{$color->color}};"></section>
                                                @endforeach
                                            </section>
                                        @endif

                                    </a>
                                </section>
                            </section>
                        @empty
                            <h2 class="text-danger text-center">محصولی یافت نشد</h2>
                        @endforelse

                        <div class="col-12">
                            <section class="my-4 d-flex justify-content-center">
                                <nav>
                                   {{$products->links('vendor.pagination.bootstrap-5')}}
                                </nav>
                            </section>
                                    </div>

                    </section>


                </section>
            </main>
        </section>
    </section>
</section>
<!-- end body -->


<section class="position-fixed p-4 flex-row-reverse d-none" id="toast"
    style="z-index:99999999;left:0;top:3rem;width:26rem;max-width:80%">
    <section class="toast bg-very-light" data-delay="7000" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header bg-very-light">
            <strong class="me-auto">آمازون</strong>
            <button type="button" class="btn btn-sm btn-dark btn-close" data-bs-dismiss="toast"
                aria-label="Close"></button>
        </div>
        <section class="toast-body py-3 d-flex text-dark">
            <strong class="ml-auto">
                جهت افزودن محصول به لیست علاقه مندی ها ابتدا وارد حساب کاربری خود شوید
                <br>
                <a class="text-dark btn btn-sm btn-primary float-end"
                    href="{{route('auth.customer.login-register-form')}}">
                    ثبت نام / ورود
                </a>
            </strong>
        </section>
    </section>
</section>
@endsection
@section('scripts')
<script>
    $('.favor-product button').click(function () {

        var url = $(this).attr('data-url');
        var element = $(this).children('i');

        $.ajax({
            url: url,
            context: $(this),
            success: function (result) {
                if (result.status == 1) {
                    element.addClass('text-danger');
                    $(this).attr('data-original-title', 'حذف از لیست علاقه مندی ها');
                    $(this).attr('data-bs-original-title', 'حذف از لیست علاقه مندی ها');

                }
                else if (result.status == 2) {
                    element.removeClass('text-danger');
                    $(this).attr('data-original-title', 'افزودن به علاقه مندی ها');
                    $(this).attr('data-bs-original-title', 'افزودن به علاقه مندی ها');

                }
                else if (result.status == 3) {
                    $('#toast').removeClass('d-none');
                    $('.toast').toast('show');
                }
            }
        })
    })
</script>
@endsection