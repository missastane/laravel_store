@extends('customer.layouts.master-two-cols')


@section('head-tag')
<title>ایجاد تیکت جدید</title>
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
                                <span>ایجاد تیکت جدید</span>
                            </h2>
                            <section class="content-header-link">
                                <!--<a href="#">مشاهده همه</a>-->
                            </section>
                        </section>
                    </section>
                    <!-- end vontent header -->
                    <a class="btn btn-dark mb-4 btn-sm mx-1" href="{{route('customer.profile.my-tickets')}}">بازگشت
                    </a>
                    <form action="{{route('customer.profile.ticket-store')}}" method="post" enctype="multipart/form-data">
                        <section class="row">
                            @csrf
                            <section class="col-12 col-md-4 my-2 py-2">
                                <label for="subject">عنوان</label>
                                <input id="subject"
                                    class="form-control form-control-sm" type="text"
                                    name="subject" value="{{old('subject')}}">
                                @error('subject')
                                    <span class="alert_required text-danger"
                                        role="alert"><strong>{{$message}}</strong></span>
                                @enderror
                            </section>

                            <section class="col-md-4 col-12 my-2 py-2">
                                <label for="category_id" >دسته تیکت</label>
                               <select name="category_id" class="form-control form-control-sm" id="category_id">
                               <option selected>دسته تیکت را انتخاب کنید</option>
                               @foreach ($categories as $category)
                                <option value="{{$category->id}}" @if (old('category_id' == $category->id))
                                selected
                                @endif>{{$category->name}}</option>
                                @endforeach
                               </select>
                                @error('category_id')
                                    <span class="alert_required text-danger"
                                        role="alert"><strong>{{$message}}</strong></span>
                                @enderror
                            </section>

                            <section class="col-md-4 col-12 my-2 py-2">
                                <label for="priority_id" >اولویت تیکت</label>
                                <select name="priority_id" class="form-control form-control-sm" id="priority_id">
                                <option selected>اولویت تیکت را انتخاب کنید</option>
                                @foreach ($periorities as $priority)
                                <option value="{{$priority->id}}" @if (old('priority_id' == $priority->id))
                                selected
                                @endif>{{$priority->name}}</option>
                                @endforeach
                               </select>
                                @error('priority_id')
                                    <span class="alert_required text-danger"
                                        role="alert"><strong>{{$message}}</strong></span>
                                @enderror
                            </section>

                            <section class="col-12 my-2 py-2">
                                <label for="description" >متن تیکت</label>
                               <textarea class="form-control form-control-sm" rows="4" name="description" id="description">{{old('description')}}</textarea>
                                @error('description')
                                    <span class="alert_required text-danger"
                                        role="alert"><strong>{{$message}}</strong></span>
                                @enderror
                            </section>
                            <section class="col-12 py-5">
                                <div class="form-group">
                                    <section class="d-flex justify-content-md-around flex-column flex-md-row">
                                    
                                            <label for="file" class="btn btn-primary my-2 my-md-0 max-w-fit-content col-12 col-md-6">بارگذاری فایل
                                                 </label>
                                            <input type="file" 
                                                class="form-control form-control-sm height-fit-content d-none visibility-hidden w-auto" name="file"
                                                id="file">
                                                <div class="mt-1 p-1 border rounded bg-danger max-w-fit-content text-white  d-none col-12 col-md-6" id="file-upload-filename"></div>
                                        
                                    </section>
                                </div>
                                @error('file')
                                    <span class="alert_required text-danger" role="alert"><strong>{{$message}}</strong></span>
                                @enderror
                            </section>
                            <section class="col-12 mt-1 py-2">
                               <button class="btn btn-sm btn-success  float-end" type="submit">ثبت</button>
                            </section>

                        </section>

                    </form>
                </section>
            </main>
        </section>
    </section>
</section>
<!-- end body -->
@endsection
@section('scripts')
<script>
    var input = document.getElementById( 'file' );
    var infoArea = document.getElementById( 'file-upload-filename' );

input.addEventListener( 'change', showFileName );

function showFileName( event ) {
  // the change event gives us the input it occurred in 
  var input = event.srcElement;
  
  // the input has an array of files in the `files` property, each one has a name that you can use. We're just using the name here.
  var fileName = input.files[0].name;
  
  infoArea.classList.remove('d-none');
  // use fileName however fits your app best, i.e. add it into a div
  infoArea.textContent = 'نام فایل انتخاب شده: ' + fileName;
}

</script>
@endsection
