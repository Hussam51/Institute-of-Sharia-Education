@extends('layouts.master')
@section('css')
    @toastr_css
@section('title')
    اضافة مراقبة جديدة لمعلم 
@stop
@endsection
@section('page-header')
<!-- breadcrumb -->
<h4 style="color: blue"> اضافة مراقبة جديدة لمعلم 
  
  
</h4>
@section('PageTitle')
    اضافة مراقبة جديدة لمعلم 
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

                <form method="post" action="{{ route('dashboard.teacher_monitorings.store') }}" autocomplete="off"
                    enctype="multipart/form-data">
                    @csrf

                    <div class="row">


                      
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="hall">   القاعة الامتحانية  : <span class="text-danger">*</span></label>
                                <select class="custom-select mr-sm-3" name="hall">
                                    <option disabled selected>--اختر قاعة</option>
                                    <option value="1" >1</option>
                                    <option value="2" >2</option>
                                    <option value="3" >3</option>
                                    <option value="4" >4</option>
                                    <option value="5" >5</option>
                                    <option value="6" >6</option>
                                    <option value="7" >7</option>
                                    <option value="8" >8</option>
                                    <option value="9" >9</option>

                                </select>
                            </div>
                        </div>

                        <div class="col-md-4">
                            
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="teacher_id"> المعلم : <span class="text-danger">*</span></label>
                                <select class="custom-select mr-sm-3" name="teacher_id">
                                  @foreach ($teachers as $teacher )
                                       <option value="{{$teacher->id}}">{{$teacher->first_name}}</option>
                                  @endforeach
                                </select>
                            </div>
                        </div>
                      
                      
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="date"> التاريخ :<span class="text-danger">*</span></label>
                                <input type="date" class="form-control" name="date" required>
                          
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



@endsection
