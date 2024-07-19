@extends('layouts.master')
@section('css')
    @toastr_css
@section('title')
    اضافةدرجةطالب جديدة
@stop
@endsection
@section('page-header')
<!-- breadcrumb -->
@section('PageTitle')
    اضافةدرجةطالب جديدة
@stop
<!-- breadcrumb -->
@endsection
@section('content')
<!-- row -->
<div class="row">
    <div class="container">
        <h1>    اضافةدرجةطالب جديدة
        </h1>
        <form action="{{ route('dashboard.quiz_results.store') }}" method="post">
            @csrf
            <div class="form-group">
                <label for="subject_id">الاختبار</label>
                <select name="subject_id" id="subject_id" class="form-control">
                    @foreach($quizzes as $quiz)
                        <option value="{{ $quiz->id }}">{{ $quiz->type }} {{$quiz->subject}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="classroom_id">الطالب</label>
                <select name="classroom_id" id="classroom_id" class="form-control">
                    @foreach($students as $student)
                        <option value="{{ $student->id }}">{{ $student->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="min_mark">الدرجة المستحقة</label>
                <input type="number" name="student_mark" id="min_mark" class="form-control" step="0.1">
            </div>
       
            <button type="submit" class="btn btn-primary">حفظ</button>
        </form>
    </div>
</div>
<!-- row closed -->
@endsection
@section('js')
@toastr_js
@toastr_render




@endsection
