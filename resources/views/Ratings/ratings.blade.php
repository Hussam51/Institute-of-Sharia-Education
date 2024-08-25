@extends('layouts.master')
@section('css')
    @toastr_css
@section('title')
    قائمة النقاط

@stop
@endsection
@section('page-header')
<!-- breadcrumb -->
@section('PageTitle')
    قائمة النقاط
@stop
<!-- breadcrumb -->
@endsection
@section('content')
<!-- row -->
<div class="row">
    <div class="container">
        <h4 style="color: rgb(97, 97, 236)">نقاط تقييم الطلاب :</h4> 
          
        <br>
        <div id="score-container">
            {{$classroom->name}}
            <h3> <span id="score"></span></h3>
           
        
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>الطالب</th>
                    <th>عدد النقاط</th>
                  
                   

                </tr>
            </thead>
            <tbody>
                @foreach ($students as $student)
                    <tr>
                        <td>{{ $student->id }}</td>
                        <td>{{ $student->first_name . ' ' . $student->last_name }}</td>
                        <td>
                            
                            <input type="number" class="student-score" data-id={{ $student->rating->id }}
                            value="{{ $student->rating->score }}" /> 
                        </td>
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

<script>
   $(".student-score").on("change", function (e) {
        // Get the initial score
     
        // Function to update the score using AJAX
        let id = $(this).data('id');
            $.ajax({
                url: "/dashboard/ratings/"+ id,
                type: "put",
                data: {
                    score:$(this).val(),
                     _token:"{{ csrf_token() }}",
                },
               
            });
           
    });
</script>
@endsection
