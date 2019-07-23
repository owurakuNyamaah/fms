@extends('layouts.app')

@section('content')
<div class='container'>
    <a href='/fees' class='btn btn-secondary btn-sm'><i class='fas fa-arrow-left'></i> Back</a>
        <h3 class='text-center'><b>{{$class}}</b> {{$term}} - {{$academicYear}}</h3>
    <table class='table table-bordered'>
        <tr>
            <th>Students with Full or Part Payment ( {{count($students)}} )</th>
            <th>Students with No Payment  ( {{count($debts)}} )</th>
        </tr>
        <tr>
            @if(count($students) > 0)
            <td>
                <ul class='list-group'>
                    @foreach($students as $std)
                        <li class='list-group-item'>
                            <button class='btn btn-success btn-sm' style='margin-right:20px'><b>paid {{$std->paid}}<br>
                                owing {{$std->fees - $std->paid}}</b></button> {{$std->student}}
    
                         </li> 
                    @endforeach
                </ul>
            </td>
            @else 
            <td> </td>
            @endif

            @if(count($debts) > 0)
            <td>
                <ul class='list-group'>
                    @foreach($debts as $debt)
                        <li class='list-group-item'>{{$debt->name}}</li>
                    @endforeach
                </ul>
            </td>
            @else  
            <td> </td>
            @endif
        </tr>
    </table>
</div>
@endsection