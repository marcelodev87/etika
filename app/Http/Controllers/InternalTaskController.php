<?php

namespace App\Http\Controllers;

use App\InternalTask;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class InternalTaskController extends Controller
{

    public function index()
    {
        $tasks = InternalTask::all();
        return view('tasks.index', compact('tasks'));
    }


    public function create()
    {
        return view('tasks.create');
    }


    public function store(Request $request)
    {
        $input = $request->all();
        $input['slug'] = Str::slug($input['name']);
        $input['price'] = str_replace(['.',','],['', '.'], $input['price']);
        $rules = [
            'name' => 'required|string|min:3',
            'slug' => 'required|string|unique:internal_tasks',
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
            InternalTask::create([
                'name' => $input['name'],
                'slug' => $input['slug'],
                'price' => $input['price'],
            ]);
            session()->flash('flash-success', 'Tarefa cadastrado com sucesso');
            return redirect()->route('app.tasks.index');
        }catch (\Exception $e){
            session()->flash('flash-warning', $e->getMessage());
            return redirect()->back();
        }
    }


    public function edit(InternalTask $internalTask)
    {
        return view('tasks.edit', compact('internalTask'));
    }


    public function update(Request $request, InternalTask $internalTask)
    {
        $input = $request->all();
        $input['slug'] = Str::slug($input['name']);
        $input['price'] = str_replace(['.',','],['', '.'], $input['price']);
        $rules = [
            'name' => 'required|string|min:3',
            'slug' => 'required|string|unique:internal_tasks,slug,'.$internalTask->id,
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
            $internalTask->update([
                'name' => $input['name'],
                'slug' => $input['slug'],
                'price' => $input['price'],
            ]);
            session()->flash('flash-success', 'Tarefa editada com sucesso');
            return redirect()->route('app.tasks.index');
        }catch (\Exception $e){
            session()->flash('flash-warning', $e->getMessage());
            return redirect()->back();
        }
    }


    public function destroy(InternalTask $internalTask)
    {
        //
    }
}
