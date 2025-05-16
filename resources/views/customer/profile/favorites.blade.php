@extends('customer.layouts.master-two-cols')
@section('head-tag')
<title>لیست علاقه مندی</title>
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
                                <span>لیست علاقه مندی های من</span>
                            </h2>
                            <section class="content-header-link">
                                <!--<a href="#">مشاهده همه</a>-->
                            </section>
                        </section>
                    </section>
                    <!-- end vontent header -->

                    @forelse(auth()->user()->products as $product)
                        <section class="cart-item d-flex py-3">
                            <section class="cart-img align-self-start flex-shrink-1"><img
                                    src="{{asset($product->image['indexArray']['medium'])}}" alt=""></section>
                            <section class="align-self-start w-100">
                                <p class="fw-bold">{{$product->name}}</p>
                                
                                <p><i class="fa fa-store-alt cart-product-selected-store me-1"></i> <span>کالا موجود در
                                        انبار</span></p>
                                <section class="favor-product">
                                    <a class="text-decoration-none cart-delete" href="{{route('customer.profile.my-favorites-remove', $product->id)}}"><i class="fa fa-trash-alt"></i> حذف
                                        از لیست علاقه مندی ها</a>
                                </section>
                            </section>
                            <section class="align-self-end flex-shrink-1">
                            @php
                                $amazingSales = $product->activeAmazingSale();
                            @endphp
                             @if (!empty($amazingSales))
                            <section class="cart-item-discount text-danger text-nowrap mb-1">میزان تخفیف : {{priceFormat($product->price * ($amazingSales->percentage / 100))}} تومان</section>
                            @endif
                                <section class="text-nowrap fw-bold text-end">{{priceFormat($product->price)}} تومان</section>
                            </section>
                        </section>
                    @empty
                    <section class="order-item">
    <section>
        <p>محصولی یافت نشد</p>
    </section>
</section>
                    @endforelse






                </section>
            </main>
        </section>
    </section>
</section>
<!-- end body -->
@endsection
@section('scripts')
<script>
    $('.favor-product button').click(function (event) {
        event.preventDefault();
        var url = $(this).attr('data-url');
        var element = $(this).children('i');

        $.ajax({
            url: url,
            context: $(this),
            success: function (result) {
                
                if (result.status == 2) {
                    

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