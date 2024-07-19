<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Classroom;
use App\Models\Library;
use App\Traits\ImageTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Exists;
use Yoeunes\Toastr\Facades\Toastr;

use function Laravel\Prompts\warning;

class LibraryController extends Controller
{
    use ImageTrait;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $files = Library::whereNull('teacher_id')->get();

        return view('Library.index', compact('files'));
        
    }

    public function filesPendingRequests()
    {
        $files = Library::whereNotNull('teacher_id')->where('status', 'pending')->get();

        return view('Library.fileUploadRequest', compact('files'));
    }


    public function filesApprovedRequests()
    {
        $files = Library::whereNotNull('teacher_id')->where('status', 'Approved')->get();

        return view('Library.fileUploadApproved', compact('files'));
    }


    public function filesRejectedRequests()
    {
        $files = Library::whereNotNull('teacher_id')->where('status', 'Rejected')->get();

        return view('Library.fileUploadRejected', compact('files'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $department_id = Auth::user()->department_id;
        $classrooms = Classroom::where('department_id', Auth::user()->department_id)->get();

        return view('Library.create', compact('classrooms'));
    }





    public function show($id)
    {
       $file=Library::findOrFail($id);
       

        return view('Library.show', compact('file'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validatedData = $request->validate([

            'title' => 'required|string',
            'subject_id' => 'required|string',
            'classroom_id' => 'required|string',
            'type' => 'required|in:book,document',

        ]);
        $fileUpload = $request->file('file_url');
        //   $file = $request->file('file');
        //  $filename = $file->getClientOriginalName();

        // Save the file in a temporary location
        //   $file->storeAs('temp', $filename);

        // Create a new file upload request


        $file_url = $this->uploadImage($fileUpload, 'library');
        // $fileUpload->storeAs('temp', $file_url);
        $validatedData['status'] = 'approved';
        $validatedData['file_url'] = $file_url;
        $fileUploadRequest = Library::create($validatedData);
        // $fileUploadRequest->save();

        // Broadcast the new file upload request event
        //  event(new NewFileUploadRequest($fileUploadRequest));
        Toastr('Uploaded Successfully', 'success', 'File Upload');
        return redirect()->route('dashboard.libraries.index');
    }

    /**
     * Display the specified resource.
     */
    public function uploadsChangeStatus(Request $request, string $id)
    {

        $requestupload = Library::find($id)->update(['status' => $request->status]);

        // Delete the temporary file
        // Storage::disk('temp')->delete($fileUploadRequest->filename);

        // Broadcast the file upload rejection event
        // event(new FileUploadRejected($requestupload));
        return $requestupload;
    }

    /*

    public function approveFileUpload(string $id)
    {
        $requestupload=Library::find($id);
        $requestupload->update(['status' => 'approved']);
        
         // Move the file from the temporary location to the final location
        // $file = Storage::disk('temp')->get($requestupload->file_url);
         //Storage::disk('uploads')->put($requestupload->file_url, $file);
         //Storage::disk('temp')->delete($requestupload->file_url);
        // Broadcast the file upload rejection event
       // event(new FileUploadRejected($requestupload));
       return $requestupload;

    }

   */


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $department_id = Auth::user()->department_id;
        $classrooms = Classroom::where('department_id', Auth::user()->department_id)->get();
        $file=Library::findOrFail($id);
        return view('Library.edit', compact('classrooms','file'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([

            'file_name' => 'required|string',
            'subject_id' => 'required|string',
            'classroom_id' => 'required|string',
            'type' => 'required|in:book,document',

        ]);

        $file = Library::find($id);;

        if ($request->hasFile('file_url')) {

            $this->deleteImage($file->file_url);
            $fileUpload = $request->file('file_url');
            $newFileUrl = $this->uploadImage($fileUpload, 'library');
        }
        $validatedData['file_url'] = $newFileUrl;
        $fileUpload = Library::create($validatedData);
        // $fileUploadRequest->save();

        // Broadcast the new file upload request event
        //  event(new NewFileUploadRequest($fileUploadRequest));
        Toastr('Uploaded Successfully', 'success', 'File Upload');
        return redirect()->route('dashboard.libraries.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $file = Library::find($id);
        if ($file->file_url) {

            $this->deleteImage($file->file_url);
        }

        $file->delete();

        Toastr('Deleted Successfully', 'warning', 'File');
        return redirect()->route('dashboard.libraries.index');
    }

    ///// file download

    public function downloadPDF(string $id)
    {
       
        $file = Library::findOrFail($id);
     
         $filePath=public_path('uploads\\'.$file->file_url) ;
        return response()->download($filePath,$file->title.'.'.'pdf');
    }
    //  return response()->download($filePath, $file->file_url);


}
