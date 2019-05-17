@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <a href='/stdClass' class='btn btn-primary btn-lg' style='width:40%;padding:20px 0;margin:15px'><h3><i class='fas fa-home fa-lg'></i> Class</h3></a>
                    <a href='/students' class='btn btn-primary btn-lg' style='width:40%;padding:20px 0;margin:15px'><h3><i class='fas fa-users fa-lg'></i> Students</h1></a><br>
                    <a href='/fees' class='btn btn-info btn-lg' style='width:40%;padding:20px 0;margin:15px'><h2><i class='fas fa-dollar-sign fa-lg'></i> Fees</h2></a>
                    <button data-toggle='modal' data-target='#report' class='btn btn-info btn-lg' style='width:40%;padding:20px 0;margin:15px'><h2><i class='far fa-clipboard fa-lg'></i> Report</h2></button>
                
                    <div id='report' class='modal fade' role='dialog'>
                        <div class='modal-dialog' role='document'>
                            <div class='modal-content'>
                                <button class='close' data-dismiss='modal'>&times;</button>
                                <div class='modal-header'>
                                    <h3 class='modal-title'>Fee Report</h3>
                                </div>
                                <div class='modal-body'>
                                    <form role='form' action='/dashboard/show' method='POST'>
                                        @csrf
                                        <label class='control-form'>Student Name</label>
                                        <input type='text' name='stdName' class='form-control' required><br>
                                        <label class='control-form'>Student Class</label>
                                        <select name='stdClass' class='browser-default custom-select mb-3' required>
                                            <option selected> </option>
                                            @foreach($stdClasses as $stdClass)
                                            <option value='{{$stdClass->className}}'>{{$stdClass->className}}</option>
                                            @endforeach
                                        </select>
                                        <label class='control-form'>Academic Year</label>
                                        <select name='academicYear' class='browser-default custom-select mb-3' required>
                                            <option selected> </option>
                                            @if(count($academicYear)>0)
                                                @foreach($academicYear as $academic)
                                                    <option value='{{$academic->academic}}'>{{$academic->academic}}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                        <button type='submit' name='submit' class='btn btn-primary'>Submit</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
