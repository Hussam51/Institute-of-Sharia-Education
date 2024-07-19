@extends('layouts.master')
@section('css')
    @toastr_css
@section('title')
    قائمة الاسئلة
@stop
@endsection
@section('page-header')
    <!-- breadcrumb -->
@section('PageTitle')
    قائمة الاسئلة
@stop
<!-- breadcrumb -->
@endsection
@section('content')
    <!-- row -->
    <div class="row">
        <div class="col-md-12 mb-30">
            <div class="card card-statistics h-100">
                <div class="card-body">
                    <div class="col-xl-12 mb-30">
                        <div class="card card-statistics h-100">
                            <div class="card-body">
                                <a href="{{route('dashboard.entertainments.create')}}" class="btn btn-success btn-sm" role="button"
                                   aria-pressed="true">اضافة سؤال جديد</a><br><br>
                                <div class="table-responsive">
                                    <table id="datatable" class="table  table-hover table-sm table-bordered p-0"
                                           data-page-length="50"
                                           style="text-align: center">
                                        <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">السؤال</th>
                                            <th scope="col">الاجابات</th>
                                            <th scope="col">الاجابة الصحيحة</th>
                                            <th scope="col">وقت البدء</th>
                                            <th scope="col">المدة</th>
                                            <th scope="col">العمليات</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($questions as $question)
                                            <tr>
                                                <td>{{ $loop->iteration}}</td>
                                                <td>{{$question->question}}</td>
                                                <td>{{$question->answer1.'-'.$question->answer2.'-'.$question->answer3.'-'.$question->answer4}}</td>
                                                <td>{{$question->correct_answer}}</td>
                                                <td>{{$question->start_time}}</td>
                                                <td>{{$question->duration}}</td>
                                                <td>
                                                    <a href="{{route('dashboard.entertainments.edit',$question->id)}}"
                                                       class="btn btn-info btn-sm" role="button" aria-pressed="true"><i
                                                            class="fa fa-edit"></i></a>
                                                    <button type="button" class="btn btn-danger btn-sm"
                                                            data-toggle="modal"
                                                            data-target="#delete_question{{ $question->id }}" title="حذف"><i
                                                            class="fa fa-trash"></i></button>
                                                </td>
                                            </tr>

                                            <div class="modal fade" id="delete_question{{$question->id}}" tabindex="-1"
                                                role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                               <div class="modal-dialog" role="document">
                                                   <form action="{{route('dashboard.entertainments.destroy',$question->id)}}" method="post">
                                                       {{method_field('delete')}}
                                                       {{csrf_field()}}
                                                       <div class="modal-content">
                                                           <div class="modal-header">
                                                               <h5 style="font-family: 'Cairo', sans-serif;"
                                                                   class="modal-title" id="exampleModalLabel">حذف سؤال</h5>
                                                               <button type="button" class="close" data-dismiss="modal"
                                                                       aria-label="Close">
                                                                   <span aria-hidden="true">&times;</span>
                                                               </button>
                                                           </div>
                                                           <div class="modal-body">
                                                               <p> هل انت متأكد من حذف السؤال{{$question->question}}</p>
                                                               <input type="hidden" name="id" value="{{$question->id}}">
                                                           </div>
                                                           <div class="modal-footer">
                                                               <div class="modal-footer">
                                                                   <button type="button" class="btn btn-secondary"
                                                                           data-dismiss="modal">إغلاق</button>
                                                                   <button type="submit" class="btn btn-danger">تأكيد</button>
                                                               </div>
                                                           </div>
                                                       </div>
                                                   </form>
                                               </div>
                                           </div>
                                        @endforeach
                                    </table>
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
@section('js')
    @toastr_js
    @toastr_render
@endsection