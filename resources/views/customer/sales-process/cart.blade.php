@extends('customer.layouts.master-two-cols')
@section('head-tag')
<title>سبد خرید</title>
@endsection

@section('content')
<section class="mb-4">
    <section class="container-xxl">
        <section class="row">
            <section class="col">
                <!-- start vontent header -->
                <section class="content-header">
                    <section class="d-flex justify-content-between align-items-center">
                        <h2 class="content-header-title">
                            <span>سبد خرید شما</span>
                        </h2>
                        <section class="content-header-link">
                            <!--<a href="#">مشاهده همه</a>-->
                        </section>
                    </section>
                </section>

                <section class="row mt-4">
                    
                    <section class="col-md-9 mb-3">
                        @if (count($cartItems) > 0)
                        <form class="content-wrapper bg-white p-3 rounded-2" method="post" action="{{route('customer.sales-process.update-cart')}}" id="cart_items">
                            @csrf
                            @php
                                $totalProductPrice = 0;
                                $totalDiscount = 0;
                            @endphp
                            @foreach ($cartItems as $cartItem)
                                                        @php
                                                            $totalProductPrice += ($cartItem->cartItemProductprice() * $cartItem->number);
                                                            $totalDiscount += ($cartItem->cartItemProductDiscount() * $cartItem->number);
                                                        @endphp
                                                        <section class="cart-item d-md-flex py-3">
                                                            <section class="cart-img align-self-start flex-shrink-1"><img
                                                                    src="{{asset($cartItem->product->image['indexArray'][$cartItem->product->image['currentImage']])}}"
                                                                    alt=""></section>
                                                            <section class="align-self-start w-100">
                                                                <p class="fw-bold">{{$cartItem->product->name}}</p>
                                                                <p>@if (!empty($cartItem->color))
                                                                    <span style="background-color: {{$cartItem->color->color}};"
                                                                        class="cart-product-selected-color me-1"></span>{{$cartItem->color->color_name}}<span></span>
                                                                @else
                                                                    <span>محصول تک رنگ</span>
                                                                @endif

                                                                </p>
                                                                <p>@if (!empty($cartItem->guarantee))
                                                                    <i class="fa fa-shield-alt cart-product-selected-warranty me-1"></i> <span>
                                                                        {{$cartItem->guarantee->name}}</span>
                                                                @else
                                                                    <i class="fa fa-shield-alt cart-product-selected-warranty me-1"></i> <span>
                                                                        گارانتی اصالت و سلامت فیزیکی کالا</span>
                                                                @endif

                                                                </p>
                                                                <p><i class="fa fa-store-alt cart-product-selected-store me-1"></i> <span>کالا
                                                                        موجود در انبار</span></p>
                                                                <section>
                                                                    <section class="cart-product-number d-inline-block ">
                                                                        <button class="cart-number-down cart-number" type="button">-</button>
                                                                        <input class="number"
                                                                            data-product-price="{{$cartItem->cartItemProductprice()}}"
                                                                            data-product-discount="{{$cartItem->cartItemProductDiscount()}}"
                                                                            type="number" min="1" max="5" step="1" name="number[{{$cartItem->id}}]" value="{{$cartItem->number}}"
                                                                            readonly="readonly">

                                                                        <button class="cart-number-up cart-number" type="button">+</button>
                                                                    </section>
                                                                    <a class="text-decoration-none ms-4 cart-delete" href="{{route('customer.sales-process.remove-from-cart', $cartItem->id)}}"><i
                                                                            class="fa fa-trash-alt"></i> حذف از سبد</a>
                                                                </section>
                                                            </section>
                                                            <section class="align-self-end flex-shrink-1">
                                                                @if (!empty($cartItem->product->activeAmazingSale()))
                                                                    <section class="cart-item-discount text-danger text-center text-nowrap mb-1">تخفیف :
                                                                        {{priceFormat($cartItem->cartItemProductDiscount())}} تومان
                                                                        </section>
                                                                        @endif
                                                                

                                                                <section class="text-nowrap fw-bold text-center">
                                                                    {{priceFormat($cartItem->cartItemProductprice())}} تومان
                                                                </section>
                                                            </section>
                                                        </section>

                            @endforeach
                        </form>
  
                       

                    
                   
                </section>
                <section class="col-md-3">
                        <section class="content-wrapper bg-white p-3 rounded-2 cart-total-price">
                            <section class="d-flex justify-content-between align-items-center">
                                <p class="text-muted">قیمت کالاها ({{$cartItems->count()}})</p>
                                <p class="text-muted"><span id="total_product_price">{{priceFormat($totalProductPrice)}}</span> تومان
                                </p>
                            </section>

                            <section class="d-flex justify-content-between align-items-center">
                                <p class="text-muted">تخفیف کالاها</p>
                                <p class="text-danger fw-bolder"><span id="total_discount">{{priceFormat($totalDiscount)}}</span>
                                    تومان</p>
                            </section>
                            <section class="border-bottom mb-3"></section>
                            <section class="d-flex justify-content-between align-items-center">
                                <p class="text-muted">جمع سبد خرید</p>
                                <p class="fw-bolder">
                                    <span id="total_price">{{priceFormat($totalProductPrice - $totalDiscount)}}</span> تومان
                                </p>
                            </section>

                            <p class="my-3">
                                <i class="fa fa-info-circle me-1"></i>کاربر گرامی خرید شما هنوز نهایی نشده است. برای ثبت
                                سفارش و تکمیل خرید باید ابتدا آدرس خود را انتخاب کنید و سپس نحوه ارسال را انتخاب کنید.
                                نحوه ارسال انتخابی شما محاسبه و به این مبلغ اضافه شده خواهد شد. و در نهایت پرداخت این
                                سفارش صورت میگیرد.
                            </p>


                            <section class="">
                                <a onclick="document.getElementById('cart_items').submit()" class="btn btn-danger d-block">تکمیل فرآیند خرید</a>
                            </section>

                        </section>
                    </section>
                    @else
<section class="content-wrapper bg-white p-3 rounded-2">
    <p class="text-danger text-center">
        سبد خرید شما خالی است
    </p>
</section>
                        @endif
            </section>
        </section>

    </section>
</section>
<!-- end cart -->



@if (count($cartItems) > 0)
<section class="mb-4 mt-2">
    <section class="container-xxl">
        <section class="row">
            <section class="col">
                <section class="content-wrapper bg-white p-3 rounded-2">
                    <!-- start vontent header -->
                
                    <section class="content-header">
                        <section class="d-flex justify-content-between align-items-center">
                            <h2 class="content-header-title">
                                <span>کالاهای مرتبط با سبد خرید شما</span>
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
                                                                            <h3 class="text-center">{{$relatedProduct->name}}</h3>
                                                                        </section>
                                                                        <section class="product-price-wrapper">
                                                                            <section class="product-price text-center">{{priceFormat($relatedProduct->price)}} تومان
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
@endif
</section>
@endsection
@section('scripts')
<script>
    $(function () {
        // bill();
        // traverse(document.body);
        $('.cart-number').click(function () {
            bill();
            traverse(document.body);
        });


    });
    function priceFormat(price) {
        price = Intl.NumberFormat().format(price);
    }
    function bill() {
        var total_product_price = 0;
        var total_discount = 0;
        var total_price = 0;

        $('.number').each(function () {
            var productPrice = parseFloat($(this).attr('data-product-price'));
            var productDiscount = parseFloat($(this).attr('data-product-discount'));
            var number = parseFloat($(this).val());

            total_product_price += productPrice * number;
            total_discount += productDiscount * number;
        })

        total_price = total_product_price - total_discount;
        $('#total_product_price').html(total_product_price.toLocaleString(undefined, { minimumFractionDigits: 2 }));
        $('#total_discount').html(total_discount.toLocaleString(undefined, { minimumFractionDigits: 2 }));
        $('#total_price').html(total_price.toLocaleString(undefined, { minimumFractionDigits: 2 }));
    }
</script>
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
@endsection