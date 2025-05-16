@extends('customer.layouts.master-two-cols')


@section('head-tag')
<title>ویرایش حساب کاربری</title>
@endsection


@section('content')
<!-- start body -->
<section class="">
    <section id="main-body-two-col" class="container-xxl body-container">
        <section class="row">
        @include('customer.profile.layouts.sidebar')
            <main id="main-body" class="main-body col-md-9">
                <section class="content-wrapper bg-white p-3 rounded-2 mb-2">

                    <!-- start vontent header -->
                    <section class="content-header mb-4">
                        <section class="d-flex justify-content-between align-items-center">
                            <h2 class="content-header-title">
                                <span>اطلاعات حساب</span>
                            </h2>
                            <section class="content-header-link">
                                <!--<a href="#">مشاهده همه</a>-->
                            </section>
                        </section>
                    </section>
                    <!-- end vontent header -->

                    <section class="d-flex justify-content-end my-4">
                        <a class="btn btn-link btn-sm text-info text-decoration-none mx-1"
                            onclick="document.getElementById('form-profile-completion').submit()"><i
                                class="fa fa-edit px-1"></i>ویرایش حساب</a>
                    </section>

                    <form action="{{route('customer.profile.update')}}" method="post"
                        id="form-profile-completion">
                        <section class="row">
                            @csrf
                            @method('put')
                            <section class="col-12 col-md-6 border-bottom mb-2 py-2">
                                <label for="first_name" class="field-title">نام</label>
                                <input id="first_name"
                                    class="field-value overflow-auto form-control form-control-sm border-0" type="text"
                                    name="first_name" value="{{old('first_name', $user->first_name)}}">
                                @error('first_name')
                                    <span class="alert_required text-danger"
                                        role="alert"><strong>{{$message}}</strong></span>
                                @enderror
                            </section>

                            <section class="col-12 col-md-6 border-bottom my-2 py-2">
                                <label for="last_name" class="field-title">نام خانوادگی</label>
                                <input id="last_name"
                                    class="field-value overflow-auto form-control form-control-sm border-0" type="text"
                                    name="last_name" value="{{old('last_name', $user->last_name)}}">
                                @error('last_name')
                                    <span class="alert_required text-danger"
                                        role="alert"><strong>{{$message}}</strong></span>
                                @enderror
                            </section>

                            <section class="col-12 col-md-6 border-bottom my-2 py-2">
                                <label for="mobile" class="field-title">شماره تلفن همراه</label>
                                <input id="mobile"disabled
                                    class="field-value overflow-auto d-inline position-relative form-control form-control-sm border-0" type="text"
                                    name="mobile" value="{{old('mobile', $user->mobile)}}">
                                    <a data-bs-toggle="modal" data-bs-target="#mobile-modal" class="btn btn-sm btn-danger position-absolute" style="margin-right: -3rem"><i class="fa fa-pencil-alt" style="padding: 0.2rem .5rem;"></i></a>
                                  
                                @error('mobile')
                                    <span class="alert_required d-block text-danger"
                                        role="alert"><strong>{{$message}}</strong></span>
                                @enderror
                            </section>

                            <section class="col-12 col-md-6 border-bottom my-2 py-2">
                                <label for="email" class="field-title">ایمیل</label>
                                <input id="email"
                                    class="field-value overflow-auto d-inline position-relative form-control form-control-sm border-0" disabled type="text"
                                    name="email" value="{{old('email', $user->email)}}">
                                    <a data-bs-toggle="modal" data-bs-target="#email-modal" class="btn btn-sm btn-danger position-absolute" style="margin-right: -3rem"><i class="fa fa-pencil-alt" style="padding: 0.2rem .5rem;"></i></a>

                                @error('email')
                                    <span class="alert_required d-block text-danger"
                                        role="alert"><strong>{{$message}}</strong></span>
                                @enderror
                            </section>

                            <section class="col-12 col-md-6 my-2 py-2">
                                <label for="national_code" class="field-title">کد ملی</label>
                                <input id="national_code"
                                    class="field-value overflow-auto form-control form-control-sm border-0" type="text"
                                    name="national_code" value="{{old('national_code', $user->national_code)}}">
                                @error('national_code')
                                    <span class="alert_required text-danger"
                                        role="alert"><strong>{{$message}}</strong></span>
                                @enderror
                            </section>

                            <!-- <section class="col-12 col-md-6 my-2 py-2">
                                <label for="password" class="field-title">رمز عبور</label>
                                <input id="password"
                                    class="field-value overflow-auto form-control form-control-sm border-0"
                                    type="password" name="password" value="{{old('password', $user->password)}}">
                                @error('password')
                                    <span class="alert_required text-danger"
                                        role="alert"><strong>{{$message}}</strong></span>
                                @enderror
                            </section> -->

                        </section>

                    </form>
                    <section class="modal fade" id="mobile-modal" tabindex="-1"
                    aria-labelledby="add-address-label" aria-hidden="true">
                    <section class="modal-dialog">
                        <section class="modal-content">
                            <section class="modal-header">
                                <h5 class="modal-title" id="add-address-label"><i
                                        class="fa fa-plus"></i> ویرایش موبایل</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </section>
                            <section class="modal-body">
                                <form class="row"
                                    action="{{route('customer.profile.mobile.confirm')}}"
                                    method="post">
                                    @csrf
                                    @method('put')
                              
                                    <section class="col-12 mb-2">
                                        <label for="mobile" class="form-label mb-1">شماره
                                            موبایل</label>
                                        <input type="text" name="mobile" class="form-control form-control-sm"
                                            id="mobile" value="{{old('mobile',auth()->user()->mobile)}}">
                                        @error('mobile')
                                            <span class="alert_required d-block text-danger p-1 rounded"
                                                role="alert">
                                                <strong>
                                                    {{ $message }}
                                                </strong>
                                            </span>
                                        @enderror
                                    </section>


                                
                            </section>
                            <section class="modal-footer py-1">
                                <button type="submit"
                                   
                                    class="btn btn-sm btn-warning">تأیید شماره
                                    موبایل</button>
                                <button type="button" class="btn btn-sm btn-danger"
                                    data-bs-dismiss="modal">بستن</button>
                            </section>
                            </form>
                        </section>
                    </section>
                </section>
                <section class="modal fade" id="email-modal" tabindex="-1"
                aria-labelledby="edit-email" aria-hidden="true">
                <section class="modal-dialog">
                    <section class="modal-content">
                        <section class="modal-header">
                            <h5 class="modal-title" id="edit-email"><i
                                    class="fa fa-plus"></i> ویرایش ایمیل</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </section>
                        <section class="modal-body">
                            <form class="row"
                                action="{{route('customer.profile.email.confirm')}}"
                                method="post">
                                @csrf
                                @method('put')
                          
                                <section class="col-12 mb-2">
                                    <label for="email" class="form-label mb-1">ایمیل
                                        </label>
                                    <input type="text" name="email" class="form-control form-control-sm"
                                        id="email" value="{{old('email', auth()->user()->email)}}">
                                    @error('email')
                                        <span class="alert_required d-block text-danger p-1 rounded"
                                            role="alert">
                                            <strong>
                                                {{ $message }}
                                            </strong>
                                        </span>
                                    @enderror
                                </section>


                            
                        </section>
                        <section class="modal-footer py-1">
                            <button type="submit"
                               
                                class="btn btn-sm btn-warning">تأیید ایمیل
                                </button>
                            <button type="button" class="btn btn-sm btn-danger"
                                data-bs-dismiss="modal">بستن</button>
                        </section>
                        </form>
                    </section>
                </section>
            </section>
                </section>
            </main>
        </section>
    </section>
</section>
<!-- end body -->
@endsection