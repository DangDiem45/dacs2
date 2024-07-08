@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="country_page">Quản lý danh mục</div>

                <div class="card-body">
                    @if (session('status')) 
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div> 
                    @endif

                    @if(!isset($category))
                        {!! Form::open(['route'=>'category.store','method'=>'POST']) !!}
                    @else
                        {!! Form::open(['route'=>['category.update',$category->id], 'method'=>'PUT']) !!}
                    @endif    

                        <div class="mb-3">
                            {!! Form::label('title', 'Title', []) !!}
                            {!! Form::text('title', isset($category)? $category->title : '', ['class'=>'form-control','placeholder'=>'Nhập vào dữ liệu ...','id'=>'slug','onkeyup'=>'ChangeToSlug()']) !!}
                        </div>
                        <div class="mb-3">
                            {!! Form::label('slug', 'Slug', []) !!}
                            {!! Form::text('slug', isset($category)? $category->slug : '', ['class'=>'form-control','placeholder'=>'Nhập vào dữ liệu ...','id'=>'convert_slug']) !!}
                        </div>
                        <div class="mb-3">
                            {!! Form::label('description', 'Description', []) !!}
                            {!! Form::textarea('description', isset($category)? $category->description : '', ['style'=>'resize:none','class'=>'form-control','placeholder'=>'Nhập vào dữ liệu ...','id'=>'description']) !!}
                        </div>
                        <br>
                        <div class="mb-3">
                            {!! Form::label('active', 'Active   ', []) !!}
                            {!! Form::select('status', ['1'=>'Hiển thị','0'=>'Không'], isset($category)? $category->status : null, ['class'=>'form-select']) !!}
                        </div>
                        <br>
                    @if(!isset($category))
                        {!! Form::submit('Thêm dữ liệu', ['class'=>'btn btn-success']) !!}
                    @else
                        {!! Form::submit('Cập nhật', ['class'=>'btn btn-success']) !!} 
                    @endif
                         
                    {!! Form::close() !!}
                </div>
            </div>
            <br>
        </div>

        <div class="container-fluid">
            <table class="table">
                <thead>
                  <tr>
                     <th scope="col">#</th>
                     <th scope="col">Title</th>
                     <th scope="col">Description</th>
                     <th scope="col">Slug</th>
                     <th scope="col">Active/Inactive</th>
                     <th scope="col">Manage</th>
                  </tr>
                </thead>
                <tbody class="order_position">
                    @foreach($list as $key => $cate)
                    <tr id="{{$cate->id}}">
                         <th scope="row">{{$key}}</th>
                         <td>{{$cate->title}}</td>
                         <td>{{$cate->description}}</td>
                         <td>{{$cate->slug}}</td>

                         <td>
                             @if($cate->status)
                                Hiển thị
                             @else
                                Không hiển thị
                             @endif      
                         </td>
                         <td>
                            <div style="display:flex;gap:10px">
                                {!! Form::open(['method'=>'DELETE','route'=>['category.destroy',$cate->id],'onsubmit'=>'return confirm("Xoá hay không?")']) !!}
                                    {!! Form::submit('Xoá', ['class'=>'btn btn-danger']) !!}
                                {!! Form::close() !!}
                                <a href="{{route('category.edit',$cate->id)}}" class="btn btn-warning">Sửa</a>
                            </div>
                         </td>
                    </tr>
                    @endforeach
               </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
