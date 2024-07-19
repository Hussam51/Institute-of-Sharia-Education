@extends('layouts.master')
@section('css')
    @toastr_css
@section('title')
    تعديل بيانات المراقبة   
@stop
@endsection
@section('page-header')
<!-- breadcrumb -->
<h4 style="color: blue"> اضافة بيانات المراقبة   
  
  
</h4>
@section('PageTitle')
    تعديل بيانات المراقبة   
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

                <form method="post" action="{{ route('dashboard.teacher_monitorings.update',$monitoring->id) }}" autocomplete="off"
                    enctype="multipart/form-data">
                    @csrf
                    @method('patch')
                    <div class="row">


                      
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="hall">   القاعة الامتحانية  : <span class="text-danger">*</span></label>
                                <select class="custom-select mr-sm-3" name="hall">
                                    <option disabled >--اختر قاعة</option>
                                    <option value="1" @selected($monitoring->id==1)>1</option>
                                    <option value="2"  @selected($monitoring->id==2)>2</option>
                                    <option value="3"  @selected($monitoring->id==3)>3</option>
                                    <option value="4"  @selected($monitoring->id==4)>4</option>
                                    <option value="5" @selected($monitoring->id==5) >5</option>
                                    <option value="6"  @selected($monitoring->id==6) >6</option>
                                    <option value="7"  @selected($monitoring->id==7)>7</option>
                                    <option value="8"  @selected($monitoring->id==8) >8</option>
                                    <option value="9"  @selected($monitoring->id==9)>9</option>

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
                                       <option value="{{$teacher->id}}"  @selected($monitoring->teacher_id==$teacher->id)>{{$teacher->first_name.' '.$teacher->last_name}}</option>
                                  @endforeach
                                </select>
                            </div>
                        </div>
                      
                      
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="date"> التاريخ :<span class="text-danger">*</span></label>
                                <input type="date" class="form-control" name="date" required value="{{old('date',$monitoring->date)}}">
                          
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="start_time"> من الساعة :<span class="text-danger">*</span></label>
                                <input type="time" class="form-control" name="start_time" required value="{{old('start_time',$monitoring->start_time)}}">
                          
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="end_time"> الى الساعة :<span class="text-danger" >*</span></label>
                                <input type="time" class="form-control" name="end_time" required value="{{old('end_time',$monitoring->end_time)}}">
                          
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
