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
            <div class="container">
                <h2>تفاصيل الاختبار</h2>
                <table class="table">
                    <tbody>
                        <tr>
                            <th>#</th>
                            <td style="color: rgb(248, 57, 57)">{{ $quiz->id }}</td>
                        </tr>
                        <tr>
                            <th>المادة</th>
                            <td style="color: rgb(31, 199, 31)">{{ $quiz->subject->name }}</td>
                        </tr>
                        <tr>
                            <th>الصف</th>
                            <td style="color: rgb(51, 214, 46)">{{ $quiz->classroom->name }}</td>
                        </tr>
                        <tr>
                            <th>الدرجة الصغرى </th>
                            <td style="color: rgb(47, 0, 255)">{{ $quiz->min_mark }}</td>
                        </tr>
                        <tr>
                            <th>الدرجة العظمى </th>
                            <td style="color: rgb(0, 68, 255)">{{ $quiz->max_mark }}</td>
                        </tr>
                        <tr>
                            <th>نوع الاختبار</th>
                            <td style="color: rgb(34, 202, 34)">{{ $quiz->type }}</td>
                        </tr>
                    </tbody>
                </table>
            
        </div>
    </div>
</div>
 <!-- row closed -->
@endsection   