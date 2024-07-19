<?php

namespace App\Http\Requests\Classrooms;
use Illuminate\Foundation\Http\FormRequest;

class updateClassroomRequest extends FormRequest
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
            'list_classes.*.name'=>'required|string|unique:classrooms,name,'.$this->classroom->id,
        
        ];
    }
}
