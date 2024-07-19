@extends('layouts.master')
@section('css')
    @toastr_css
@section('title')
    اضافة سؤال جديد
@stop
@endsection
@section('page-header')
<!-- breadcrumb -->
@section('PageTitle')
    اضافة سؤال جديد
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
                        <form action="{{ route('dashboard.entertainments.store') }}" method="post" autocomplete="off">
                            @csrf
                            <div class="form-group">
                                <label for="question">السؤال:</label>
                                <textarea class="form-control" name="question" id="question" rows="3" required></textarea>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="answer1">الإجابة 1:</label>
                                        <input type="text" class="form-control" name="answer1" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="answer2">الإجابة 2:</label>
                                        <input type="text" class="form-control" name="answer2" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="answer3">الإجابة 3:</label>
                                        <input type="text" class="form-control" name="answer3" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="answer4">الإجابة 4:</label>
                                        <input type="text" class="form-control" name="answer4" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="correct_answer">الإجابة الصحيحة :</label>
                                    <select class="custom-select mr-sm-2" name="correct_answer" required>
                                        <option value="1" disabled selected> --الاجابة --</option>
                                        <option value="1">الاجابة 1</option>
                                        <option value="2">الاجابة 2</option>
                                        <option value="3">الاجابة 3</option>
                                        <option value="4">الاجابة 4</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                            <div class="col-md-6">
                            <div class="form-group">
                                <label for="start_time">وقت البدء :</label>
                                <input type="time" class="form-control" name="start_time" required>
                            </div>
                            </div>
                            <div class="col-md-6">
                            <div class="form-group">
                                <label for="duration">المدة (بالدقائق):</label>
                                <input type="number" class="form-control" name="duration" required>
                            </div>
                            </div>
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
