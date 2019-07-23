@extends('layouts.app')

@section('content')

<div class='container'>
    <a href='/stdClass' class='btn btn-secondary btn-sm'><i class='fas fa-arrow-left'></i> Back</a>

    <h5 class='text-center'><i>Total Number Of Stduents = {{$countStds[0]->numStds}}</i></h5>
    
    @if(!empty($class))
    <table class='table'>
        <tr>
            <th>Class Name</th>
            <th>Category</th>
            <th>Fees</th>
            <th></th>
            <th></th>
        </tr>
            <tr>
                <td>{{$class[0]->className}}</td>
                <td>{{$class[0]->category}}</td>
                <td>{{$class[0]->fees}}</td>
                <td> 
                    <a href='/stdClass/{{$class[0]->id}}/edit' class='btn btn-primary btn-sm'><i class='fas fa-edit'></i> Edit</a>
                </td>
                <td>
                    <form action='/stdClass/{{$class[0]->id}}' method='POST' class='form-group'>
                        @csrf
                        <input type='hidden' name='_method' value='DELETE'>

                        <button type='submit' name='submit' class='btn btn-danger btn-sm'><i class='fas fa-trash'></i> Delete</button>
                    </form>
                </td>
            </tr>
    </table>
    <div class='text-center'>
        <h6><b>Fees Receivable per term = <i>GHs</i> {{$countStds[0]->numStds * $class[0]->fees}}</b></h6>
        <h6><b>Fees Receivable for the academic year = <i>GHs</i> {{$countStds[0]->numStds * $class[0]->fees * 3}}</b></h6>
    </div>

    <ul class='list-group'>
        @foreach($students as $student)
        <li class='list-group-item'>
            <a href='/students/{{$student->id}}/edit' class='btn btn-primary btn-sm' style='margin-right:20px'><i class='fas fa-edit'></i>Edit</a>
            <button class='btn btn-danger btn-sm' style='margin-right:20px'><i class='fas fa-trash'></i>Delete</button>
            {{$student->name}}
        </li>
        
        @endforeach
    </ul>
    @else 
        <h1 class='text-center'>{{$class->name}} could not be found</h1>
    @endif
</div>



@endsection