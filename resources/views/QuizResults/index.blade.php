@extends('layouts.master')
@section('css')
    @toastr_css
@section('title')
    قائمة الدرجات

@stop
@endsection
@section('page-header')
<!-- breadcrumb -->
@section('PageTitle')
    قائمة الدرجات
@stop
<!-- breadcrumb -->
@endsection
@section('content')
<!-- row -->
<div class="row">
    <div class="container">
        <h3>نتائج الإختبارات</h3>
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
                        إضافة درجة جديدة
                    </button>
                    <br><br>

                    <div class="table-responsive">

                        <table id="datatable" class="table  table-hover table-sm table-bordered p-0"
                            data-page-length="50" style="text-align: center">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>الطالب</th>
                                    <th>الاختبار</th>
                                    <th>درجة الطالب</th>
                                    <th>العمليات</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 0; ?>

                                @foreach ($marks as $mark)
                                    <tr>
                                        <?php $i++; ?>
                                        <td>{{ $i }}</td>
                                        <td>{{ $mark->student->first_name . ' ' . $mark->student->last_name }}</td>
                                        <td>{{ $mark->quiz->type }}</td>
                                        <td>{{ $mark->student_mark }}</td>

                                        <td>
                                            <button type="button" class="btn btn-info btn-sm" data-toggle="modal"
                                                data-target="#edit{{ $mark->id }}" title="تعديل درجة"><i
                                                    class="fa fa-edit"></i></button>
                                            <button type="button" class="btn btn-danger btn-sm" data-toggle="modal"
                                                data-target="#delete_mark{{ $mark->id }}" title="حذف درجة "><i
                                                    class="fa fa-trash"></i></button>
                                        </td>
                                    </tr>






                                    <!-- edit_modal_table -->
                                    <div class="modal fade" id="edit{{ $mark->id }}" tabindex="-1" role="dialog"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title"
                                                        id="exampleModalLabel">
                                                        تعديل البيانات
                                                    </h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <!-- edit_form -->
                                                    <form
                                                        action="{{ route('dashboard.quiz_results.update', $mark->id) }}"
                                                        method="post">
                                                        {{ method_field('patch') }}
                                                        @csrf
                                                        <div class="card-body">
                                                            <div class="form-group">
                                                                <label for="quiz_id">الاختبار</label>
                                                                <select name="quiz_id" id="quiz_id"
                                                                    class="form-control">
                                                                    @foreach ($quizzes as $quiz)
                                                                        <option value="{{ $quiz->id }}" @selected($quiz->id==$mark->quiz_id)>
                                                                            {{ $quiz->type }}
                                                                            {{ $quiz->subject->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="student_id">الطالب</label>
                                                                <select name="student_id" id="student_id"
                                                                    class="form-control">
                                                                    @foreach ($students as $student)
                                                                        <option value="{{ $student->id }}" @selected($student->id==$mark->student_id)>
                                                                            {{ $student->first_name }}{{ $student->last_name }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="student_mark">الدرجة المستحقة</label>
                                                                <input type="number" name="student_mark"
                                                                    id="student_mark" class="form-control"
                                                                    step="0.1" value="{{old('student_mark',$mark->student_mark)}}">
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-dismiss="modal">إلغاء</button>
                                                                <button type="submit"
                                                                    class="btn btn-success">حفظ</button>
                                                            </div>
                                                        </div>
                                                       

                                                       
                                                    </form>

                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <!-- delete_modal_Grade -->
                                    <div class="modal fade" id="delete_mark{{ $mark->id }}" tabindex="-1"
                                        role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title"
                                                        id="exampleModalLabel">
                                                        هل أنت متأكد من حذف درجة الطالب
                                                        {{ $mark->student->first_name }} في
                                                        إختبار{{ $mark->quiz->type }}؟
                                                    </h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form
                                                        action="{{ route('dashboard.quiz_results.destroy', $mark->id) }}"
                                                        method="post">
                                                        {{ method_field('Delete') }}
                                                        @csrf
                                                        <input id="id" type="hidden" name="id"
                                                            class="form-control" value="{{ $mark->id }}">
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-dismiss="modal">إلغاء</button>
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
                        <br><br>


                    </div>
                </div>



            </div>

        </div>
        <!-- add_modal_table -->
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title" id="exampleModalLabel">
                            إضافة درجة جديدة
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <form class=" row mb-30" action="{{ route('dashboard.quiz_results.store') }}"
                            method="POST">
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="quiz_id">الاختبار</label>
                                    <select name="quiz_id" id="quiz_id" class="form-control">
                                        @foreach ($quizzes as $quiz)
                                            <option value="{{ $quiz->id }}">{{ $quiz->type }}
                                                {{ $quiz->subject->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="student_id">الطالب</label>
                                    <select name="student_id" id="student_id" class="form-control">
                                        @foreach ($students as $student)
                                            <option value="{{ $student->id }}">
                                                {{ $student->first_name }} <li></li> {{ $student->last_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="student_mark">الدرجة المستحقة</label>
                                    <input type="number" name="student_mark" id="student_mark" class="form-control"
                                        step="0.1">
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-dismiss="modal">إلغاء</button>
                                    <button type="submit" class="btn btn-success">حفظ</button>
                                </div>
                            </div>
                        </form>
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
