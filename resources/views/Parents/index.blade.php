@extends('layouts.master')
@section('css')
    @toastr_css
@section('title')
    قائمة أولياء الأمور
@stop
@endsection
@section('page-header')
    <!-- breadcrumb -->
@section('PageTitle')
   قائمة أولياء الأمور
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
                                <a href="{{route('dashboard.parents.create')}}" class="btn btn-success btn-sm" role="button"
                                   aria-pressed="true">اضافة ولي الأمر</a><br><br>
                                <div class="table-responsive">
                                    <table id="datatable" class="table  table-hover table-sm table-bordered p-0"
                                           data-page-length="50"
                                           style="text-align: center">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>الاسم الاول </th>
                                            <th>الاسم الاخير</th>
                                            <th>الهاتف</th>
                                            <th>الايميل</th>
                                            <th>الطالب</th>
                                            <th>الصورة الشخصية</th>
                                            <th>العمليات </th>

                                        </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $i=0;
                                            @endphp
                                        @foreach($parents as $parent)
                                        <?php $i++; ?>
                                            <tr>
                                            <td>{{ $i }}</td>
                                            <td>{{$parent->first_name}}</td>
                                            <td>{{$parent->last_name}}</td>
                                           
                                            <td>{{$parent->phone}}</td>
                                            <td>{{$parent->email}}</td>
                                            <td>{{$parent->student->first_name}}</td>
                                            <td><img src="{{ $parent->getImageUrl() }}" alt="Student Image" height="60px" width="60px"></td>
                                            
                                                <td>
                                                    <a href="{{route('dashboard.parents.edit',$parent->id)}}" class="btn btn-info btn-sm" role="button" aria-pressed="true"><i class="fa fa-edit"></i></a>
                                                    <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#delete_student{{ $parent->id }}" title="حذف طالب "><i class="fa fa-trash"></i></button>
                                                    <a href="#" class="btn btn-warning btn-sm" role="button" aria-pressed="true"><i class="fa fa-eye"></i></a>
                                                </td>
                                            </tr>
                                           <!-- delete_modal_Grade -->
                                <div class="modal fade" id="delete_student{{ $parent->id }}" tabindex="-1"
                                    role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title"
                                                    id="exampleModalLabel">
                                                    هل أنت متأكد من حذف ولي الأمر ؟
                                                </h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route('dashboard.parents.destroy', $parent->id) }}"
                                                    method="post">
                                                    {{ method_field('Delete') }}
                                                    @csrf
                                                    <input id="id" type="hidden" name="id"
                                                        class="form-control" value="{{ $parent->id }}">
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
