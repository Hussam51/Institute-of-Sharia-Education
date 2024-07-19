@extends('layouts.master')
@section('css')
    @toastr_css
@section('title')
    تعديل بيانات دوام المعلم   
@stop
@endsection
@section('page-header')
<!-- breadcrumb -->
<h4 style="color: blue"> اضافة بيانات دوام المعلم   
  
  
</h4>
@section('PageTitle')
    تعديل بيانات دوام المعلم   
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

                <form method="post" action="{{ route('dashboard.teacher_weekTable.update',$teacherTime->id) }}" autocomplete="off"
                    enctype="multipart/form-data">
                    @csrf
                    @method('patch')
                    <div class="row">


                      
                      
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="day">اليوم  : <span class="text-danger">*</span></label>
                                    <select class="custom-select mr-sm-3" name="day">
                                        <option disabled >--اختراليوم</option>
                                        <option value="sunday" @selected($teacherTime->day=='sunday') >الاحد</option>
                                        <option value="monday" @selected($teacherTime->day=='monday')>الاثنين</option>
                                        <option value="tuesday" @selected($teacherTime->day=='tuesday')>الثلاثاء</option>
                                        <option value="wednesday" @selected($teacherTime->day=='wednesday')>الاربعاء</option>
                                        <option value="thursday"@selected($teacherTime->day=='thursday') >الخميس</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="classroom_id"> الصف : <span class="text-danger">*</span></label>
                                    <select class="custom-select mr-sm-3" name="classroom_id">
                                      @foreach ($classrooms as $classroom )
                                           <option value="{{$classroom->id}}" @selected($teacherTime->classroom_id==$classroom->id)>{{$classroom->name}}</option>
                                      @endforeach
                                    </select>
                                </div>
                            </div>
                           
    
                      

                       
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="teacher_id"> المعلم : <span class="text-danger">*</span></label>
                                    <select class="custom-select mr-sm-3" name="teacher_id">
                                        <option value="{{$teacherTime->teacher_id}}"  @selected($teacherTime->teacher_id)>{{$teacherTime->teacher->first_name.' '.$teacherTime->teacher->last_name}}</option>

                                    </select>
                                </div>
                            </div>
                       

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="start_time"> من الساعة :<span class="text-danger">*</span></label>
                                <input type="time" class="form-control" name="start_time" required value="{{old('start_time',$teacherTime->start_time)}}">
                          
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="end_time"> الى الساعة :<span class="text-danger" >*</span></label>
                                <input type="time" class="form-control" name="end_time" required value="{{old('end_time',$teacherTime->end_time)}}">
                          
                            </div>
                        </div>
                        
                    </div>
                          <br>
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
