@extends('layouts.app')

@section('content')
    <div class='container'>
        <a href='/dashboard' class='btn btn-secondary btn-sm'><i class='fas fa-arrow-left'></i> Back</a>
        <h5 class='text-center'>Manage Fees</h5><hr>
    
        <div class='text-right'>
            <a href='/students/create' class='btn btn-success bt-lg'><i class='fas fa-plus fa-lg'></i> Student</a>
            <button class='btn btn-primary' data-toggle='modal' data-target='#paid'>Check Payments By Class</button>
        </div>
        <div id='paid' class='modal fade' role='dialog'>
            <div class='modal-dialog' role='document'>
                <div class='modal-content'>
                    <div class='close text-right' data-dismiss='modal'>&times;</div>
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
                            <input type='text' name='academicYear' class='form-control' value='{{date('Y')-1}}/{{date('Y')}}'><br>
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
        @if(count($students) > 0)
        <div class='well'>
            <table class='table table-striped'>
                <tr>
                    <th>STUDENT</th>
                    <th>CLASS</th>
                    <th>GUARDIAN</th>
                    <th>TELEPHONE
                    <th>FEES</th>
                    <th></th>
                    <th>Action</th>
                    <th></th>
                </tr>
                @foreach($students as $student)
                <tr>
                    <td>{{$student->stdName}}</td>
                    <td>{{$student->class}}</td>
                    <td>{{$student->guardian}}</td>
                    <td>{{$student->tel}}</td>
                    <td>{{$student->fees}}</td>
                    <td> 
                        <a href='/takes/{{$student->stdID}}' class='btn btn-success'><i class='fas fa-dollar-sign'></i> Take Fees</a>        
                    </td>
                    <td>
            
                        <a href='/fees/{{$student->stdID}}/edit' class='btn btn-primary'><i class='fas fa-edit'></i> Edit</a>
                    </td>
                    <td>
                        <form action='/fees/{{$student->stdID}}' class='form-group' method='POST'>
                            @csrf
                            <input type='hidden' name='_method' value='DELETE'>
                            <button type='submit' class='btn btn-danger'><i class='fas fa-trash'></i> Delete</button>
                        </form>
                    </td>    

                </tr>
                @endforeach
            @else 
                <div class='container text-center'>
                    <h3>No Student Added</h3>
                    <p><small><i>please make sure classes have been added before you add students</i></small></p>
                </div>
            @endif
            </table>
            {{$students->links()}}

        </div>
    </div>

@endsection