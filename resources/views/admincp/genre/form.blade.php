@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="country_page">Quản lý thể loại</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }} 
                        </div>
                    @endif

                    @if(!isset($genre))
                        {!! Form::open(['route'=>'genre.store','method'=>'POST']) !!}
                    @else
                        {!! Form::open(['route'=>['genre.update',$genre->id], 'method'=>'PUT']) !!}
                    @endif    

                        <div class="mb-3">
                            {!! Form::label('title', 'Title', []) !!}
                            {!! Form::text('title', isset($genre)? $genre->title : '', ['class'=>'form-control','placeholder'=>'Nhập vào dữ liệu ...','id'=>'slug', 'onkeyup'=>'ChangeToSlug()']) !!}
                        </div>
                        <div class="mb-3">
                            {!! Form::label('slug', 'Slug', []) !!}
                            {!! Form::text('slug', isset($genre)? $genre->slug : '', ['class'=>'form-control','placeholder'=>'Nhập vào dữ liệu ...','id'=>'convert_slug']) !!}
                        </div>
                        <div class="mb-3">
                            {!! Form::label('description', 'Description', []) !!}
                            {!! Form::textarea('description', isset($genre)? $genre->description : '', ['style'=>'resize:none','class'=>'form-control','placeholder'=>'Nhập vào dữ liệu ...','id'=>'description']) !!}
                        </div>
                        <br>
                        <div class="mb-3">
                            {!! Form::label('active', 'Active   ', []) !!}
                            {!! Form::select('status', ['1'=>'Hiển thị','0'=>'Không'], isset($genre)? $genre->status : null, ['class'=>'form-select']) !!}
                        </div>
                        <br>
                    @if(!isset($genre))
                        {!! Form::submit('Thêm dữ liệu', ['class'=>'btn btn-success']) !!}
                    @else
                        {!! Form::submit('Cập nhật', ['class'=>'btn btn-success']) !!} 
                    @endif
                         
                    {!! Form::close() !!}
                </div>
                <br>
            </div>
        </div>
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
            <tbody>
                @foreach($list as $key => $genre)
                <tr>
                     <th scope="row">{{$key}}</th>
                     <td>{{$genre->title}}</td>
                     <td>{{$genre->description}}</td>
                     <td>{{$genre->slug}}</td>
                     <td>
                         @if($genre->status)
                            Hiển thị
                         @else
                            Không hiển thị
                         @endif      
                     </td>
                     <td>
                        <div style="display:flex;gap:10px">
                            {!! Form::open(['method'=>'DELETE','route'=>['genre.destroy',$genre->id],'onsubmit'=>'return confirm("Xoá hay không?")']) !!}
                                {!! Form::submit('Xoá', ['class'=>'btn btn-danger']) !!}
                            {!! Form::close() !!}
                            <a href="{{route('genre.edit',$genre->id)}}" class="btn btn-warning">Sửa</a>
                        </div>
                     </td>
                </tr>
                @endforeach
           </tbody>
        </table>
    </div>
</div>
@endsection
