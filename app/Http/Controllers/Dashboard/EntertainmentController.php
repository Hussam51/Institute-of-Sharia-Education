<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Entertainment;
use Illuminate\Http\Request;
use Yoeunes\Toastr\Facades\Toastr;

class EntertainmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $questions=Entertainment::all();
       return view('Entertainments.index',compact('questions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
       return view('Entertainments.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
       
      
        $validatedData = $request->validate([
            'question' => 'required',
            'answer1' => 'required',
            'answer2' => 'required',
            'answer3' => 'required',
            'answer4' => 'required',
            'correct_answer' => 'required',
            'start_time' => 'required|date_format:H:i',
            'duration' => 'required',
        ]);

        $entertainment = Entertainment::create($validatedData);
       
    Toastr('success','Entertainment question added successfully!');
        return redirect()->route('dashboard.entertainments.index');
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
        $enterainment=Entertainment::findOrFail($id)->first();   

       return view('Entertainments.edit',compact('enterainment'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
       $entertainment =Entertainment::findOrFail($id);
        $validatedData = $request->validate([
            'question' => 'required',
            'answer1' => 'required',
            'answer2' => 'required',
            'answer3' => 'required',
            'answer4' => 'required',
            'correct_answer' => 'required',
            'start_time' => 'required|date_format:H:i:s',
            'duration' => 'required',
        ]);

        $entertainment->update($validatedData);
    Toastr('info','Entertainment question updated successfully!');
        return redirect()->route('dashboard.entertainments.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $entertainment =Entertainment::findOrFail($id)
        ->delete();

        Toastr('warning','Entertainment question deleted successfully!');
        return redirect()->route('dashboard.entertainments.index');
    }
}
