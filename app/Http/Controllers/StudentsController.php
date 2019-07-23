<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Student;
use App\StdClass;
use DB;

class StudentsController extends Controller
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
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user_id = auth()->user()->id;
        $stdClasses = StdClass::where('user_id',$user_id)->orderby('className','asc')->get();
        return view('fees.addStd',compact('stdClasses'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'stdName'=>'required',
            'stdClass'=>'required',
        ]);

        $user_id = auth()->user()->id;
        $name = $request->input('stdName');
        $class_id = $request->input('stdClass');
        //if student already exits in a particular class do not store that student's info
        $getStd = DB::select("SELECT name,class_id from students where name = '$name' and class_id=$class_id and user_id = $user_id ");
        $class = StdClass::find($class_id);
        if(count($getStd)>0) {
            if($name == $getStd[0]->name && $class_id == $getStd[0]->class_id) {
                return redirect('/students/create')->with('error',$name.' already exist in '.$class->className);
            }
        }
        else {
            $student = new Student;
            $student->name = $request->input('stdName');
            $student->class_id = $request->input('stdClass');
            $student->guardian = $request->input('stdGuardian');
            $student->guardian_no = $request->input('guardian_no');
            $student->address = $request->input('address');
            $student->user_id = auth()->user()->id;
            $student->save();
    
            return redirect('/students/create')->with('success', $student->name.' has been Added to '.$class->className);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $name = $request->input('searchStd');
        $students = DB::table('students')->where('name',$name)->orwhere('class',$name)->orderBy('class','desc')->paginate(20);

        return view('students.showStd',compact('name','students'));
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

        return view('students.editStd',compact('student','stdClass','stdClasses'));
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

        return redirect('/stdClass/'.$stdClass->id)->with('success', $student->name.' data updated');
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

        return redirect('/students')->with('error',"$student->name Deleted");
    }

}
