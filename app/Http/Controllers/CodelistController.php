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
        $codelists = Codelist::paginate(25);
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
}
