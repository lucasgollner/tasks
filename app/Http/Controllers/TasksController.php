<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Auth;

class TasksController extends Controller
{
    //

    public function index()
    {
    	$tasks = \App\tasks::where('user', Auth::id())->orderBy('date', 'desc')->get();
		//$filiaisarray = \App\versa\conexoes::listafiliais();
        return view('tasks', compact('tasks'));
        //return view('tasks');
    }

    public function save()
    {
    	$input = Input::all();
    	$rules = array(
    		    'name'      => 'required|min:3|max:250'
            );

            $validator = Validator::make($input, $rules);
            if($validator->passes())
            {
                $task =  new \App\tasks();
                $task->name                = Input::get('name');
                $task->user                = Auth::id();
                $task->date                = Input::get('date');
                $task->save();

                return Redirect::back()->with('success','Task added successfully');

            }else{
                return Redirect::back()->withInput(Input::old())->withErrors('Task not included. (task should require at least three characters)');
            }
    }

    public function savesubtask()
    {
    	$input = Input::all();
    	$rules = array(
    		    'name'      => 'required|min:3|max:250',
    		    'date'      => 'required'
            );

            $validator = Validator::make($input, $rules);
            if($validator->passes())
            {
                $task =  new \App\subtasks();
                $task->name                = Input::get('name');
                $task->idtasks             = Input::get('idtask');
                $task->date                = Input::get('date');
                $task->save();

                return Redirect::back()->with('success','SubTask added successfully');

            }else{
                return Redirect::back()->withInput(Input::old())->withErrors('SubTask not included.');
            }
    }
}
