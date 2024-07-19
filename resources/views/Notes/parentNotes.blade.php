@extends('layouts.master')
@section('css')
    @toastr_css
@section('title')
   ملاحظات اولياء الأمور 
@stop
@endsection
@section('page-header')
<h3 style="color: blue"> ملاحظات اولياء الأمور 
  
</h3>
<!-- breadcrumb -->
@section('PageTitle')
                          ملاحظات اولياء الأمور 
 
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
                           
                            <div class="table-responsive">
                                <table  class="table  table-hover table-sm table-bordered p-0"
                                    data-page-length="50" style="text-align: center">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th> ولي الأمر</th>
                                            <th >تاريخ الإرسال </th>
                                            <th>الملاحظة </th>
                                           
                                           
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($parent_notes as $P_note)
                                            <tr id="{{ $P_note->id }}">
                                                <td>{{ $P_note->id }}</td>
                                                <td>{{ $P_note->parent->first_name.' '.$P_note->parent->last_name }}</td>
                                                <td>{{ $P_note->sent_at }}</td>
                                                <td >{{ $P_note->note }}</td>
                                               
                                               
                                               
                                            </tr>
                                        @endforeach
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
