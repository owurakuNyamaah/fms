@extends('layouts.app')

@section('content')
<div class='container'>
    <a href='/fees' class='btn btn-secondary btn-sm'><i class='fas fa-arrow-left'></i>Back</a>
    <h4 class='text-center'>Edit Student</h4><hr>
    
    <div style='margin:0 20%'>
    <form action='/fees/{{$student->id}}' method='POST' class='form-group'>
        @csrf
        <input type='hidden' name='_method' value='PUT'>
        <label for='stdName'>NAME</label>
        <input type='text' name='stdName' value ='{{$student->name}}' class='form-control'>
        <label class='control-label'>Class</label>
        <select name='stdClass' class='browser-default custom-select mb-3' required>
            <option value='{{$stdClass->id}}' selected>{{$stdClass->className}}</option>
                @foreach($stdClasses as $stdClass)
                <option value='{{$stdClass->id}}'>{{$stdClass->className}}</option>
                @endforeach
            </select>
        <label class='control-label'>Guardian Name</label>
        <input type='text' name='stdGuardian' value='{{$student->guardian}}' class='form-control'>
        <label class='control-label'>Guardian Phone Number</label>
        <input type='text' name='guardian_no' value='{{$student->guardian_no}}' class='form-control'>
        <label class='control-label'>Address</label>
        <input type='text' name='address' value='{{$student->address}}' class='form-control'><br>

        <button type='submit' name='submit' class='btn btn-primary'>Save</button>
    </form>
    </div>

    </div>



@endsection
