@extends('layouts.master')
@section('css')
    @toastr_css
@section('title')
    الإرشاد
@stop
@endsection
@section('page-header')
<!-- breadcrumb -->
@section('PageTitle')
   الإرشاد   

@stop
<!-- breadcrumb -->
@endsection
@section('content')
<!-- row -->
<div class="row">


@if ($errors->any())
    <div class="error">{{ $errors->first('name') }}</div>
@endif



<div class="col-xl-12 mb-30">
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

            <button type="button" class="button x-small" data-toggle="modal" data-target="#exampleModal">
               اضافة مرشد جديد
            </button>
            <br><br>

            <div class="table-responsive">
                <table id="datatable" class="table  table-hover table-sm table-bordered p-0" data-page-length="50"
                    style="text-align: center">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th> الاسم الاول</th>
                            <th> الاسم الاخير</th>

                            <th>رقم الهاتف</th>
                            <th>الصورة الشخصية</th>
                            <th>العمليات</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 0; ?>
                        @foreach ($advisers as $adviser)
                            <tr>
                                <?php $i++; ?>
                                <td>{{ $i }}</td>
                                <td>{{ $adviser->first_name }}</td>
                                <td>{{ $adviser->last_name }}</td>

                                <td>{{ $adviser->phone }}</td>
                                <td><img src="{{ $adviser->getPhotoUrl()}}" alt="adviser Image" height="60px" width="60px"></td>
                                <td>
                                    <button type="button" class="btn btn-info btn-sm" data-toggle="modal"
                                        data-target="#edit{{ $adviser->id }}"
                                        title="تعديل"><i class="fa fa-edit"></i></button>
                                    <button type="button" class="btn btn-danger btn-sm" data-toggle="modal"
                                        data-target="#delete{{ $adviser->id }}"
                                        title="حذف"><i
                                            class="fa fa-trash"></i></button>
                                </td>
                            </tr>

                            <!-- edit_modal_adviser -->
                            <div class="modal fade" id="edit{{ $adviser->id }}" tabindex="-1" role="dialog"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title"
                                                id="exampleModalLabel">
                                               تعديل معلومات المرشد
                                            </h5>
                                            <button type="button" class="close" data-dismiss="modal"
                                                aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <!-- add_form -->
                                            <form action="{{ route('dashboard.advisers.update',$adviser->id) }}" method="post" enctype="multipart/form-data">
                                                {{ method_field('patch') }}
                                                @csrf
                                                <div class="row">
                                                    <div class="col">
                                                        <label for="Name"
                                                            class="mr-sm-2">الاسم الاول
                                                            :</label>
                                                        <input id="Name" type="text" name="first_name"
                                                            class="form-control"
                                                            value="{{old('first_name',$adviser->first_name)}}"
                                                            required>
                                                        <input id="id" type="hidden" name="id" class="form-control"
                                                            value="{{ $adviser->id }}">
                                                    </div>
                                                    <div class="col">
                                                        <label for="lname" class="mr-sm-2">الاسم الاخير 
                                                            :</label>
                                                        <input id="lname" type="text" name="last_name" class="form-control"  value="{{old('last_name',$adviser->last_name)}}"
                                                        required>
                                                    </div>

                                                </div>
                                                <div class="form-group">
                                                    <label
                                                        for="">رقم الهاتف
                                                        :</label>
                                                        <input id="phone" type="number" name="phone"
                                                        class="form-control"
                                                        value="{{old('phone',$adviser->phone)}}"
                                                        required>
                                                   
                                                </div>
                                                <div class="form-group">
                                                    <label
                                                        for="">كلمة المرور
                                                        :</label>
                                                        <input id="password" type="password" name="password"
                                                        class="form-control fa-eye">
                                                </div>

                                                <div class="form-group">
                                                    <label
                                                        for="">الصورة الشخصية
                                                        :</label>
                                                        <img src="{{ $adviser->getPhotoUrl() }}" alt="adviser Image" height="60px" width="60px">
                                                        <input id="photo" type="file" name="photo"
                                                        class="form-control" required>
                                                </div>
                                                <br><br>

                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-dismiss="modal">إغلاق</button>
                                                    <button type="submit"
                                                        class="btn btn-success">حفظ</button>
                                                </div>
                                            </form>

                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- delete_modal_adviser -->
                            <div class="modal fade" id="delete{{ $adviser->id }}" tabindex="-1" role="dialog"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title"
                                                id="exampleModalLabel">
                                            هل أنت متأكد من حذف المرشد ؟
                                            </h5>
                                            <button type="button" class="close" data-dismiss="modal"
                                                aria-label="Close"> 
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('dashboard.advisers.destroy', $adviser->id) }}" method="post">
                                                {{ method_field('Delete') }}
                                                @csrf
                                                <input id="id" type="hidden" name="id" class="form-control"
                                                    value="{{ $adviser->id }}">
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-dismiss="modal">إلغاء</button>
                                                    <button type="submit"
                                                        class="btn btn-danger">تأكيد</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>


                        @endforeach
                </table>
            </div>
        </div>
    </div>
</div>



<!-- add_modal_adviser -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title" id="exampleModalLabel">
                    اضافة مشرف جديد
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- add_form -->
                <form action="{{ route('dashboard.advisers.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col">
                            <label for="Name" class="mr-sm-2">الاسم 
                                :</label>
                            <input id="fname" type="text" name="first_name" class="form-control">
                        </div>
                        
                        <div class="col">
                            <label for="lname" class="mr-sm-2">الاسم الاخير 
                                :</label>
                            <input id="lname" type="text" name="last_name" class="form-control">
                        </div>

                    </div>
                    <div class="row">
                        <div class="col">
                            <label for="phone" class="mr-sm-2">رقم الهاتف 
                                :</label>
                            <input id="phone" type="number" name="phone" class="form-control">
                        </div>

                    </div>
                    <div class="row">
                        <div class="col">
                            <label for="password" class="mr-sm-2">كلمة المرور  
                                :</label>
                            <input id="password" type="text" name="password" class="form-control">
                        </div>

                    </div>
                    <div class="row">
                        <div class="col">
                            <label for="photo" class="mr-sm-2"> الصورة الشخصية  
                                :</label>
                            <input id="photo" type="file" name="photo" class="form-control">
                        </div>

                    </div>
                  
                    <br><br>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary"
                    data-dismiss="modal">إغلاق</button>
                <button type="submit" class="btn btn-success">حفظ</button>
            </div>
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

