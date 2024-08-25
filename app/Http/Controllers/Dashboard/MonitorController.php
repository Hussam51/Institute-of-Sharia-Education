<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Monitor;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class MonitorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $advisers = Monitor::all();
        return view('Monitors.monitors', compact('advisers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {


            $validatedData = $request->validate([
                'first_name' => 'required',
                'last_name' => 'required',
                'password' => 'required|min:8',
            ]);
            $adviser = new Monitor();
            $adviser->first_name = $request->first_name;
            $adviser->last_name = $request->last_name;

            $adviser->phone = $request->phone;


            $adviser->department_id = Auth::user()->department_id;
            $adviser->password = Hash::make($request->password);
          
            $adviser->save();
            toastr('Monitor created successfully');
            return redirect()->route('dashboard.monitors.index');
        } catch (Exception $e) {
            toastr($e->getMessage(), 'warning', 'there is an error');
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Monitor $adviser)
    {
        try {

           
               // $input['password'] = Hash::make($request->password);
          
               $input=$request->except('password');
               if ($request->password) {
                $input['password'] = Hash::make($request->password);
            }
            $adviser->update($input);
            toastr('Monitor updated successfully');
            return redirect()->route('dashboard.monitors.index');
        } catch (Exception $e) {

            toastr($e->getMessage(), 'warning', 'there is error');
            return redirect()->route('dashboard.monitors.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Monitor $adviser)
    {
        try {



            $adviser->delete();
            toastr('Monitor deleted successfully', 'warning');
            return redirect()->route('dashboard.monitors.index');
        } catch (Exception $e) {
            toastr($e->getMessage(), 'warning');
            return redirect()->back();
        }
    }
}
