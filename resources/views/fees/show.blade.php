@extends('layouts.app')

@section('content')
    <div class='container'>
        <a href='/fees' class='btn btn-secondary'><i class='fas fa-arrow-left'></i>Back</a>
    </div>
        @if(!empty($stds[0]))
            <table class='table table-striped'>
                <tr>
                    <th class='text-center' style='font-size:30px'>{{$stds[0]->stdName}}</th>
                    <td> 
                            <button data-toggle='modal' data-target='#take' class='btn btn-success btn-lg'><i class='fas fa-dollar-sign'></i> Take Fees</button>
                            <div id='take' class='modal fade' role='dialog'>
                                <div class='modal-dialog' role='document'>
                                    <div class='modal-content'>
                                        <div class='text-right'><button class='close' data-dismiss='modal'>&times;</button></div>
                                        <div class='modal-header'>
                                            <h5 class='text-center'>Take Fees</h5>
                                        </div>
                                        <div class='modal-body'>
                                            <form role='form' action='/fees' method='POST' class='form-group'>
                                                @csrf
                                                <input type='hidden' name='stdClass' value='{{$stds[0]->class}}'>
                                                <label class='control-label'>Student Name</label>
                                                <input type='text' name='stdName' value='{{$stds[0]->stdName}}' class='form-control' readonly>
                                                <label class='control-label'>Fees</label>
                                                <input type='number' name='fees' value='{{$stds[0]->fees}}' class='form-control' readonly>
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
                                                <input type='text' name='remarks' class='form-control'>
                                                <button type='submit' name='submit' class='btn btn-primary'>Save</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <button data-toggle='modal' data-target='#report' class='btn btn-info btn-lg'><i class='far fa-clipboard'></i> Fee Report</button>
                            <div id='report' class='modal fade' role='dialog'>
                                    <div class='modal-dialog' role='document'>
                                        <div class='modal-content'>
                                            <button class='close' data-dismiss='modal'>&times;</button>
                                            <div class='modal-header'>
                                                <h3 class='modal-title'>Fee Report</h3>
                                            </div>
                                            <div class='modal-body'>
                                                <form role='form' action='/dashboard/show' method='POST'>
                                                    @csrf
                                                    <label class='control-form'>Student Name</label>
                                                    <input type='text' name='stdName' class='form-control' value='{{$stds[0]->stdName}}' readonly><br>
                                                    <label class='control-form'>Student Class</label>
                                                    <input type='text' name='stdClass' value='{{$stds[0]->class}}' class='form-control' readonly><br>
                                                    <label class='control-form'>Academic Year</label>
                                                    <select name='academicYear' class='browser-default custom-select mb-3' required>
                                                        <option selected>{{date('Y')-1}}/{{date('Y')}} </option>
                                                        @if(count($academicYear)>0)
                                                            @foreach($academicYear as $academic)
                                                                <option value='{{$academic->academic}}'>{{$academic->academic}}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                    <button type='submit' name='submit' class='btn btn-primary'>Submit</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
            
                        </td>
                        </tr>
            </table>
            <div class='container' style='margin-top:50px'>
            <h5>Total fees info ({{date('Y')-1}}/{{date('Y')}})</h5>
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
            </div>

        <div class='container' style='margin-top:50px'>
            <table class='table'>
                <tr>
                    <th>CLASS</th>
                    <th>FEES</th>
                    <th>GUARDIAN</th>
                    <th>TELEPHONE</th>
                    <th>ADDRESS</th>
                    <th>Action</th>
                    <th></th>
                </tr>
                <tr>
                    <td>{{$stds[0]->class}}</td>
                    <td>{{$stds[0]->fees}}</td>
                    <td>{{$stds[0]->guardian}}</td>
                    <td>{{$stds[0]->tel}}</td>
                    <td>{{$stds[0]->stdAddress}}</td>
                    <td>
                        <div id='editform' class='modal fade' role='dialog'>
                            <div class='modal-dialog' role='document'>
                                <div class='modal-content'>
                                    <button class='close btn btn-lg text-right' data-dismiss='modal'>&times;</button> 
                                    <div class='modal-header'>
                                        <h3 class='modal-title text-center'>Edit Student</h3>
                                    </div>
                                    <div class='modal-body'>
                                        <form role='form' action='/fees/{{$stds[0]->stdID}}' method='POST' class='form-group'>
                                            @csrf
                                            <input type='hidden' name='_method' value='PUT'>
                                            <label class='control-form'>NAME</label>
                                            <input type='text' name='stdName' value ='{{$stds[0]->stdName}}' class='form-control'>
                                            <label class='control-form'>Class</label>
                                            <select name='stdClass' class='browser-default custom-select mb-3' required>
                                                    <option selected>{{$stds[0]->class}}</option>
                                                        @foreach($stdClasses as $stdClass)
                                                        <option value='{{$stdClass->className}}'>{{$stdClass->className}}</option>
                                                        @endforeach
                                                    </select>
                                        
                                            <label class='control-form'>Guardian Name</label>
                                            <input type='text' name='stdGuardian' value='{{$stds[0]->guardian}}' class='form-control'>
                                            <label class='control-form'>Guardian Phone Number</label>
                                            <input type='text' name='guardian_no' value='{{$stds[0]->tel}}' class='form-control'>
                                            <label class='control-form'>Address</label>
                                            <input type='text' name='address' value='{{$stds[0]->stdAddress}}' class='form-control'>
                    
                                            <button type='submit' name='submit' class='btn btn-primary'>Save</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>                         
            
                        <button type='button' data-target='#editform' data-toggle='modal' class='btn btn-primary'><i class='fas fa-edit'></i> Edit</a>
                    </td>
                    <td>
                        <form action='/fees/{{$stds[0]->stdID}}' class='form-group' method='POST'>
                            @csrf
                            <input type='hidden' name='_method' value='DELETE'>
                            <button type='submit' class='btn btn-danger primary'><i class='fas fa-trash'></i> Delete</button>
                        </form>

                </tr>
            </table>
        </div>

        @else 
        <h1 class='text-center text-success'>{{$name}} does not exist</h1>
        <h5 class='text-center'>OR</h5>
        <h3 class='text-center text-success'>Student and class do not match</h3>
    @endif
@endsection