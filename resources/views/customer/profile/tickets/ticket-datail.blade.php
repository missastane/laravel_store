@extends('customer.layouts.master-two-cols')


@section('head-tag')
<title>پاسخ تیکت</title>
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
                                <span>پاسخ تیکت</span>
                            </h2>

                        </section>
                    </section>
                    <!-- end vontent header -->

                    <a class="btn btn-dark mb-4 btn-sm mx-1" href="{{route('customer.profile.my-tickets')}}">بازگشت
                    </a>

                    <section class="row">
                        <section class="col-12">

                        <div class="mb-3 bg-secondary d-flex justify-content-between text-white p-2 rounded">
                            <section>
                                <span for="subject">تاریخ : </span>
                               <span>{{jalalidate($ticket->created_at)}}</span>
                               </section>
                               @if ($ticket->ticketFile()->count() > 0)
                               <a href="{{asset($ticket->ticketFile->file_path)}}" download class="btn btn-sm btn-danger float-end vertical-middle">دانلود ضمیمه</a>
                               @endif
                               
                            </div>
                            <div class="mb-3">
                                <label for="subject" class="form-label">موضوع</label>
                                <input type="subject" disabled class="form-control" id="subject"
                                    value="{{$ticket->subject}}">

                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label">
                                    متن تیکت</label>
                                <textarea disabled class="form-control" id="description"
                                    rows="3">{{$ticket->description}}</textarea>
                            </div>
                        </section>

                        @if (count($ticket->children()->get()->toArray()) > 0)
                            <section class="col-12">
                                <label for="description" class="form-label">پاسخ ها
                                </label>

                                @foreach ($ticket->children as $child)

                                    <div class="mb-3 w-100 d-flex p-2 align-items-center">

                                        <section class="col-1"><i
                                                class="fa fa-reply d-flex justify-content-center text-center @if ($child->author == 1)
                                                text-success
                                                @else
                                                text-secondary
                                                @endif"></i>
                                        </section>
                                        <section class="card w-75 mb-2">
                                            <section class="card-header bg-info text-white d-flex justify-content-between">
                                                <div>{{$child->author == 1 ? $child->admin->user->fullName : $child->user->fullName}}</div>
                                                <div>{{jalalidate($child->created_at)}}</div>
                                                
                                            </section>
                                            <section class="body-header mt-3 mb-2">

                                                <p class="card-text text-secondary p-2 font-size-14">{{$child->description}}</p>
                                               
                                            </section>
                                            @if($child->ticketFile)
                                            <a class="btn btn-sm btn-warning" href="{{asset($child->ticketFile->file_path)}}">فایل ضمیمه</a>
                                        @endif
                                        </section>

                                    </div>
                                @endforeach
                            </section>
                        @endif
                        @if ($ticket->status == 2)
                        <section class="col-12">
                            <form action="{{route('customer.profile.ticket-answer', $ticket)}}" method="post" enctype="multipart/form-data">
                                <section class="row">
                                    @csrf
                                    <section class="col-12">
                                        <div class="form-group">
                                            <label for="description">پاسخ تیکت</label>
                                            <textarea class="form-control form-control-sm" name="description"
                                                id="description" rows="5">{{old('description')}}</textarea>
                                        </div>
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
                                    <div class="col-12 mt-2">
                                        <button type="submit" class="btn btn-success btn-sm">ثبت</button>
                                    </div>
                                </section />
                            </form>
                        </section>
                        @endif
                      
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