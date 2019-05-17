@extends('layouts.app')

@section('content')
    <div class='container'>
        <a href='/fees' class='btn btn-secondary'><i class='fas fa-arrow-left'></i>Back</a>
        <h4 class='text-center'>Manage Fees</h4><hr>
        @if(!empty($stds[0]))
        <table class='table table-striped'>
            <tr>
                <th>STUDENT</th>
                <th>CLASS</th>
                <th>FEES</th>
                <th>Action</th>
            </tr>
            <tr>
                <td>{{$stds[0]->stdName}}</td>
                <td>{{$stds[0]->class}}</td>
                <td>{{$stds[0]->fees}}</td>
                <td> 
                    <button data-toggle='modal' data-target='#take' class='btn btn-primary'>Take Fees</button>
                    <div id='take' class='modal fade' role='dialog'>
                        <div class='modal-dialog' role='document'>
                            <div class='modal-content'>
                                <div class='text-right'><button class='close' data-dismiss='modal'>&times;</button></div>
                                <div class='modal-header'>
                                    <h5 class='text-center'>Take Fees</h5>
                                </div>
                                <div class='modal-body'>
                                    <form role='form' action='/fees' method='POST' class='form-group'>
                                        @csrf
                                        <input type='hidden' name='stdClass' value='{{$stds[0]->class}}'>
                                        <label class='control-label'>Student Name</label>
                                        <input type='text' name='stdName' value='{{$stds[0]->stdName}}' class='form-control' readonly>
                                        <label class='control-label'>Fees</label>
                                        <input type='number' name='fees' value='{{$stds[0]->fees}}' class='form-control' readonly>
                                        <label class='control-label'>Pay</label>
                                        <input type='number' name='pay' class='form-control'>
                                        <label class='control-label'>Academic Year</label>
                                        <input type='text' name='academicYear' class='form-control' placeholder='eg. 2018/19' required>
                                        <label class='control-label'>Term</label>
                                        <select name='term' class='browser-default custom-select mb-3' required>
                                            <option selected></option>
                                            <option value='1st term'>First Term</option>
                                            <option value='2nd term'>Second Term</option>
                                            <option value='3rd term'>Third Term</option>
                                        </select>
                                        <label class='control-label'>Remarks</label>
                                        <input type='text' name='remarks' class='form-control'>
                                        <button type='submit' name='submit' class='btn btn-primary'>Save</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
            @else 
                <h1 class='text-center text-success'>Student does not exist</h1>
                <h5 class='text-center'>OR</h5>
                <h3 class='text-center text-success'>Student and class do not match</h3>
            @endif
    </div>
@endsection