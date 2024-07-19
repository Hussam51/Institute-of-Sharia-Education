@extends('layouts.master')
@section('css')
    @toastr_css
@section('title')
{{ $advertisement->title }}- الإعلان
@stop
@endsection
@section('page-header')
<!-- breadcrumb -->
@section('PageTitle')
{{ $advertisement->title }}- الإعلان

@stop
<!-- breadcrumb -->
@endsection
@section('content')
<!-- row -->
<div class="row">

    <div class="container">
        <h3>{{ $advertisement->title }}</h3>
        <p>{{ $advertisement->content }}</p>
        <p><i style="color: rgb(8, 218, 255)">Published at:</i> {{ $advertisement->created_at->format('Y-m-d') }}</p>
    </div>

</div>

<!-- row closed -->
@endsection
@section('js')
@toastr_js
@toastr_render
@endsection
