@extends('layouts.master')
@section('css')
    @toastr_css
@section('title')
   تعديل معلومات الطالب

@stop
@endsection
@section('page-header')
<!-- breadcrumb -->
@section('PageTitle')
تعديل معلومات الطالب
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

                <form method="post"  action="{{ route('dashboard.students.update',$student->id) }}" autocomplete="off">
                    @csrf
                    @method('patch')
                    <h6 style="font-family: 'Cairo', sans-serif;color: blue"> معلومات الطالب الاساسية</h6><br>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>الاسم الاول : <span class="text-danger">*</span></label>
                                    <input  type="text" name="first_name"  class="form-control" value="{{old('first_name',$student->first_name)}}" >
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>الاسم الاخير : <span class="text-danger">*</span></label>
                                    <input  class="form-control" name="last_name" type="text" value="{{old('last_name',$student->last_name)}}" >
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>الايميل : </label>
                                    <input type="email"  name="email" class="form-control" value="{{old('email',$student->email)}}" >
                                </div>
                            </div>


                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>الهاتف :</label>
                                    <input  type="number" name="phone" class="form-control" value="{{old('phone',$student->phone)}}" >
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    @if ($student->image)
                                    <img src="{{ $student->getImageUrl() }}" alt="Student Image" height="60px" width="60px">
                                    @endif
                                    <label> صورة شخصية  :<i style="color: red">jpg or png</i></label>
                                    <input  type="file" name="image" class="form-control" >
                                </div>
                            </div>



                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>تاريخ الميلاد  :</label>
                                    <input class="form-control" type="text"  id="datepicker-action" name="data_birth" data-date-format="yyyy-mm-dd" value="{{old('data_birth',$student->data_birth)}}">
                                </div>
                            </div>

                        </div>

                    <h6 style="font-family: 'Cairo', sans-serif;color: blue">معلومات الطالب الثانوية</h6><br>
                    <div class="row">

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="department_id">الاقسام الدراسية : <span class="text-danger">*</span></label>
                                    <select class="custom-select mr-sm-2" name="department_id" required>
                                        <option selected disabled>اختر القسم...</option>
                                        @foreach($departments as $department)
                                            <option  value="{{ $department->id }}" @selected($student->department_id==$department->id)>{{ $department->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>


                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="classroom_id">الصف الدراسي : <span class="text-danger">*</span></label>
                                    <select class="custom-select mr-sm-2" name="classroom_id">
                                        @foreach ($classrooms as $classroom )

                                        <option value="{{$classroom->id}}" @selected($student->classroom_id==$classroom->id)>{{$classroom->name}}</option>

                                        @endforeach
                                    </select>
                                </div>
                            </div>




                        </div><br>
                    <button class="btn btn-success btn-sm nextBtn btn-lg pull-right" type="submit">حفظ البيانات</button>
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
        $(document).ready(function () {
            $('select[name="department_id"]').on('change', function () {
                var department_id = $(this).val();
                if (department_id) {

                    $.ajax({

                        url: "{{ URL::to('dashboard/depclasses') }}/" + department_id,
                        type: "GET",
                        dataType: "json",
                        success: function (data) {
                            $('select[name="classroom_id"]').empty();
                            $.each(data, function (key, value) {
                                $('select[name="classroom_id"]').append('<option selected disabled >اختر الصف ..</option>');
                                $('select[name="classroom_id"]').append('<option value="' + key + '" @selected($student->classroom_id==$classroom->id)>' + value + '</option>');
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
