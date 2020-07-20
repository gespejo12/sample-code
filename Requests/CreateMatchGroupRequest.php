<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateMatchGroupRequest extends FormRequest
{
    /**
     * Create Match Group validation Rules
     */
    public function rules()
    {
        return [
            'code'              => 'required|unique:match_groups',
            'name'              => 'required|unique:match_groups'
        ];
    }
}
