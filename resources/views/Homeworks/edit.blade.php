@extends('layouts.master')
@section('css')
    @toastr_css
@section('title')
    اضافة واجب 
@stop
@endsection
@section('page-header')
<!-- breadcrumb -->
<h4 style="color: blue"> اضافة واجب 
  
</h4>
@section('PageTitle')
    اضافة واجب 
@stop
<!-- breadcrumb -->
@endsection
@section('content')
<!-- row -->
<div class="row">
    <div class="col-md-12 mb-30">
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

                <form method="post" action="{{ route('dashboard.homeworks.update',$homework->id) }}" autocomplete="off"
                    enctype="multipart/form-data">
                    @csrf
                    @method('patch')

                    <div class="row">


                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="homework_name"> عنوان الواجب :<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="homework_name" required value="{{old('homework_name',$homework->homework_name)}}">
                          
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="type">  نوع الواجب  : <span class="text-danger">*</span></label>
                                <select class="custom-select mr-sm-3" name="type">
                                    <option  >--اختر النوع</option>
                                    <option value="homework" @selected($homework->type=='homework') >وظيفة</option>
                                    <option value="Review"  @selected($homework->type=='Review')>مراجعة</option>
                                    <option value="lesson"  @selected($homework->type=='lesson')>درس مقرر</option>

                                </select>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="classroom_id">الصف الدراسي : <span class="text-danger">*</span></label>
                                <select class="custom-select mr-sm-2" name="classroom_id">
                                    <option disabled selected>--اخترالصف--</option>
                                    @foreach ($classrooms as $classroom)
                                        <option value="{{ $classroom->id }}" @selected($homework->classroom_id==$classroom->id)>{{ $classroom->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="teacher_id"> المعلم : <span class="text-danger">*</span></label>
                                <select class="custom-select mr-sm-3" name="teacher_id">
                                    <option value="{{ $homework->teacher_id }}" @selected($homework->classroom_id)>{{ $homework->classroom->name }}</option>

                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="subject_id"> المادة    : <span class="text-danger">*</span></label>
                                <select class="custom-select mr-sm-3" name="subject_id">
                                    <option disabled selected>--اختر المادة</option>
                                       @foreach ($subjects as $subject)
                            
                                    <option value="{{$subject->id}}" @selected($homework->subject_id==$subject->id)>{{$subject->name}}</option>
                                  
                                       @endforeach
                                </select>
                            </div>
                        </div>
                      
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="date"> التاريخ :<span class="text-danger">*</span></label>
                                <input type="datetime-local" class="form-control" name="date" required value="{{old('date',$homework->date)}}">
                          
                            </div>
                        </div>
                    </div>


                    

                       
                    
                    <div class="col-md-8">
                        <div class="form-group">
                            <label>الملاحظة : </label>
                            <textarea type="text" name="notes" class="form-control" required> {{$homework->notes}}</textarea>
                        </div>
                    </div><br>
                    <button class="btn btn-success btn-sm nextBtn btn-lg pull-right" type="submit">حفظ
                        البيانات</button>
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


<script>
    $(document).ready(function() {
        $('select[name="classroom_id"]').on('change', function() {
            var classroom_id = $(this).val();

            if (classroom_id) {




                $.ajax({

                    url: "{{ URL::to('dashboard/classStudents') }}/" + classroom_id,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        $('select[name="student_id"]').empty();
                        $('select[name="student_id"]').append(
                            '<option selected disabled value="">' + ' ..اختر طالب' +
                            '</option>');
                        $.each(data, function(index, student) {

                            $('select[name="student_id"]').append(
                                '<option value="' + student.id + '">' + student
                                .first_name + ' ' + student.last_name +
                                '</option>');
                        });

                    },
                });
            } else {
                console.log('AJAX load did not work');
            }
        });
    });
</script>



<script>
    $(document).ready(function() {
        $('select[name="classroom_id"]').on('change', function() {
            var classroom_id = $(this).val();

            if (classroom_id) {




                $.ajax({

                    url: "{{ URL::to('dashboard/classTeachers') }}/" + classroom_id,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        $('select[name="teacher_id"]').empty();
                        $('select[name="teacher_id"]').append(
                            '<option selected disabled value="">' + ' ..اختر معلم' +
                            '</option>');
                        $.each(data, function(index, teacher) {

                            $('select[name="teacher_id"]').append(
                                '<option value="' + teacher.id + '">' + teacher
                                .first_name + ' ' + teacher.last_name +
                                '</option>');
                        });

                    },
                });
            } else {
                console.log('AJAX load did not work');
            }
        });
    });
</script>

@endsection
