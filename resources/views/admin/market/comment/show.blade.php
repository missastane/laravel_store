@extends('admin.layouts.master')

@section('head-tag')
<title>نمایش نظر</title>
{!! htmlScriptTagJsApi([#logopreview
    'callback_then' => 'callbackThen',
    'callback_catch' => 'callbackCatch',
    ]) !!}
@endsection

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb text-center">
        <li class="breadcrumb-item font-size-12"><a href="{{route('admin.home')}}">خانه</a></li>
        <li class="breadcrumb-item font-size-12"><a href="{{route('admin.home')}}"> بخش فروش</a></li>
        <li class="breadcrumb-item font-size-12"><a href="{{route('admin.market.comment.index')}}">نظرات</a></li>
        <li class="breadcrumb-item active font-size-12" aria-current="page">نمایش نظر</li>
    </ol>
</nav>
<section class="row">
    <section class="col-12">
        <section class="main-body-container">
            <section class="main-body-container-header">
                <h4>نمایش نظر</h4>
            </section>
            <section class="d-flex justify-content-between align-items-center my-4">
                <a class="btn btn-dark btn-sm" href="{{route('admin.market.comment.index')}}">بازگشت</a>
                
            </section>
            <section class="card mb-2">
         <section class="card-header bg-custom-yellow text-white">
          {{$comment->user->fullName}} 
         </section>
         <section class="w-100 mt-3 mb-2 p-2">
         <section class="d-md-flex justify-content-between">
         <h5 class="card-title"><b>عنوان محصول :  {{$comment->commentable->name}}</b></h5>
         <section>
           <section>
           @if ($comment->approved == 1)
            <h6><i class="text-success fa fa-check-circle"></i> تأیید شده</h6>
            @else
            <h5><i class="text-danger fa fa-times-circle"></i> تأیید نشده</h5>
            @endif
           </section>
            
           <section>
           @if ($comment->status == 1)
            <h6 class="ml-2"><i class="text-success fa fa-check-circle"></i> فعال </h6>
            @else
            <h5 class="ml-2"><i class="text-danger fa fa-times-circle"></i> غیرفعال</h5>
            @endif
           </section>
          
         </section>
         </section>
            <p class="card-text text-secondary font-size-14">{{$comment->body}}</p>
         </section>
            </section>
   @if ($comment->parent_id == null)
   <section>
            <form action="{{route('admin.market.comment.answer', $comment->id)}}" method="post">
                <section class="row">
                    @csrf
                    <section class="col-12">
                    <div class="form-group">
                        <label for="body">پاسخ ادمین</label> 
                        <textarea class="form-control form-control-sm" name="body" id="body" rows="5">{{old('body')}}</textarea>
                    </div>
                    @error('body')
                    <span class="alert_required text-danger mt-md-0 mt-1" role="alert"><strong>{{$message}}</strong></span>
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