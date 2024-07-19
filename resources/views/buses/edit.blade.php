@extends('layouts.master')
@section('css')
    @toastr_css
@section('title')
    تعديل معلومات الخط

@stop
@endsection
@section('page-header')
<!-- breadcrumb -->
@section('PageTitle')
    تعديل معلومات الخط
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

                <form method="post" action="{{ route('dashboard.buses.update', $bus->id) }}" autocomplete="off">
                    @csrf
                    @method('patch')
                    <h6 style="font-family: 'Cairo', sans-serif;color: blue"> معلومات خط السير</h6><br>
                    <div class="row">

                        <div class="col-md-6">
                            <div class="form-group">
                                <label> الوجهة : <span class="text-danger">*</span></label>
                                <input class="form-control" name="route_name" type="text" required  value="{{ old('route_name', $bus->route_name ?? '') }}">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label> مكان الإنطلاق  : <span class="text-danger">*</span></label>
                                <input type="text" name="start_location" class="form-control" required  value="{{ old('start_location', $bus->start_location ?? '') }}">
                            </div>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>  مكان العودة : <span class="text-danger">*</span> </label>
                                <input type="text" name="end_location" class="form-control" required   value="{{ old('end_location', $bus->end_location ?? '') }}">
                            </div>
                        </div>


                        <div class="col-md-6">
                            <label for="departure_time">وقت الإنطلاق : <span class="text-danger">*</span></label>
                            <input type="time" class="form-control @error('departure_time') is-invalid @enderror"
                                id="departure_time" name="departure_time"
                                value="{{ old('departure_time', $bus->departure_time ?? '') }}" required>
                            @error('departure_time')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="arrival_time"> وقت الوصول : <span class="text-danger">*</span></label>
                                <input type="time" class="form-control @error('arrival_time') is-invalid @enderror"
                                    id="arrival_time" name="arrival_time"
                                    value="{{ old('arrival_time', $bus->arrival_time ?? '') }}" required >
                                @error('arrival_time')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                      
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>نوع المركبة : <span class="text-danger">*</span> </label>
                                <input type="text" name="vehicle_type" class="form-control" required   value="{{ old('vehicle_type', $bus->vehicle_type ?? '') }}">
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
