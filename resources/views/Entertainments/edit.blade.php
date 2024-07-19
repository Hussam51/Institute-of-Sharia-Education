@extends('layouts.master')
@section('css')
    @toastr_css
@section('title')
    تعديل السؤال
@stop
@endsection
@section('page-header')
<!-- breadcrumb -->
<h4 style="color: blue"> تعديل السؤال
</h4>
@section('PageTitle')
    تعديل السؤال
@stop
<!-- breadcrumb -->
@endsection
@section('content')
<!-- row -->
<div class="row">
    <div class="col-md-12 mb-30">
        <div class="card card-statistics h-100">
            <div class="card-body">

                @if (session()->has('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>{{ session()->get('error') }}</strong>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
                <div class="col-xs-12">
                    <div class="col-md-12">
                        <br>
                        <form action="{{ route('dashboard.entertainments.update', $enterainment->id) }}" method="post"
                            autocomplete="off">
                            @csrf
                            @method('patch')
                            <div class="form-group">
                                <label for="question">السؤال:</label>
                                <textarea class="form-control" name="question" id="question" rows="3"
                                    value="{{ old('question', $enterainment->question) }}" required>{{ $enterainment->question }}</textarea>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="answer1">الإجابة 1:</label>
                                        <input type="text" class="form-control" name="answer1"
                                            value="{{ old('answer1', $enterainment->answer1) }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="answer2">الإجابة 2:</label>
                                        <input type="text" class="form-control" name="answer2"
                                            value="{{ old('answer2', $enterainment->answer2) }}" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">

                                    <div class="form-group">
                                        <label for="answer3">الإجابة 3:</label>
                                        <input type="text" class="form-control" name="answer3"
                                            value="{{ old('answer3', $enterainment->answer3) }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="answer4">الإجابة 4:</label>
                                        <input type="text" class="form-control" name="answer4"
                                            value="{{ old('answer4', $enterainment->answer4) }}" required>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="correct_answer">الإجابة الصحيحة :</label>
                                <select class="custom-select mr-sm-2" name="correct_answer" required>
                                    <option value="1" @selected($enterainment->correct_answer == 1)>الاجابة 1</option>
                                    <option value="2" @selected($enterainment->correct_answer == 2)>الاجابة 2</option>
                                    <option value="3" @selected($enterainment->correct_answer == 3)>الاجابة 3</option>
                                    <option value="4" @selected($enterainment->correct_answer == 4)>الاجابة 4</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="start_time">وقت البدء :</label>
                                <input type="time" class="form-control" name="start_time" required
                                    value="{{ old('start_time', $enterainment->start_time) }}">
                            </div>
                            <div class="form-group">
                                <label for="duration">المدة (بالدقائق):</label>
                                <input type="number" class="form-control" name="duration"
                                    value="{{ old('duration', $enterainment->duration) }}" required>
                            </div>




                            <button class="btn btn-success btn-sm nextBtn btn-lg pull-right" type="submit">حفظ
                                البيانات</button>
                        </form>
                    </div>
                </div>
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
