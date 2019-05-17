@extends('layouts.app')

@section('content')
    <div class='container'>
        <a href='/dashboard' class='btn btn-secondary btn-sm'><i class='fas fa-arrow-left'></i> Back</a>
        <h4 class='text-center'>Manage Fees</h4><hr>
        <div class='text-right'>
            <button class='btn btn-success' data-toggle='modal' data-target='#paid'>Check Payment By Class</button>
        </div>
        <div id='paid' class='modal fade' role='dialog'>
            <div class='modal-dialog' role='document'>
                <div class='modal-content'>
                    <div class='close' data-dismiss='modal'>&times;</div>
                    <div class='modal-header'>
                        <h3 class='modal-title'>Student with part or full payment</h3>
                    </div>
                    <div class='modal-body'>
                        <form role='form' action='/paid' method='get' class='form-group'>
                            <label class='control-label'>Class Name</label>
                            <select name='stdClass' class='browser-default custom-select' required>
                                    <option selected>select class</option>
                                    @foreach($stdClasses as $stdClass)
                                    <option value='{{$stdClass->className}}'>{{$stdClass->className}}</option>
                                    @endforeach
                            </select>
                            <label class='control-label'>Term</label>
                            <select name='term' class='browser-default custom-select mb-3' required>
                                    <option selected></option>
                                    <option value='1st term'>First Term</option>
                                    <option value='2nd term'>Second Term</option>
                                    <option value='3rd term'>Third Term</option>
                            </select>
                                
                            <label class='control-label'>Academic Year</label>
                            <input type='text' name='academicYear' class='form-control'>
                            <button type='submit' class='btn btn-primary'>Save</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <table class='table table-bordered'>
            <tr>
            <td>
                <form action='/fees/show' method='POST' class='form-inline'>
                    @csrf
                    <input type='hidden' name='_method' value='GET'>
                    <input type='text' name='stdSearch' class='form-control' placeholder="Enter student's name" required>
                    <i class='fas fa-arrow-right fa-lg'></i>
                    <select name='stdClass' class='browser-default custom-select' required>
                            <option selected>select class</option>
                            @foreach($stdClasses as $stdClass)
                            <option value='{{$stdClass->className}}'>{{$stdClass->className}}</option>
                            @endforeach
                    </select>
                    <button type='submit' class='btn btn-primary'><i class='fas fa-search'></i></button>
                </form>
            </td>
            </tr>
        </table>
        <div class='well'>
            <table class='table table-striped'>
                <tr>
                    <th>STUDENT</th>
                    <th>CLASS</th>
                    <th>FEES</th>
                    <th>Action</th>
                </tr>
                @foreach($students as $student)
                <tr>
                    <td>{{$student->stdName}}</td>
                    <td>{{$student->class}}</td>
                    <td>{{$student->fees}}</td>
                    <td> 
                        <a href='/takes/{{$student->stdID}}' class='btn btn-primary'>Take Fees</a>
                    </td>
                </tr>
                @endforeach
            </table>
            {{$students->links()}}
        </div>

    </div>

@endsection