<header class="header mb-4">


    <!-- start top-header logo, searchbox and cart -->
    <section class="top-header">
        <section class="container-xxl ">
            <section class="d-md-flex justify-content-md-between align-items-md-center py-3">

                <section class="d-flex justify-content-between align-items-center d-md-block">
                    <a class="text-decoration-none" href="{{route('customer.home')}}"><img src="{{asset('customer-assets/images/logo/8.png')}}"
                            alt="logo"></a>
                    <button class="btn btn-link text-dark d-md-none" type="button" data-bs-toggle="offcanvas"
                        data-bs-target="#offcanvasExample" aria-controls="offcanvasExample">
                        <i class="fa fa-bars me-1"></i>
                    </button>
                </section>

                <section class="mt-3 mt-md-auto search-wrapper">
                    <section class="search-box">
                        <section class="search-textbox">
                            <span><i class="fa fa-search"></i></span>
                            <form
                                action="{{ route('customer.products', request()->category ? request()->category : null) }}"
                                method="get">
                                <input type="text" id="autocomplete-products" name="search" value="{{ request()->search }}"
                                    placeholder="جستجو ..." autocomplete="off" data-url="{{route('customer.products.autocomplete')}}">
                                    {{csrf_field()}}
                            </form>
                        </section>
                        <section class="p-1" id="products-autocomplete-list"></section>
                      
                        <!-- <section class="search-result visually-hidden">
                            <section class="search-result-title">نتایج جستجو برای <span class="search-words">"موبایل
                                    شیا"</span><span class="search-result-type">در دسته بندی ها</span></section>
                            <section class="search-result-item"><a class="text-decoration-none" href="#"><i
                                        class="fa fa-link"></i> دسته موبایل و وسایل جانبی</a></section>

                            <section class="search-result-title">نتایج جستجو برای <span class="search-words">"موبایل
                                    شیا"</span><span class="search-result-type">در برندها</span></section>
                            <section class="search-result-item"><a class="text-decoration-none" href="#"><i
                                        class="fa fa-link"></i> برند شیائومی</a></section>
                            <section class="search-result-item"><a class="text-decoration-none" href="#"><i
                                        class="fa fa-link"></i> برند توشیبا</a></section>
                            <section class="search-result-item"><a class="text-decoration-none" href="#"><i
                                        class="fa fa-link"></i> برند شیانگ پینگ</a></section>

                            <section class="search-result-title">نتایج جستجو برای <span class="search-words">"موبایل
                                    شیا"</span><span class="search-result-type">در کالاها</span></section>
                            <section class="search-result-item"><span class="search-no-result">موردی یافت نشد</span>
                            </section>
                        </section> -->
                   
                    </section>
                </section>

                <section class="mt-3 mt-md-auto text-end">
                    @auth
                        <section class="d-inline px-md-3">
                            <button class="btn btn-link text-decoration-none text-dark dropdown-toggle profile-button"
                                type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa fa-user"></i>
                            </button>
                            <section class="dropdown-menu dropdown-menu-end custom-drop-down"
                                aria-labelledby="dropdownMenuButton1">
                                <section><a class="dropdown-item" href="{{ route('customer.profile.index') }}"><i
                                            class="fa fa-user-circle"></i>پروفایل کاربری</a></section>
                                <section><a class="dropdown-item" href="{{ route('customer.profile.orders') }}"><i
                                            class="fa fa-newspaper"></i>سفارشات</a></section>
                                <section><a class="dropdown-item" href="{{ route('customer.profile.my-favorites') }}"><i
                                            class="fa fa-heart"></i>لیست
                                        علاقه مندی</a></section>
                                <section>
                                    <hr class="dropdown-divider">
                                </section>
                                <section><a class="dropdown-item" href="{{ route('auth.customer.logout') }}"><i
                                            class="fa fa-sign-out-alt"></i>خروج</a></section>

                            </section>
                        </section>
                    @endauth
                    @guest
                        <a class="btn btn-link text-decoration-none text-dark profile-button"
                            href="{{ route('auth.customer.login-register-form') }}"><i class="fa fa-user-lock"></i></a>
                    @endguest
                    <section class="header-cart d-inline ps-3 border-start position-relative">
                        @guest
                            <a class="btn btn-link position-relative text-dark header-cart-link"
                                href="{{ route('customer.sales-process.cart') }}">
                                <i class="fa fa-shopping-cart"></i>
                            </a>
                        @endguest
                        @auth
                            <a class="btn btn-link position-relative text-dark header-cart-link"
                                href="{{ route('customer.sales-process.cart') }}">
                                <i class="fa fa-shopping-cart"></i>
                                <span style="top: 80%;"
                                    class="position-absolute start-0 translate-middle badge rounded-pill bg-danger">{{ auth()->user()->cartItems()->count() }}</span>
                            </a>
                            <section class="header-cart-dropdown">
                                <section class="border-bottom d-flex justify-content-between p-2">
                                    <span class="text-muted">{{ count($cartItems) }} کالا</span>
                                    <a class="text-decoration-none text-info"
                                        href="{{ route('customer.sales-process.cart') }}">مشاهده سبد خرید </a>
                                </section>
                                <section class="header-cart-dropdown-body">
                                    @php

                                        $totalProductPrice = 0;
                                        $totalDiscount = 0;
                                    @endphp
                                    @foreach ($cartItems as $cartItem)
                                        @php
                                            $totalProductPrice += $cartItem->cartItemProductprice() * $cartItem->number;
                                            $totalDiscount += $cartItem->cartItemProductDiscount() * $cartItem->number;
                                        @endphp
                                        <section
                                            class="header-cart-dropdown-body-item d-flex justify-content-start align-items-center">
                                            <img class="flex-shrink-1"
                                                src="{{ asset($cartItem->product->image['indexArray'][$cartItem->product->image['currentImage']]) }}"
                                                alt="">
                                            @if (!empty($cartItem->color))
                                                <p class="product-colors-item me-1"
                                                    style="background-color: {{ $cartItem->color->color }};"></p>
                                            @endif
                                            <section class="w-100 text-truncate"><a class="text-decoration-none text-dark"
                                                    href="{{ route('customer.market.product', $cartItem->product) }}">{{ $cartItem->product->name }}</a>
                                            </section>
                                            <section class="flex-shrink-1"><a class="text-muted text-decoration-none p-1"
                                                    href="{{ route('customer.sales-process.remove-from-cart', $cartItem) }}"><i
                                                        class="fa fa-trash-alt"></i></a></section>
                                        </section>
                                    @endforeach




                                </section>
                                @if (count($cartItems) > 0)
                                    <section
                                        class="header-cart-dropdown-footer border-top d-flex justify-content-between align-items-center p-2">
                                        <section class="">
                                            <section>مبلغ قابل پرداخت</section>
                                            <section> {{ priceFormat($totalProductPrice - $totalDiscount) }} تومان
                                            </section>
                                        </section>
                                        <section class=""><a class="btn btn-danger btn-sm d-block"
                                                href="{{ route('customer.sales-process.update-cart') }}">ثبت
                                                سفارش</a></section>
                                    </section>
                                @endif

                            </section>
                        @endauth

                    </section>
                </section>
            </section>
        </section>
    </section>
    <!-- end top-header logo, searchbox and cart -->


    <!-- start menu -->
    <nav class="top-nav">
        <section class="container-xxl ">
            <nav class="">
                <section class="d-none d-md-flex justify-content-md-start position-relative">

                    <section class="super-navbar-item me-4">
                        <section class="super-navbar-item-toggle">
                            <i class="fa fa-bars me-1"></i>
                            دسته بندی کالاها
                        </section>
                        <section class="sublist-wrapper position-absolute w-100">
                            <section class="position-relative sublist-area">
                                @foreach ($categories->whereNull('parent_id') as $sublist)
                                    <section class="sublist-item">
                                        <section class="sublist-item-toggle"><a href="{{route('customer.products', ['category'=>$sublist])}}" class="link-danger text-decoration-none">{{ $sublist->name }}</a></section>
                                        <section class="sublist-item-sublist">
                                            <section
                                                class="sublist-item-sublist-wrapper d-flex justify-content-around align-items-center">
                                                <section class="sublist-column col">

                                                        
                                                        @if($sublist->name == 'موبایل')
                                                        @php
                                                        $products = $sublist->products;
                                                        $brands = [];
                                                        foreach ($products as $key => $product) {
                                                        if($product->brand_id != null && !in_array($product->brand, $brands)){
                                                               array_push($brands, $product->brand);
                                                        }
                                                        }
                                                        @endphp
                                                        @foreach ($brands as $brand)
                                                        <a href="{{route('customer.products', ['category' => $sublist, 'brands' => explode(' ', $brand->id)])}}"
                                                       class="sub-category"> موبایل {{ $brand->persian_name }}</a>
                                                        @endforeach
                                                        @endif
                                                    @foreach ($sublist->children as $subCategory)
                                                        
                                                        
                                                         
                                                       <a href="{{route('customer.products', ['category'=>$subCategory])}}"
                                                       class="sub-category">{{ $subCategory->name }}</a>
                                                       
                                                        @foreach ($subCategory->children as $subChild)
                                                            <a href="{{route('customer.products', ['category'=>$subChild])}}"
                                                                class="sub-sub-category">{{ $subChild->name }}</a>
                                                        @endforeach
                                                    @endforeach



                                                </section>


                                            </section>
                                        </section>
                                    </section>
                                @endforeach




                            </section>
                        </section>
                    </section>
                    <section class="border-start my-2 mx-1"></section>
                    <section class="navbar-item"><a href="#">سوپرمارکت</a></section>
                    <section class="navbar-item"><a href="#">تخفیف ها و پیشنهادها</a></section>
                    <section class="navbar-item"><a href="{{route('customer.products')}}">آمازون من</a></section>
                    <section class="navbar-item"><a href="#">آمازون پلاس</a></section>
                    <section class="navbar-item"><a href="#">درباره ما</a></section>
                    <section class="navbar-item"><a href="#">فروشنده شوید</a></section>
                    <section class="navbar-item"><a href="#">فرصت های شغلی</a></section>

                </section>


                <!--mobile view-->
                <section class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasExample"
                    aria-labelledby="offcanvasExampleLabel" style="z-index: 9999999;">
                    <section class="offcanvas-header">
                        <h5 class="offcanvas-title" id="offcanvasExampleLabel"><a class="text-decoration-none"
                                href="{{route('customer.home')}}"><img src="{{asset('customer-assets/images/logo/8.png')}}" alt="logo"></a></h5>
                        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                            aria-label="Close"></button>
                    </section>
                    <section class="offcanvas-body">

                        <section class="navbar-item"><a href="#">سوپرمارکت</a></section>
                        <section class="navbar-item"><a href="#">تخفیف ها و پیشنهادها</a></section>
                        <section class="navbar-item"><a href="#">آمازون من</a></section>
                        <section class="navbar-item"><a href="#">آمازون پلاس</a></section>
                        <section class="navbar-item"><a href="#">درباره ما</a></section>
                        <section class="navbar-item"><a href="#">فروشنده شوید</a></section>
                        <section class="navbar-item"><a href="#">فرصت های شغلی</a></section>


                        <hr class="border-bottom">
                        <section class="navbar-item"><a href="javascript:void(0)">دسته بندی</a></section>
                        <!-- start sidebar nav-->
                        
                        
                        <section class="sidebar-nav mt-2 px-3">
                        @foreach($categories->whereNull('parent_id') as $category)
                            <section class="sidebar-nav-item">
                                <span class="sidebar-nav-item-title">{{$category->name}}<i
                                        class="fa fa-angle-left"></i></span>
                                        @php
                                                        $products = $category->products;
                                                        $brands = [];
                                                        foreach ($products as $key => $product) {
                                                        if($product->brand_id != null && !in_array($product->brand, $brands)){
                                                               array_push($brands, $product->brand);
                                                        }
                                                        }
                                                        @endphp
                                                        <section class="sidebar-nav-sub-wrapper">
                                                        @foreach ($brands as $brand)
                                                       
                                    <section class="sidebar-nav-sub-item">
                                        <span class="sidebar-nav-sub-item-title"><a href="{{route('customer.products', ['category' => $category, 'brands' => explode(' ', $brand->id)])}}"> {{$brand->persian_name}}
                                                </a></span>
                                        
                                </section>
                                                        @endforeach
                                                        </section>
                                                       
                                <section class="sidebar-nav-sub-wrapper">
                                @foreach($category->children as $subCategory) 
                                    <section class="sidebar-nav-sub-item">
                                        <span class="sidebar-nav-sub-item-title"><a href="{{route('customer.products', $subCategory)}}"> {{$subCategory->name}}
                                                </a><i class="fa fa-angle-left"></i></span>
                                               
                                        <section class="sidebar-nav-sub-sub-wrapper">
                                        @foreach($subCategory->children as $subChild) 
                                            <section class="sidebar-nav-sub-sub-item"><a href="{{route('customer.products', $subChild)}}">هندزفری</a>
                                            </section>
                                            @endforeach
                                    </section>
                                 
                                </section>
                                @endforeach
                            </section>
                          

                        </section>
                        <!--end sidebar nav-->
@endforeach


                    </section>
                </section>

            </nav>
        </section>
    </nav>
    <!-- end menu -->


</header>
