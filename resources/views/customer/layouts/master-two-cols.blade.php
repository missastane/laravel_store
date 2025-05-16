<!DOCTYPE html>
<html lang="en">
<head>
    @include('customer.layouts.head-tag')
    @yield('head-tag')
</head>
<body>
        <!-- preloader -->
        <div class="loader-wrap">
        <div class="loader">
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
        </div>
    </div>
<!-- end preloader -->
    @include('customer.layouts.header')
    <section class="container-xxl body-container">
        @yield('customer.layouts.sidebar')
    </section>
   
    @yield('content')
    <!-- start main one col -->
    <main id="main-body-one-col" class="main-body">
   
    </main>
    <!-- end main one col -->
    
    @include('customer.layouts.footer')
    @include('customer.layouts.scripts')
    @yield('scripts')
    <section class="toast-wrapper flex-row-reverse">
   @include('customer.alerts.toast.success')
   @include('customer.alerts.alert-section.success')
   @include('customer.alerts.toast.error')
</section>
@include('customer.alerts.sweetalert.success')
@include('customer.alerts.sweetalert.error')
</body>
</html>