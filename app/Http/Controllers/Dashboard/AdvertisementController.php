<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Ads;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yoeunes\Toastr\Facades\Toastr;

class AdvertisementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       $advertisements=Ads::all();
       return view('Advertisements.advertisment',compact('advertisements'));
    }
    public function show(Ads $advertisement)
    {
      
       return view('Advertisements.show',compact('advertisement'));
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
           
        ]);
        $validatedData['department_id']=Auth::user()->department_id;
       Ads::create($validatedData);
       Toastr::success('Created Successfully','Advertisement');
       return redirect()->route('dashboard.advertisements.index');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Ads  $advertisement)
    {  $validatedData = $request->validate([
        'title' => 'required|max:255',
        'content' => 'required',
       
    ]);
        $advertisement->update($validatedData);
        Toastr('Updated Successfully');
        return redirect()->route('dashboard.advertisements.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ads  $advertisement)
    {
        $advertisement->delete();
        Toastr('deleted successfully','success','advertisment');
        return redirect()->route('dashboard.advertisements.index');
    }
}
