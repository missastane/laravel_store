@extends('customer.layouts.master-simple')
@section('head-tag')
<title>تأیید اطلاعات حساب کاربری</title>
<style>
    #resend-otp {
        font-size: 1rem;
    }
   
</style>
@endsection
@section('content')
<section class="vh-100 d-flex justify-content-center align-items-center pb-5">

    <form action="{{route('customer.sales-process.profile-info-confirm', $token)}}" method="post">
        <section class="login-wrapper mb-5">
            @csrf
            <section class="login-logo">
                <img src="{{asset('customer-assets/images/logo/4.png')}}" alt="">
            </section>
            <section class="login-title mb-2">
              
            </section>
            <section class="login-title">
                کد تأیید را وارد نمایید
            </section>
            <section class="login-info" id="login-info">
                @if($otp->type == 0)
                    کد تأیید برای شماره موبایل {{$otp->login_id}} ارسال گردید
                @else
                    کد تأیید برای ایمیل {{$otp->login_id}} ارسال گردید
                @endif
            </section>
            <section class="login-input-text">
                <input type="text" name="otp" value="{{old('otp')}}">
            </section>
            @error('otp')
                <span class="alert_required text-danger my-1" role="alert"><strong>{{$message}}</strong></span>
            @enderror
            <section class="login-btn d-grid g-2 mt-2"><button class="btn btn-danger">تأیید</button></section>
            <section id="resend-otp" class="d-none">
                <a class="text-decoration-none text-primary"
                    href="{{route('customer.sales-process.resend-otp', $token)}}">دریافت مجدد کد تأیید</a>
            </section>
            <section id="timer"></section>
        </section>
</section>
</form>
</section>
@endsection
@section('scripts')
@php
   if(session('timer'))
{
    $timer = session('timer');
}
else{
    $timer = ((new \Carbon\Carbon($otp->created_at))->addMinutes(2)->timestamp - \Carbon\Carbon::now()->timestamp) * 1000;
}
@endphp
<script>
    var countDownDate = new Date().getTime() + {{$timer}};
    var timer = $('#timer');
    var resendOtp = $('#resend-otp');
    var loginInfo = $('#login-info');

    resendOtp.on('click', function () {
        loginInfo.removeClass('d-none');
    });
    var x = setInterval(function () {
        var now = new Date().getTime();
        var distance = countDownDate - now;
        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        var seconds = Math.floor((distance % (1000 * 60)) / (1000));
        if (minutes == 0) {
            timer.html('ارسال مجدد کد تأیید تا ' + seconds + ' ثانیه دیگر')
        }
        else {
            timer.html('شمارش معکوس تا ارسال مجدد کد   ' + seconds + ' : ' + minutes)
        }
        if (distance < 0) {
            clearInterval(x);
            timer.addClass('d-none');
            resendOtp.removeClass('d-none');
            loginInfo.addClass('d-none');
        }
    })
</script>
@endsection