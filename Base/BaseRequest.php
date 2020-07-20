<?php

namespace App\Base;

use App\Repositories\CustomFieldRepository;
use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\CustomFieldValidations;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Contracts\Validation\Factory as ValidationFactory;

class BaseRequest extends FormRequest
{
    /**
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the "id" value of the the route params
     *
     * @return string
     */
    protected function getRouteId()
    {
        return $this->route()->parameter('id');
    }
}
