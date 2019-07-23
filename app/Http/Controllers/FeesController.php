<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Student;
use App\StdClass;
use App\Fee;
use DB;

class FeesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_id = auth()->user()->id;

        $students = DB::table('students')->join('std_classes','students.class_id','=','std_classes.id')->select('students.id as stdID',
        'students.name as stdName','std_classes.className as class','std_classes.fees as fees','students.guardian as guardian',
        'students.guardian_no as tel','students.address as address')->where('students.user_id',$user_id)->orderBy('std_classes.className')
        ->orderBy('students.name')->distinct()->paginate(30);
        $stdClasses = StdClass::where('user_id',$user_id)->orderby('className','asc')->get();
        
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
        $student = DB::select("SELECT stdID,StdName,class,fees from (select students.id as stdID, students.name as stdName, std_classes.className as class,
        std_classes.fees as fees from students inner join std_classes on students.class_id = std_classes.id ) as t where stdID = $id");

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
        // $this->validate($request, [
        //     'pay' => 'required',
        // ]);
        
        $fee = new Fee;
        $fee->student = $request->input('stdName');
        $fee->fees = $request->input('fees');
        $fee->paid = $request->input('pay');
        $fee->academic_year = $request->input('academicYear');
        $fee->term = $request->input('term');
        $fee->remarks = $request->input('remarks');
        $fee->std_class = $request->input('stdClass');
        $fee->user_id = auth()->user()->id;
        $fee->save();

        return redirect('/fees')->with('success',"$fee->student - Ghs $fee->paid Payment successful");
    }

    //Add student
    public function addStd(Request $request) 
    {
        $student = new Student;
        $student->name = $request->input('stdName');
        $student->class = $request->input('stdClass');
        $student->guardian = $request->input('stdGuardian');
        $student->guardian_no = $request->input('guardian_no');
        $student->address = $request->input('address');
        $student->user_id = auth()->user()->id;
        $student->save();

        return redirect('/fees')->with('success',"$student->name Added");

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $user_id = auth()->user()->id;
        $name = $request->input('stdSearch');
        $class = $request->input('stdClass');
        $stds = DB::select("SELECT students.id as stdID,students.name as stdName,std_classes.className as class,std_classes.fees as fees,
        students.guardian as guardian,students.guardian_no as tel,students.address as stdAddress
        from students inner join std_classes on students.class_id = std_classes.id where students.name='$name' and std_classes.className='$class'
         and students.user_id = $user_id ");

        $stdClasses = StdClass::where('user_id',$user_id)->orderby('className','asc')->get();
        $academicYear = DB::select("SELECT DISTINCT academic_year as academic from fees where user_id = $user_id order by academic desc");


        $date = date('Y');
        $students = DB::select("SELECT * from fees where student='$name' and std_class='$class' and user_id=$user_id and academic_year like '%/$date' ");
        $TotalPaid = DB::select("SELECT sum(paid) as paid from fees where student='$name' and std_class='$class' and user_id=$user_id and academic_year like '%/$date' ");
        $TotalFees = DB::select("SELECT fees from fees where student='$name' and std_class='$class' and user_id=$user_id and academic_year like '%/$date' limit 1");
        $firstPaid = DB::select("SELECT sum(paid) as paid from fees where student='$name' and user_id=$user_id and std_class='$class' 
        and academic_year like '%/$date' and term='1st term' ");
        $secondPaid = DB::select("SELECT sum(paid) as paid from fees where student='$name' and user_id=$user_id and std_class='$class' 
        and academic_year like '%/$date' and term='2nd term' ");
        $thirdPaid = DB::select("SELECT sum(paid) as paid from fees where student='$name' and user_id=$user_id  and std_class='$class' 
        and academic_year like '%/$date' and term='3rd term' ");
        $firstFees = DB::select("SELECT fees from fees where student='$name' and std_class='$class' and user_id=$user_id and academic_year like '%/$date' 
        and term='1st term' limit 1");
        $secondFees = DB::select("SELECT fees from fees where student='$name' and std_class='$class' and user_id=$user_id and academic_year like '%/$date' 
        and term='2nd term' limit 1");
        $thirdFees = DB::select("SELECT fees from fees where student='$name' and std_class='$class' and user_id=$user_id and academic_year like '%$/date' 
        and term='3rd term' limit 1");

        return view('fees.show',compact('name','stds','stdClasses','firstPaid','secondPaid','thirdPaid','firstFees','secondFees','thirdFees','academicYear'));

    }

    /**show students who have made some payments */
    public function paid(Request $request) 
    {
        $user_id = auth()->user()->id;
        $class = $request->input('stdClass');
        $term = $request->input('term');
        $academicYear = $request->input('academicYear');

        $students = DB::table('fees')->select(DB::raw('fees,sum(paid) as paid,student'))->where([
            ['std_class','=',"$class"],
            ['term','=',"$term"],
            ['academic_year','=',"$academicYear"],
            ['user_id','=',$user_id]
        ])->groupBy('student')->get();

        //find the class_id for $class
        $class_id = DB::table('std_Classes')->select('id')->where('className',$class)->get();
        $id = $class_id[0]->id;

        $debts = DB::select("SELECT name from (SELECT name,class_id FROM students WHERE NOT EXISTS ( SELECT student FROM fees WHERE 
        students.name = fees.student and term='$term' and user_id=$user_id and academic_year='$academicYear '))
         as t where class_id = $id ");




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
        $user_id = auth()->user()->id;
        $student = Student::find($id);
        $stdClass = StdClass::find($student->class_id);
        $stdClasses = StdClass::where('user_id',$user_id)->orderby('className','asc')->get();

        return view('fees.editStd',compact('student','stdClasses','stdClass'));

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
         $student = Student::find($id);
         $stdClass = StdClass::find($student->class_id);
 

        $student->name = $request->input('stdName');
        $student->class_id = $request->input('stdClass');
        $student->guardian = $request->input('stdGuardian');
        $student->guardian_no = $request->input('guardian_no');
        $student->address = $request->input('address');
        $student->user_id = auth()->user()->id;
        $student->save();

        return redirect('/fees')->with('success',"$student->name data updated");

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $student = Student::find($id);
        $student->delete();

        return redirect('/fees')->with('error', $student->name.' Deleted from '.$student->class);

    }
}
