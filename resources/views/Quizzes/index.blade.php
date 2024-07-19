@extends('layouts.master')
@section('css')
    @toastr_css
@section('title')
      قائمة الاختبارات
@stop
@endsection
@section('page-header')
    <!-- breadcrumb -->
@section('PageTitle')
      قائمة الاختبارات
@stop
<!-- breadcrumb -->
@endsection
@section('content')
    <!-- row -->
    <div class="row">
        <div class="container">
            <h1>Quizzes</h1>
            <a href="{{ route('dashboard.quizzes.create') }}" class="btn btn-primary mb-3"> إضافة اختبار </a>
            <table class="table">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>المادة</th>
                    <th>الصف</th>
                    <th>الدرجة الصغرى </th>
                    <th>الدرجة العظمى </th>
                    <th>نوع الاختبار</th>
                    <th> العمليات</th>
                </tr>
                </thead>
                <tbody>
                @foreach($quizzes as $quizz)
                    <tr>
                        <td>{{ $quizz->id }}</td>
                        <td>{{ $quizz->subject->name }}</td>
                        <td>{{ $quizz->classroom->name }}</td>
                        <td>{{ $quizz->min_mark }}</td>
                        <td>{{ $quizz->max_mark }}</td>
                        <td>
                            <a href="{{ route('dashboard.quiz_marks', ['classroom_id' => $quizz->classroom->id, 'quiz_id' => $quizz->id]) }}">
                                {{ $quizz->type }}
                            </a>
                        </td>
                        <td>
                            <a href="{{route('dashboard.quizzes.edit',$quizz->id)}}" class="btn btn-info btn-sm" role="button" aria-pressed="true"><i class="fa fa-edit"></i></a>
                                                    <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#delete_quizz{{ $quizz->id }}" title="حذف اختبار "><i class="fa fa-trash"></i></button>
                                                    <a href="{{route('dashboard.quizzes.show',$quizz->id)}}" class="btn btn-warning btn-sm" role="button" aria-pressed="true"><i class="fa fa-eye"></i></a>
                        </td>
                    </tr>

                    <div class="modal fade" id="delete_quizz{{ $quizz->id }}" tabindex="-1"
                        role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title"
                                        id="exampleModalLabel">
                                        هل أنت متأكد من حذف الإختبار ؟
                                    </h5>
                                    <button type="button" class="close" data-dismiss="modal"
                                        aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ route('dashboard.quizzes.destroy', $quizz->id) }}"
                                        method="post">
                                        {{ method_field('Delete') }}
                                        @csrf
                                        <input id="id" type="hidden" name="id"
                                            class="form-control" value="{{ $quizz->id }}">
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
                </tbody>
            </table>
        </div>
    </div>
    <!-- row closed -->
@endsection
@section('js')
    @toastr_js
    @toastr_render
@endsection
