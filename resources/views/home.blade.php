@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="country_page">Quản lý admin</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <br><br>
                    <img class="img-responsive" src="../img/homeadmin.gif" alt="Phim hay 2021- Xem phim hay nhất" style="width: 400px;height: 300px;margin: auto;" />
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
