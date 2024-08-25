@extends('layouts.master')
@section('css')
    @toastr_css
@section('title')
     حضور المعلمين 
@stop
@endsection
@section('page-header')
    <!-- breadcrumb -->
 قائمة الحضور والغياب للمعلمين
@section('PageTitle')
    قائمة الحضور والغياب للمعلمين
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
    <form method="post" action="{{ route('dashboard.teacher_attendences.store') }}">

        @csrf
        <table id="datatable" class="table  table-hover table-sm table-bordered p-0" data-page-length="50"
               style="text-align: center">
            <thead>
            <tr>
                <th class="alert-success">#</th>
                <th class="alert-success">الاسم الاول </th>
                <th class="alert-success">الاسم الاخير </th>
              
                <th class="alert-success">حالة الحضور</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($teachers as $teacher)
                <tr>
                    <td>{{ $loop->index + 1 }}</td>
                    <td>{{ $teacher->first_name }}</td>
                    <td>{{ $teacher->last_name }}</td>
                    <td>

                        @if(isset($teacher->attendances()->where('attendance_date',date('Y-m-d'))->first()->teacher_id))

                            <label class="block text-gray-500 font-semibold sm:border-r sm:pr-4">
                                <input name="attendances[{{ $teacher->id }}]" disabled
                                @checked($teacher->attendances()->first()->attendance_status == 1 )
                                       class="leading-tight" type="checkbox" value="presence">
                                <span class="text-success">حضور</span>
                            </label>


                        
                           



                            <label class="ml-4 block text-gray-500 font-semibold">
                                <input  name="attendances[{{ $teacher->id }}]" disabled 
                                @checked($teacher->attendances()->first()->attendance_status == 0 )
                                      
                                       class="leading-tight" type="checkbox" value="absent">
                                <span class="text-danger">غياب</span>
                               
                            </label>
                           

                        @else

                            <label class="block text-gray-500 font-semibold sm:border-r sm:pr-4">
                                <input id="attendance_presence" name="attendances[{{ $teacher->id }}]" class="leading-tight" type="checkbox"
                                       value="presence">
                                <span class="text-success">حضور</span>
                            </label>

                          
                            <label class="ml-4 block text-gray-500 font-semibold">
                                <input id="attendance_absent" name="attendances[{{ $teacher->id }}]" class="leading-tight" type="checkbox"
                                       value="absent">
                                <span class="text-danger">غياب</span>
                               
                            </label>

                        @endif

                        <input type="hidden" name="teacher_id[]" value="{{ $teacher->id }}">
                        <input type="hidden" name="department_id" value="{{ $teacher->department_id }}">
                       

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
                    absentCheckbox.checked = false;
                }
            });

        
    
            absentCheckbox.addEventListener('change', function () {
                if (absentCheckbox.checked) {
                    presenceCheckbox.checked = false;

                }
            });
        });
    </script>

@endsection