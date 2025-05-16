@extends('admin.layouts.master')

@section('head-tag')
<title>ایجاد دسترسی ادمین</title>
{!! htmlScriptTagJsApi([#logopreview
    'callback_then' => 'callbackThen',
    'callback_catch' => 'callbackCatch',
    ]) !!}
@endsection

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb text-center">
        <li class="breadcrumb-item font-size-12"><a href="{{route('admin.home')}}">خانه</a></li>
        <li class="breadcrumb-item font-size-12"><a href="{{route('admin.home')}}"> بخش کاربران</a></li>
        <li class="breadcrumb-item font-size-12"><a href="{{route('admin.user.admin-user.index')}}">کاربران ادمین</a>
        </li>
        <li class="breadcrumb-item active font-size-12" aria-current="page">ایجاد دسترسی ادمین</li>
    </ol>
</nav>
<section class="row">
    <section class="col-12">
        <section class="main-body-container">
            <section class="main-body-container-header">
                <h4>ایجاد دسترسی ادمین</h4>
            </section>
            <section class="d-flex justify-content-between align-items-center my-4">
                <a class="btn btn-dark btn-sm" href="{{route('admin.user.admin-user.index')}}">بازگشت</a>

            </section>
            <section>
                <form action="{{route('admin.user.admin-user.permissions-store', $admin->id)}}" method="post">
                    <section class="row">
                        @csrf
                        <section class="col-12 py-2">
                            <div class="form-group">
                                <label for="permissions">دسترسی ها</label>
                                <select class="form-control form-control-sm js-example-basic-single" 
                                    multiple="multiple" name="permissions[]" id="permissions">
                                   @foreach ($permissions as $permission)
                                   <option value="{{$permission->id}}" @foreach ($admin->permissions as $adminPermission)
                                   @if ($adminPermission->id === $permission->id)
                                   selected
                                   @endif
                                   @endforeach>{{$permission->name}}</option>
                                   @endforeach
                                        
                                </select>
                            </div>
                            @error('permissions')
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
                    </section>
                </form>
            </section>
        </section>
    </section>
</section>
@endsection
@section('script')
<script>

    $(document).ready(function () {
    
        $('#permissions').select2({
            tags: true,
            multiple : true,
            placeholder: 'لطفا دسترسی ها را وارد نمایید ...'
        });
    });
</script>
@endsection