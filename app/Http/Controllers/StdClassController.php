<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\StdClass;
use App\Student;
use App\User;
use DB;

class StdClassController extends Controller
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
        $classes = StdClass::where('user_id',$user_id)->orderby('className','asc')->paginate(5);
        $stdClasses = StdClass::where('user_id',$user_id)->orderby('className','asc')->get();

        return view('students.stdClass',compact('classes','stdClasses'));
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
        $user_id = auth()->user()->id;
        $name = $request->input('className');
        $category = $request->input('category');
        //if a class with a category already exist do not store the new class entry
        $getClass = DB::table('std_classes')->select('className','category')->where([['user_id',$user_id],['className',$name]])->get();
        if(count($getClass)>0) {
            if(($name == $getClass[0]->className) & ($category == $getClass[0]->category)) {
                return redirect('/stdClass')->with('error',"$name with $category-category already exists");
            }
        }
        else {
            $stdClass = new StdClass;
            $stdClass->className = $request->input('className');
            $stdClass->category = $request->input('category');
            $stdClass->fees = $request->input('fees');
            $stdClass->user_id = auth()->user()->id;
            $stdClass->save();
    
            return redirect('/stdClass')->with('success',"$name with $category-category has been Added");
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user_id = auth()->user()->id;
        $class = DB::table('std_classes')->where([['user_id',$user_id],['id',$id]])->get();
        
        $students = DB::table('students')->select('name','id','guardian')->where([['user_id',$user_id],['class_id',$id]])->orderby('name')->get();
        $countStds = DB::select("SELECT count(name) as numStds from students where class_id=$id and user_id = $user_id ");


        return view('students.classShow',compact('class','students','countStds'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $class = StdClass::find($id);

        return view('students.editClass')->with('class',$class);
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
        $class = StdClass::find($id);

        $class->ClassName = $request->input('className');
        $class->category = $request->input('category');
        $class->fees = $request->input('fees');
        $class->user_id = auth()->user()->id;
        $class->save();

        return redirect("/stdClass/$class->id")->with('success',"$class->ClassName Edited");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $class = StdClass::find($id);
        $class->delete();

        return redirect('/stdClass')->with('error', "$class->className with $class->category has been Deleted");
    }

    /**Edit fees based on catergory */
    public function fees(Request $request) 
    {
        $user_id = auth()->user()->id;
        $category = $request->input('category');
        $fees = $request->input('fees');

        DB::update('UPDATE std_classes set fees=? where category=? and user_id',[$fees,$category,$user_id]);

        return redirect('/stdClass')->with('success','Fees Updated based on category - '.$category);
    }

    // public function promote($id) {
    //     $user_id = auth()->user()->id;
    //     $students = DB::select("SELECT * from students where class_id='$id' and user_id=$user_id order by(name)");

    //     $stdClasses = StdClass::where('user_id',$user_id)->get();


    //     return view('students.promote',compact('students','stdClasses'));
 
    // }
    // public function stdPromoted(Request $request) {
    //     $user_id = auth()->user()->id;
    //     $name = $request->input('stdName');

    //     $class_id = $request->input('stdClass');

    //     $student = DB::update("UPDATE students set class_id = '$class_id' where name='$name' and user_id = $user_id");


    //     return redirect('/stdClass')->with('success',"$name promoted");
    // }

}
