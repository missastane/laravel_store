@extends('customer.layouts.master-two-cols')
@section('head-tag')
<title>{{$product->name}}</title>

<style>
    /* @import url(//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css); */

    /* Styling h1 and links
––––––––––––––––––––––––––––––––– */
    .starrating>input {
        display: none;
    }

    /* Remove radio buttons */

    .starrating>label:before {
        /* content: "\f005"; */
        /* Star */
        margin: 2px;
        font-size: 2em;
        font-family: FontAwesome;
        display: inline-block;
    }

    .starrating>label {
        color: #222222;
        /* Start color when not clicked */
    }

    .starrating>input:checked~label {
        color: #ffca08;
    }

    /* Set yellow color when star checked */

    .starrating>input:hover~label {
        color: #ffca08;
    }

    /* Set yellow color when star hover */
</style>
@endsection

@section('content')
<!-- start cart -->
<section class="mb-4">
    <section class="container-xxl">
        <section class="row">
            <section class="col">
                <!-- start vontent header -->
                <section class="content-header">
                    <section class="d-flex justify-content-between align-items-center">
                        <h2 class="content-header-title">
                            <span>{{$product->name}}</span>
                        </h2>
                        <section class="content-header-link">
                            <!--<a href="#">مشاهده همه</a>-->
                        </section>
                    </section>
                </section>

                <section class="row mt-4">
                    <!-- start image gallery -->
                    <section class="col-md-4">
                        <section class="content-wrapper bg-white p-3 rounded-2 mb-4">
                            <section class="product-gallery">
                                
                                @php
                                    $gllaeries = $product->images()->get();
                                    $images = collect();
                                    $images->push($product);
                                    foreach ($gllaeries as $image) {
                                        $images->push($image);
                                    }


                                @endphp
                                <section class="product-gallery-selected-image mb-3">
                                    <img src="{{asset($images->first()->image['indexArray']['medium'])}}"
                                        alt="{{$product->name}}">
                                </section>
                                <section class="product-gallery-thumbs">
                                    @if (count($images->toArray()) != 0)

                                        @foreach ($images as $key => $image)

                                            <img class="product-gallery-thumb"
                                                src="{{asset($image->image['indexArray']['small'])}}" alt="{{$image->name}}"
                                                data-input="{{asset($image->image['indexArray']['medium'])}}">
                                        @endforeach

                                    @endif
                                </section>
                            </section>
                        </section>
                    </section>
                    <!-- end image gallery -->

                    <!-- start product info -->
                    <section class="col-md-5">

                        <section class="content-wrapper bg-white p-3 rounded-2 mb-4">

                            <!-- start vontent header -->
                            <section class="content-header mb-3">
                                <section class="d-flex justify-content-between align-items-center">
                                    <h2 class="content-header-title content-header-title-small">
                                        {{$product->name}}
                                    </h2>
                                    <section class="content-header-link">
                                        <!--<a href="#">مشاهده همه</a>-->
                                    </section>
                                </section>
                            </section>

                            <section class="product-info">
                                <form id="add-to-cart"
                                    action="{{route('customer.sales-process.add-to-cart', $product)}}" method="post"
                                    class="product-info">
                                    @php
                                        $colors = $product->colors()->get();
                                    @endphp
                                    @csrf
                                    @if (count($colors) != 0)
                                        <p><span>رنگ انتخاب شده : <span
                                                    id="selected_color_name">{{$colors->first()->color_name}}</span></span>
                                        </p>
                                        <p>
                                            @foreach ($colors as $key => $color)
                                                @if ($color->marketable_number > 0)
                                                    <label for="{{'color_' . $color->id}}"
                                                        style="background-color: {{$color->color ?? '#ffffff'}}; font-size:large;text-align:center;color:white"
                                                        class="product-info-colors me-1" data-bs-toggle="tooltip"
                                                        data-bs-placement="bottom" title="{{$color->color_name}}"></label>
                                                    <input class="d-none" value="{{$color->id}}" type="radio" name="color"
                                                        id="{{'color_' . $color->id}}" data-color-name="{{$color->color_name}}"
                                                        data-color-price="{{$color->price_increase}}" @if ($key == 0) checked @endif>
                                                @endif

                                            @endforeach
                                        </p>
                                    @endif
                                    @php
                                        $guarantees = $product->guarantees()->get();
                                    @endphp
                                    @if (count($guarantees) != 0)
                                        <p class="d-flex justify-content-start align-items-center">
                                            <label for="guarantee"><i
                                                    class="fa fa-shield-alt cart-product-selected-warranty me-1"></i>
                                                گارانتی : </label>
                                            <select class="form-control form-control-sm w-50 my-2 ms-1" name="guarantee"
                                                id="guarantee">
                                                @foreach ($guarantees as $key => $guarantee)

                                                    <option class="text-center" data-guarantee-name="{{$guarantee->name}}"
                                                        data-guarantee-price="{{$guarantee->price_increase}}"
                                                        value="{{$guarantee->id}}" @if ($key == 0) selected @endif>
                                                        {{$guarantee->name}}
                                                    </option>

                                                @endforeach
                                            </select>
                                        </p>
                                    @endif
                                    <p>
                                        @if ($product->marketable_number > 0)
                                            <i class="fa fa-store-alt cart-product-selected-store me-1"></i> <span>کالا
                                                موجود در
                                                انبار</span>
                                        @else
                                            <i class="fa fa-store-alt cart-product-selected-store me-1"></i>
                                            <span>ناموجود</span>
                                        @endif
                                    </p>
                                    <div>
                                    @guest
                                        <p class="favor-product"><button
                                                data-url="{{route('customer.market.add-to-favorite', $product->id)}}"
                                                class="btn btn-light btn-sm text-decoration-none">
                                                <i class="fa fa-heart me-1"></i>
                                                <span class="product-title">افزودن به علاقه مندی</span>
                                            </button>
                                        </p>
                                    @endguest
                                    @auth
                                        @if ($product->users->contains(auth()->user()->id))
                                            <p class="favor-product"><button
                                                    data-url="{{route('customer.market.add-to-favorite', $product->id)}}"
                                                    class="btn btn-light btn-sm text-decoration-none">
                                                    <i class="fa fa-heart me-1 text-danger"></i>
                                                    <span class="product-title">حذف از لیست علاقه مندی ها</span>
                                                </button>
                                            </p>
                                        @else
                                            <p class="favor-product"><button
                                                    data-url="{{route('customer.market.add-to-favorite', $product->id)}}"
                                                    class="btn btn-light btn-sm text-decoration-none">
                                                    <i class="fa fa-heart me-1"></i>
                                                    <span class="product-title">افزودن به علاقه مندی</span>
                                                </button>
                                            </p>
                                        @endif
                                    @endauth

                                    
                                        <p class="compare-product"><a href="{{route('customer.market.compare', $product)}}" target="_blank"
                                                class="btn btn-light btn-sm text-decoration-none">
                                                <i class="fa fa-industry me-1"></i>
                                                <span class="product-title">افزودن به لیست مقایسه</span>
                                            </a>
                                        </p>
                                  
                                
                                    </div>
                                    <section>
                                        <section class="cart-product-number d-inline-block ">
                                            <button class="cart-number cart-number-down" type="button">-</button>
                                            <input id="number" name="number" type="number" min="1"
                                                max="{{$product->marketable_number}}" step="1" value="1"
                                                readonly="readonly">
                                            <button class="cart-number cart-number-up" type="button">+</button>
                                        </section>
                                    </section>
                                    <p class="mb-3 mt-5">
                                        <i class="fa fa-info-circle me-1"></i>کاربر گرامی خرید شما هنوز نهایی نشده است.
                                        برای
                                        ثبت سفارش و تکمیل خرید باید ابتدا آدرس خود را انتخاب کنید و سپس نحوه ارسال را
                                        انتخاب
                                        کنید. نحوه ارسال انتخابی شما محاسبه و به این مبلغ اضافه شده خواهد شد. و در نهایت
                                        پرداخت این سفارش صورت میگیرد. پس از ثبت سفارش کالا بر اساس نحوه ارسال که شما
                                        انتخاب
                                        کرده اید کالا برای شما در مدت زمان مذکور ارسال می گردد.
                                    </p>
                            </section>
                        </section>

                    </section>
                    <!-- end product info -->

                    <section class="col-md-3">
                        <section class="content-wrapper bg-white p-3 rounded-2 cart-total-price">
                            <section class="d-flex justify-content-between align-items-center">
                                <p class="text-muted">قیمت کالا</p>
                                <p class="text-muted"><span id="product_price"
                                        data-product-original-price="{{$product->price}}"></span><span class="small">
                                        تومان</span>
                                </p>
                            </section>
                            @php
                                $amazingSales = $product->activeAmazingSale();
                            @endphp
                            @if (!empty($amazingSales))
                                <section class="d-flex justify-content-between align-items-center">
                                    <p class="text-muted">تخفیف کالا</p>
                                    <p class="text-danger fw-bolder">
                                        <span id="product_discount_price"
                                            data-product-discount-price="{{$product->price * ($amazingSales->percentage / 100)}}">
                                            {{priceFormat($product->price * ($amazingSales->percentage / 100))}}
                                        </span>
                                        <span class="small"> تومان</span>
                                    </p>
                                </section>



                                <section class="border-bottom mb-3"></section>

                                <section class="d-flex justify-content-between align-items-center">
                                    <p class="text-muted">قیمت نهایی با تخفیف</p>
                                    <p class="fw-bolder"><span id="final_price"></span>
                                        <span class="small"> تومان</span>
                                    </p>
                                </section>
                            @endif
                            @if ($product->marketable_number > 0)
                                <section class="">
                                    <button onclick="document.getElementById('add-to-cart').submit()" id="next-level"
                                        class="btn btn-danger d-block w-100">افزودن به سبد خرید</button>
                                </section>

                            @else
                                <section class="">
                                    <button id="next-level" href="#" class="btn btn-secondary w-100 d-block">محصول نامجود
                                        است</button>
                                </section>
                            @endif
                            </form>
                        </section>
                    </section>
                </section>
            </section>
        </section>

    </section>
</section>
<!-- end cart -->



<!-- start product lazy load -->
<section class="mb-4">
    <section class="container-xxl">
        <section class="row">
            <section class="col">
                <section class="content-wrapper bg-white p-3 rounded-2">
                    <!-- start vontent header -->
                    <section class="content-header">
                        <section class="d-flex justify-content-between align-items-center">
                            <h2 class="content-header-title">
                                <span>کالاهای مرتبط</span>
                            </h2>
                            <section class="content-header-link">
                                <!--<a href="#">مشاهده همه</a>-->
                            </section>
                        </section>
                    </section>
                    <!-- start vontent header -->
                    <section class="lazyload-wrapper">
                        <section class="lazyload light-owl-nav owl-carousel owl-theme">
                            @forelse ($relatedProducts as $relatedProduct)
                                                        @php
                                                            $relatedProductColors = $relatedProduct->colors()->get();
                                                        @endphp

                                                        <section class="item">
                                                            <section class="lazyload-item-wrapper">
                                                                <section class="product">
                                                                    <!-- <section class="product-add-to-cart"><a href="#" data-bs-toggle="tooltip"
                                                                                                        data-bs-placement="left" title="افزودن به سبد خرید"><i
                                                                                                            class="fa fa-cart-plus"></i></a></section> -->
                                                                    @guest
                                                                        <section class="product-add-to-favorite favor-product">
                                                                            <button
                                                                                data-url="{{route('customer.market.add-to-favorite', $relatedProduct->id)}}"
                                                                                class="btn btn-sm btn-light" data-bs-toggle="tooltip"
                                                                                data-bs-placement="left" title="افزودن به علاقه مندی">
                                                                                <i class="fa fa-heart"></i>
                                                                            </button>
                                                                        </section>
                                                                    @endguest
                                                                    @auth
                                                                        @if ($relatedProduct->users->contains(auth()->user()->id))
                                                                            <section class="product-add-to-favorite favor-product">
                                                                                <button
                                                                                    data-url="{{route('customer.market.add-to-favorite', $relatedProduct->id)}}"
                                                                                    class="btn btn-sm btn-light" data-bs-toggle="tooltip"
                                                                                    data-bs-placement="left" title="حذف از لیست علاقه مندی ها">
                                                                                    <i class="fa fa-heart text-danger"></i>
                                                                                </button>
                                                                            </section>
                                                                        @else
                                                                            <section class="product-add-to-favorite favor-product">
                                                                                <button
                                                                                    data-url="{{route('customer.market.add-to-favorite', $relatedProduct->id)}}"
                                                                                    class="btn btn-sm btn-light" data-bs-toggle="tooltip"
                                                                                    data-bs-placement="left" title="افزودن به علاقه مندی">
                                                                                    <i class="fa fa-heart"></i>
                                                                                </button>
                                                                            </section>
                                                                        @endif
                                                                    @endauth
                                                                    <a class="product-link"
                                                                        href="{{route('customer.market.product', $relatedProduct)}}">
                                                                        <section class="product-image">
                                                                            <img class=""
                                                                                src="{{asset($relatedProduct->image['indexArray']['medium'])}}"
                                                                                alt="">
                                                                        </section>
                                                                        <section class="product-name">
                                                                            <h3>{{$relatedProduct->name}}</h3>
                                                                        </section>
                                                                        <section class="product-price-wrapper">
                                                                            <section class="product-price">{{priceFormat($relatedProduct->price)}}
                                                                                تومان
                                                                            </section>
                                                                        </section>
                                                                        @if (count($relatedProductColors) != 0)
                                                                            <section class="product-colors">
                                                                                @foreach ($relatedProductColors as $relatedProductColor)
                                                                                    <section class="product-colors-item"
                                                                                        style="background-color: {{$relatedProductColor->color}};">
                                                                                    </section>
                                                                                @endforeach
                                                                            </section>
                                                                        @endif
                                                                    </a>
                                                                </section>
                                                            </section>
                                                        </section>
                                                        @empty
                                                        <p>محصولی یافت نشد</p>
                            @endforelse
                        </section>
                    </section>
                </section>
            </section>
        </section>
    </section>
</section>
<!-- end product lazy load -->

<!-- start description, features and comments -->
<section class="mb-4">
    <section class="container-xxl">
        <section class="row">
            <section class="col">
                <section class="content-wrapper bg-white p-3 rounded-2">
                    <!-- start content header -->
                    <section id="introduction-features-comments" class="introduction-features-comments">
                        <section class="content-header">
                            <section class="d-flex justify-content-between align-items-center">
                                <h2 class="content-header-title">
                                    <span class="me-2"><a class="text-decoration-none text-dark"
                                            href="#introduction">معرفی</a></span>
                                    <span class="me-2"><a class="text-decoration-none text-dark" href="#features">ویژگی
                                            ها</a></span>
                                    <span class="me-2"><a class="text-decoration-none text-dark" href="#comments">دیدگاه
                                            ها</a></span>
                                    <span class="me-2"><a class="text-decoration-none text-dark" href="#rating">
                                            امتیاز ها</a></span>
                                </h2>
                                <section class="content-header-link">
                                    <!--<a href="#">مشاهده همه</a>-->
                                </section>
                            </section>
                        </section>
                    </section>
                    <!-- start content header -->

                    <section class="py-4">

                        <!-- start vontent header -->
                        <section id="introduction" class="content-header mt-2 mb-4">
                            <section class="d-flex justify-content-between align-items-center">
                                <h2 class="content-header-title content-header-title-small">
                                    معرفی
                                </h2>
                                <section class="content-header-link">
                                    <!--<a href="#">مشاهده همه</a>-->
                                </section>
                            </section>
                        </section>
                        <section class="product-introduction mb-4">
                            {!! $product->introduction !!}
                        </section>

                        <!-- start vontent header -->
                        <section id="features" class="content-header mt-2 mb-4">
                            <section class="d-flex justify-content-between align-items-center">
                                <h2 class="content-header-title content-header-title-small">
                                    ویژگی ها
                                </h2>
                                <section class="content-header-link">
                                    <!--<a href="#">مشاهده همه</a>-->
                                </section>
                            </section>
                        </section>
                        <section class="product-features mb-4 table-responsive">
                            <table class="table table-bordered border-white">
                                @if (count($category_attr_details_group) > 0)

                                    @foreach ($category_attr_details_group as $key => $group)

                                        <tr>

                                            <td>{{$key}}</td>
                                            <td>
                                                {{$group}}

                                            </td>


                                        </tr>
                                    @endforeach
                                @endif
                                @if (count($product->metas) > 0)
                                    @foreach ($product->metas as $meta)
                                        <tr>
                                            <td>{{$meta->meta_key}}</td>
                                            <td>{{$meta->meta_value}}</td>
                                        </tr>
                                    @endforeach
                                @endif
                            </table>
                        </section>

                        <!-- start vontent header -->
                        <section id="comments" class="content-header mt-2 mb-4">
                            <section class="d-flex justify-content-between align-items-center">
                                <h2 class="content-header-title content-header-title-small">
                                    دیدگاه ها
                                </h2>
                                <section class="content-header-link">
                                    <!--<a href="#">مشاهده همه</a>-->
                                </section>
                            </section>
                        </section>
                        <section class="product-comments mb-4">

                            <section class="comment-add-wrapper">
                                <button class="comment-add-button" type="button" data-bs-toggle="modal"
                                    data-bs-target="#add-comment"><i class="fa fa-plus"></i> افزودن دیدگاه</button>
                                <!-- start add comment Modal -->
                                <section class="modal fade" id="add-comment" tabindex="-1"
                                    aria-labelledby="add-comment-label" aria-hidden="true">
                                    <section class="modal-dialog">
                                        <section class="modal-content">
                                            <section class="modal-header">
                                                <h5 class="modal-title" id="add-comment-label"><i
                                                        class="fa fa-plus"></i> افزودن دیدگاه</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </section>
                                            @guest
                                                <section class="modal-body">
                                                    <p class="text-danger">
                                                        کاربر گرامی لطفا برای ثبت نظر ابتدا وارد حساب کاربری خود شوید
                                                    </p>
                                                </section>
                                            @endguest
                                            @auth
                                                <section class="modal-body">
                                                    <form class="row"
                                                        action="{{route('customer.market.add-comment', $product)}}"
                                                        method="post">
                                                        @csrf
                                                        <!-- <section class="col-6 mb-2">
                                                                                    <label for="first_name" class="form-label mb-1">نام</label>
                                                                                    <input type="text" class="form-control form-control-sm"
                                                                                        id="first_name" placeholder="نام ...">
                                                                                </section>

                                                                                <section class="col-6 mb-2">
                                                                                    <label for="last_name" class="form-label mb-1">نام
                                                                                        خانوادگی</label>
                                                                                    <input type="text" class="form-control form-control-sm"
                                                                                        id="last_name" placeholder="نام خانوادگی ...">
                                                                                </section> -->

                                                        <section class="col-12 mb-2">
                                                            <label for="body" class="form-label mb-1 py-2">دیدگاه
                                                                شما</label>
                                                            <textarea class="form-control form-control-sm" id="body"
                                                                placeholder="دیدگاه شما ..." rows="4"
                                                                name="body">{{old('body')}}</textarea>
                                                            @error('body')
                                                                <span class="alert_required text-danger"
                                                                    role="alert"><strong>{{$message}}</strong></span>
                                                            @enderror
                                                        </section>


                                                </section>
                                            @endauth
                                            <section class="modal-footer py-1">
                                                @guest
                                                    <a href="{{route('auth.customer.login-register-form')}}"
                                                        class="btn btn-sm btn-primary">ورود یا ثبت نام</a>
                                                @endguest
                                                @auth
                                                <button type="submit" class="btn btn-sm btn-primary">ثبت دیدگاه</button>
                                                @endAuth
                                                </form>
                                                <button type="button" class="btn btn-sm btn-danger"
                                                    data-bs-dismiss="modal">بستن</button>
                                            </section>
                                        </section>
                                    </section>
                                </section>
                            </section>

                            @foreach ($product->activeComments() as $activeComment)
                                <section class="product-comment">
                                    <section class="product-comment-header d-flex justify-content-start">
                                        <section class="product-comment-date">{{jalalidate($activeComment->created_at)}}
                                        </section>
                                        <section class="product-comment-title">
                                            @if (empty($activeComment->user->first_name) && empty($activeComment->user->last_name))
                                                'ناشناس'
                                            @else
                                                {{$activeComment->user->fullName}}
                                            @endif
                                        </section>
                                    </section>
                                    <section
                                        class="product-comment-body @if ($activeComment->children()->count() > 0) border-bottom p-2  @endif">
                                        {!!$activeComment->body!!}
                                    </section>
                                    @foreach ($activeComment->children()->get() as $answer)
                                        <section class="row">
                                            <section
                                                class="col-md-1 col-2 text-center d-flex align-items-center justify-content-center">
                                                <i class="fa fa-reply text-secondary"></i>
                                            </section>
                                            <section class="product-comment col-md-10 col-9">
                                                <section class="product-comment-header d-flex justify-content-start">
                                                    <section class="product-comment-date">{{jalalidate($answer->created_at)}}
                                                    </section>
                                                    <section class="product-comment-title">
                                                        @if (empty($answer->user->first_name) && empty($answer->user->last_name))
                                                            'ناشناس'
                                                        @else
                                                            {{$answer->user->fullName}}
                                                        @endif
                                                    </section>
                                                </section>
                                                <section class="product-comment-body">
                                                    {!!$answer->body!!}
                                                </section>
                                            </section>
                                        </section>
                                    @endforeach
                                </section>
                            @endforeach





                        </section>

                           <!-- start rating -->
                              <section id="rating" class="content-header mt-2 mb-4">
                            <section class="d-flex justify-content-between align-items-center">
                                <h2 class="content-header-title content-header-title-small">
                                    امتیاز ها
                                </h2>
                                <section class="content-header-link">
                                    <!--<a href="#">مشاهده همه</a>-->
                                </section>
                            </section>
                        </section>
                        @auth

                        <section class="product-rating mb-4">

                            <div class="container">
                                <h6 class="text-danger">
                                    شما هم به این محصول امتیاز دهید :
                                </h6>
                                <form
                                    class="starrating risingstar d-flex justify-content-end flex-row-reverse align-items-center"
                                    action="{{ route('customer.market.add-rate', $product) }}" method="post">
                                    @csrf
                                    <div class="mx-3">
                                        <button class="btn btn-info btn-sm">ثبت امتیاز</button>
                                    </div>
                                    <input type="radio" id="star5" name="rating" value="5" />
                                    <label for="star5" title="5 star"><span class="fa fa-star fa-2x"></span></label>
                                    <input type="radio" id="star4" name="rating" value="4" />
                                    <label for="star4" title="4 star"><span class="fa fa-star fa-2x"></span></label>
                                    <input type="radio" id="star3" name="rating" value="3" />
                                    <label for="star3" title="3 star"><span class="fa fa-star fa-2x"></span></label>
                                    <input type="radio" id="star2" name="rating" value="2" />
                                    <label for="star2" title="2 star"><span class="fa fa-star fa-2x"></span></label>
                                    <input type="radio" id="star1" name="rating" value="1" />
                                    <label for="star1" title="1 star"><span class="fa fa-star fa-2x"></span></label>

                                </form>
                                <h6>
                                    میانگین امتیاز : {{ number_format($product->ratingsAvg(), 1, '/') ?? 'شما اولین
                                    امتیاز را ثبت نمایید!!!' }}
                                </h6>
                                
                            </div>

                        </section>
                        @endauth
                        @guest
                        <section>
                            <p>کاربر گرامی لطفا برای ثبت نظر ابتدا وارد حساب کاربری خود شوید </p>
                            <p>لینک ثبت نام و یا ورود
                                <a href="{{ route('auth.customer.login-register-form') }}">کلیک
                                    کنید</a>
                            </p>
                        </section>
                        @endguest   
                    </section>

                </section>
            </section>
        </section>
    </section>
</section>
<!-- end description, features and comments -->
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
    $(document).ready(function () {
        $('input[name="color"]:checked').prev().html('&#10004;');
        $('#guarantee option:selected').prepend('&#9989; ');
        updatePrice()
        // change color
        $('input[name="color"]').change(function () {
            $('input[name="color"]:checked').prev().html('&#10004;');
            $('input[type="radio"]:not(:checked)').prev().html('')
            updatePrice()
        });

        // change guarantee
        $('select[name="guarantee"]').change(function () {
            $('#guarantee option:selected').prepend('&#9989; ');
            $('#guarantee option:not(:selected)').each(function () {
                var text = $(this).text();
                if (text.indexOf('✅') != -1) {
                    $(this).html($(this).attr('data-guarantee-name'));
                }
            });

            updatePrice()

        });

        // change count
        $('.cart-number').click(function () {
            updatePrice()

        });

      

    });
    function updatePrice() {

        bill();
        traverse(document.body);
    }

    function bill() {
        if ($('input[name="color"]:checked').length > 0) {
            var selected_color = $('input[name="color"]:checked');
            $('#selected_color_name').html(selected_color.attr('data-color-name'));
        }
        // price computing
        var selected_color_price = 0;
        var selected_guarantee_price = 0;
        var number = 1;
        var product_discount_price = 0;
        var product_original_price = parseFloat($('#product_price').attr('data-product-original-price'));


        if ($('input[name="color"]:checked').length > 0) {
            selected_color_price = parseFloat(selected_color.attr('data-color-price'));
        }

        if ($('#guarantee option:selected').length > 0) {
            selected_guarantee_price = parseFloat($('#guarantee option:selected').attr('data-guarantee-price'));
        }

        if ($('#number').val() > 0) {
            number = parseFloat($('#number').val());
        }

        if ($('#product_discount_price').attr('data-product-discount-price') > 0) {
            product_discount_price = parseFloat($('#product_discount_price').attr('data-product-discount-price'));
        }

        // final price
        var product_price = product_original_price + selected_color_price + selected_guarantee_price;
        var final_price = number * (product_price - product_discount_price);
        $('#product_price').html(product_price.toLocaleString(undefined, { minimumFractionDigits: 2 }));

        $('#final_price').html(final_price.toLocaleString(undefined, { minimumFractionDigits: 2 }));
    }
</script>
<script>
    $('.favor-product button').click(function (event) {
        event.preventDefault();
        var url = $(this).attr('data-url');
        var element = $(this).children('i');

        $.ajax({
            url: url,
            context: $(this),
            success: function (result) {
                if (result.status == 1) {
                    element.addClass('text-danger');
                    $(this).find('.product-title').html('حذف از لیست علاقه مندی ها');
                    $(this).attr('data-original-title', 'حذف از لیست علاقه مندی ها');
                    $(this).attr('data-bs-original-title', 'حذف از لیست علاقه مندی ها');

                }
                else if (result.status == 2) {
                    element.removeClass('text-danger');
                    $(this).find('.product-title').html('افزودن به علاقه مندی');
                    $(this).attr('data-original-title', 'افزودن به علاقه مندی');
                    $(this).attr('data-bs-original-title', 'افزودن به علاقه مندی');

                }
                else if (result.status == 3) {
                    $('#toast').removeClass('d-none');
                    $('.toast').toast('show');
                }
            }
        })
    })
</script>
<script>
    $('.compare-product button').click(function (event) {
        event.preventDefault();
        var url = $(this).attr('data-url');
        var element = $(this).children('i');

        $.ajax({
            url: url,
            context: $(this),
            success: function (result) {
                if (result.status == 1) {
                    element.addClass('text-primary');
                    $(this).find('.product-title').html('حذف از لیست مقایسه');
                    $(this).attr('data-original-title', 'حذف از لیست مقایسه');
                    $(this).attr('data-bs-original-title', 'حذف از لیست مقایسه');

                }
                else if (result.status == 2) {
                    element.removeClass('text-primary');
                    $(this).find('.product-title').html('افزودن به لیست مقایسه');
                    $(this).attr('data-original-title', 'افزودن به لیست مقایسه');
                    $(this).attr('data-bs-original-title', 'افزودن به لیست مقایسه');

                }
                else if (result.status == 3) {
                    $('#toast').removeClass('d-none');
                    $('.toast').toast('show');
                }
            }
        })
    })
</script>
<script>
    //start product introduction, features and comment
    $(document).ready(function () {
        var s = $("#introduction-features-comments");
        var pos = s.position();
        $(window).scroll(function () {
            var windowpos = $(window).scrollTop();

            if (windowpos >= pos.top) {
                s.addClass("stick");
            } else {
                s.removeClass("stick");
            }
        });
    });
    //end product introduction, features and comment

</script>
@endsection