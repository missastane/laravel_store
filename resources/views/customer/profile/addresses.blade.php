@extends('customer.layouts.master-two-cols')


@section('head-tag')
<title>آدرس های من</title>
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
                                    <span>آدرس های من</span>
                                </h2>
                                <section class="content-header-link">
                                    <!--<a href="#">مشاهده همه</a>-->
                                </section>
                            </section>
                        </section>
                        <!-- end vontent header -->



                        <section class="address-select">
                          
                                @foreach (auth()->user()->addresses as $address)
                                
                                    <input type="radio" name="address_id" value="{{$address->id}}" id="address_{{$address->id}}" />
                                    <!--checked="checked"-->
                                    <label for="address_{{$address->id}}" class="address-wrapper mt-1 mb-2 p-2">
                                        <section class="mb-2">
                                            <i class="fa fa-map-marker-alt mx-1"></i>
                                            آدرس : {{$address->address ?? '-'}}
                                        </section>
                                        <section class="mb-2">
                                            <i class="fa fa-user-tag mx-1"></i>
                                            گیرنده :
                                            @if (!empty($address->recipient_first_name) && !empty($address->recipient_last_name))
                                                {{$address->recipient_first_name . ' ' . $address->recipient_last_name}}
                                            @else
                                                {{auth()->user()->fullName}}
                                            @endif
                                        </section>
                                        <section class="mb-2">
                                            <i class="fa fa-mobile-alt mx-1"></i>
                                            موبایل گیرنده : {{$address->mobile}}
                                        </section>
                                        <a data-bs-toggle="modal" data-bs-target="#edit-address-{{$address->id}}"><i class="fa fa-edit"></i> ویرایش آدرس</a>
                                        
                                    </label>
                                  
                                  
                                    <section class="modal fade" id="edit-address-{{$address->id}}" tabindex="-1"
                                        aria-labelledby="add-address-label" aria-hidden="true">
                                        <section class="modal-dialog">
                                            <section class="modal-content">
                                                <section class="modal-header">
                                                    <h5 class="modal-title" id="add-address-label"><i
                                                            class="fa fa-plus"></i> ویرایش آدرس</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </section>
                                                <section class="modal-body">
                                                    <form class="row" id="edit-address-form"
                                                        action="{{route('customer.sales-process.update-address', $address->id)}}"
                                                        method="post">
                                                        @csrf
                                                        @method('put')
                                                        <section class="col-6 mb-2">
                                                            <label for="province" class="form-label mb-1">استان</label>
                                                            <select class="form-select form-select-sm" id="province-{{$address->id}}" name="province_id">
                                                                @foreach ($provinces as $province)
                                                                    <option
                                                                        data-url="{{route('customer.sales-process.get-cities', $province->id)}}"
                                                                        value="{{$province->id}}" 
                                                                        @if (old('province_id', $address->city->province->id) == $province->id)
                                                                        selected
                                                                        @endif >
                                                                        {{$province->name}}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                            @error('province_id')
                                                                <span class="alert_required text-danger p-1 rounded"
                                                                    role="alert">
                                                                    <strong>
                                                                        {{ $message }}
                                                                    </strong>
                                                                </span>
                                                            @enderror
                                                        </section>

                                                        <section class="col-6 mb-2">
                                                            <label for="city" class="form-label mb-1">شهر</label>
                                                            <select class="form-select form-select-sm" id="city-{{$address->id}}" name="city_id">
                                                            @foreach ($cities as $city)
                                                            <option value="{{$city->id}}" {{$city->id == $address->city_id ? 'selected' : ''}}>{{$city->name}}</option>
                                                            
                                                            @endforeach
                                                        </select>
                                                            @error('city_id')
                                                                <span class="alert_required text-danger p-1 rounded"
                                                                    role="alert">
                                                                    <strong>
                                                                        {{ $message }}
                                                                    </strong>
                                                                </span>
                                                            @enderror
                                                        </section>
                                                        <section class="col-12 mb-2">
                                                            <label for="address" class="form-label mb-1">نشانی</label>
                                                            <textarea class="form-control form-control-sm"
                                                                id="address" name="address" placeholder="نشانی">{{old('address', $address->address)}}</textarea>
                                                            @error('address')
                                                                <span class="alert_required text-danger p-1 rounded"
                                                                    role="alert">
                                                                    <strong>
                                                                        {{ $message }}
                                                                    </strong>
                                                                </span>
                                                            @enderror
                                                        </section>

                                                        <section class="col-6 mb-2">
                                                            <label for="postal_code" class="form-label mb-1">کد
                                                                پستی</label>
                                                            <input type="text" class="form-control form-control-sm"
                                                                id="postal_code" value="{{old('postal_code', $address->postal_code)}}" name="postal_code" placeholder="کد پستی">
                                                            @error('postal_code')
                                                                <span class="alert_required text-danger p-1 rounded"
                                                                    role="alert">
                                                                    <strong>
                                                                        {{ $message }}
                                                                    </strong>
                                                                </span>
                                                            @enderror
                                                        </section>

                                                        <section class="col-3 mb-2">
                                                            <label for="no" class="form-label mb-1">پلاک</label>
                                                            <input type="text" class="form-control form-control-sm"
                                                                id="no" name="no"  value="{{old('no', $address->no)}}" placeholder="پلاک">
                                                            @error('no')
                                                                <span class="alert_required text-danger p-1 rounded"
                                                                    role="alert">
                                                                    <strong>
                                                                        {{ $message }}
                                                                    </strong>
                                                                </span>
                                                            @enderror
                                                        </section>

                                                        <section class="col-3 mb-2">
                                                            <label for="unit" class="form-label mb-1">واحد</label>
                                                            <input type="text" class="form-control form-control-sm"
                                                                id="unit" name="unit"  value="{{old('unit', $address->unit)}}" placeholder="واحد">
                                                            @error('unit')
                                                                <span class="alert_required text-danger p-1 rounded"
                                                                    role="alert">
                                                                    <strong>
                                                                        {{ $message }}
                                                                    </strong>
                                                                </span>
                                                            @enderror
                                                        </section>

                                                        <section class="border-bottom mt-2 mb-3"></section>

                                                        <section class="col-12 mb-2">
                                                            <section class="form-check">
                                                                <input {{$address->recipient_first_name ? 'checked' : ''}} class="form-check-input" type="checkbox"
                                                                    id="receiver" value="{{old('receiver')}}" name="receiver">
                                                                <label class="form-check-label" for="receiver">
                                                                گیرنده سفارش خودم نیستم (اطلاعات زیر تکمیل شود)
                                                                </label>
                                                            </section>
                                                        </section>

                                                        <section class="col-6 mb-2">
                                                            <label for="first_name" class="form-label mb-1">نام
                                                                گیرنده</label>
                                                            <input type="text" class="form-control form-control-sm"
                                                                id="first_name" value="{{old('recipient_first_name', $address->recipient_first_name)}}" name="recipient_first_name" placeholder="نام گیرنده">
                                                            @error('recipient_first_name')
                                                                <span class="alert_required text-danger p-1 rounded"
                                                                    role="alert">
                                                                    <strong>
                                                                        {{ $message }}
                                                                    </strong>
                                                                </span>
                                                            @enderror
                                                        </section>

                                                        <section class="col-6 mb-2">
                                                            <label for="last_name" class="form-label mb-1">نام خانوادگی
                                                                گیرنده</label>
                                                            <input type="text" value="{{old('recipient_last_name', $address->recipient_last_name)}}" name="recipient_last_name" class="form-control form-control-sm"
                                                                id="last_name" placeholder="نام خانوادگی گیرنده">
                                                            @error('recipient_last_name')
                                                                <span class="alert_required text-danger p-1 rounded"
                                                                    role="alert">
                                                                    <strong>
                                                                        {{ $message }}
                                                                    </strong>
                                                                </span>
                                                            @enderror
                                                        </section>

                                                        <section class="col-6 mb-2">
                                                            <label for="mobile" class="form-label mb-1">شماره
                                                                موبایل</label>
                                                            <input type="text" name="mobile" class="form-control form-control-sm"
                                                                id="mobile" value="{{old('mobile', $address->mobile)}}" placeholder="شماره موبایل">
                                                            @error('mobile')
                                                                <span class="alert_required text-danger p-1 rounded"
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
                                                       
                                                        class="btn btn-sm btn-warning">ویرایش
                                                        آدرس</button>
                                                    <button type="button" class="btn btn-sm btn-danger"
                                                        data-bs-dismiss="modal">بستن</button>
                                                </section>
                                                </form>
                                            </section>
                                        </section>
                                    </section>
                                @endforeach
                              
                               



                                <section class="address-add-wrapper">
                                    <button class="address-add-button" type="button" data-bs-toggle="modal"
                                        data-bs-target="#add-address"><i class="fa fa-plus"></i> ایجاد آدرس
                                        جدید</button>
                                    <!-- start add address Modal -->
                                    <section class="modal fade" id="add-address" tabindex="-1"
                                        aria-labelledby="add-address-label" aria-hidden="true">
                                        <section class="modal-dialog">
                                            <section class="modal-content">
                                                <section class="modal-header">
                                                    <h5 class="modal-title" id="add-address-label"><i
                                                            class="fa fa-plus"></i> ایجاد آدرس جدید</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </section>
                                                <section class="modal-body">
                                                    <form class="row" id="add-address-form"
                                                        action="{{route('customer.sales-process.add-address')}}"
                                                        method="post">
                                                        @csrf
                                                        <section class="col-6 mb-2">
                                                            <label for="province" class="form-label mb-1">استان</label>
                                                            <select class="form-select form-select-sm" id="province" name="province_id">
                                                                <option selected>استان را انتخاب کنید</option>
                                                                @foreach ($provinces as $province)
                                                                    <option
                                                                        data-url="{{route('customer.sales-process.get-cities', $province->id)}}"
                                                                        value="{{$province->id}}" @if ($province->id == old('province_id'))
                                                                        selected
                                                                        @endif>{{$province->name}}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                            @error('province_id')
                                                                <span class="alert_required text-danger p-1 rounded"
                                                                    role="alert">
                                                                    <strong>
                                                                        {{ $message }}
                                                                    </strong>
                                                                </span>
                                                            @enderror
                                                        </section>

                                                        <section class="col-6 mb-2">
                                                            <label for="city" class="form-label mb-1">شهر</label>
                                                            <select class="form-select form-select-sm" id="city" name="city_id">
                                                                <option selected>شهر را انتخاب کنید</option>
                                                            </select>
                                                            @error('city_id')
                                                                <span class="alert_required text-danger p-1 rounded"
                                                                    role="alert">
                                                                    <strong>
                                                                        {{ $message }}
                                                                    </strong>
                                                                </span>
                                                            @enderror
                                                        </section>
                                                        <section class="col-12 mb-2">
                                                            <label for="address" class="form-label mb-1">نشانی</label>
                                                            <textarea class="form-control form-control-sm"
                                                                id="address" name="address" placeholder="نشانی">{{old('address')}}</textarea>
                                                            @error('address')
                                                                <span class="alert_required text-danger p-1 rounded"
                                                                    role="alert">
                                                                    <strong>
                                                                        {{ $message }}
                                                                    </strong>
                                                                </span>
                                                            @enderror
                                                        </section>

                                                        <section class="col-6 mb-2">
                                                            <label for="postal_code" class="form-label mb-1">کد
                                                                پستی</label>
                                                            <input type="text" class="form-control form-control-sm"
                                                                id="postal_code" value="{{old('postal_code')}}" name="postal_code" placeholder="کد پستی">
                                                            @error('postal_code')
                                                                <span class="alert_required text-danger p-1 rounded"
                                                                    role="alert">
                                                                    <strong>
                                                                        {{ $message }}
                                                                    </strong>
                                                                </span>
                                                            @enderror
                                                        </section>

                                                        <section class="col-3 mb-2">
                                                            <label for="no" class="form-label mb-1">پلاک</label>
                                                            <input type="text" class="form-control form-control-sm"
                                                                id="no" name="no"  value="{{old('no')}}" placeholder="پلاک">
                                                            @error('no')
                                                                <span class="alert_required text-danger p-1 rounded"
                                                                    role="alert">
                                                                    <strong>
                                                                        {{ $message }}
                                                                    </strong>
                                                                </span>
                                                            @enderror
                                                        </section>

                                                        <section class="col-3 mb-2">
                                                            <label for="unit" class="form-label mb-1">واحد</label>
                                                            <input type="text" class="form-control form-control-sm"
                                                                id="unit" name="unit"  value="{{old('unit')}}" placeholder="واحد">
                                                            @error('unit')
                                                                <span class="alert_required text-danger p-1 rounded"
                                                                    role="alert">
                                                                    <strong>
                                                                        {{ $message }}
                                                                    </strong>
                                                                </span>
                                                            @enderror
                                                        </section>

                                                        <section class="border-bottom mt-2 mb-3"></section>

                                                        <section class="col-12 mb-2">
                                                            <section class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                    id="receiver" value="{{old('receiver')}}" name="receiver">
                                                                <label class="form-check-label" for="receiver">
                                                                گیرنده سفارش خودم نیستم (اطلاعات زیر تکمیل شود)
                                                                </label>
                                                            </section>
                                                        </section>

                                                        <section class="col-6 mb-2">
                                                            <label for="first_name" class="form-label mb-1">نام
                                                                گیرنده</label>
                                                            <input type="text" class="form-control form-control-sm"
                                                                id="first_name" value="{{old('recipient_first_name')}}" name="recipient_first_name" placeholder="نام گیرنده">
                                                            @error('recipient_first_name')
                                                                <span class="alert_required text-danger p-1 rounded"
                                                                    role="alert">
                                                                    <strong>
                                                                        {{ $message }}
                                                                    </strong>
                                                                </span>
                                                            @enderror
                                                        </section>

                                                        <section class="col-6 mb-2">
                                                            <label for="last_name" class="form-label mb-1">نام خانوادگی
                                                                گیرنده</label>
                                                            <input type="text" value="{{old('recipient_last_name')}}" name="recipient_last_name" class="form-control form-control-sm"
                                                                id="last_name" placeholder="نام خانوادگی گیرنده">
                                                            @error('recipient_last_name')
                                                                <span class="alert_required text-danger p-1 rounded"
                                                                    role="alert">
                                                                    <strong>
                                                                        {{ $message }}
                                                                    </strong>
                                                                </span>
                                                            @enderror
                                                        </section>

                                                        <section class="col-6 mb-2">
                                                            <label for="mobile" class="form-label mb-1">شماره
                                                                موبایل</label>
                                                            <input type="text" name="mobile" class="form-control form-control-sm"
                                                                id="mobile" value="{{old('mobile')}}" placeholder="شماره موبایل">
                                                            @error('mobile')
                                                                <span class="alert_required text-danger p-1 rounded"
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
                                                       
                                                        class="btn btn-sm btn-primary">ثبت
                                                        آدرس</button>
                                                    <button type="button" class="btn btn-sm btn-danger"
                                                        data-bs-dismiss="modal">بستن</button>
                                                </section>
                                                </form>
                                            </section>
                                        </section>
                                    </section>
                                    <!-- end add address Modal -->
                                </section>

                            </section>


                    </section>
                </main>
            </section>
        </section>
    </section>
<!-- end body -->
@endsection
@section('scripts')
<script>
    $(document).ready(function () {
        $('#province').change(function () {
            var province = $('#province option:selected');
            var url = province.data('url');

            $.ajax({
                url: url,
                type: "GET",
                success: function (response) {
                    
                    if (response.status) {
                        let cities = response.cities;
                        $('#city').empty();
                        cities.map((city) => {
                            $('#city').append($('<option/>').val(city.id).text(city.name));
                        })

                    }
                    else {
                        errorToast('خطا پیش آمده است');
                    }
                },
                error: function () {
                    errorToast('خطا پیش آمده است');
                }
            });
        });


        //edit address

        var addresses = {!! auth()->user()->addresses !!}
       addresses.map(function(address){
        var id = address.id;
        var target = `#province-${id}`;
        var selected = `${target} option:selected`;
       
        $(target).on('change',function () {
            var province = $(selected);
            var url = province.data('url');
           
            $.ajax({
                url: url,
                type: "GET",
                success: function (response) {
                    
                    if (response.status) {
                        let cities = response.cities;
                        $(`#city-${id}`).empty();
                        cities.map((city) => {
                            $(`#city-${id}`).append($('<option/>').val(city.id).text(city.name));
                        })
                    }
                    else {
                        errorToast('خطا پیش آمده است');
                    }
                },
                error: function () {
                    errorToast('خطا پیش آمده است');
                }
            });

            
        });
       
    })
    

  
    });
</script>

@endsection