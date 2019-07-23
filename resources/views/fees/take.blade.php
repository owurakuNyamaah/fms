@extends('layouts.app')

@section('content')
<div class='container'>
    <a href='/fees' class='btn btn-secondary btn-sm'><i class='fas fa-arrow-left'></i> Back</a>
    <h5 class='text-center'>Take Fees</h5><hr>
    <div style='margin:0% 20%'>
    <form role='form' action='/fees' method='POST' class='form-group'>
        @csrf
        <input type='hidden' name='stdClass' value='{{$student[0]->class}}'>
        <label class='control-label'>Student Name</label>
        <input type='text' name='stdName' value='{{$student[0]->stdName}}' class='form-control' readonly>
        <label class='control-label'>Fees</label>
        <input type='number' name='fees' value='{{$student[0]->fees}}' class='form-control' readonly>
        <label class='control-label'>Pay</label>
        <input type='number' name='pay' class='form-control'>
        <label class='control-label'>Academic Year</label>
        <input type='text' name='academicYear' class='form-control' value='{{date('Y')-1}}/{{date('Y')}}' required>
        <label class='control-label'>Term</label>
        <select name='term' class='browser-default custom-select mb-3' required>
            <option selected></option>
            <option value='1st term'>First Term</option>
            <option value='2nd term'>Second Term</option>
            <option value='3rd term'>Third Term</option>
        </select>
        <label class='control-label'>Remarks</label>
        <input type='text' name='remarks' class='form-control'><br>
        <button type='submit' name='submit' class='btn btn-primary'>Save</button>
    </form>
    </div>
</div>

@endsection