<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Student;
use App\StdClass;
use DB;

class StudentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $students = Student::orderby('name','asc')->paginate(20);
        $stdClasses = StdClass::all();
        return view('students.index',compact('students','stdClasses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $request->validate([
        //     'stdName'=>'required',
        //     'stdClass'=>'required',
        //     'stdGuardian'=>'required',
        //     'guardian_no'=>'required'
        // ]);

        $student = new Student;
        $student->name = $request->input('stdName');
        $student->class = $request->input('stdClass');
        $student->guardian = $request->input('stdGuardian');
        $student->guardian_no = $request->input('guardian_no');
        $student->address = $request->input('address');
        $student->save();

        return redirect('/students')->with('success','Student Added');
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
        $student = Student::find($id);
        $stdClasses = StdClass::all();

        return view('students.editStd',compact('student','stdClasses'));
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

        $student->name = $request->input('stdName');
        $student->class = $request->input('stdClass');
        $student->guardian = $request->input('stdGuardian');
        $student->guardian_no = $request->input('guardian_no');
        $student->address = $request->input('address');
        $student->save();

        return redirect('/students')->with('success','Student data updated');
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

        return redirect('/students')->with('error','Student Deleted');
    }

}
