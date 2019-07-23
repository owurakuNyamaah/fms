@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header text-center">Total number of Students = <b>{{$totalStds[0]->numStds}}</b></div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <a href='/stdClass' class='btn btn-primary btn-lg' style='width:40%;padding:20px 0;margin:15px'><h3><i class='fas fa-home fa-lg'></i> Class</h3></a>
                    <a href='/fees' class='btn btn-primary btn-lg' style='width:40%;padding:20px 0;margin:15px'><h2><i class='fas fa-dollar-sign fa-lg'></i> Take Fees</h2></a>
                
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
