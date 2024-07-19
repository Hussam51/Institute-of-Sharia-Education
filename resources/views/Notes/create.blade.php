@extends('layouts.master')
@section('css')
    @toastr_css
@section('title')
    اضافة ملاحظات النقل
@stop
@endsection
@section('page-header')
<!-- breadcrumb -->
<h4 style="color: blue"> اضافة ملاحظات النقل
  
</h4>
@section('PageTitle')
    اضافة ملاحظات النقل
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

                <form method="post" action="{{ route('dashboard.bus_notes.store') }}" autocomplete="off"
                    enctype="multipart/form-data">
                    @csrf

                    <div class="row">

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="classroom_id">الصف الدراسي : <span class="text-danger">*</span></label>
                                <select class="custom-select mr-sm-2" name="classroom_id">
                                    <option disabled selected>--اخترالصف--</option>
                                    @foreach ($classrooms as $classroom)
                                        <option value="{{ $classroom->id }}">{{ $classroom->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="student_id"> الطالب : <span class="text-danger">*</span></label>
                                <select class="custom-select mr-sm-3" name="student_id">

                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="type"> وسيلة النقل   : <span class="text-danger">*</span></label>
                                <select class="custom-select mr-sm-3" name="transport_id">
                                    <option disabled selected>--اختر الحالة</option>
                                       @foreach ($transports as $transport)
                            
                                    <option value="{{$transport->id}}">{{$transport->vehicle_type}}</option>
                                  
                                       @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="type"> حالة الطالب  : <span class="text-danger">*</span></label>
                                <select class="custom-select mr-sm-3" name="status">
                                    <option disabled selected>--اختر الحالة</option>
                                    <option value="absent" style="background-color: rgb(230, 13, 13)">غياب</option>
                                    <option value="late" style="background-color: rgb(32, 91, 219)">تأخر</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="date"> التاريخ :<span class="text-danger">*</span></label>
                                <input type="datetime-local" class="form-control" name="date" required>
                          
                            </div>
                        </div>
                    </div>


                    

                       
                    
                    <div class="col-md-8">
                        <div class="form-group">
                            <label>الملاحظة : </label>
                            <textarea type="text" name="note" class="form-control" required></textarea>
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
