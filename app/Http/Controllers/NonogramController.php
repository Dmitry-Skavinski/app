<?php

namespace App\Http\Controllers;

use App\Models\Nonogram;
use App\Models\Progress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NonogramController extends Controller
{
    public function list()
    {
        $nonograms = Nonogram::orderBy('id', 'desc')->paginate(20, ['*'], 'p');
        return response()->json($nonograms);
    }

    public function listByAuthor($author)
    {
        $nonograms = Nonogram::where('author_id', '=', $author)
            ->orderBy('id', 'desc')
            ->paginate(20, ['*'], 'p');

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

    public function getProgress($id)
    {
        if ($progress = Auth::user()->startedNonograms()->where('nonogram_id', $id)->first()) {
            return response()->json($progress);
        }
        return response('progress was not found', 400);
    }

    public function setProgress(Request $request, $id)
    {
        if ($progress = Auth::user()->startedNonograms()->where('nonogram_id', $id)->first()) {
            $progress->data = $request->data;
        } else {
            $progress = Progress::create([
                'data' => $request->data,
                'nonogram_id' => $id,
                'user_id' => Auth::id()
                ]);
            $progress->user()->associate(Auth::user());
            $progress->nonogram()->associate(Nonogram::find($id));
        }
        $progress->save();
        return response()->json($progress);
    }
}
