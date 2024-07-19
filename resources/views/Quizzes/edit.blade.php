@extends('layouts.master')
@section('css')
    @toastr_css
@section('title')
    تعديل معلومات الخط

@stop
@endsection
@section('page-header')
<!-- breadcrumb -->
@section('PageTitle')
    تعديل معلومات الخط
@stop
<!-- breadcrumb -->
@endsection
@section('content')
<!-- row -->
<div class="row">
    <div class="container">
        <h1>تعديل تفاصيل الاختبار</h1>
        <form action="{{ route('dashboard.quizzes.update', $quiz->id) }}" method="post">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="classroom_id">الصف</label>
                <select name="classroom_id" id="classroom_id" class="custom-select mr-sm-2">
                    @foreach($classrooms as $classroom)
                        <option value="{{ $classroom->id }}" {{ $quiz->classroom_id == $classroom->id ? 'selected' : '' }}>{{ $classroom->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="subject_id">المادة</label>
                <select name="subject_id" id="subject_id" class="custom-select mr-sm-2">
                    @foreach($subjects as $subject)
                    <option  value="{{ $subject->id }}" @selected($subject->id==$quiz->subject_id)>{{$subject->name}}</option>
                @endforeach
                </select>
            </div>
          
            <div class="form-group">
                <label for="min_mark">الدرجة الصغرى </label>
                <input type="number" name="min_mark" id="min_mark" class="form-control" value="{{ $quiz->min_mark }}" step="0.1">
            </div>
            <div class="form-group">
                <label for="max_mark">الدرجة العظمى </label>
                <input type="number" name="max_mark" id="max_mark" class="form-control" value="{{ $quiz->max_mark }}" step="0.1">
            </div>
            <div class="form-group">
                <label for="type">نوع الإختبار</label>
                <select name="type" id="type" class="custom-select mr-sm-2">
                  
                    <option value="probe_1" @selected($quiz->type=='probe_1')>السبر الاول </option>
                    <option value="quiz_1" @selected($quiz->type=='quiz_1')> الاختبار الاول </option>
                    <option value="midterm_exam" @selected($quiz->type=='midterm_exam')> إمتحان الفصل الاول </option>
                    <option value="probe_2" @selected($quiz->type=='probe_2')>السبر الثاني </option>
                    <option value="quiz_2" @selected($quiz->type=='quiz_2')> الاختبار الثاني </option>
                    <option value="final_exam" @selected($quiz->type=='final_exam')>الإمتحان النهائي </option>

                    
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

<script>
    $(document).ready(function () {
        $('select[name="classroom_id"]').on('change', function () {
            var classroom_id = $(this).val();
          
            if (classroom_id) {


               
            
                $.ajax({

                    url: "{{ URL::to('dashboard/class_subjects') }}/" + classroom_id,
                    type: "GET",
                    dataType: "json",
                    success: function (data) {
                        $('select[name="subject_id"]').empty();
                        $('select[name="subject_id"]').append('<option selected disabled value="">' +' ..اختر مادة'+ '</option>');
                        $.each(data, function (index, subject) {
                          
                            $('select[name="subject_id"]').append('<option value="' + subject.id + '" >' + subject.name  + '</option>');
                        });

                    },
                });
            }

            else {
                console.log('AJAX load did not work');
            }
        });
    });
</script>

@endsection
