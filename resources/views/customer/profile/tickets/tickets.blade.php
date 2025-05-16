@extends('customer.layouts.master-two-cols')


@section('head-tag')
<title>تیکت های من</title>
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
                                <span>تیکت های من</span>
                            </h2>
                            <section class="content-header-link">
                                <!--<a href="#">مشاهده همه</a>-->
                            </section>
                        </section>
                    </section>
                    <!-- end vontent header -->

                    <a class="btn btn-primary btn-sm mx-1" href="{{route('customer.profile.ticket-create')}}">ایجاد تیکت
                        جدید</a>


                    <section class="d-flex justify-content-center my-4">

                        <a class="btn btn-outline-primary btn-sm mx-1"
                            href="{{route('customer.profile.my-tickets')}}">همه تیکت ها</a>
                        <a class="btn btn-warning btn-sm mx-1"
                            href="{{route('customer.profile.my-tickets', 'type=0')}}">دیده نشده</a>
                        <a class="btn btn-success btn-sm mx-1"
                            href="{{route('customer.profile.my-tickets', 'type=2')}}">تیکت های باز</a>
                        <a class="btn btn-danger btn-sm mx-1"
                            href="{{route('customer.profile.my-tickets', 'type=1')}}">تیکت های بسته</a>
                    </section>

                    <!-- start content header -->
                    <section class="content-header mb-3">
                        <section class="d-flex justify-content-between align-items-center">
                            <h2 class="content-header-title content-header-title-small">

                            </h2>
                            <section class="content-header-link">
                                <!--<a href="#">مشاهده همه</a>-->
                            </section>
                        </section>
                    </section>
                    <!-- end content header -->

                                                
                                        <table class="table d-table table-responsive w-100">
                                            <thead>
                                                <tr>
                                                    <th scope="col">تاریخ ثبت</th>
                                                    <th scope="col">موضوع</th>
                                                    <th scope="col">دسته تیکت</th>
                                                    <th scope="col">اولویت تیکت</th>
                                                    <th scope="col">تعداد پاسخ</th>
                                                    <th scope="col">وضعیت تیکت</th>
                                                    <th scope="col">عملیات</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($tickets as $ticket)
                                                <tr>

                                                    <td>{{jalalidate($ticket->created_at)}}</td>
                                                    <td>{{$ticket->subject}}</td>
                                                    <td>{{$ticket->category->name}}</td>
                                                    <td>{{$ticket->priority->name}}</td>
                                                    <td>{{$ticket->children->count()}}</td>
                                                    <td>{{$ticket->status == 2 ? 'باز' : 'بسته'}}</td>
                                                
                                                    <td><a href="{{route('customer.profile.ticket-details', $ticket)}}" class="btn btn-sm btn-info">مشاهده</a></td>

                                                </tr>

                               
                          
                        @endforeach
                                            </tbody>
                                        </table>
                       

                   


                </section>
            </main>
        </section>
    </section>
</section>
<!-- end body -->
@endsection