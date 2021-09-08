<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProjectRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return \Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        if (request()->isMethod("post")) {
            return [
                'title'       => 'required|string',
                'description' => 'required|string',
                'notes'       => 'sometimes|nullable',
            ];
        }elseif (request()->isMethod("patch")) {
            return [
                'title'       => 'required|string',
                'description' => 'required|string',
                'notes'       => 'required|string',
            ];
        }
    }
}
