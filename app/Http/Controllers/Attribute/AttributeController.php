<?php

namespace App\Http\Controllers\Attribute;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AttributeController extends Controller
{
    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:text,date,number,select'
        ]);
        dd($validated);
        $attribute = Attribute::updateOrCreate(
            ['name' => $validated['name']],
            ['type' => $validated['type']]
        );

        return response()->json($attribute);
    }
}
