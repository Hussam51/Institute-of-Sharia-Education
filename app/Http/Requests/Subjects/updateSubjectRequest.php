<?php

namespace App\Http\Requests\Subjects;

use Illuminate\Foundation\Http\FormRequest;

class updateSubjectRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array


    {
        return [
            'name'=>'required|unique:subjects,name,'.$this->subject->id,
            'classroom_id'=>'required|unique:classrooms,id,'.$this->subject->classroom_id
        ];



    }
}
