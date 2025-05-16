@extends('customer.layouts.master-two-cols')
@section('head-tag')
    <title>لیست مقایسه محصولات</title>
@endsection

@section('content')
    <!-- start body -->
    <section class="">
        <section id="main-body-two-col" class="container-xxl body-container">
            <section class="row">
                <main id="main-body" class="main-body col-md-12">
                    <section class="content-wrapper bg-white p-3 rounded-2 mb-2">

                        <!-- start vontent header -->
                        <section class="content-header mb-4">
                            <section class="d-flex justify-content-between align-items-center">
                                <h2 class="content-header-title">
                                    <span>لیست مقایسه محصولات</span>
                                </h2>
                                <section class="content-header-link">
                                    <!--<a href="#">مشاهده همه</a>-->
                                </section>
                            </section>
                        </section>
                        <!-- end vontent header -->
                        @php
                            if (session('data')) {
                                $products = session('data');
                            } elseif (session($product->id)) {
                                $products = session($product->id);
                            }

                        @endphp
                        <section class="row align-items-center justify-content-between">
                            <section class="col-12">
                                @if (count($products) > 0)
                                    <section class="col-10 d-flex justify-content-start mx-auto overflow-hidden">
                                        @php
                                            // show products info to compare
                                            $compareProducts = [];
                                            foreach ($products as $key => $productItem) {
                                                $compareProduct = [];
                                                $compareProduct['وزن'] = $productItem->weight;
                                                $compareProduct['طول'] = $productItem->length;
                                                $compareProduct['عرض'] = $productItem->width;
                                                $compareProduct['قظر'] = $productItem->height;
                                                $values = $productItem->values->toArray();
                                                $names = $productItem->category->attributes->toArray();
                                                foreach ($names as $name) {
                                                    $compareProduct[$name['name']] = null;
                                                    foreach ($values as $value) {
                                                        if ($name['id'] == $value['category_attribute_id']) {
                                                            $compareProduct[$name['name']] = json_decode(
                                                                $value['value'],
                                                            )->value;
                                                        }
                                                    }
                                                }
                                                $compareProduct['مشخصات ویژه'] = '';
                                                foreach ($productItem->metas as $meta) {
                                                    $compareProduct['مشخصات ویژه'] =
                                                        $compareProduct['مشخصات ویژه'] .
                                                        $meta->meta_key .
                                                        ' : ' .
                                                        $meta->meta_value .
                                                        '. ';
                                                }
                                                array_push($compareProducts, $compareProduct);
                                            }

                                            // products that users allows to compare with $product
                                            $productIds = [];
                                            foreach ($products as $product) {
                                                array_push($productIds, $product->id);
                                            }
                                            $catProducts = $products[0]->category->products->except($productIds);
                                        @endphp


                                    </section>
                                    <section class="d-flex justify-content-start mx-auto mt-1">
                                        <table class="table overflow-hidden">
                                            <tr class="w-100 d-flex">

                                                @foreach ($products as $key => $productItem)
                                                    <td
                                                        class="@if (count($products) == 1) col-7 col-md-6 @elseif(count($products) == 2) col-6 col-md-4 @elseif(count($products) == 3) col-6 col-md-3 @elseif(count($products) == 4) col-6 col-md-3 @endif">
                                                        <section
                                                            class="d-flex @if ($key < 3) border-end @endif py-2 px-4 flex-column align-items-center justify-start h-100">
                                                            @if (count($products) > 1)
                                                                <form class="d-flex align-self-end"
                                                                    action="{{ route('customer.market.remove-from-compare', ['product' => $product]) }}"
                                                                    method="get">

                                                                    @foreach($products as $oldProduct)
                                                                    <input type="hidden" name="oldProducts[]"
                                                                        value="{{$oldProduct->id}}">
                                                                        @endforeach
                                                                        <input type="hidden" name="removedProduct"
                                                                        value="{{ $productItem->id }}">
                                                                    <button type="submit" class="border-0 bg-white">
                                                                        <i
                                                                            class="fa fa-times-circle fa-2x" style="font-weight: normal; color:#8d949982"></i>
                                                                    </button>
                                                                </form>
                                                            @endif
                                                            <div class="my-4 compare">
                                                                <a class="text-center text-decoration-none text-dark"
                                                                    href="">
                                                                    <img class="w-100"
                                                                        src="{{ asset($productItem->image['indexArray']['medium']) }}"
                                                                        alt="{{ $product->name }}" width="150"
                                                                        height="150">
                                                                    <h3 class="mt-1">
                                                                       
                                                                        {{ $productItem->name }}</h3>
                                                                    <div class="mx-auto text-center mt-1">
                                                                        @if ($productItem->activeAmazingSale())
                                                                        @php
                                                                            $discount =
                                                                                $productItem->price *
                                                                                ($productItem->activeAmazingSale()
                                                                                    ->percentage /
                                                                                    100);
                                                                        @endphp
                                                                        {{ priceFormat($productItem->price - $discount) }} تومان
                                                                    @else
                                                                    {{ priceFormat($productItem->price) }} تومان
                                                                    @endif
                                                                    </div>
                                                                    </a>
                                                            </div>
                                                        </section>
                                                    </td>
                                                @endforeach
                                                <td
                                                    class="border-0 @if (count($products) == 1) col-5 col-md-6 @elseif(count($products) == 2) col-6 col-md-4 @elseif(count($products) == 3) col-6 col-md-3 @elseif(count($products) == 4) d-none @endif d-flex align-items-center justify-content-center">
                                                    <button type="button" data-bs-toggle="modal"
                                                        data-bs-target="#add-product" class="btn btn-sm btn-dark">انتخاب
                                                        کالا</button>
                                                    <!-- start add product Modal -->
                                                    <section class="modal fade" id="add-product" tabindex="-1"
                                                        aria-labelledby="add-comment-label" aria-hidden="true">
                                                        <section class="modal-dialog">
                                                            <section class="modal-content">
                                                                <section class="modal-header">
                                                                    <h5 class="modal-title" id="add-product-label">
                                                                        <i class="fa fa-plus"></i>
                                                                        افزودن کالا به لیست مقایسه
                                                                    </h5>
                                                                    <button type="button" class="btn-close"
                                                                        data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </section>



                                                                <section class="modal-body mx-auto mx-md-0">
                                                                    <form class="row mx-auto mx-md-0" id="choose-product-form"
                                                                        action="{{ route('customer.market.add-to-compare', ['product' => $product]) }}"
                                                                        method="get">

                                                                        @foreach ($products as $oldProduct)
                                                                            <input type="hidden" name="oldProduct[]"
                                                                                value="{{ $oldProduct->id }}">
                                                                        @endforeach

                                                                        <section class="col-12 mb-2 mx-auto mx-md-0">
                                                                            <section class="row mx-auto mx-md-0">
                                                                                @foreach ($catProducts as $selectedProduct)
                                                                                    <section class="item col-12 col-md-4 mx-auto mx-md-0">
                                                                                        <section
                                                                                            class="lazyload-item-wrapper">
                                                                                            <section
                                                                                                class="add-to-compare-product"
                                                                                                id="add-to-compare-product">

                                                                                                <!-- <section class="product-add-to-cart"><a href="#" data-bs-toggle="tooltip"
                                                                                                                                                                 data-bs-placement="left" title="افزودن به سبد خرید"><i
                                                                                                                                                                     class="fa fa-cart-plus"></i></a></section> -->
                                                                                                <input type="radio"
                                                                                                    class="d-none"
                                                                                                    name="product"
                                                                                                    value="{{ (int) $selectedProduct->id }}"
                                                                                                    id="product_{{ $selectedProduct->id }}" onchange="$('#choose-product-form').submit()">
                                                                                                <label
                                                                                                    class="product-choosed-compare d-block"
                                                                                                    for="product_{{ $selectedProduct->id }}">
                                                                                                    <section class="p-2 d-flex flex-column align-items-center">
                                                                                                        <section
                                                                                                            class="product-image">
                                                                                                                <img class=""
                                                                                                                    src="{{ asset($selectedProduct->image['indexArray']['medium']) }}"
                                                                                                                    alt="{{$selectedProduct->name}}">
                                                                                                        </section>
                                                                                                        <section
                                                                                                            class="product-colors">
                                                                                                        </section>
                                                                                                        <section
                                                                                                            class="product-name">
                                                                                                            <h3 class="text-center">{{ Str::limit($selectedProduct->name, 30) }}
                                                                                                            </h3>
                                                                                                        </section>
                                                                                                        <section
                                                                                                            class="product-price-wrapper">
                                                                                                            @if ($selectedProduct->activeAmazingSale())
                                                                                                                @php
                                                                                                                    $discount =
                                                                                                                        $selectedProduct->price *
                                                                                                                        ($selectedProduct->activeAmazingSale()
                                                                                                                            ->percentage /
                                                                                                                            100);
                                                                                                                @endphp
                                                                                                                <section
                                                                                                                    class="product-discount d-flex">
                                                                                                                    <span
                                                                                                                        class="product-old-price">{{ priceFormat($discount) }}
                                                                                                                        تومان</span>
                                                                                                                    <span
                                                                                                                        class="product-discount-amount">{{ $selectedProduct->activeAmazingSale()->percentage }}%</span>
                                                                                                                </section>
                                                                                                                <section
                                                                                                                    class="product-price">
                                                                                                                    {{ priceFormat($selectedProduct->price - $discount) }}
                                                                                                                    تومان
                                                                                                                </section>
                                                                                                            @else
                                                                                                                <section
                                                                                                                    class="product-price">
                                                                                                                    {{ priceFormat($selectedProduct->price) }}
                                                                                                                    تومان
                                                                                                                </section>
                                                                                                            @endif


                                                                                                        </section>
                                                                                                       
                                                                                                    </section>
                                                                                                </label>
                                                                                            </section>
                                                                                        </section>
                                                                                    </section>
                                                                                @endforeach
                                                                            </section>

                                                                        </section>


                                                                </section>

                                                                
                                                                    </form>
                                                                    
                                                            </section>
                                                        </section>
                                                    </section>
                                                </td>
                                            </tr>

                                            @foreach ($compareProduct as $key => $value)
                                                <tr class="d-flex w-100 border-top-0">
                                                    <td class="col-1 col-md-1">{{ $key }}</td>

                                                    @if (count($compareProducts) == 1)
                                                        <td class="col-6 col-md-5 text-center">
                                                            {{ $compareProducts[0][$key] ?? '-' }}</td>
                                                    @endif
                                                    @if (count($compareProducts) == 2)
                                                        <td class="col-5 col-md-3 text-center">
                                                            {{ $compareProducts[0][$key] ?? '-' }}</td>
                                                        <td class="col-6 col-md-4 text-center">
                                                            {{ $compareProducts[1][$key] ?? '-' }}</td>
                                                    @endif

                                                    @if (count($compareProducts) == 3)
                                                        <td class="col-5 col-md-2 text-center">
                                                            {{ $compareProducts[0][$key] ?? '-' }}</td>
                                                        <td class="col-6 col-md-3 text-center">
                                                            {{ $compareProducts[1][$key] ?? '-' }}</td>
                                                        <td class="col-md-3 text-center">
                                                            {{ $compareProducts[2][$key] ?? '-' }}</td>
                                                    @endif
                                                    @if (count($compareProducts) == 4)
                                                        <td class="col-5 col-md-2">{{ $compareProducts[0][$key] ?? '-' }}
                                                        </td>
                                                        <td class="col-6 col-md-3 text-center">
                                                            {{ $compareProducts[1][$key] ?? '-' }}</td>
                                                        <td class="col-md-3 text-center">
                                                            {{ $compareProducts[2][$key] ?? '-' }}</td>
                                                        <td class="col-md-3 text-center">
                                                            {{ $compareProducts[3][$key] ?? '-' }}</td>
                                                    @endif
                                                </tr>
                                            @endforeach







                                        </table>
                                    @else
                                        <h2>محصولی برای مقایسه یافت نشد</h2>
                                @endif
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
        $('.favor-product button').click(function(event) {
            event.preventDefault();
            var url = $(this).attr('data-url');
            var element = $(this).children('i');

            $.ajax({
                url: url,
                context: $(this),
                success: function(result) {

                    if (result.status == 2) {


                    } else if (result.status == 3) {
                        $('#toast').removeClass('d-none');
                        $('.toast').toast('show');
                    }
                }
            })
        })
    </script>
  
@endsection
