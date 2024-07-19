@extends('layouts.master')
@section('css')
    @toastr_css
@section('title')
    برنامج مراقبة المعلمين
@stop
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <h4 style="color: blue">        برنامج مراقبة المعلمين
 
  
    </h4>
@section('PageTitle')
برنامج مراقبة المعلمين
 
     
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
                                <a href="{{route('dashboard.teacher_monitorings.create')}}" class="btn btn-success btn-sm" role="button"
                                   aria-pressed="true">اضافة مراقبة </a><br><br>
                                   @foreach ($teachers as $teacher)
                                       
                                   <h5 > الاستاذ: {{$teacher->first_name.' '.$teacher->last_name}}</h5>
                                <div class="table-responsive">
                                    <table id="datatable" class="table  table-hover table-sm table-bordered p-0"
                                           data-page-length="50"
                                           style="text-align: center">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th> القاعة الامتحانية  </th>
                                            <th> المعلم</th>
                                            <th> التاريخ</th>
                                            <th>تبدء المراقبة</th>
                                            <th> تنتهي المراقبة</th>
                                            <th>العمليات </th>

                                        </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $i=0;
                                            @endphp
                                        @foreach($monitorings as $monitoring)
                                        @if($teacher->id==$monitoring->teacher->id)

                                        <?php $i++; ?>
                                            <tr>
                                            <td>{{$i}}</td>
                                            <td>{{$monitoring->hall}}</td>
                                            <td>{{$monitoring->teacher->first_name.' '.$monitoring->teacher->last_name}}</td>
                                            <td>{{$monitoring->date}}</td>
                                            <td>{{$monitoring->start_time}}</td>
                                            <td>{{$monitoring->end_time}}</td>
                                         
                                          
                                            
                                           
                                          
                                            
                                                <td>
                                                    <a href="{{route('dashboard.teacher_monitorings.edit',$monitoring->id)}}" class="btn btn-info btn-sm" role="button" aria-pressed="true"><i class="fa fa-edit"></i></a>
                                                    <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#delete_student{{ $monitoring->id }}" title="حذف طالب "><i class="fa fa-trash"></i></button>
                                                    {{--<a href="#" class="btn btn-warning btn-sm" role="button" aria-pressed="true"><i class="fa fa-eye"></i></a>--}}
                                                </td>
                                            </tr>
                                           <!-- delete_modal_Grade -->
                                <div class="modal fade" id="delete_student{{ $monitoring->id }}" tabindex="-1"
                                    role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title"
                                                    id="exampleModalLabel">
                                                     هل أنت متأكد من حذف مراقبة الاستاذ   {{$monitoring->teacher->first_name.' '.$monitoring->teacher->last_name}} ؟
                                                </h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route('dashboard.teacher_monitorings.destroy', $monitoring->id) }}"
                                                    method="post">
                                                    {{ method_field('Delete') }}
                                                    @csrf
                                                    <input id="id" type="hidden" name="id"
                                                        class="form-control" value="{{ $monitoring->id }}">
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">إلغاء</button>
                                                        <button type="submit" class="btn btn-danger">تأكيد</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif
                                        @endforeach
                                    </table>
                                </div>
                                @endforeach
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
