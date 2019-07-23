@extends('layouts.app')

@section('content')
<div class='container'>
    <a href='/stdClass/{{$class->id}}' class='btn btn-secondary btn-sm'><i class='fas fa-arrow-left fa-sm'></i> Back</a>
    <h4 class='text-center'>Edit Class</h4><hr>
    <div style='margin:0 20%'>
        <form role='form' action='/stdClass/{{$class->id}}' method='POST'>
            @csrf
            <input type='hidden' name='_method' value='PUT'>
            <label class='control-label'>Class Name</label><br>
            <input type='text' name='className' class='form-control' value='{{$class->className}}'><br>
            <label class='control-label'>Class Category</label><br>
            <select name='category' class='browser-default custom-select mb-3' >
                    <option selected >{{$class->category}}</option>
                    <option value='nursery'>Nursery</option>
                    <option value='lower primary'>Lower Primary</option>
                    <option value='upper primary'>Upper Primary</option>
                    <option value='jhs'>J.H.S</option>
            </select><br>    
            <label class='control-label'>Fees</label><br>
            <input type='number' name='fees' class='form-control' value='{{$class->fees}}'><br>
            <button type='submit' name='submit' class='btn btn-primary'>Save</button>              
        </form>
    </div>

</div>

@endsection