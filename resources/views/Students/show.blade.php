@extends('layouts.master')
@section('css')
    @toastr_css
@section('title')
    معلومات الطالب 
@stop
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <h3 style="color:blue">    معلومات الطالب 
    </h3>
@section('PageTitle')
معلومات الطالب 
@stop
<!-- breadcrumb -->
@endsection
@section('content')
    <!-- row -->
    <div class="row">
        <div class="col-md-12 mb-30">
            <div class="card card-statistics h-100">
                <div class="card-body">
                    <div class="col-xl-12 mb-30">
                        <div class="card card-statistics h-100">
                            <div class="card-body">
                               
                                   <br>
                                <div class="table-responsive">
                                    <table id="datatable" class="table  table-hover table-sm table-bordered p-0"
                                           data-page-length="50"
                                           style="text-align: center">
                                       
                                        <tbody>
                                           
                                            <tr>
                                            
                                                <th>الاسم الاول </th>
                                                <td>{{$student->first_name}}</td>
                                            </tr>
                                            <tr>
    
                                                <th>الاسم الاخير</th>
                                                <td>{{$student->last_name}}</td>
    
                                            </tr>
                                            <tr>
    
                                                <th>تاريخ الميلاد</th>
                                                <td>{{$student->data_birth}}</td>
                                            </tr>
                                            <tr>
    
                                                <th>الهاتف</th>
                                                <td>{{$student->phone}}</td>
                                            </tr>
                                            <tr>
    
                                                <th>الايميل</th>
                                                <td>{{$student->email}}</td>
                                            </tr>
                                            <tr>
    
                                                <th>الصف</th>
                                                <td>{{$student->classroom->name}}</td>
    
                                            </tr>
                                            <tr>
    
                                                <th>الصورة الشخصية</th>
                                                <td><img src="{{ $student->getImageUrl() }}" alt="Student Image" height="120px" width="120px"></td>
                                            </tr>
                                            <tr>
                                                <th>تاريخ الانتساب</th>
                                                <td>{{$student->created_at}}</td>
                                             
                                            </tr>
                                        </tbody>
                           
                                    </table>
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
    @toastr_js
    @toastr_render
@endsection
