@extends('layouts.app')

@section('content')
    <div class='container'>
        <a href='/dashboard' class='btn btn-secondary btn-sm'><i class='fas fa-arrow-left'></i>Back</a>
        <h4 class='text-center'>Student Fee Report</h4>
        @if(count($students) > 0)
            <div class='well'>
                <h5>Student info</h5>
                    <table class='table table-bordered'>
                        <tr>
                            <th>Name</th>
                            <th>{{$stdName}}</th>
                        </tr>
                        <tr>
                            <th>Class</th>
                            <th>{{$stdClass}}</th>
                        </tr>
                        <tr>
                            <th>Academic Year</th>
                            <th>{{$academicYear}}</th>
                        </tr>
                    </table>
                    <h5>Total fees info</h5>
                    <table class='table'>
                        <tr>
                            <th> </th>
                            <th>1st Term</th>
                            <th> </th>
                            <th> </th>
                            <th>2nd Term</th>
                            <th> </th>
                            <th> </th>
                            <th>3rd Term</th>
                            <th> </th>
                        </tr>
                        <tr>
                            <td>Fees</td>
                            <td>Paid</td>
                            <td>Balance</td>
                            <td>Fees</td>
                            <td>Paid</td>
                            <td>Balance</td>
                            <td>Fees</td>
                            <td>Paid</td>
                            <td>Balance</td>
                        </tr>
                        <tr>
                            @if(!empty($firstFees) & !empty($firstPaid))
                            <td>{{$firstFees[0]->fees}}</td>
                            <td>{{$firstPaid[0]->paid}}</td>
                            <td><b>{{$firstFees[0]->fees - $firstPaid[0]->paid}}</b></td>
                            @else 
                            <td></td>
                            <td></td>
                            <td></td>
                            @endif

                            @if(!empty($secondFees) & !empty($secondPaid))
                            <td>{{$secondFees[0]->fees}}</td>
                            <td>{{$secondPaid[0]->paid}}</td>
                            <td><b>{{$secondFees[0]->fees - $secondPaid[0]->paid}}</b></td>
                            @else
                            <td></td>
                            <td></td>
                            <td></td>
                            @endif

                            @if(!empty($thirdFees) & !empty($thirdPaid))
                            <td>{{$thirdFees[0]->fees}}</td>
                            <td>{{$thirdPaid[0]->paid}}</td>
                            <td><b>{{$thirdFees[0]->fees - $thirdPaid[0]->paid}}</b></td>
                            @else
                            <td></td>
                            <td></td>
                            <td></td>
                            @endif
                        </tr>
                    </table>

                    <h5>Fees details</h5>
                    <table class='table table-bordered'>
                        <tr>
                            <th>Date</th>
                            <th>Paid</th>
                            <th>Term</th>
                            <th>Remarks</th>
                        </tr>
                        @foreach($students as $student)
                        <tr>
                            <td>{{$student->created_at}}</td>
                            <td>{{$student->paid}}</td>
                            <td>{{$student->term}}</td>
                            <td>{{$student->remarks}}</td>
                        </tr>
                        @endforeach
                    </table>
                </div>
                <div>
                    @if(!empty($firstFees) & !empty($firstPaid) & !empty($secondFees) & !empty($secondPaid) & !empty($thirdFees) & !empty($thirdPaid))
                    <h4>Total Fees = {{$firstFees[0]->fees + $secondFees[0]->fees + $thirdFees[0]->fees}}</h4>
                    <h4>Total Paid = {{$firstPaid[0]->paid + $secondPaid[0]->paid + $thirdPaid[0]->paid }}</h4>
                    <h3><b>Fees payable = GHs {{$firstFees[0]->fees - $firstPaid[0]->paid + $secondFees[0]->fees - $secondPaid[0]->paid + 
                    $thirdFees[0]->fees - $thirdPaid[0]->paid}}</b></h3>
                    @endif
    
                </div>
                @else
                    <h1 class='text-center text-success'>Student has not paid</h1>
                    <h5 class='text-center'>OR</h5>
                    <h3 class='text-center text-success'>Student and class do not match</h3>
                @endif

    </div>
@endsection