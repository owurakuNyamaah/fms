<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\StdClass;
use DB;

class StdClassController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $classes = StdClass::orderby('className','asc')->paginate(5);
        return view('students.stdClass')->with('classes',$classes);
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
        $stdClass = new StdClass;
        $stdClass->className = $request->input('className');
        $stdClass->category = $request->input('category');
        $stdClass->fees = $request->input('fees');
        $stdClass->save();

        return redirect('/stdClass')->with('success','Class Added');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,$id)
    {
        $name = $request->input('searchStd');
        $class = DB::table('std_classes')->where('className',$name)->first();

        return view('students.classShow',compact('class','name'));
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
        $class->save();

        return redirect('/stdClass')->with('success','class Edited');
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

        return redirect('/stdClass')->with('error','Class Deleted');
    }

    /**Edit fees based on catergory */
    public function fees(Request $request) 
    {
        $category = $request->input('category');
        $fees = $request->input('fees');

        DB::update('UPDATE std_classes set fees=? where category=?',[$fees,$category]);

        return redirect('/stdClass')->with('success','Fees Updated based on category');
    }

}
