<?php

namespace App\Http\Controllers;

use App\InternalProcess;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class InternalProcessController extends Controller
{

    public function index()
    {
        $processes = InternalProcess::all();
        return view('processes.index', compact('processes'));
    }


    public function create()
    {
        return view('processes.create');
    }


    public function store(Request $request)
    {
        $input = $request->all();
        $input['slug'] = Str::slug($input['name']);
        $input['price'] = str_replace(['.',','],['', '.'], $input['price']);
        $rules = [
            'name' => 'requried|string|min:3'
        ];
    }


    public function show(InternalProcess $internalProcess)
    {
        //
    }


    public function edit(InternalProcess $internalProcess)
    {
        //
    }


    public function update(Request $request, InternalProcess $internalProcess)
    {
        //
    }


    public function destroy(InternalProcess $internalProcess)
    {
        //
    }
}
