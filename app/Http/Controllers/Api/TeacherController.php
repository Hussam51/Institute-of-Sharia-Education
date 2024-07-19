<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Library;
use App\Traits\ImageTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

class TeacherController extends Controller
{
    use ImageTrait;
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */

    /*    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['register']]);
    }
*/
    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        if (!$token = auth()->guard('teacher')->attempt($validator->validated())) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return  $this->createNewToken($token);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function userProfile()
    {
        return response()->json(auth()->guard('teacher')->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->guard('teacher')->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {

        return response()->json($this->createNewToken(JWTAuth::refresh()));
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */

    //


    protected function createNewToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => JWTAuth::factory()->getTTL() * 60,
            'user' => auth()->guard('teacher')->user()
        ]);
    }







    public function uploadFile(Request $request)
    {

        $validatedData = $request->validate([

            'title' => 'required|string',
            'subject_id' => 'required|string',
            'classroom_id' => 'required',
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
        $validatedData['teacher_id'] = auth()->guard('teacher')->user()->id;
        $validatedData['department_id'] = auth()->guard('teacher')->user()->department_id;
        $validatedData['file_url'] = $file_url;
        $fileUploadRequest = Library::create($validatedData);
        return response()->json('Uploaded successfully', 200);
    }

    public function teacherFiles()
    {
        $files = Library::whereNotNull('teacher_id')
        ->where('teacher_id',auth()->guard('teacher')->user()->id)
                ->where('status','approved')
                 ->get();

        return response()->json($files,200);

    }


    
}
