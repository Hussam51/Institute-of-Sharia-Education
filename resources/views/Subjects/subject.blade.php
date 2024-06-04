@extends('layouts.master')
@section('css')
    @toastr_css
@section('title')
    المواد الدراسية
@stop
@endsection
@section('page-header')
<!-- breadcrumb -->
@section('PageTitle')
    المواد الدراسية

@stop
<!-- breadcrumb -->
@endsection
@section('content')
<!-- row -->
<div class="row">


    @if ($errors->any())
        <div class="error">{{ $errors->first('name') }}</div>
    @endif



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
                    اضافة مادة جديدة
                </button>
                <br><br>

                <div class="table-responsive">
                    <table id="datatable" class="table  table-hover table-sm table-bordered p-0" data-page-length="50"
                        style="text-align: center">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>اسم المادة</th>
                                <th>الصف الدراسي </th>
                                <th>العمليات</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 0; ?>
                            @foreach ($subjects as $subject)
                                <tr>
                                    <?php $i++; ?>
                                    <td>{{ $i }}</td>
                                    <td>{{ $subject->name }}</td>
                                    <td>{{ $subject->classroom->name }}</td>

                                    <td>
                                        <button type="button" class="btn btn-info btn-sm" data-toggle="modal"
                                            data-target="#edit{{ $subject->id }}" title="تعديل"><i
                                                class="fa fa-edit"></i></button>
                                        <button type="button" class="btn btn-danger btn-sm" data-toggle="modal"
                                            data-target="#delete{{ $subject->id }}" title="حذف"><i
                                                class="fa fa-trash"></i></button>
                                    </td>
                                </tr>

                                <!-- edit_modal_department -->
                                <div class="modal fade" id="edit{{ $subject->id }}" tabindex="-1" role="dialog"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title"
                                                    id="exampleModalLabel">
                                                    تعديل معلومات المادة
                                                </h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <!-- add_form -->
                                                <form action="{{ route('dashboard.subjects.update', $subject->id) }}"
                                                    method="post">
                                                    {{ method_field('patch') }}
                                                    @csrf
                                                    <div class="row">
                                                        <div class="col">
                                                            <label for="Name" class="mr-sm-2">إسم المادة
                                                                :</label>
                                                            <input id="Name" type="text" name="name"
                                                                class="form-control"
                                                                value="{{ old('name', $subject->name) }}" required>
                                                            <input id="id" type="hidden" name="id"
                                                                class="form-control" value="{{ $subject->id }}">
                                                        </div>

                                                    </div>
                                                    <div class="form-group">
                                                        <label for="Classroom_id">
                                                          select classroom  :</label>
                                                        <select class="form-control" name="classroom_id"
                                                            id="Classroom_id" rows="3">
                                                            @foreach ($classrooms as $classroom)

                                                            <option value="{{$classroom->id}}" @selected($subject->classroom_id==$classroom->id)> {{ $subject->classroom->name }}</option>
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
                                <div class="modal fade" id="delete{{ $subject->id }}" tabindex="-1" role="dialog"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title"
                                                    id="exampleModalLabel">
                                                    هل أنت متأكد من حذف المادة ؟
                                                </h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form
                                                    action="{{ route('dashboard.subjects.destroy', $subject->id) }}"
                                                    method="post">
                                                    {{ method_field('Delete') }}
                                                    @csrf
                                                    <input id="id" type="hidden" name="id"
                                                        class="form-control" value="{{ $subject->id }}">
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



    <!-- add_modal_department -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title" id="exampleModalLabel">
                        اضافة مادة جديدة
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- add_form -->
                    <form action="{{ route('dashboard.subjects.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col">
                                <label for="Name" class="mr-sm-2">اسم المادة
                                    :</label>
                                <input id="Name" type="text" name="name" class="form-control">
                            </div>

                        </div>
                        <div class="form-group">
                            <label for="Classroom_id">
                                select classroom  :</label>
                              <select class="form-control" name="classroom_id"
                                  id="Classroom_id" rows="3">
                                  @foreach ($classrooms as $classroom)

                                  <option value="{{$classroom->id}}"> {{ $classroom->name }}</option>
                                  @endforeach
                              </select>
                        </div>
                        <br><br>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">إغلاق</button>
                    <button type="submit" class="btn btn-success">حفظ</button>
                </div>
                </form>

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
