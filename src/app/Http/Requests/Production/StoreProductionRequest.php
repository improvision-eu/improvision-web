<?php

namespace App\Http\Requests\Production;


class StoreProductionRequest extends UpdateProductionRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

}
