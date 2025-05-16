<!DOCTYPE html>
<html lang="en">
<head>
    @include('customer.layouts.head-tag')
    @yield('head-tag')
</head>
<body>
 
    <!-- start main one col -->
    <main id="main-body-one-col" class="main-body">
    @yield('content')
    </main>
    <!-- end main one col -->
    
   
    @include('customer.layouts.scripts')
    @yield('scripts')
    <section class="toast-wrapper flex-row-reverse">
   @include('customer.alerts.toast.success')
   @include('customer.alerts.toast.error')
</section>
@include('customer.alerts.sweetalert.success')
@include('customer.alerts.sweetalert.error')
</body>
</html>