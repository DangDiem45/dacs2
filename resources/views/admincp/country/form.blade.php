@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="country_page">Quản lý quốc gia</div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert"> 
                            {{ session('status') }}
                        </div>
                    @endif

                    @if(!isset($country))
                        {!! Form::open(['route'=>'country.store','method'=>'POST']) !!}
                    @else
                        {!! Form::open(['route'=>['country.update',$country->id], 'method'=>'PUT']) !!}
                    @endif    

                        <div class="mb-3">
                            {!! Form::label('title', 'Title', []) !!}
                            {!! Form::text('title', isset($country)? $country->title : '', ['class'=>'form-control','placeholder'=>'Nhập vào dữ liệu ...','id'=>'slug', 'onkeyup'=>'ChangeToSlug()']) !!}
                        </div>
                        <div class="mb-3">
                            {!! Form::label('slug', 'Slug', []) !!}
                            {!! Form::text('slug', isset($country)? $country->slug : '', ['class'=>'form-control','placeholder'=>'Nhập vào dữ liệu ...','id'=>'convert_slug']) !!}
                        </div>
                        <div class="mb-3">
                            {!! Form::label('description', 'Description', []) !!}
                            {!! Form::textarea('description', isset($country)? $country->description : '', ['style'=>'resize:none','class'=>'form-control','placeholder'=>'Nhập vào dữ liệu ...','id'=>'description']) !!}
                        </div>
                        <br>
                        <div class="mb-3">
                            {!! Form::label('active', 'Active   ', []) !!}
                            {!! Form::select('status', ['1'=>'Hiển thị','0'=>'Không'], isset($country)? $country->status : null, ['class'=>'form-select']) !!}
                        </div>
                        <br>
                    @if(!isset($country))
                        {!! Form::submit('Thêm dữ liệu', ['class'=>'btn btn-success']) !!}
                    @else
                        {!! Form::submit('Cập nhật', ['class'=>'btn btn-success']) !!} 
                    @endif
                         
                    {!! Form::close() !!}
                </div>
            </div>
            <br>
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
                @foreach($list as $key => $country)
                <tr>
                     <th scope="row">{{$key}}</th>
                     <td>{{$country->title}}</td>
                     <td>{{$country->description}}</td>
                     <td>{{$country->slug}}</td>
                     <td>
                         @if($country->status)
                            Hiển thị
                         @else
                            Không hiển thị
                         @endif      
                     </td>
                     <td>
                        <div style="display:flex;gap:10px">
                            {!! Form::open(['method'=>'DELETE','route'=>['country.destroy',$country->id],'onsubmit'=>'return confirm("Xoá hay không?")']) !!}
                            {!! Form::submit('Xoá', ['class'=>'btn btn-danger']) !!}
                            {!! Form::close() !!}
                            <a href="{{route('country.edit',$country->id)}}" class="btn btn-warning">Sửa</a>
                        </div>
                     </td>
                </tr>
                @endforeach
           </tbody>
        </table>
    </div>
</div>
@endsection
