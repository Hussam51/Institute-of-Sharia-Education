@extends('layouts.master')
@section('css')
   
@section('title')
    الصفوف الدراسية
@stop
@endsection
@section('page-header')
<!-- breadcrumb -->
  الصفوف الدراسية  / تقارير الطلاب
@section('PageTitle')
    الصفوف الدراسية
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
                                <h3 style="color:blue"> Students Statistics Report</h3>
                                <div class="table-responsive">

                                    @foreach ($class_students as $class)
                                         <h4><i style="color: rgb(223, 58, 8)">Class :</i> {{ $class->name }}</h4>
                                       
                                    <table cellpadding="12" cellspacing="4" border="1" 
                                           data-page-length="100"
                                           style="text-align: center">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th> الاسم الاول  </th>
                                            <th> الاسم الاخير </th>
                                            <th> تاريخ الميلاد </th>
                                            <th>الهاتف</th>
                                            <th>الايميل</th>
                                          
                                            <th>  الحضور </th>
                                            <th> اجمالي الغياب </th>
                                            <th>  الغياب المبرر </th>
                                            <th>  الغياب الغير المبرر </th>
                                           

                                        </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $i=0;
                                            @endphp
                                        @foreach($class->students as $student)
                                        <?php $i++; ?>
                                            <tr>
                                            <td class="mr-3">{{ $i }}</td>
                                            <td class="mr-3">{{$student->first_name}}</td>
                                            <td class="mr-3">{{$student->last_name}}</td>
                                            <td class="mr-3">{{$student->data_birth}}</td>
                                            <td class="mr-3">{{$student->phone}}</td>
                                            <td class="mr-3">{{$student->email}}</td>
                                            <td class="mr-3">{{$student->attendances()->where('attendance_status',1)->count()}}</td>

                                            <td class="mr-3">{{$student->attendances()->where('attendance_status',0)->count()}}</td>
                                            <td class="mr-3">{{$student->attendances()->where('attendance_status',0)->whereNotNull('absent_reason')->count()}}</td>
                                            <td class="mr-3">{{$student->attendances()->where('attendance_status',0)->whereNull('absent_reason')->count();}}</td>

                                            </tr>
                                           <!-- delete_modal_Grade -->
                              
                                        @endforeach
                                    </table>
                                    <hr>
                                    @endforeach
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
    