@extends('layouts.master')
@section('css')
    @toastr_css
@section('title')
    قائمة الدرجات

@stop
@endsection
@section('page-header')
<!-- breadcrumb -->
@section('PageTitle')
    قائمة الدرجات
@stop
<!-- breadcrumb -->
@endsection
@section('content')
<!-- row -->
<div class="row">
    <div class="container">
        <h3>نتائج الإختبارات</h3>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>الطالب</th>
                    <th>الاختبار</th>
                    <th>الدرجة الصغرى </th>
                    <th>الدرجة العظمى </th>
                    <th>الدرجة المستحقة </th>
                   

                </tr>
            </thead>
            <tbody>
                @foreach ($marks as $mark)
                    <tr>
                        <td>{{ $mark->id }}</td>
                        <td>{{ $mark->student->first_name . ' ' . $mark->student->last_name }}</td>
                        <td>{{ $mark->quiz->type }}</td>
                        <td>{{ $mark->quiz->min_mark }}</td>
                        <td>{{ $mark->quiz->max_mark }}</td>
                        <td>{{ $mark->student_mark }}</td>
                        

                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<!-- row closed -->
@endsection
@section('js')

@toastr_js
@toastr_render
@endsection
