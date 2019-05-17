<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\StdClass;
use App\Fee;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $stdClasses = StdClass::all();
        $academicYear = DB::select("SELECT DISTINCT academic_year as academic from fees order by academic desc");
        return view('dashboard',compact('stdClasses','academicYear'));
    }

    public function show(Request $request) {
        $stdName = $request->input('stdName');
        $stdClass = $request->input('stdClass');
        $academicYear = $request->input('academicYear');
        $students = DB::select("SELECT * from fees where student='$stdName' and std_class='$stdClass' and academic_year='$academicYear' ");
        $TotalPaid = DB::select("SELECT sum(paid) as paid from fees where student='$stdName' and std_class='$stdClass' and academic_year='$academicYear' ");
        $TotalFees = DB::select("SELECT fees from fees where student='$stdName' and std_class='$stdClass' and academic_year='$academicYear' limit 1");
        $firstPaid = DB::select("SELECT sum(paid) as paid from fees where student='$stdName' and std_class='$stdClass' 
        and academic_year='$academicYear' and term='1st term' ");
        $secondPaid = DB::select("SELECT sum(paid) as paid from fees where student='$stdName' and std_class='$stdClass' 
        and academic_year='$academicYear' and term='2nd term' ");
        $thirdPaid = DB::select("SELECT sum(paid) as paid from fees where student='$stdName' and std_class='$stdClass' 
        and academic_year='$academicYear' and term='3rd term' ");
        $firstFees = DB::select("SELECT fees from fees where student='$stdName' and std_class='$stdClass' and academic_year='$academicYear' 
        and term='1st term' limit 1");
        $secondFees = DB::select("SELECT fees from fees where student='$stdName' and std_class='$stdClass' and academic_year='$academicYear' 
        and term='2nd term' limit 1");
        $thirdFees = DB::select("SELECT fees from fees where student='$stdName' and std_class='$stdClass' and academic_year='$academicYear' 
        and term='3rd term' limit 1");
        

        return view('report',compact('students','stdName','stdClass','academicYear','TotalFees','TotalPaid','firstPaid','secondPaid',
        'thirdPaid','firstFees','secondFees','thirdFees'));
    }
}
