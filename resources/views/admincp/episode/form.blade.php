@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Quản lý Tập Phim</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if(!isset($episode))
                        {!! Form::open(['route'=>'episode.store','method'=>'POST','enctype'=>'multipart/form-data']) !!}
                    @else
                        {!! Form::open(['route'=>['episode.update',$episode->id], 'method'=>'PUT','enctype'=>'multipart/form-data']) !!}
                    @endif    

                        
                        <div class="mb-3">
                            {!! Form::label('Movie', 'Chọn Phim', []) !!}
                            {!! Form::select('movie_id', $list_movie, isset($episode)? $episode->movie_id : null, ['class'=>'form-select select-movie']) !!}
                        </div>
                        <div class="mb-3">
                            {!! Form::label('link', 'Link Phim', []) !!}
                            {!! Form::text('link', isset($episode)? $episode->linkphim : '', ['class'=>'form-control','placeholder'=>'Nhập vào dữ liệu ...']) !!}
                        </div>
                        <div class="mb-3">
                            {!! Form::label('episode', 'Tập Phim', []) !!}
                            <select name="episode" class="form-select" id="show_movie">
                            
                            </select>
                        </div>
                    @if(!isset($movie))
                        {!! Form::submit('Thêm Tập Phim', ['class'=>'btn btn-success']) !!}
                    @else
                        {!! Form::submit('Cập nhật Tập Phim', ['class'=>'btn btn-success']) !!} 
                    @endif
                         
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
