@extends('layouts.master')
@section('css')
    @toastr_css
@section('title')
    تعديل  درجة الطالب

@stop
@endsection
@section('page-header')
<!-- breadcrumb -->
@section('PageTitle')
    تعديل  درجة الطالب
@stop
<!-- breadcrumb -->
@endsection
@section('content')
<!-- row -->
<div class="row">
    <div class="container">
        <h1>تعديل تفاصيل الاختبار</h1>
        <form action="{{ route('dashboard.quizzes.update', $quizz->id) }}" method="post">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="subject_id">المادة</label>
                <select name="subject_id" id="subject_id" class="form-control">
                    @foreach($subjects as $subject)
                        <option value="{{ $subject->id }}" {{ $quizz->subject_id == $subject->id ? 'selected' : '' }}>{{ $subject->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="classroom_id">الصف</label>
                <select name="classroom_id" id="classroom_id" class="form-control">
                    @foreach($classrooms as $classroom)
                        <option value="{{ $classroom->id }}" {{ $quizz->classroom_id == $classroom->id ? 'selected' : '' }}>{{ $classroom->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="min_mark">الدرجة الصغرى </label>
                <input type="number" name="min_mark" id="min_mark" class="form-control" value="{{ $quizz->min_mark }}" step="0.1">
            </div>
            <div class="form-group">
                <label for="max_mark">الدرجة العظمى </label>
                <input type="number" name="max_mark" id="max_mark" class="form-control" value="{{ $quizz->max_mark }}" step="0.1">
            </div>
            <div class="form-group">
                <label for="type">نوع الإختبار</label>
                <select name="type" id="type" class="form-control">
                    @foreach($types as $type)
                        <option value="{{ $type }}" {{ $quizz->type == $type ? 'selected' : '' }}>{{ $type }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary">تحديث </button>
        </form>
    </div>
</div>
<!-- row closed -->
@endsection
@section('js')
@toastr_js
@toastr_render



@endsection
