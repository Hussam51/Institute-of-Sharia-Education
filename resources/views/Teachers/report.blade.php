@extends('layouts.master')
@section('css')
   
@section('title')
تقرير الحضور @stop
@endsection
@section('page-header')
<!-- breadcrumb -->
  ادارة المعلمين   /  تقارير الحضور
@section('PageTitle')
تقرير الحضور
@stop
<!-- breadcrumb -->
@endsection
@section('content')
<!-- row -->
<div class="row" >
        <div class="col-md-12 mb-30">
            <div class="card card-statistics h-100">
                <div class="card-body">
                    <div class="col-xl-12 mb-30">
                        <div class="card card-statistics h-100">
                            <div class="card-body">
                                <h5 style="color:blue"> تقرير احصائيات الحضور والغياب</h5>
                                <br>
                                <div class="table-responsive">

                                       
                                    <table cellpadding="12" cellspacing="4" border="1" 
                                           data-page-length="100"
                                           style="text-align: center">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th> الاسم الاول  </th>
                                            <th> الاسم الاخير </th>
                                            <th>الهاتف</th>
                                            <th>الايميل</th>
                                          
                                            <th>  الحضور </th>
                                            <th> اجمالي الغياب </th>


                                        </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $i=0;
                                            @endphp
                                        @foreach($teachers as $teacher)
                                        <?php $i++; ?>
                                            <tr>
                                            <td class="mr-3">{{ $i }}</td>
                                            <td class="mr-3">{{$teacher->first_name}}</td>
                                            <td class="mr-3">{{$teacher->last_name}}</td>
                                            <td class="mr-3">{{$teacher->phone}}</td>
                                            <td class="mr-3">{{$teacher->email}}</td>

                                            <td class="mr-3">{{$teacher->attendances()->where('attendance_status',1)->count()}}</td>

                                            <td class="mr-3">{{$teacher->attendances()->where('attendance_status',0)->count()}}</td>
                                          
                                            </tr>
                                           <!-- delete_modal_Grade -->
                              
                                        @endforeach
                                    </table>
                                    <hr>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- row closed -->
    @endsection
    @section('js')
    
 
    @endsection
    