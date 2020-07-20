<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMatchGroupRequest extends FormRequest
{
    /**
     * Update Match Group validation Rules
     */
    public function rules()
    {
        return [
            'code'   => 'sometimes|unique:match_groups',
            'name'   => 'required|unique:match_groups'
        ];
    }
}
