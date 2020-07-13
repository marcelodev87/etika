<?php

namespace App\Http\Controllers;

use App\InternalProcess;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
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
            'name' => 'required|string|min:3',
            'slug' => 'required|string|unique:internal_processes',
            'price' => 'required|numeric|min:0',
        ];
        $errors = [];
        $fields = [
            'name' => 'nome',
            'price' => 'price',
        ];
        $validator = Validator::make($input, $rules, $errors, $fields);
        if($validator->fails()){
            session()->flash('flash-warning', $validator->errors()->first());
            return redirect()->back()->withInput($request->all());
        }

        try {
            InternalProcess::create([
               'name' => $input['name'],
               'slug' => $input['slug'],
               'price' => $input['price'],
            ]);
            session()->flash('flash-success', 'Processo cadastrado com sucesso');
            return redirect()->route('app.processes.index');
        }catch (\Exception $e){
            session()->flash('flash-warning', $e->getMessage());
            return redirect()->back();
        }
    }


    public function edit(InternalProcess $internalProcess)
    {
        return view('processes.edit', compact('internalProcess'));
    }


    public function update(Request $request, InternalProcess $internalProcess)
    {
        $input = $request->all();
        $input['slug'] = Str::slug($input['name']);
        $input['price'] = str_replace(['.',','],['', '.'], $input['price']);
        $rules = [
            'name' => 'required|string|min:3',
            'slug' => 'required|string|unique:internal_processes,slug,'.$internalProcess->id,
            'price' => 'required|numeric|min:0',
        ];
        $errors = [];
        $fields = [
            'name' => 'nome',
            'price' => 'price',
        ];
        $validator = Validator::make($input, $rules, $errors, $fields);
        if($validator->fails()){
            session()->flash('flash-warning', $validator->errors()->first());
            return redirect()->back()->withInput($request->all());
        }

        try {
            $internalProcess->update([
                'name' => $input['name'],
                'slug' => $input['slug'],
                'price' => $input['price'],
            ]);
            session()->flash('flash-success', 'Processo editado com sucesso');
            return redirect()->route('app.processes.index');
        }catch (\Exception $e){
            session()->flash('flash-warning', $e->getMessage());
            return redirect()->back();
        }
    }


    public function destroy(InternalProcess $internalProcess)
    {
        //
    }
}
