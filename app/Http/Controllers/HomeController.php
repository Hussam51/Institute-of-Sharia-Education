<?php

namespace App\Http\Controllers;

use App\Models\Adviser;
use App\Models\Classroom;
use App\Models\Library;
use App\Models\Monitor;
use App\Models\Parents;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
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
        $department_id=Auth::user()->department_id;
        $statistics['students']=Student::where('department_id',$department_id)->count();
        $statistics['teachers']=Teacher::where('department_id',$department_id)->count();
        $statistics['classrooms']=Classroom::where('department_id',$department_id)->count();
        $statistics['subjects']=Subject::count();
        $statistics['parents']=Parents::count();
        $statistics['advisers']=Adviser::where('department_id',$department_id)->count();
        $statistics['monitors']=Monitor::where('department_id',$department_id)->count();

        $statistics['files']=Library::count();
        return view('home',compact('statistics'));
    }
}
