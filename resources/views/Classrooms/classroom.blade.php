@extends('layouts.master')
@section('css')
    @toastr_css
@section('title')
    الصفوف الدراسية
@stop
@endsection
@section('page-header')
<!-- breadcrumb -->
@section('PageTitle')
    الصفوف الدراسية
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

                <button type="button" class="button x-small" data-toggle="modal" data-target="#exampleModal">
                    إضافة صف جديد
                </button>
                <br><br>

                <div class="table-responsive">
                  {{--  <form action="{{ route('dashboard.classrooms.delete-checked') }}" method="POST"
                        id="deleteCheckedForm">
                        @csrf
                     --}}
                        <table id="datatable" class="table  table-hover table-sm table-bordered p-0"
                            data-page-length="50" style="text-align: center">
                            <thead>
                                <tr>
                                   {{-- <th>حذف الصفوف المحددة</th>--}}
                                    <th>#</th>
                                    <th>إسم الصف</th>
                                    <th>القسم</th>
                                    <th>العمليات</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 0; ?>

                                @foreach ($classrooms as $classroom)
                                    <tr>
                                        <?php $i++; ?>
                                       {{-- <td>
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input"
                                                    id="classroom_{{ $classroom->id }}" name="classrooms[]"
                                                    value="{{ $classroom->id }}">
                                                <label class="custom-control-label"
                                                    for="classroom_{{ $classroom->id }}"></label>
                                            </div>
                                            
                                        </td> --}}
                                        <td>{{ $i }}</td>
                                        <td>{{ $classroom->name }}</td>
                                        <td>{{ $classroom->department->name }}</td>
                                        <td>
                                            <button type="button" class="btn btn-info btn-sm" data-toggle="modal"
                                                data-target="#edit{{ $classroom->id }}" title="تعديل صف"><i
                                                    class="fa fa-edit"></i></button>
                                            <button type="button" class="btn btn-danger btn-sm" data-toggle="modal"
                                                data-target="#delete{{ $classroom->id }}" title="حذف صف"><i
                                                    class="fa fa-trash"></i></button>
                                        </td>
                                    </tr>




                                    <!-- edit_modal_classroom -->
                                    <div class="modal fade" id="edit{{ $classroom->id }}" tabindex="-1" role="dialog"
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
                                                    <form
                                                        action="{{ route('dashboard.classrooms.update', $classroom->id) }}"
                                                        method="post">
                                                        {{ method_field('patch') }}
                                                        @csrf
                                                        <div class="row">
                                                            <div class="col">
                                                                <label for="Name" class="mr-sm-2">إسم الصف
                                                                    :</label>
                                                                <input id="Name" type="text" name="name"
                                                                    class="form-control"
                                                                    value="{{ old('name', $classroom->name) }}"
                                                                    required>
                                                                <input id="id" type="hidden" name="id"
                                                                    class="form-control" value="{{ $classroom->id }}">
                                                            </div>

                                                        </div><br>
                                                        <div class="form-group">
                                                            <label for="exampleFormControlTextarea1">القسم
                                                                :</label>
                                                            <select class="form-control form-control-lg"
                                                                id="exampleFormControlSelect1" name="department_id">


                                                                @foreach ($departments as $department)
                                                                    <option value="{{ $department->id }}"
                                                                        @selected($classroom->department_id == $department->id)>
                                                                        {{ $department->name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>

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
                                    <div class="modal fade" id="delete{{ $classroom->id }}" tabindex="-1"
                                        role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                                    <form
                                                        action="{{ route('dashboard.classrooms.destroy', $classroom->id) }}"
                                                        method="post">
                                                        {{ method_field('Delete') }}
                                                        @csrf

                                                        <input id="id" type="hidden" name="id"
                                                            class="form-control" value="{{ $classroom->id }}">
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-dismiss="modal">الغاء</button>
                                                            <button type="submit"
                                                                class="btn btn-danger">تأكيد</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </tbody>
                        </table>
                    {{--    <button type="submit" class="btn btn-danger btn-sm"><i
                            class="fa fa-trash"></i> Delete Selected</button>
                    </form>
                   --}}

                </div>
            </div>



        </div>

    </div>
    <!-- add_modal_classroom -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title" id="exampleModalLabel">
                        إضافة صف جديد
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <form class=" row mb-30" action="{{ route('dashboard.classrooms.store') }}" method="POST">
                        @csrf
                        <div class="card-body">
                            <div class="repeater">
                                <div data-repeater-list="list_classes">
                                    <div data-repeater-item>
                                        <div class="row">

                                            <div class="col">
                                                <label for="Name" class="mr-sm-2">إسم
                                                    الصف
                                                    :</label>
                                                <input class="form-control" type="text" name="name" />
                                            </div>

                                            <div class="col">
                                                <label for="Name_en" class="mr-sm-2">القسم
                                                    :</label>

                                                <div class="box">
                                                    <select class="fancyselect" name="department_id">
                                                        @foreach ($departments as $department)
                                                            <option value="{{ $department->id }}">
                                                                {{ $department->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>

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
