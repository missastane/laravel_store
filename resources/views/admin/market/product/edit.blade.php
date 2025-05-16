@extends('admin.layouts.master')

@section('head-tag')
    <link rel="stylesheet" href="{{ asset('admin-assets/jalalidatepicker/persian-datepicker.min.css') }}">
    <title>ویرایش کالا</title>
    {!! htmlScriptTagJsApi([#logopreview
        'callback_then' => 'callbackThen',
        'callback_catch' => 'callbackCatch',
        ]) !!}
@endsection

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb text-center">
            <li class="breadcrumb-item font-size-12"><a href="{{ route('admin.home') }}">خانه</a></li>
            <li class="breadcrumb-item font-size-12"><a href="{{ route('admin.home') }}"> بخش فروش</a></li>
            <li class="breadcrumb-item font-size-12"><a href="{{ route('admin.market.product.index') }}">کالاها</a></li>
            <li class="breadcrumb-item active font-size-12" aria-current="page">ویرایش کالا</li>
        </ol>
    </nav>
    <section class="row">
        <section class="col-12">
            <section class="main-body-container">
                <section class="main-body-container-header">
                    <h4>ویرایش کالا</h4>
                   
                </section>
                <section class="d-flex justify-content-between align-items-center my-4">
                    <a class="btn btn-dark btn-sm" href="{{ route('admin.market.product.index') }}">بازگشت</a>

                </section>
                <section>
                    <form action="{{ route('admin.market.product.update', $product->id) }}" method="post"
                        enctype="multipart/form-data">
                        <section class="row">
                            @csrf
                            @method('put')
                            <section class="col-12 col-md-6 py-2">
                                <div class="form-group">
                                    <label for="name">نام کالا</label>
                                    <input class="form-control form-control-sm" type="text"
                                        value="{{ old('name', $product->name) }}" name="name" id="name">
                                </div>
                                @error('name')
                                    <span class="alert_required text-danger"
                                        role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </section>
                            <section class="col-12 col-md-6 py-2">
                                <div class="form-group">
                                    <label for="category_id">دسته کالا</label>
                                    <select class="form-control form-control-sm" name="category_id" id="category_id">
                                        <option value="" selected disabled>انتخاب دسته</option>
                                        @foreach ($productCategories as $productcCategory)
                                            <option value="{{ $productcCategory->id }}"
                                                @if (old('category_id', $product->category_id) == $productcCategory->id) selected @endif>
                                                {{ $productcCategory->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('category_id')
                                    <span class="alert_required text-danger"
                                        role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </section>
                            <section class="col-12 col-md-6 py-2">
                                <div class="form-group">
                                    <label for="brand_id">برند کالا</label>
                                    <select class="form-control form-control-sm" name="brand_id" id="brand_id">
                                        <option value="" selected disabled>انتخاب برند</option>
                                        @foreach ($brands as $brand)
                                            <option value="{{ $brand->id }}"
                                                @if (old('brand_id', $product->brand_id) == $brand->id) selected @endif>
                                                {{ $brand->original_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('brand_id')
                                    <span class="alert_required text-danger"
                                        role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </section>

                            <section class="col-12 py-2 col-md-6">
                                <div class="form-group">
                                    <label for="published_at">تاریخ انتشار</label>
                                    <input class="form-control form-control-sm d-none" type="text" name="published_at"
                                        id="published_at">
                                    <input class="form-control form-control-sm" value="{{ old('published_at') }}"
                                        type="text" id="published_at_view">
                                </div>
                                @error('published_at')
                                    <span class="alert_required text-danger"
                                        role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </section>

                            <section class="col-12 col-md-6 py-2">
                                <div class="form-group">
                                    <label for="price">قیمت کالا</label>
                                    <input class="form-control form-control-sm" value="{{ old('price', $product->price) }}"
                                        type="text" name="price" id="price">
                                </div>
                                @error('price')
                                    <span class="alert_required text-danger"
                                        role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </section>
                            <section class="col-12 col-md-6 py-2">
                                <div class="form-group">
                                    <label for="weight">وزن کالا</label>
                                    <input class="form-control form-control-sm"
                                        value="{{ old('weight', $product->weight) }}" type="text" name="weight"
                                        id="weight">
                                </div>
                                @error('weight')
                                    <span class="alert_required text-danger"
                                        role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </section>
                            <section class="col-12 col-md-6 py-2">
                                <div class="form-group">
                                    <label for="length">طول کالا</label>
                                    <input class="form-control form-control-sm" type="text"
                                        value="{{ old('length', $product->length) }}" name="length" id="length">
                                </div>
                                @error('length')
                                    <span class="alert_required text-danger"
                                        role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </section>
                            <section class="col-12 col-md-6 py-2">
                                <div class="form-group">
                                    <label for="width">عرض کالا</label>
                                    <input class="form-control form-control-sm"
                                        value="{{ old('width', $product->width) }}" type="text" name="width"
                                        id="width">
                                </div>
                                @error('width')
                                    <span class="alert_required text-danger"
                                        role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </section>
                            <section class="col-12 col-md-6 py-2">
                                <div class="form-group">
                                    <label for="heght">ارتفاع کالا</label>
                                    <input class="form-control form-control-sm" type="text"
                                        value="{{ old('height', $product->height) }}" name="height" id="heght">
                                </div>
                                @error('height')
                                    <span class="alert_required text-danger"
                                        role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </section>
                            @php
                            $relatedProduct = $product->related_products;
 $relatedProductIds = [];
        if ($relatedProduct != null) {
            $relatedProduct = explode(',', $relatedProduct);
            foreach($relatedProduct as $intId)
            {
                array_push($relatedProductIds, $intId);
            }
        }
    
    $relatedProductIds = array_unique($relatedProductIds);
                            @endphp
                            <section class="col-12 col-md-6 py-2">
                                <div class="form-group">
                                    <label for="related_products">محصولات مرتبط</label>
                                    <select class="form-control form-control-sm" multiple="multiple"
                                        name="related_products[]" id="related_products">
                                        @foreach ($products as $related)
                                        @if(!in_array($related->id, $relatedProductIds))
                                            <option value="{{ $related->id }}">{{ $related->name }}
                                            </option>
                                            @endif
                                        @endforeach
                                        @if (old('related_products'))
                                            @for ($i = 0; $i < count(old('related_products')); $i++)
                                                <option value="{{ old('related_products')[$i] }}"
                                                    @if (in_array(old('related_products')[$i], old('related_products'))) selected @endif>
                                                    @foreach ($products->where('id', old('related_products')[$i]) as $productrelate)
                                                        {{ $productrelate->name }}
                                                    @endforeach

                                                </option>
                                            @endfor
                                        @else

                                        @if (count(array_filter($relatedProducts)) > 0)
                                            @for ($i = 0; $i < count($relatedProducts); $i++)
                                                <option value="{{ $relatedProducts[$i] }}"
                                                    @if (in_array($relatedProducts[$i], $relatedProducts)) selected @endif>
                                                    @foreach ($products->where('id',$relatedProducts[$i]) as $productrel)
                                                            {{ $productrel->name }}
                                                    @endforeach
                                                </option>
                                            @endfor
                                        @endif
                                        @endif
                                    </select>
                                </div>
                                @error('related_products')
                                    <span class="alert_required text-danger"
                                        role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </section>
                            <section class="col-12 py-2">
                                <div class="form-group">
                                    <label for="tags">برچسب ها</label>
                                    <select class="form-control form-control-sm js-example-basic-single"
                                        multiple="multiple" name="tags[]">
                                        @if (old('tags'))
                                            @for ($i = 0; $i < count(old('tags')); $i++)
                                                <option value="{{ old('tags')[$i] }}"
                                                    @if (in_array(old('tags')[$i], old('tags'))) selected @endif>{{ old('tags')[$i] }}
                                                </option>
                                            @endfor
                                        @else
                                            @for ($i = 0; $i < count($tags); $i++)
                                                <option value="{{ $tags[$i] }}"
                                                    @if (in_array($tags[$i], $tags)) selected @endif>
                                                    {{ $tags[$i] }}
                                                </option>
                                            @endfor
                                        @endif
                                    </select>
                                </div>
                                @error('tags')
                                    <span class="alert_required text-danger"
                                        role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </section>
                            <section class="col-12 py-2 col-md-6">
                                <div class="form-group">
                                    <label for="status">وضعیت</label>
                                    <select class="form-control form-control-sm" name="status" id="status">
                                        <option value="1" @if (old('status', $product->status) == 1) selected @endif>فعال
                                        </option>
                                        <option value="2" @if (old('status', $product->status) == 2) selected @endif>غیرفعال
                                        </option>
                                    </select>
                                </div>
                                @error('status')
                                    <span class="alert_required text-danger"
                                        role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </section>
                            <section class="col-12 py-2 col-md-6">
                                <div class="form-group">
                                    <label for="marketable">قابلیت فروش دارد؟</label>
                                    <select class="form-control form-control-sm" name="marketable" id="marketable">
                                        <option value="1" @if (old('marketable', $product->marketable) == 1) selected @endif>
                                            بله</option>
                                        <option value="2" @if (old('marketable', $product->marketable) == 2) selected @endif>
                                            خیر</option>
                                    </select>
                                </div>
                                @error('status')
                                    <span class="alert_required text-danger"
                                        role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </section>
                            <section class="col-12 py-2">
                                <div class="form-group">
                                    <section class="row">
                                        <section class="col-12 col-md-6">
                                            <label for="files-logo" class="btn btn-primary mt-4 mx-5">بارگذاری تصویر
                                                کالا</label>
                                            <input type="file" onchange="readURL(this, '#logopreview')"
                                                class="form-control form-control-sm visibility-hidden" name="image"
                                                id="files-logo">
                                        </section>
                                        <section class="col-12 col-md-6">
                                            <img class="preUpload-preview-img"
                                                src="{{ asset($product->image['indexArray'][$product->image['currentImage']]) }}"
                                                alt="" id="logopreview">

                                        </section>
                                    </section>
                                </div>
                                @error('image')
                                    <span class="alert_required text-danger"
                                        role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                                <section class="row mt-4">
                                    @php
                                        $number = 1;
                                    @endphp

                                    <section class="col-12">
                                        <label for="">لطفا ابعاد تصویر را انتخاب فرمایید</label>
                                    </section>
                                    @foreach ($product->image['indexArray'] as $key => $value)
                                        <section class="col-md-{{ 6 / $number }}">
                                            <div class="form-check">
                                                <input type="radio" class="form-check-input"
                                                    value="{{ $key }}" name="currentImage"
                                                    id="{{ $number }}"
                                                    @if ($product->image['currentImage'] == $key) checked @endif>
                                                <label for="{{ $number }}" class="form-check-label mx-2">
                                                    <img src="{{ asset($value) }}" class="w-100" alt="">
                                                </label>
                                            </div>
                                        </section>
                                        @php
                                            $number++;
                                        @endphp
                                    @endforeach

                                </section>
                            </section>
                            <section class="col-12 py-2">
                                <div class="form-group">
                                    <label for="introduction">توضیحات کالا</label>
                                    <textarea class="form-control form-control-sm" name="introduction" id="introduction" rows="10">{{ old('introduction', $product->introduction) }}</textarea>
                                </div>
                                @error('introduction')
                                    <span class="alert_required text-danger"
                                        role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </section>

                            <section class="col-12 border-top mx-md-3 border-bottom mb-2 mt-2">

                                @if ($product->metas()->get()->toArray() != null)
                                    @foreach ($product->metas as $meta)
                                        <div class="row mb-3 mt-3 remove_section" id="{{ $meta->id }}_section">
                                            <section class="col-12 col-md-3">

                                                <div class="form-group row">

                                                    <label for="meta_key">ویژگی</label>

                                                    <input class="form-control form-control-sm" type="text"
                                                        value="{{ $meta->meta_key }}" name="meta_key[]" id="meta_key">

                                                </div>

                                            </section>
                                            <section class="col-12 col-md-3">
                                                <div class="form-group">
                                                    <label for="meta_value">مقدار</label>
                                                    <input class="form-control form-control-sm" type="text"
                                                        value="{{ $meta->meta_value }}" name="meta_value[]"
                                                        id="meta_value">
                                                </div>
                                            </section>
                                            <section class="col-md-1 mt-4 meta"><a
                                                    class="btn btn-sm btn-danger text-white mt-2" title="حذف ویژگی"
                                                    id="{{ $meta->id }}_deleteMeta"
                                                    onclick="deleteMeta({{ $meta->id }})"
                                                    data-url="{{ route('admin.market.product.deleteMeta', $meta->id) }}">حذف</a>
                                            </section>
                                            @error('meta_key.*')
                                            <span class="alert_required text-danger mt-4"
                                                role="alert"><strong>{{ $message }}</strong></span>
                                        @enderror
                                        @error('meta_value.*')
                                        <span class="alert_required text-danger mt-4"
                                            role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                        </div>
                                    @endforeach
                                @else
                                    <div class="row mb-3 mt-3 remove">
                                        <section class="col-12 col-md-3">
                                            <div class="form-group" id="descField">
                                                <label for="meta_key">ویژگی</label>
                                                <input class="form-control form-control-sm" type="text"
                                                    name="meta_key[]" id="meta_key">
                                            </div>
                                        </section>
                                        <section class="col-12 col-md-3">
                                            <div class="form-group">
                                                <label for="meta_value">مقدار</label>
                                                <input class="form-control form-control-sm" type="text"
                                                    name="meta_value[]" id="meta_value">
                                            </div>
                                        </section>
                                        <section class="mt-1">
                                            <button class="btn btn-danger btn-sm mt-4" id="remove"
                                                type="button">حذف</button>
                                        </section>
                                    </div>
                                @endif
                                <section id="descFields"></section>
                                <section class="col-12 mb-3 mt-3">
                                    <button type="button" id="addDesc" class="btn btn-success btn-sm">افزودن</button>
                                </section>

                            </section>
                            <section class="col-12 d-flex mt-3 flex-md-row flex-column align-items-center justify-content-md-center">
                                {!! htmlFormSnippet() !!}
                               
                                @if($errors->has('g-recaptcha-response'))
                                <div style="margin-right:1rem !important">
                                 @error('g-recaptcha-response')
                                         <span class="alert_required text-danger mt-md-0 mt-1" role="alert"><strong>{{$message}}</strong></span>
                                     @enderror
                                     </div>
                                     @endif
                                </section>
                            <div class="col-12 mt-2">
                                <button type="submit" class="btn btn-primary btn-sm">ثبت</button>
                            </div>
                        </section>
                    </form>
                </section>
            </section>
        </section>
    </section>
@endsection
@section('script')
    <script src="{{ asset('admin-assets/ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('admin-assets/jalalidatepicker/persian-date.min.js') }}"></script>
    <script src="{{ asset('admin-assets/jalalidatepicker/persian-datepicker.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $("#published_at_view").persianDatepicker({

                format: 'YYYY-MM-DD HH:mm:ss',
                toolbox: {
                    calendarSwitch: {
                        enabled: true
                    }
                },
                timePicker: {
                    enabled: true,
                },
                observer: true,
                altField: '#published_at'

            })

        });
    </script>
    <script>
        CKEDITOR.replace('introduction');
    </script>
    <script>
        $(document).ready(function() {
            $('.js-example-basic-single').select2({
                tags: true,
                placeholder: 'لطفا تگ های خود را وارد نمایید ...'
            });
            $('#related_products').select2({
                tags: true,
                placeholder: 'لطفا محصولات مرتبط با این محصول را وارد نمایید ...'
            });
        });
    </script>
    <script></script>
    <script>
        $(document).ready(function() {

            $('#addDesc').click(function(e) {


                var descFields = $('#descFields');

                var descLabel = $('#descLabel').val();
                var large =
                    '<div class="row remove mb-3 mt-3">\n' +
                    '<section class="col-12 col-md-3">\n' +
                    '<div class="form-group" id="descField">\n' +

                    '<label for="meta_key">ویژگی</label>\n' +
                    '<input type="text" type="text" class="form-control form-control-sm" name="meta_key[]" id="meta_key" />\n' +
                    '</div>\n' +

                    '</section>\n' +
                    '<section class="col-12 col-md-3">\n' +
                    '<div class="form-group">\n' +

                    '<label for="meta_value">مقدار</label>\n' +
                    '<input class="form-control form-control-sm" type="text" name="meta_value[]" id="meta_value" />\n' +

                    '</div>\n' +
                    '</section>\n' +
                    '<span class="input-group-btn mt-1">\n' +
                    '<button class="btn btn-sm btn-danger mt-4" id="removeDesc" type="button">حذف</button>\n' +
                    '</span>\n' +
                    '</div>';


                descFields.add(large).appendTo(descFields);

                e.preventDefault();

            });

            $('#descFields').on('click', '#removeDesc', function(e) {
                $(this).parent().parent('.remove').remove();
            });
            $('#remove').on('click', function(e) {

                $(this).parent().parent('.remove').remove();
            });

        });
    </script>
    <script>
        function deleteMeta(id) {
            debugger;
            var button = $('#' + id + '_deleteMeta');
            var url = button.attr('data-url');
            var parent_section = button.parent().parent('.remove_section');
            $.ajax({
                url: url,
                type: "DELETE",
                data: {
                    "_token": "{{ csrf_token() }}"
                },
                success: function(response) {

                    if (response.status) {
                        parent_section.remove();
                        showStatusResponse(response.message);
                    } else {
                        showErrorResponse(response.message);
                    }
                },
                error: function() {
                    showErrorResponse('عملیات با خطا مواجه شد');
                }

            })

        }
    </script>
    <script>
        function showStatusResponse(response) {

            var toastSuccess = '<section class="toast" data-delay="5000">\n' +
                '<section class="toast-body py-3 d-flex bg-success text-white">\n' +
                '<strong class="ml-auto">' + response + '</strong>\n' +
                '<button type="button" class="mr-2 close" data-dismiss="toast" aria-label="Close">\n' +
                '<span aria-hidden="true">&times;</span>\n' +
                '</button>\n' +
                '</section>\n' +
                '</section>';
            $('.toast-wrapper').append(toastSuccess);
            $('.toast').toast('show').delay(5500).queue(function() {
                $(this).remove();
            });
        }

        function showErrorResponse(response) {
            var toastDanger = ' <section class="toast" data-delay="5000">\n' +
                '<section class="toast-body py-3 d-flex bg-danger text-white">\n' +
                '<strong class="ml-auto">' + response + '</strong>\n' +
                '<button type="button" class="mr-2 close" data-dismiss="toast" aria-label="Close">\n' +
                '<span aria-hidden="true">&times;</span>\n' +
                '</button>\n' +
                '</section>\n' +
                '</section>';
            $('.toast-wrapper').append(toastDanger);
            $('.toast').toast('show').delay(5500).queue(function() {
                $(this).remove();
            });
        }
    </script>
@endsection
