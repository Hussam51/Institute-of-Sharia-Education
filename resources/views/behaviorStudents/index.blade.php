@extends('layouts.master')
@section('css')
    @toastr_css
@section('title')
    سلوك الطلاب
@stop
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <h4 style="color: blue">  سلوك الطلاب  
    </h4>
@section('PageTitle')
  سلوك الطلاب  
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
                                <a href="{{route('dashboard.behaviors.create')}}" class="btn btn-success btn-sm" role="button"
                                   aria-pressed="true">اضافة سلوك طالب </a><br><br>
                                <div class="table-responsive">
                                    <table id="datatable" class="table  table-hover table-sm table-bordered p-0"
                                           data-page-length="50"
                                           style="text-align: center">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>الطالب  </th>
                                            <th>حالة السلوك </th>
                                            <th>الملاحظة</th>
                                            <th>ارسلت في</th>
                                            <th>العمليات </th>

                                        </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $i=0;
                                            @endphp
                                        @foreach($behaviors as $behavior)
                                        <?php $i++; ?>
                                            <tr>
                                            <td>{{ $i }}</td>
                                           
                                            <td>{{$behavior->student->first_name.' '.$behavior->student->last_name}}</td>
                                            <td>{{$behavior->type}}</td>
                                            <td>{{$behavior->note}}</td>
                                            <td>{{$behavior->sent_at}}</td>
                                           
                                          
                                            
                                                <td>
                                                    <a href="{{route('dashboard.behaviors.edit',$behavior->id)}}" class="btn btn-info btn-sm" role="button" aria-pressed="true"><i class="fa fa-edit"></i></a>
                                                    <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#delete_student{{ $behavior->id }}" title="حذف طالب "><i class="fa fa-trash"></i></button>
                                                    {{--<a href="#" class="btn btn-warning btn-sm" role="button" aria-pressed="true"><i class="fa fa-eye"></i></a>--}}
                                                </td>
                                            </tr>
                                           <!-- delete_modal_Grade -->
                                <div class="modal fade" id="delete_student{{ $behavior->id }}" tabindex="-1"
                                    role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title"
                                                    id="exampleModalLabel">
                                                    هل أنت متأكد من حذف سلوك الطالب {{$behavior->student->first_name.' '.$behavior->student->last_name}} ؟
                                                </h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route('dashboard.behaviors.destroy', $behavior->id) }}"
                                                    method="post">
                                                    {{ method_field('Delete') }}
                                                    @csrf
                                                    <input id="id" type="hidden" name="id"
                                                        class="form-control" value="{{ $behavior->id }}">
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
