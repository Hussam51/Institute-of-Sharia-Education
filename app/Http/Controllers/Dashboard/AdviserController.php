<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Adviser;
use App\Traits\ImageTrait;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdviserController extends Controller
{
    use ImageTrait;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $advisers = Adviser::all();
        return view('Advisers.advisers', compact('advisers'));
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
            $adviser = new Adviser();
            $adviser->first_name = $request->first_name;
            $adviser->last_name = $request->last_name;

            $adviser->phone = $request->phone;


            $adviser->department_id = Auth::user()->department_id;
            $adviser->password = Hash::make($request->password);
            if ($request->hasFile('photo')) {

                $img = $request->file('photo');
                $adviser->photo = $this->UploadImage($img, 'advisers');
            }
            $adviser->save();
            toastr('adviser created successfully');
            return redirect()->route('dashboard.advisers.index');
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
    public function update(Request $request, Adviser $adviser)
    {
        try {
            $input = $request->except('photo');

            if ($request->password) {
                $input['password'] = Hash::make($request->password);
            }
            if ( $request->hasFile('photo')) {
                $this->deleteImage($adviser->photo);
                $input['photo'] = $this->uploadImage($request->file('image'), 'advisers');
            }

            $adviser->update($input);
            toastr('adviser updated successfully');
            return redirect()->route('dashboard.advisers.index');
        } catch (Exception $e) {

            toastr($e->getMessage(), 'warning', 'there is error');
            return redirect()->route('dashboard.advisers.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Adviser $adviser)
    {
        try {

            if ($adviser->photo) {
                $this->deleteImage($adviser->photo);
            }

            $adviser->delete();
            toastr('adviser deleted successfully', 'warning');
            return redirect()->route('dashboard.advisers.index');
        } catch (Exception $e) {
            toastr($e->getMessage(), 'warning');
            return redirect()->back();
        }
    }
}
