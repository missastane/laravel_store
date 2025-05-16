<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{ asset('customer-assets/images/logo/favicon.png') }}">
    <link rel="stylesheet" href="{{ asset('customer-assets/css/bootstrap/bootstrap.rtl.min.css') }}">
    <link rel="stylesheet" href="{{ asset('customer-assets/css/style.css') }}">
    <title>صفحه مورد نظر یافت نشد</title>
   
</head>

<body>
    <section id="not-found" class="d-flex align-items-center flex-column justify-content-center vh-100 p-2">
        <h1 style="font-size: 10rem;">404</h1>
        <h4 style="margin-top: -1.5rem">متأسفانه صفحه مورد نظر شما وجود ندارد</h4 style="margin-top: -1rem">
        <section class="w-100 mt-3">
            <section>
                <span><i class="fa fa-search"></i></span>
                <form action="{{ route('customer.products', request()->category ? request()->category : null) }}"
                    method="get">
                    <input class="w-25 p-1 d-block m-auto rounded border-0" id="search" type="text" name="search"
                        value="{{ request()->search }}" placeholder="جستجو در محصولات ..." autocomplete="off">
                </form>
            </section>
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
    <script src="{{asset('admin-assets/js/jquery-3.5.1.min.js')}}"></script>
    <script src="{{asset('customer-assets/js/snow.js')}}"></script>
</body>

</html>
