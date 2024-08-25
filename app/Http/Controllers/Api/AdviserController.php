<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Consult;
use App\Models\ConsultReply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class AdviserController extends Controller
{




    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        if (!$token = auth()->guard('adviser')->attempt($validator->validated())) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }


        return $this->createNewToken($token);
    }






    public function logout()
    {
        auth()->guard('adviser')->logout();

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




/////////////////
    public function showStudentConsult()
    {
        if (!auth()->guard('adviser')->check()) {
            return response()->json(['error' => 'Only adviser can view student consult.'], 403);
        }

        $adviser = auth()->guard('adviser')->user();
        $consults = $adviser->consult()->with('student')->get();

        $consultsWithStudentNames = $consults->map(function ($consult) {
            $studentName = $consult->is_anonymous ? ' المرسِل مجهول' : $consult->student->first_name.' '.$consult->student->last_name;
            return [
                'id' => $consult->id,
                'adviser_id' => $consult->adviser_id,
                'student_id' => $consult->student_id,
                'student_name' => $studentName,
                'consult' => $consult->consult,
                'answered' => $consult->answered,
                'created_at' => $consult->created_at,
                'updated_at' => $consult->updated_at,
            ];
        });

        return response()->json($consultsWithStudentNames);
    }







/////////////////////////////////////////////
    public function replyToConsult(Request $request)
    {
        // Get the authenticated adviser
        $adviser = auth()->guard('adviser')->user();

        // Check if the adviser is authenticated
        if (!$adviser) {
            return response()->json(['error' => 'Only adviser can reply to student consult.'], 403);
        }

        // Get the consult ID from the request
        $consultId = $request->input('consult_id');

        // Find the consult and check if it belongs to the adviser's department
        $consult = Consult::with('student', 'student.department', 'replies.adviser')
            ->whereHas('student.department', function ($query) use ($adviser) {
                $query->where('department_id', $adviser->department_id);
            })
            ->findOrFail($consultId);

        $consult->answered = true;
        $consult->save();
        // Create the reply
        $answer = $consult->replies()->create([
            'reply' => $request->input('reply'),
            'adviser_id' => $adviser->id,
        ]);

        // Prepare the response
        $response = [
            'consult' => [
                'id' => $consult->id,
                'student_name' =>  $consult->is_anonymous ? ' المرسِل مجهول' : $consult->student->first_name.' '.$consult->student->last_name,//
                'department_name' => $consult->student->department->name,
                'consult_text' => $consult->consult,
            ],
            'reply' => [
                'id' => $answer->id,
                'reply' => $answer->reply,
                'adviser_name' => $answer->adviser->first_name.' '.$adviser->last_name,
            ],
        ];

        return response()->json($response);
    }




    public function getConsultById(Request $request)
    {
        if (!auth()->guard('adviser')->check()) {
            return response()->json(['error' => 'Only adviser can view student consult.'], 403);
        }



        $consultId = $request->input('id');
        $consult = Consult::findOrFail($consultId);

        $studentName = $consult->is_anonymous ? ' المرسِل مجهول' : $consult->student->first_name.' '.$consult->student->last_name;

        return response()->json([
            'id' => $consult->id,
                'adviser_id' => $consult->adviser_id,
                'student_id' => $consult->student_id,
                'student_name' => $studentName,
                'consult' => $consult->consult,
                'created_at' => $consult->created_at,
                'updated_at' => $consult->updated_at,
        ]);
    }








    public function deleteConsultReply(Request $request)
    {
        $consultReplyId = $request->input('id');
        $consultReply = ConsultReply::findOrFail($consultReplyId);
        $consultReply->delete();

        return response()->json([
            'message' => 'consultReply deleted'
        ]);
    }





    public function updateConsultReply(Request $request)
    {

        $consultReplyId = $request->input('id');

        $consultReply = ConsultReply::findOrFail($consultReplyId);

        $consultReply->update([
            'reply' => $request->input('reply'),
        ]);

        return response()->json([
            'message' => 'consultReply updated'
        ]);
    }



    public function showConsultReplies()
    {

        $replies = \App\Models\ConsultReply::all();


        return response()->json($replies);
    }






    public function showGuards()
    {
        $guards = array_keys(config('auth.guards'));

        $arabicGuards = [];
        foreach ($guards as $guard) {
            if ($guard !== 'web' && $guard !== 'sanctum' && $guard !== 'api') {
                switch ($guard) {
                    case 'student':
                        echo 'type';
                        $arabicGuards[] = 'طالب';
                        break;
                    case 'parent':
                        $arabicGuards[] = 'ولي أمر';
                        break;
                    case 'teacher':
                        $arabicGuards[] = 'معلم';
                        break;
                    case 'monitor':
                        $arabicGuards[] = 'موجه';
                        break;
                    case 'adviser':

                        $arabicGuards[] = 'مرشد';
                        break;
                    default:
                        $arabicGuards[] = $guard;
                        break;
                }
            }
        }

        return response()->json($arabicGuards);
    }





    protected function createNewToken($token){

        $user = auth()->guard('adviser')->user();
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => JWTAuth::factory()->getTTL() * 60,
            'user' => [
                'id' => $user->id,
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'password'=>$user->password,
                'full_name'=>$user->first_name.' '.$user->last_name
            ],
        ]);
    }
}
