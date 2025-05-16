@extends('admin.layouts.master')

@section('head-tag')
<title>نمایش تیکت</title>
{!! htmlScriptTagJsApi([#logopreview
    'callback_then' => 'callbackThen',
    'callback_catch' => 'callbackCatch',
    ]) !!}
@endsection

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb text-center">
        <li class="breadcrumb-item font-size-12"><a href="{{route('admin.home')}}">خانه</a></li>
        <li class="breadcrumb-item font-size-12"><a href="{{route('admin.home')}}"> بخش تیکت</a></li>
        <li class="breadcrumb-item font-size-12"><a href="{{route('admin.ticket.index')}}">تیکت ها</a></li>
        <li class="breadcrumb-item active font-size-12" aria-current="page">نمایش تیکت</li>
    </ol>
</nav>
<section class="row">
    <section class="col-12">
        <section class="main-body-container">
            <section class="main-body-container-header">
                <h4>نمایش تیکت</h4>
            </section>
            <section class="d-flex justify-content-between align-items-center my-4">
                <a class="btn btn-dark btn-sm" href="{{route('admin.ticket.index')}}">بازگشت</a>
                
            </section>
            <section class="card mb-2">
         <section class="card-header bg-custom-blue text-white">
            {{$ticket->user->fullName}} - {{jalalidate($ticket->created_at)}}
            @if ($ticket->ticketFile()->count() > 0)
            <a href="{{asset($ticket->ticketFile->file_path)}}" download class="btn btn-sm btn-danger float-left vertical-middle"><i class="fa fa-download"></i></a>
            @endif
         </section>
        
         <section class="p-2 mt-3 mb-2">
            <h5 class="card-title"><b>موضوع : {{$ticket->subject}}</b></h5>
            <p class="card-text text-secondary p-2 font-size-14">{{$ticket->description}}</p>
         </section>
            </section>
            @foreach ($ticket->children as $child)

<div class="mb-3 w-100 d-flex p-2 align-items-center">

    <section class="col-1"><i
            class="fa fa-reply text-center d-flex justify-content-center @if ($child->author == 1)
                                                text-secondary
                                                @else
                                                text-success
                                                @endif"></i>
    </section>

    <section class="card w-75 mb-2">
        <section class="card-header bg-info text-white d-flex justify-content-between">
            <div>{{$child->author == 1 ? $child->admin->user->fullName : $child->user->fullName}}</div>
            <div>{{jalalidate($child->created_at)}}</div>
            
        </section>
        <section class="p-2 mt-3 mb-2">

            <p class="card-text text-secondary p-2 font-size-14">{{$child->description}}</p>
        </section>
        @if($child->ticketFile)
        <a class="btn btn-sm btn-warning" href="{{asset($child->ticketFile->file_path)}}">فایل ضمیمه</a>
    @endif
    </section>

</div>
@endforeach
            @if ($ticket->parent == null)
            <section>
            <form action="{{route('admin.ticket.answer', $ticket->id)}}" method="post" enctype="multipart/form-data">
                <section class="row">
                    @csrf
                    <section class="col-12">
                    <div class="form-group">
                        <label for="description">پاسخ تیکت</label> 
                        <textarea class="form-control form-control-sm" name="description" id="description" rows="5">{{old('description')}}</textarea>
                    </div>
                    @error('description')
                                <span class="alert_required text-danger" role="alert"><strong>{{$message}}</strong></span>
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
                        <button type="submit" class="btn btn-success btn-sm">ثبت</button>
                    </div>
                </section/>
            </form>
            </section>
            @endif
         
        </section>
    </section>
</section>
@endsection
@section('script')
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