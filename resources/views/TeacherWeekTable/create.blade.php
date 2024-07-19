@extends('layouts.master')
@section('css')
    @toastr_css
@section('title')
    اضافة اوقات دوام للمعلم  
@stop
@endsection
@section('page-header')
<!-- breadcrumb -->
<h4 style="color: blue">     اضافة اوقات دوام للمعلم  
    
  
  
</h4>
@section('PageTitle')
اضافة اوقات دوام للمعلم  
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

                <form method="post" action="{{ route('dashboard.teacher_weekTable.store') }}" autocomplete="off"
                    enctype="multipart/form-data">
                    @csrf

                    <div class="row">


                      
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="day">اليوم  : <span class="text-danger">*</span></label>
                                <select class="custom-select mr-sm-3" name="day">
                                    <option disabled selected>--اختراليوم</option>
                                    <option value="sunday" >الاحد</option>
                                    <option value="monday" >الاثنين</option>
                                    <option value="tuesday" >الثلاثاء</option>
                                    <option value="wednesday" >الاربعاء</option>
                                    <option value="thursday" >الخميس</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4">
                            
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="classroom_id"> الصف : <span class="text-danger">*</span></label>
                                <select class="custom-select mr-sm-3" name="classroom_id">
                                    <option selected disabled>--اختر صف --</option>
                                  @foreach ($classrooms as $classroom )
                                       <option value="{{$classroom->id}}">{{$classroom->name}}</option>
                                  @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="teacher_id"> المعلم : <span class="text-danger">*</span></label>
                                <select class="custom-select mr-sm-3" name="teacher_id">
                                
                                </select>
                            </div>
                        </div>
                      
                      
                       

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="start_time"> من الساعة :<span class="text-danger">*</span></label>
                                <input type="time" class="form-control" name="start_time" required>
                          
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="end_time"> الى الساعة :<span class="text-danger">*</span></label>
                                <input type="time" class="form-control" name="end_time" required>
                          
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
