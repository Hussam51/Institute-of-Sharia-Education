@extends('layouts.master')
@section('css')
    @toastr_css
@section('title')
    جدول دوام الطلاب
@stop
@endsection
@section('page-header')
<!-- breadcrumb -->
@section('PageTitle')
    جدول دوام الطلاب
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
                    إضافة جدول جديد
                </button>
                <br><br>

                <div class="table-responsive">
                    <p style="padding-right: 400px;background-color:chartreuse;"> برنامج دوام الفصل الاول</p>
                    <table id="datatable" class="table  table-hover table-sm table-bordered p-0" data-page-length="50"
                        style="text-align: center">
                        <thead>
                            <tr>

                                <th>#</th>
                                <th> اليوم</th>
                                <th>الحصة</th>
                                <th>المادة</th>
                                <th>العمليات</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 0; ?>

                            @foreach ($tables as $table)
                                @if ($table->term == 1)
                                    <tr>
                                        <?php $i++; ?>
                                        <td>{{ $i }}</td>
                                        <td>{{ $table->day }}</td>
                                        <td>{{ $table->session }}</td>
                                        <td>{{ $table->subject->name }}</td>

                                        <td>
                                           {{-- <button type="button" class="btn btn-info btn-sm" data-toggle="modal"
                                                data-target="#edit{{ $table->id }}" title="تعديل صف"><i
                                                    class="fa fa-edit"></i></button>
                                                    --}}
                                            <button type="button" class="btn btn-danger btn-sm" data-toggle="modal"
                                                data-target="#delete{{ $table->id }}" title="حذف صف"><i
                                                    class="fa fa-trash"></i></button>
                                        </td>
                                    </tr>
                                @endif





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
                                                            <label for="day" class="mr-sm-2"> اليوم
                                                                :</label>
                                                          <select name="day" class="form-control" id="day">
                                                            <option value="أحد" @selected($table->day=='أحد') >الاحد</option>
                                                            <option value="اثنين" @selected($table->day=='اثنين') >الاثنين</option>
                                                            <option value="ثلاثاء" @selected($table->day=='ثلاثاء')>الثلاثاء</option>
                                                            <option value="أربعاء" @selected($table->day=='أربعاء')>الاربعاء</option>
                                                            <option value="خميس" @selected($table->day=='خميس')>الخميس</option>
                                                          </select>
                                                            
                                                        </div>
            
                                                        <div class="col">
                                                            <label for="subject" class="mr-sm-2">إسم
                                                                المادة
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
                                                            <label for="session" c  lass="mr-sm-2"> الحصة
                                                                :</label>
            
                                                                <select name="الحصة" class="form-control" id="session">
                                                                    <option value="1" @selected($table->session==1) >الاولى </option>
                                                                    <option value="2" @selected($table->session==2)>الثانية</option>
                                                                    <option value="3" @selected($table->session==3)>الثالثة</option>
                                                                    <option value="4" @selected($table->session==4)>الرابعة</option>
                                                                    <option value="5" @selected($table->session==5)>الخامسة</option>
                                                                    <option value="6" @selected($table->session==6)>السادسة</option>
                                                                    <option value="7" @selected($table->session==7)>السابعة</option>
                                                                  </select>
                                                        </div>
            
                                                       
                                                            <input type="hidden" name="term" value="1">
                                                        
                                                       </div>
                                                    <br><br>
                                                    <input type="hidden" name="classroom_id" value="{{$classroom->id}}" />
                                                    <input type="hidden" name="department_id" value="{{$classroom->department_id}}" />
                                                
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
                                                    هل أنت متأكد من عملية حذف الصف ؟
                                                </h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route('dashboard.week_tables.destroy', $table->id) }}"
                                                    method="post">
                                                    {{ method_field('Delete') }}
                                                    @csrf

                                                    <input id="id" type="hidden" name="id"
                                                    
                                                        class="form-control" value="{{ $table->id }}">

                                                        <input type="hidden" name="classroom_id" value="{{$classroom->id}}" />
                                                    <input type="hidden" name="department_id" value="{{$classroom->department_id}}" />
                                                
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
                    <p style="padding-right: 400px;background-color:chartreuse;"> برنامج دوام الفصل الثاني</p>
                    <table id="datatable" class="table  table-hover table-sm table-bordered p-0"
                        data-page-length="50" style="text-align: center">
                        <thead>
                            <tr>

                                <th>#</th>

                                <th>اليوم</th>
                                <th> الحصة</th>
                                <th> المادة</th>
                              

                                <th>العمليات</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 0; ?>

                            @foreach ($tables as $table)
                                @if ($table->term == 2)
                                    <tr>
                                        <?php $i++; ?>
                                       
                                        <td>{{ $i }}</td>
                                        <td>{{ $table->day }}</td>
                                        <td>{{ $table->session }}</td>
                                        <td>{{ $table->subject->name }}</td>

                                        <td>
                                          {{--  <button type="button" class="btn btn-info btn-sm" data-toggle="modal"
                                                data-target="#edit{{ $table->id }}" title="تعديل صف"><i
                                                    class="fa fa-edit"></i></button>
                                                    --}}
                                            <button type="button" class="btn btn-danger btn-sm" data-toggle="modal"
                                                data-target="#delete{{ $table->id }}" title="حذف صف"><i
                                                    class="fa fa-trash"></i></button>
                                        </td>
                                    </tr>
                                @endif





                                <!-- edit_modal_table term 2 -->
                                <div class="modal fade" id="edit{{ $table->id }}" tabindex="-1" role="dialog"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title"
                                                    id="exampleModalLabel">
                                                    تعديل بيانات الصف
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

                                                      
                                                           <input type="hidden" name="term" value="2">
                                                        
            
                                                        <div class="col">
                                                            <label for="day" class="mr-sm-2"> اليوم
                                                                :</label>
                                                          <select name="day" class="form-control" id="day">
                                                            <option value="أحد" @selected($table->day=='أحد') >الاحد</option>
                                                            <option value="اثنين" @selected($table->day=='أربعاء') >الاثنين</option>
                                                            <option value="ثلاثاء" @selected($table->day=='أربعاء')>الثلاثاء</option>
                                                            <option value="أربعاء" @selected($table->day=='أربعاء')>الاربعاء</option>
                                                            <option value="خميس" @selected($table->day=='خميس')>الخميس</option>
                                                          </select>
                                                            
                                                        </div>
            
                                                        <div class="col">
                                                            <label for="subject" class="mr-sm-2">إسم
                                                                المادة
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
                                                            <label for="session" c  lass="mr-sm-2"> الحصة
                                                                :</label>
            
                                                                <select name="session" class="form-control" id="session">
                                                                    <option value="1" @selected($table->session==1) >الاولى </option>
                                                                    <option value="2" @selected($table->session==2)>الثانية</option>
                                                                    <option value="3" @selected($table->session==3)>الثالثة</option>
                                                                    <option value="4" @selected($table->session==4)>الرابعة</option>
                                                                    <option value="5" @selected($table->session==5)>الخامسة</option>
                                                                    <option value="6" @selected($table->session==6)>السادسة</option>
                                                                    <option value="7" @selected($table->session==7)>السابعة</option>
                                                                  </select>
                                                        </div>
            
                                                        
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
                                <div class="modal fade" id="delete{{ $table->id }}" tabindex="-1"
                                    role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title"
                                                    id="exampleModalLabel">
                                                    هل أنت متأكد من عملية الحذف  ؟
                                                </h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route('dashboard.week_tables.destroy', $table->id) }}"
                                                    method="post">
                                                    {{ method_field('Delete') }}
                                                    @csrf

                                                    <input id="id" type="hidden" name="id"
                                                        class="form-control" value="{{ $table->id }}">

                                                        <input type="hidden" name="classroom_id" value="{{$classroom->id}}" />
                                                        <input type="hidden" name="department_id" value="{{$classroom->department_id}}" />
                                                    
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
                        إضافة جدول للطلاب
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <form class=" row mb-30" action="{{ route('dashboard.week_tables.store') }}" method="POST">
                        @csrf
                        <div class="card-body">
                            <div class="repeater">
                                <div data-repeater-list="list_classes">
                                    <input type="hidden" name="classroom_id" value="{{$classroom->id}}" />
                                    <input type="hidden" name="department_id" value="{{$classroom->department_id}}" />
                                
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
                                                <label for="day" class="mr-sm-2"> اليوم
                                                    :</label>
                                              <select name="day" class="form-control" id="day">
                                                <option value="أحد" >الاحد</option>
                                                <option value="اثنين" >الاثنين</option>
                                                <option value="ثلاثاء" >الثلاثاء</option>
                                                <option value="أربعاء" >الاربعاء</option>
                                                <option value="خميس" >الخميس</option>
                                              </select>
                                                
                                            </div>

                                            <div class="col">
                                                <label for="subject" class="mr-sm-2">إسم
                                                    المادة
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
                                                <label for="session" class="mr-sm-2"> الحصة
                                                    :</label>

                                                    <select name="session" class="form-control" id="session">
                                                        <option value="1" >الاولى </option>
                                                        <option value="2" >الثانية</option>
                                                        <option value="3" >الثالثة</option>
                                                        <option value="4" >الرابعة</option>
                                                        <option value="5" >الخامسة</option>
                                                        <option value="6" >السادسة</option>
                                                        <option value="7" >السابعة</option>
                                                      </select>
                                            </div>

                                            <div class="col">
                                                <label for="Name_en" class="mr-sm-2">العمليات
                                                    :</label>
                                                <input class="btn btn-danger btn-block" data-repeater-delete
                                                    type="button" value="حذف الحقل" />
                                            </div>
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

                        <input type="hidden" name="classroom_id" value="{{$classroom->id}}" />
                        <input type="hidden" name="department_id" value="{{$classroom->department_id}}" />
                    
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
