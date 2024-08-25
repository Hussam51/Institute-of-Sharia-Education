@extends('layouts.master')
@section('css')
    @toastr_css
@section('title')
    اضافة اختبار جديد
@stop
@endsection
@section('page-header')
<!-- breadcrumb -->
@section('PageTitle')
    اضافة اختبار جديد
@stop
<!-- breadcrumb -->
@endsection
@section('content')
<!-- row -->
<div class="row">
    <div class="container">
        <h3>إضافة اختبار</h3>
        <form action="{{ route('dashboard.quizzes.store') }}" method="post">
            @csrf
            <div class="row">

                <div class="col-md-6">
                    <label for="classroom_id">الصف <span class="text-danger">*</span></label>
                    <select name="classroom_id" id="classroom_id" class="custom-select mr-sm-2">
                        <option disabled selected>اختر صف--</option>
                        @foreach($classrooms as $classroom)
                            <option value="{{ $classroom->id }}">{{ $classroom->name }}</option>
                        @endforeach
                    </select>
                </div>

             <div class="col-md-6">
           
                <label for="subject_id"> المادة <span class="text-danger">*</span></label>
                  <select name="subject_id" id="subject_id" class="custom-select mr-sm-2">
                   {{-- <option disabled>اختر مادة--</option>
                    @foreach($subjects as $subject)
                        <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                    @endforeach
                    --}}
                  </select>
              </div>
           
            </div>
            <br>
            <div class="col-md-6">
                <label for="type">نوع الإختبار <span class="text-danger">*</span></label>
                <select name="type" id="type" class="custom-select mr-sm-2">
                  
                        <option value="النشاط"> النشاط </option>
                        <option value="المشاركة">  المشاركة </option>
                        <option value="الوظائف">   الوظائف </option>
                        <option value="الشفهي"> الشفهي </option>
                        <option value="المذاكرة">  المذاكرة </option>
                        <option value="الامتحان">الإمتحان  </option>

                        
                </select>
            </div>
            <div class="row">
                <div class="col-md-6">
                <label for="min_mark">الدرجة الصغرى <span class="text-danger">*</span></label>
                <input type="number" name="min_mark" id="min_mark" class="form-control" step="0.1">
            </div>
            <div class="col-md-6">
                <label for="max_mark">الدرجة العظمى <span class="text-danger">*</span></label>
                <input type="number" name="max_mark" id="max_mark" class="form-control" step="0.1">
            </div>
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
                          
                            $('select[name="subject_id"]').append('<option value="' + subject.id + '">' + subject.name  + '</option>');
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
