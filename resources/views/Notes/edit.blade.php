@extends('layouts.master')
@section('css')
    @toastr_css
@section('title')
    تعديل ملاحظات النقل
@stop
@endsection
@section('page-header')
<!-- breadcrumb -->
<h4 style="color: blue"> تعديل ملاحظات النقل
  
</h4>
@section('PageTitle')
    تعديل ملاحظات النقل
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

                <form method="post" action="{{ route('dashboard.bus_notes.update',$studentTrans->id) }}" autocomplete="off"
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
                                        <option value="{{ $classroom->id }}">{{ $classroom->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="student_id"> الطالب : <span class="text-danger">*</span></label>
                                <select class="custom-select mr-sm-3" name="student_id">
                                    <option  value="{{$studentTrans->student_id}}">{{$studentTrans->student->first_name.' '.$studentTrans->student->last_name}}</option>

                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="type"> وسيلة النقل   : <span class="text-danger">*</span></label>
                                <select class="custom-select mr-sm-3" name="transport_id">
                                    <option disabled selected>--اختر الحالة</option>
                                       @foreach ($transports as $transport)
                                    
                                    <option value="{{$transport->id}}" @selected($studentTrans->transport_id==$transport->id)>{{$transport->vehicle_type}}</option>
                                  
                                       @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="type"> حالة الطالب  : <span class="text-danger">*</span></label>
                                <select class="custom-select mr-sm-3" name="status">
                                    
                                    <option value="غياب" style="background-color: rgb(230, 13, 13)" @selected($studentTrans->status=='غياب')>غياب</option>
                                    <option value="حاضر" style="background-color: rgb(67, 170, 42)" @selected($studentTrans->status=='حاضر')>حاضر</option>
                                    <option value="تأخر" style="background-color: rgb(65, 170, 91)" @selected($studentTrans->status=='تأخر')>تأخر</option>
                                    <option value="إذن" style="background-color: rgb(32, 91, 219)" @selected($studentTrans->status=='إذن')>إذن</option>
                             
                               
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="date"> التاريخ :<span class="text-danger">*</span></label>
                                <input type="datetime-local" class="form-control" name="date" required value="{{old('date',$studentTrans->date)}}">
                          
                            </div>
                        </div>
                    </div>


                    

                       
                    
                    <div class="col-md-8">
                        <div class="form-group">
                            <label>الملاحظة : </label>
                            <textarea type="text" name="note" class="form-control" required aria-valuetext="{{$studentTrans->note}}">{{$studentTrans->note}}</textarea>
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
