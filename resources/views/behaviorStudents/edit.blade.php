@extends('layouts.master')
@section('css')
    @toastr_css
@section('title')
    تعديل سلوك الطالب
@stop
@endsection
@section('page-header')
<!-- breadcrumb -->
<h4 style="color: blue"> تعديل سلوك الطالب
</h4>
@section('PageTitle')
    تعديل سلوك الطالب
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

                <form method="post" action="{{ route('dashboard.behaviors.update',$behavoir->id) }}" autocomplete="off"
                    enctype="multipart/form-data">
                    @csrf
                     @method('patch')
                    <div class="row">

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="classroom_id">الصف الدراسي : <span class="text-danger">*</span></label>
                                <select class="custom-select mr-sm-2" name="classroom_id">
                                    <option disabled selected>--اخترالصف--</option>
                                    @foreach ($classrooms as $classroom)
                                        <option value="{{ $classroom->id }}" >{{ $classroom->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="student_id"> الطالب : <span class="text-danger">*</span></label>
                                <select class="custom-select mr-sm-3" name="student_id">
                                  <option  value="{{$behavoir->student_id}}">{{$behavoir->student->first_name.' '.$behavoir->student->last_name}}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="type"> حالة سلوك الطالب : <span class="text-danger">*</span></label>
                                <select class="custom-select mr-sm-3" name="type">
                                    <option disabled selected>--اختر الحالة</option>
                                    <option value="positive" style="background-color: green" @selected($behavoir->type=='positive')>إيجابي</option>
                                    <option value="negative" style="background-color: rgb(233, 78, 6)" @selected($behavoir->type=='negative')>سلبي</option>
                                </select>
                            </div>
                        </div>
                       
                    </div>


                    

                       
                    
                    <div class="col-md-8">
                        <div class="form-group">
                            <label>الملاحظة : </label>
                            <textarea type="text" name="note" class="form-control" required aria-valuetext="{{old('note',$behavoir->note)}}">{{$behavoir->note}}</textarea>
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

@endsection
