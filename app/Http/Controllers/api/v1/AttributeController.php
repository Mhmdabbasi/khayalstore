<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Model\Attribute;

class AttributeController extends Controller
{
    public function get_attributes()
    {
        $attributes = Attribute::all();

        return response()->json($attributes, 200);
    }
}
