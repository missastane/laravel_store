@extends('admin.layouts.master')

@section('head-tag')
<title>ویرایش اولویت بندی</title>
{!! htmlScriptTagJsApi([#logopreview
    'callback_then' => 'callbackThen',
    'callback_catch' => 'callbackCatch',
    ]) !!}
@endsection

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb text-center">
        <li class="breadcrumb-item font-size-12"><a href="{{route('admin.home')}}">خانه</a></li>
        <li class="breadcrumb-item font-size-12"><a href="{{route('admin.home')}}"> بخش تیکت ها</a></li>
        <li class="breadcrumb-item font-size-12"><a href="{{route('admin.ticket.priority.index')}}">اولویت بندی</a></li>
        <li class="breadcrumb-item active font-size-12" aria-current="page">ویرایش اولویت بندی</li>
    </ol>
</nav>
<section class="row">
    <section class="col-12">
        <section class="main-body-container">
            <section class="main-body-container-header">
                <h4>ویرایش اولویت بندی تیکت ها</h4>
            </section>
            <section class="d-flex justify-content-between align-items-center my-4">
                <a class="btn btn-dark btn-sm" href="{{route('admin.ticket.priority.index')}}">بازگشت</a>

            </section>
            <section>
                <form action="{{route('admin.ticket.priority.update', $ticketPriority->id)}}" method="post"
                    >
                    @csrf
                    {{method_field('put')}}
                    <section class="row">
                        <section class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="name">نام اولویت</label>
                                <input class="form-control form-control-sm" value="{{old('name', $ticketPriority->name)}}"
                                    type="text" name="name" id="name">
                            </div>
                            @error('name')
                                <span class="alert_required text-danger" role="alert"><strong>{{$message}}</strong></span>
                            @enderror
                        </section>

                        <section class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="status">وضعیت</label>
                                <select class="form-control form-control-sm" name="status" id="status">
                                    <option value="1" @if (old('status', $ticketPriority->status) == 1) selected @endif>
                                        فعال</option>
                                    <option value="2" @if (old('status', $ticketPriority->status) == 2) selected @endif>
                                        غیرفعال</option>
                                </select>
                            </div>
                            @error('status')
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
                            <button type="submit" class="btn btn-warning btn-sm">ویرایش</button>
                        </div>
                    </section>
                </form>
            </section>
        </section>
    </section>
</section>
@endsection