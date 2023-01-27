<?php

namespace App\Http\Controllers;

use App\Models\Nonogram;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NonogramController extends Controller
{
    public function list()
    {
        $nonograms = Nonogram::orderBy('id', 'desc')->paginate(20, ['*'], 'p');
        return response()->json($nonograms);
    }

    public function create(Request $request)
    {
        $validated = $request->validate([
            'name' => 'min:3|required',
            'height' => 'numeric|min:5|max:100|required',
            'width' => 'numeric|min:5|max:100|required',
        ]);

        if (!Nonogram::isValid($request->nonogram)) {
            return response('8====D', 400);
        }

        $validated['task'] = Nonogram::createTask($request->nonogram, $request->height, $request->width);
        $validated['result'] = $request->nonogram;
        $nonogram = Nonogram::create($validated);
        $nonogram->author()->associate(Auth::user());
        $nonogram->save();
        return response()->json($nonogram);
    }
    public function show($id)
    {
        return Nonogram::find($id)->toJson();
    }
}
