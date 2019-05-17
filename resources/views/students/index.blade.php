@extends('layouts.app')

@section('content')
<div class='container'>
    <a href='/dashboard' class='btn btn-secondary btn-sm'><i class='fas fa-arrow-left'></i> Back</a>
    <h4 class='text-center'>Manage Students</h4><hr>
    <div class='text-right'>
        <button data-target='#stdform' data-toggle='modal' class='btn btn-success bt-lg'><i class='fas fa-plus fa-lg'></i> Student</button>
    </div>
    <div id='stdform' class='modal fade' role='dialog'>
        <div class='modal-dialog' role='document'>
            <div class='modal-content'>
                <button class='close btn btn-lg text-right' data-dismiss='modal'>&times;</button> 
                <div class='modal-header'>
                    <h3 class='modal-title text-center'>Add Student</h3>
                </div>
                <div class='modal-body'>
                    <form role='form' action='/students' method='POST' class='form-group'>
                        @csrf
                        <label class='control-form'>NAME</label>
                        <input type='text' name='stdName' class='form-control' required>
                        <label class='control-form'>Class</label>
                        <select name='stdClass' class='browser-default custom-select mb-3' required>
                            <option selected> </option>
                            @foreach($stdClasses as $stdClass)
                            <option value='{{$stdClass->className}}'>{{$stdClass->className}}</option>
                            @endforeach
                        </select>
                        <label class='control-form'>Guardian Name</label>
                        <input type='text' name='stdGuardian' class='form-control' required>
                        <label class='control-form'>Guardian Phone Number</label>
                        <input type='text' name='guardian_no' class='form-control'>
                        <label class='control-form'>Address</label>
                        <input type='text' name='address' class='form-control'>

                        <button type='submit' name='submit' class='btn btn-primary'>Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @if(count($students) > 0)
        @foreach($students as $student)
        <form action='/students/{{$student->id}}' method='post' class='form-inline'>
        @endforeach
            @csrf
            <input type='hidden' name='_method' value='GET'>
            <input type='search' name='searchStd' class='form-control' placeholder='Search by Name or Class'>
            <button type='submit' name='submit' class='btn btn-primary btn-sm'><i class='fas fa-search'></i></button>
        </form>
        <table class='table table-striped'>
            <tr>
                <th>NAME</th>
                <th>CLASS</th>
                <th>GUARDIAN</th>
                <th>GUARDIAN CONTACT</th>
                <th>ADDRESS</th>
                <th></th>
                <th></th>
            </tr>
            @foreach($students as $student)
            <tr>
                <td>{{$student->name}}</td>
                <td>{{$student->class}}</td>
                <td>{{$student->guardian}}</td>
                <td>{{$student->guardian_no}}</td>
                <td>{{$student->address}}</td>
                <td>        
                    <a href='/students/{{$student->id}}/edit' class='btn btn-primary btn-sm'><i class='fas fa-edit'></i> Edit</a>
                </td>
                <td>
                    <form action='/students/{{$student->id}}' class='form-group' method='POST'>
                        @csrf
                        <input type='hidden' name='_method' value='DELETE'>
                        <button type='submit' class='btn btn-danger btn-sm'><i class='fas fa-trash'></i> Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </table>
        {{$students->links()}}
        @else
            <h1 class='text-center'>No Student Added</h1>
        </table>

    @endif

    
</div>

@endsection