@extends('layouts.app')

@section('content')
<div class='container'>
    <a href='/fees' class='btn btn-secondary btn-sm'><i class='fas fa-arrow-left'></i>Back</a>
</div>

<div class='container'>
    <h4 class='text-center'>Add Student</h4><hr>
    <div style='margin:0 20%'>
    <form role='form' action='/students' method='POST' class='form-group'>
        @csrf
        <label class='control-form'>NAME</label>
        <input type='text' name='stdName' class='form-control' required>
        <label class='control-form'>Class</label>
        <select name='stdClass' class='browser-default custom-select mb-3' required>
            <option selected> </option>
            @foreach($stdClasses as $stdClass)
            <option value='{{$stdClass->id}}'>{{$stdClass->className}}</option>
            @endforeach
        </select>
        <label class='control-form'>Guardian Name</label>
        <input type='text' name='stdGuardian' class='form-control' >
        <label class='control-form'>Guardian Phone Number</label>
        <input type='text' name='guardian_no' class='form-control'>
        <label class='control-form'>Address</label>
        <input type='text' name='address' class='form-control'><br>

        <button type='submit' name='submit' class='btn btn-primary'>Save</button>
    </form>
    </div>
</div>

@endsection
