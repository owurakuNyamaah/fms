<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Student;
use App\StdClass;
use App\Fee;
use DB;

class FeesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $students = DB::select("SELECT students.id as stdID,students.name as stdName,std_classes.className as class,std_classes.fees as fees 
        // from students inner join std_classes on students.class = std_classes.className");
        $students = DB::table('students')->join('std_classes','students.class','=','std_classes.className')->select('students.id as stdID',
        'students.name as stdName','std_classes.className as class','std_classes.fees as fees')->orderBy('std_classes.className')->paginate(30);
        $stdClasses = StdClass::all();
        
        return view('fees.index',compact('students','stdClasses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
    }

    /**show form for creating take fees resource */
    public function take($id) 
    {
        $student = DB::select("SELECT stdID, stdName, class, fees FROM ( SELECT `students`.`id` AS `stdID`, `students`.`name` AS `stdName`, 
        `std_classes`.`className` AS `class`, `std_classes`.`fees` AS `fees` FROM `students` INNER JOIN `std_classes` 
        ON `students`.`class` = `std_classes`.`className` ) AS t WHERE stdID = $id");

        return view('fees.take',compact('student'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'pay' => 'required',
        ]);
        
        $fee = new Fee;
        $fee->student = $request->input('stdName');
        $fee->fees = $request->input('fees');
        $fee->paid = $request->input('pay');
        $fee->academic_year = $request->input('academicYear');
        $fee->term = $request->input('term');
        $fee->remarks = $request->input('remarks');
        $fee->std_class = $request->input('stdClass');
        $fee->save();

        return redirect('/fees')->with('success','Payment successful');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $name = $request->input('stdSearch');
        $class = $request->input('stdClass');
        $stds = DB::select("SELECT students.id as stdID,students.name as stdName,std_classes.className as class,std_classes.fees as fees 
        from students inner join std_classes on students.class = std_classes.className where students.name='$name' and std_classes.className='$class' ");

        return view('fees.show',compact('stds'));

    }

    /**show students who have made some payments */
    public function paid(Request $request) 
    {
        $class = $request->input('stdClass');
        $term = $request->input('term');
        $academicYear = $request->input('academicYear');

        $students = DB::select("SELECT distinct student from (SELECT * from fees where std_class='$class' and term='$term'
        and academic_year='$academicYear') as t");
       
        $debts = DB::select("SELECT name from (SELECT name,class FROM students WHERE NOT EXISTS ( SELECT student FROM fees WHERE 
        students.name = fees.student and term='$term' and academic_year='$academicYear'))
         as t where class='$class' ");

        return view('fees.paid',compact('students','class','term','academicYear','debts'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
