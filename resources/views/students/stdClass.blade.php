@extends('layouts.app')

@section('content')

<div class='container'>
    <a href='/dashboard' class='btn btn-secondary btn-sm'><i class='fas fa-arrow-left'></i> Back</a>
    <h5 class='text-center'>Manage Class</h5><hr>

    <div class='text-right'>
        <button class='btn btn-success btn-lg' data-toggle='modal' data-target='#addClass'><i class='fas fa-plus'></i> Class</button>
        
        <button class='btn btn-primary btn-lg' data-toggle='modal' data-target='#fees'><i class='fas fa-edit'></i> Fees</button>
    </div>
    <div id='addClass' class='modal fade' role='dialog'>
        <div class='modal-dialog' role='document'>
            <div class='modal-content'>
                <button class='close' data-dismiss='modal'>&times;</button>
                <div class='modal-header'>
                    <h3 class='modal-title'>Add Class</h3>
                </div>
                <div class='modal-body'>
                    <form role='form' action='/stdClass' method='POST'>
                        @csrf
                        <label class='control-label'>Class Name</label><br>
                        <input type='text' name='className' class='form-control' required><br>
                        <label class='control-label'>Class Category</label><br>
                        <select name='category' class='browser-default custom-select mb-3' required>
                            <option selected> </option>
                            <option value='nursery & KG'>Nursery and KG</option>
                            <option value='lower primary'>Lower Primary</option>
                            <option value='upper primary'>Upper Primary</option>
                            <option value='jhs'>J.H.S</option>
                        </select><br>    

                        <label class='control-label'>Fees</label><br>
                        <input type='number' name='fees' class='form-control' placeholder='GHs'><br>
    
                        <button type='submit' name='submit' class='btn btn-primary'>Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div id='fees' class='modal fade' role='dialog'>
        <div class='modal-dialog' role='document'>
            <div class='modal-content'>
                <button class='close text-right' data-dismiss='modal'>&times;</button>
                <div class='modal-header'>
                    <h3 class='modal-title'>Change Fees</h3>
                </div>
                <div class='modal-body'>
                    <form role='form' action='/changefees' method='POST'>
                        @csrf
                        <input type='hidden' name='_method' value='PUT'>
                        <label class='control-label'>Class Category</label><br>
                        <select name='category' class='browser-default custom-select mb-3' required>
                            <option selected> </option>
                            <option value='nursery & KG'>Nursery and KG</option>
                            <option value='lower primary'>Lower Primary</option>
                            <option value='upper primary'>Upper Primary</option>
                            <option value='jhs'>J.H.S</option>
                        </select><br>    

                        <label class='control-label'>Fees</label><br>
                        <input type='number' name='fees' class='form-control' placeholder='GHs' required><br>
    
                        <button type='submit' name='submit' class='btn btn-primary'>Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
        @if(count($classes) > 0 )
            
        <table class='table'>
            <tr>
                <th>Class Name</th>
                <th>Category</th>
                <th>Fees</th>
                <th></th>
                <th></th>
            </tr>
            @foreach($classes as $class)
                <tr>
                    <td><a href='stdClass/{{$class->id}}'>{{$class->className}}</a></td>
                    <td>{{$class->category}}</td>
                    <td><i>GHs</i> {{$class->fees}}</td>
                    <td> 
                        <a href='/stdClass/{{$class->id}}/edit' class='btn btn-primary btn-sm'><i class='fas fa-edit'></i> Edit</a>
                    </td>
                    <td>
                        <form action='/stdClass/{{$class->id}}' method='POST' class='form-group'>
                            @csrf
                            <input type='hidden' name='_method' value='DELETE'>

                            <button type='submit' name='submit' class='btn btn-danger btn-sm'><i class='fas fa-trash'></i> Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </table>
        {{$classes->links()}}
        @else 
            <h1 class='text-center'>No Class Added</h1>
    @endif
</div>


@endsection