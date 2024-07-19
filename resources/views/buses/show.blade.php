@extends('layouts.master')
@section('css')
    @toastr_css
@section('title')
    معلومات خط السير 

@stop
@endsection
@section('page-header')
<!-- breadcrumb -->
@section('PageTitle')
 معلومات خط السير
@stop
<!-- breadcrumb -->
@endsection
@section('content')
<!-- row -->
<div class="row">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
معلومات خط السير 
                    </div>
    
                    <div class="card-body">
                        <div class="form-group row">
                            <label for="bus_number" class="col-md-4 col-form-label text-md-right"> الوجهة </label>
    
                            <div class="col-md-6">
                                <input type="text" class="form-control" id="route_name" name="route_name" value="{{ $bus->route_name }}" disabled>
                            </div>
                        </div>
    
                        <div class="form-group row">
                            <label for="driver_name" class="col-md-4 col-form-label text-md-right"> مكان الانطلاق </label>
    
                            <div class="col-md-6">
                                <input type="text" class="form-control" id="driver_name" name="driver_name" value="{{ $bus->start_location }}" disabled>
                            </div>
                        </div>
    
                        <div class="form-group row">
                            <label for="end_location" class="col-md-4 col-form-label text-md-right">مكان الوصول</label>
    
                            <div class="col-md-6">
                                <input type="text" class="form-control" id="end_location" name="end_location" value="{{ $bus->end_location }}" disabled>
                            </div>
                        </div>
    
                       
    
                        <div class="form-group row">
                            <label for="departure_time" class="col-md-4 col-form-label text-md-right">وقت الإنطلاق </label>
    
                            <div class="col-md-6">
                                <input type="time" class="form-control" id="departure_time" name="departure_time" value="{{ $bus->departure_time }}" disabled>
                            </div>
                        </div>
    
                        <div class="form-group row">
                            <label for="return_time" class="col-md-4 col-form-label text-md-right">وقت العودة </label>
    
                            <div class="col-md-6">
                                <input type="time" class="form-control" id="return_time" name="return_time" value="{{ $bus->arrival_time}}" disabled>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="vehicle_type" class="col-md-4 col-form-label text-md-right"> نوع المركبة</label>
    
                            <div class="col-md-6">
                                <input type="text" class="form-control" id="vehicle_type" name="vehicle_type" value="{{ $bus->vehicle_type}}" disabled>
                            </div>
                        </div>
    
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <a href="{{ route('dashboard.buses.index') }}" class="btn btn-primary"><- العودة لقائمة خطوط السير   </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
 <!-- row closed -->
@endsection   