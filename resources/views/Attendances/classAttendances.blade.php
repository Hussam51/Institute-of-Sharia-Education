@extends('layouts.master')
@section('css')
    @toastr_css
@section('title')
    قائمة الحضور والغياب للطلاب
@stop
@endsection
@section('page-header')
    <!-- breadcrumb -->
 قائمة الحضور والغياب للطلاب/ {{$classroom->name}}
@section('PageTitle')
    قائمة الحضور والغياب للطلاب
@stop
<!-- breadcrumb -->
@endsection
@section('content')
    <!-- row -->

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (session('status'))
        <div class="alert alert-danger">
            <ul>
                <li>{{ session('status') }}</li>
            </ul>
        </div>
    @endif



    <h5 style="font-family: 'Cairo', sans-serif;color: red"> تاريخ اليوم : {{ date('Y-m-d') }}</h5>
    <form method="post" action="{{ route('dashboard.attendences.store') }}">

        @csrf
        <table id="datatable" class="table  table-hover table-sm table-bordered p-0" data-page-length="50"
               style="text-align: center">
            <thead>
            <tr>
                <th class="alert-success">#</th>
                <th class="alert-success">الاسم الاول </th>
                <th class="alert-success">الاسم الاخير </th>
                <th class="alert-success">الايميل</th>
                <th class="alert-success">الهاتف</th>
                <th class="alert-success">الصف</th>
                <th class="alert-success">حالة الحضور</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($students as $student)
                <tr>
                    <td>{{ $loop->index + 1 }}</td>
                    <td>{{ $student->first_name }}</td>
                    <td>{{ $student->last_name }}</td>
                    <td>{{ $student->email }}</td>
                    <td>{{ $student->phone }}</td>
                    <td>{{ $student->classroom->name }}</td>
                    <td>

                        @if(isset($student->attendances()->where('attendance_date',date('Y-m-d'))->first()->student_id))

                            <label class="block text-gray-500 font-semibold sm:border-r sm:pr-4">
                                <input name="attendances[{{ $student->id }}]" disabled
                                @checked($student->attendances()->first()->attendance_status == 1 )
                                       class="leading-tight" type="checkbox" value="presence">
                                <span class="text-success">حضور</span>
                            </label>
                           
                            <label class="ml-4 block text-gray-500 font-semibold">
                                <input  name="attendances[{{ $student->id }}]" disabled 
                                @checked($student->attendances()->first()->attendance_status == 0 )
                                      
                                       class="leading-tight" type="checkbox" value="absent">
                                <span class="text-danger">غياب</span>
                                @if($student->attendances()->where('attendance_date',date('Y-m-d'))->first()->absent_reason !=null)
                                <div id="absent-reason">
                                    <div class="form-group">
                                        <label for="absent_reason"> سبب الغياب  :</label>
                                        <textarea name="absent_reason" id="absent_reason" class="form-control" disabled>{{$student->attendances()->first()->absent_reason}}</textarea>
                                    </div>
                                </div>
                                @endif
                            </label>
                           

                        @else

                            <label class="block text-gray-500 font-semibold sm:border-r sm:pr-4">
                                <input id="attendance_presence" name="attendances[{{ $student->id }}]" class="leading-tight" type="checkbox"
                                       value="presence">
                                <span class="text-success">حضور</span>
                            </label>

                            <label class="ml-4 block text-gray-500 font-semibold">
                                <input id="attendance_absent" name="attendances[{{ $student->id }}]" class="leading-tight" type="checkbox"
                                       value="absent">
                                <span class="text-danger">غياب</span>
                                <div id="absent-reason" style="display: none;">
                                    <div class="form-group">
                                        <label for="absent_reason">سبب الغياب  :</label>
                                        <textarea name="absent_reason" id="absent_reason" class="form-control"></textarea>
                                    </div>
                                </div>
                            </label>

                        @endif

                        <input type="hidden" name="student_id[]" value="{{ $student->id }}">
                        <input type="hidden" name="department_id" value="{{ $student->department_id }}">
                        <input type="hidden" name="classroom_id" value="{{ $student->classroom_id }}">
                       

                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <P>
            <button class="btn btn-success" type="submit">تأكيد الحضور</button>
        </P>
    </form><br>
    <!-- row closed -->
@endsection
@section('js')
    @toastr_js
    @toastr_render

 {{--   <script>
        $('#attendance_absent').on('change',function(e) {
           
                $('#absent-reason').show();
          
        });

        $('#attendance_presence').on('change',function(e) {
           
           $('#absent-reason').hide();
     
        });
    </script>
    --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var presenceCheckbox = document.getElementById('attendance_presence');
            var absentCheckbox = document.getElementById('attendance_absent');
    
            presenceCheckbox.addEventListener('change', function () {
                if (presenceCheckbox.checked) {
                    $('#absent-reason').hide();
                    absentCheckbox.checked = false;

                }
            });
    
            absentCheckbox.addEventListener('change', function () {
                if (absentCheckbox.checked) {
                    presenceCheckbox.checked = false;
                    $('#absent-reason').show();
                }
            });
        });
    </script>

@endsection