@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="country_page">Quản lý phim</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if(!isset($movie))
                        {!! Form::open(['route'=>'movie.store','method'=>'POST','enctype'=>'multipart/form-data']) !!}
                    @else
                        {!! Form::open(['route'=>['movie.update',$movie->id], 'method'=>'PUT','enctype'=>'multipart/form-data']) !!}
                    @endif    

                        <div class="mb-3">
                            {!! Form::label('title', 'Title', []) !!}
                            {!! Form::text('title', isset($movie)? $movie->title : '', ['class'=>'form-control','placeholder'=>'Nhập vào dữ liệu ...','id'=>'slug', 'onkeyup'=>'ChangeToSlug()']) !!}
                        </div>
                        <br>
                        <div class="mb-3">
                            {!! Form::label('episode', 'Episode', []) !!}
                            {!! Form::text('episode', isset($movie)? $movie->episode : '', ['class'=>'form-control','placeholder'=>'Nhập vào dữ liệu ...']) !!}
                        </div>
                        <br>
                        <div class="mb-3">
                            {!! Form::label('thoi_luong', 'Time', []) !!}
                            {!! Form::text('thoi_luong', isset($movie)? $movie->thoi_luong : '', ['class'=>'form-control','placeholder'=>'Nhập vào dữ liệu ...','id'=>'slug', 'onkeyup'=>'ChangeToSlug()']) !!}
                        </div>
                        <br>
                        <div class="mb-3">
                            {!! Form::label('Tên tiếng anh', 'English', []) !!}
                            {!! Form::text('name_eng', isset($movie)? $movie->name_eng : '', ['class'=>'form-control','placeholder'=>'Nhập vào dữ liệu ...']) !!}
                        </div>
                        <br>
                        <div class="mb-3">
                            {!! Form::label('trailer', 'Trailer', []) !!}
                            {!! Form::text('trailer', isset($movie)? $movie->trailer : '', ['class'=>'form-control','placeholder'=>'Nhập vào dữ liệu ...']) !!}
                        </div>
                        <br>
                        <div class="mb-3">
                            {!! Form::label('slug', 'Slug', []) !!}
                            {!! Form::text('slug', isset($movie)? $movie->slug : '', ['class'=>'form-control','placeholder'=>'Nhập vào dữ liệu ...','id'=>'convert_slug']) !!}
                        </div>
                        <br>
                        <div class="mb-3">
                            {!! Form::label('description', 'Description', []) !!}
                            {!! Form::textarea('description', isset($movie)? $movie->description : '', ['style'=>'resize:none','class'=>'form-control','placeholder'=>'Nhập vào dữ liệu ...','id'=>'description']) !!}
                        </div>
                        <br>
                        <div class="mb-3">
                            {!! Form::label('status', 'Active', []) !!}
                            <br>
                            {!! Form::select('status', ['1'=>'Hiển thị','0'=>'Không'], isset($movie)? $movie->status : null, ['class'=>'form-select']) !!}
                        </div>
                        <br>
                        <div class="mb-3">
                            {!! Form::label('resolution', 'Resolution', []) !!}<br>
                            {!! Form::select('resolution', ['0'=>'HD','1'=>'SD','2'=>'HDCam','3'=>'Cam','4'=>'FullHD','5'=>'Trailer'], isset($movie)? $movie->resolution : null, ['class'=>'form-select']) !!}
                        </div>
                        <br>
                        <div class="mb-3">
                            {!! Form::label('subtitle', 'Subtitle', []) !!}<br>
                            {!! Form::select('subtitle', ['1'=>'Thuyết minh','0'=>'Phụ đề'], isset($movie)? $movie->subtitle : null, ['class'=>'form-select']) !!}
                        </div>
                        <br>
                        <div class="mb-3">
                            {!! Form::label('category', 'Category', []) !!}<br>
                            {!! Form::select('category_id', $category, isset($movie)? $movie->category_id : null, ['class'=>'form-select']) !!}
                        </div>
                        <br>
                        <div class="mb-3">
                            {!! Form::label('Genre', 'Thể loại') !!}
                            <br>
                            @foreach($list_genre as $key => $gen)
                                @if(isset($movie))
                                    {!! Form::checkbox('genre[]', $gen->id , isset($movie_genre) && $movie_genre->contains($gen->id)? true : false) !!}
                                @else
                                    {!! Form::checkbox('genre[]', $gen->id, '') !!}
                                @endif    
                                {!! Form::label('genre', $gen->title) !!}
                            @endforeach
                        </div>
                        <br>
                        <div class="mb-3">
                            {!! Form::label('country', 'Country', []) !!}<br>
                            {!! Form::select('country_id', $country, isset($movie)? $movie->country_id : null, ['class'=>'form-select']) !!}
                        </div>
                        <br>
                        <div class="mb-3">
                            {!! Form::label('Hot', 'Hot', []) !!}<br>
                            {!! Form::select('phim_hot', ['1'=>'Có','0'=>'Không'], isset($movie)? $movie->phim_hot : null, ['class'=>'form-select']) !!}
                        </div>
                        <br>
                        <div class="mb-3">
                            {!! Form::label('image', 'Image', []) !!} <br>
                            {!! Form::file('image', ['class'=>'form-select-file']) !!}
                            <br> <br>
                            @if(isset($movie))
                                <img width="20%" src="{{asset('uploads/movie/'.$movie->image)}}">
                            @endif
                        </div>
                    @if(!isset($movie))
                        {!! Form::submit('Thêm dữ liệu', ['class'=>'btn btn-success']) !!}
                    @else
                        <br>{!! Form::submit('Cập nhật', ['class'=>'btn btn-success']) !!} 
                    @endif
                         
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid"> 
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table" id="tablephim">
                    <thead>
                      <tr>
                         <th scope="col">#</th>
                         <th scope="col">Title</th>
                         <th scope="col">Time</th>
                         <th scope="col">Image</th>
                         <th scope="col">Hot</th>
                         <th scope="col">Resolution</th>
                         <th scope="col">Subtitle</th>
                         <th scope="col">Description</th>
                         <th scope="col">Slug</th>
                         <th scope="col">Active/Inactive</th>
                         <th scope="col">Category</th>
                         <th scope="col">Genre</th>
                         <th scope="col">Country</th>
                         <th scope="col">Episode</th>
                         <th scope="col">Create Date</th>
                         <th scope="col">Update Date</th>
                         <!-- <th scope="col">Top views</th> -->
                         <th scope="col">Manage</th>
                      </tr>
                    </thead>
                    <tbody>
                        @foreach($list as $key => $movie)
                        <tr>
                             <th scope="row">{{$key}}</th>
                             <td>{{$movie->title}}</td>
                             <td>{{$movie->thoi_luong}}</td>
                             <td><img width="100%" src="{{asset('uploads/movie/'.$movie->image)}}"></td>
                             <td>
                                 @if($movie->phim_hot==0)
                                    Không
                                 @else
                                    Có
                                 @endif      
                             </td>
                             <td>
                                 @if($movie->resolution==0)
                                    HD
                                 @elseif($movie->resolution==1)
                                    SD
                                 @elseif($movie->resolution==2)
                                    HDCam
                                @elseif($movie->resolution==3)
                                    Cam
                                @elseif($movie->resolution==4)
                                    FullHD 
                                @else
                                    Trailer    
                                @endif         
                             </td>
                             <td>
                                 @if($movie->subtitle==0)
                                    Phụ đề
                                 @else($movie->subtitle==1)
                                    Thuyết minh
                                @endif         
                             </td>
                             <td>{{$movie->description}}</td>
                             <td>{{$movie->slug}}</td>
                             <td>
                                 @if($movie->status)
                                    Hiển thị
                                 @else
                                    Không hiển thị
                                 @endif      
                             </td>
                             <td>{{$movie->category->title}}</td>
                             <td>
                                @foreach($movie->movie_genre as $gen)
                                    <span class="badge bg-secondary">{{$gen->title}}</span>
                                @endforeach
                             </td>
                             <td>{{$movie->country->title}}</td>
                             <td>{{$movie->episode}}</td>
                             <td>{{$movie->create_date}}</td>
                             <td>{{$movie->update_date}}</td>
                             <!-- <td>
                                 {!! Form::select('topview', ['0'=>'Ngày','1'=>'Tuần','2'=>'Tháng'], isset($movie->topview)? $movie->topview : null, ['class'=>'select-topview','id'=>'$movie->id']) !!}
                             </td> -->
                             <td>
                                {!! Form::open(['method'=>'DELETE','route'=>['movie.destroy',$movie->id],'onsubmit'=>'return confirm("Xoá hay không?")']) !!}
                                    {!! Form::submit('Xoá', ['class'=>'btn btn-danger']) !!}
                                {!! Form::close() !!}
                                <a href="{{route('movie.edit',$movie->id)}}" class="btn btn-warning">Sửa</a>
                             </td>
                        </tr>
                        @endforeach
                   </tbody>
                </table>
            </div>
        </div>    
    </div>
</div>    
@endsection
