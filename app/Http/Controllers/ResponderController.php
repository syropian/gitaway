<?php

namespace App\Http\Controllers;

use App\Lib\GitHubClient;
use App\Models\Responder;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class ResponderController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'message' => 'required',
            'startDate' => 'required|date|before:' . $request->input('endDate'),
            'endDate' => 'required|date|after:' . $request->input('startDate'),
            'repoId' => 'nullable|integer',
        ]);

        // TODO: This should iterate over an array of repo ids and create a record for each one
        $responder = auth()->user()->responders()->create([
            'title' => $request->input('title'),
            'message' => $request->input('message'),
            'start_date' => $request->input('startDate'),
            'end_date' => $request->input('endDate'),
            'repo_id' => $request->input('repoId')
        ]);

        return response()->json($responder, 201);
    }

}
