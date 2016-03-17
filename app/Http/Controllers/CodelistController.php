<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Codelist;

class CodelistController extends Controller
{
    /**
     * Lists all codelists
     *
     * @return Response
     */
    public function index()
    {
        $codelists = Codelist::paginate(20);
        return view('codelists')->with('codelists', $codelists);
    }

    /**
     * Show the specified codelist
     *
     * @param  int  $number
     * @return Response
     */
    public function show($number)
    {
        $codelist = Codelist::where('number', $number)->firstOrFail();
        return view('codes')->with('codelist', $codelist);
    }

    public function search(Request $request)
    {
        $searchResults = Codelist::search($request->input('q'), ['hitsPerPage' => 9999]);

        // Array to store the codelist numbers found in search results
        $codelistNumbers = [];
        foreach ($searchResults['hits'] as $hit) {
            $codelistNumbers[] = $hit['number'];
        }
        
        $codelists = Codelist::whereIn('number', $codelistNumbers)->paginate(20);

        return view('codelists')->with('codelists', $codelists->appends($request->except('page')));
    }
}
