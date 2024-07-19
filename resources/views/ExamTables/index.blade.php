@extends('layouts.master')
@section('css')
    @toastr_css
@section('title')
    الامتحانات  
@stop
@endsection
@section('page-header')
<!-- breadcrumb -->
@section('PageTitle')
     الامتحانات 
@stop
<!-- breadcrumb -->
@endsection
@section('content')
<!-- row -->
<div class="row">

    <div class="col-xl-12 mb-30">
        <div class="card card-statistics h-100">
            <div class="card-body">

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <button style="background-color: rgb(59, 59, 247)" type="button" class="button x-small fa fa-plus"
                    data-toggle="modal" data-target="#exampleModal">
                    إضافة امتحان جديد
                </button>
                <br><br>

                <div class="table-responsive">
                    <p style="padding-right: 400px;background-color:chartreuse;"> برنامج الامتحان</p>
                    <table id="datatable" class="table  table-hover table-sm table-bordered p-0" data-page-length="50"
                        style="text-align: center">
                        <thead>
                            <tr>

                                <th>#</th>
                                <th>الفصل</th>
                                <th> التاريخ</th>
                                <th>الامتحان</th>
                                <th>المدة</th>
                                <th>العمليات</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 0; ?>

                            @foreach ($tables as $table)
                               
                                    <tr>
                                        <?php $i++; ?>
                                        <td>{{ $i }}</td>
                                        <td>{{ $table->term }}</td>
                                        <td>{{ $table->exam_date }}</td>
                                        <td>{{ $table->subject->name }}</td>
                                         <td>{{ $table->exam_duration }}</td>

                                        <td>
                                            <button type="button" class="btn btn-info btn-sm" data-toggle="modal"
                                                data-target="#edit{{ $table->id }}" title="تعديل صف"><i
                                                    class="fa fa-edit"></i></button>
                                            <button type="button" class="btn btn-danger btn-sm" data-toggle="modal"
                                                data-target="#delete{{ $table->id }}" title="حذف صف"><i
                                                    class="fa fa-trash"></i></button>
                                        </td>
                                    </tr>
                              





                                <!-- edit_modal_table -->
                                <div class="modal fade" id="edit{{ $table->id }}" tabindex="-1" role="dialog"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title"
                                                    id="exampleModalLabel">
                                                    تعديل بيانات الجدول
                                                </h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <!-- edit_form -->
                                                <form action="{{ route('dashboard.week_tables.update', $table->id) }}"
                                                    method="post">
                                                    {{ method_field('patch') }}
                                                    @csrf
                                                    <div class="row">

                                                       
            
                                                      
            
                                                        <div class="col">
                                                            <label for="subject" class="mr-sm-2">
                                                                الامتحان
                                                                :</label>
                                                            <select  name="subject_id" id="subject" class="form-control">
                                                                @foreach ($classroom->subjects as $subject)
                                                                    <option value="{{ $subject->id }}" @selected($table->subject_id==$subject->id)>
                                                                        {{ $subject->name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
            
                                                        <div class="col">
                                                            <label for="term" class="mr-sm-2">الفصل
                                                                :</label>
            
            
                                                            <select name="term" id="term" class="form-control">
            
                                                                <option value="1" @selected($table->term==1)>
                                                                    الفصل الأول
                                                                </option>
                                                                <option value="2"  @selected($table->term==2)>
                                                                    الفصل الثاني
                                                                </option>
            
                                                            </select>
            
                                                        </div>
                                                       
                                                       
            
            
            
                                                        <div class="col">
                                                            <label for="exam_duration" class="mr-sm-2">
                                                                المدة
                                                                :</label>
                                                                <input type="number" name="exam_duration" value="{{old('exam_duration',$table->exam_duration)}}" />
                                                        </div>
                                                        <div class="col">
                                                            <label for="exam_date" class="mr-sm-2">
                                                                التاريخ
                                                                :</label>
                                                                <input type="datetime-local" name="exam_date" value="{{old('exam_date',$table->exam_date)}}" />
                                                        </div>
                                                       
                                                       
                                                            <input type="hidden" name="term" value="1">
                                                        
                                                        <input type="hidden" name="classroom_id" value="{{$classroom->id}}" />
                                                        <input type="hidden" name="department_id" value="{{$classroom->department_id}}" />
                                                    </div>
                                                    <br><br>

                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">إغلاق</button>
                                                        <button type="submit" class="btn btn-success">حفظ</button>
                                                    </div>
                                                </form>

                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <!-- delete_modal_Grade -->
                                <div class="modal fade" id="delete{{ $table->id }}" tabindex="-1" role="dialog"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title"
                                                    id="exampleModalLabel">
                                                   هل أنت متأكد من عملية حذف امتحان  {{$table->subject->name}}؟ 
                                                </h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route("dashboard.exam_tables.destroy", $table->id) }}"
                                                    method="post">
                                                    {{ method_field('Delete') }}
                                                    @csrf

                                                    <input id="id" type="hidden" name="id"
                                                        class="form-control" value="{{ $table->id }}">
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">الغاء</button>
                                                        <button type="submit" class="btn btn-danger">تأكيد</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </tbody>
                    </table>
                    <br><br>
                  

                </div>
            </div>



        </div>

    </div>
    <!-- add_modal_table -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title" id="exampleModalLabel">
                     إضافة امتحان جديد
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <form class=" row mb-30" action="{{ route('dashboard.exam_tables.store') }}" method="POST">
                        @csrf
                        <div class="card-body">
                            <div class="repeater">
                                <div data-repeater-list="list_classes">
                                    <div data-repeater-item>
                                        <div class="row">

                                            <div class="col">
                                                <label for="term" class="mr-sm-2">الفصل
                                                    :</label>


                                                <select name="term" id="term" class="form-control">

                                                    <option value="1">
                                                        الفصل الأول
                                                    </option>
                                                    <option value="2">
                                                        الفصل الثاني
                                                    </option>

                                                </select>

                                            </div>

                                          

                                            <div class="col">
                                                <label for="subject" class="mr-sm-2">إسم
                                                    الامتحان
                                                    :</label>
                                                <select  name="subject_id" id="subject" class="form-control">
                                                    @foreach ($classroom->subjects as $subject)
                                                        <option value="{{ $subject->id }}">
                                                            {{ $subject->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                          
                                            <div class="col">
                                                <label for="exam_date" class="mr-sm-2">
                                                    التاريخ
                                                    :</label>
                                                    <input type="datetime-local" name="exam_date" />
                                            </div>



                                            <div class="col">
                                                <label for="exam_duration" class="mr-sm-2">
                                                    المدة
                                                    :</label>
                                                    <input type="number" name="exam_duration" />
                                            </div>


                                            <div class="col">
                                                <label for="Name_en" class="mr-sm-2">العمليات
                                                    :</label>
                                                <input class="btn btn-danger btn-block" data-repeater-delete
                                                    type="button" value="حذف الحقل" />
                                            </div>
                                            <input type="hidden" name="classroom_id" value="{{$classroom->id}}" />
                                            <input type="hidden" name="department_id" value="{{$classroom->department_id}}" />
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-20">
                                    <div class="col-12">
                                        <input class="button" data-repeater-create type="button"
                                            value="إضافة حقل جديد" />
                                    </div>

                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-dismiss="modal">إلغاء</button>
                                    <button type="submit" class="btn btn-success">حفظ</button>
                                </div>


                            </div>
                        </div>
                    </form>
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
