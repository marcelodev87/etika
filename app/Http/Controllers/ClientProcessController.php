<?php

namespace App\Http\Controllers;

use App\Client;
use App\ClientProcess;
use App\InternalProcess;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ClientProcessController extends Controller
{

    public function index(Client $client, ClientProcess $clientProcess)
    {
        return view('clients.process.index', compact('client', 'clientProcess'));
    }

    public function store(Request $request, Client $client)
    {
        $input = $request->all();
        $input['price'] = str_replace(['.', ','], ['', '.'], $input['price']);
        $rules = [
            'process_id' => 'required|integer|exists:internal_processes,id',
            'price' => 'required|numeric|min:0',
        ];
        $errors = [];
        $fields = [
            'process_id' => 'processo',
            'price' => 'preço',
        ];
        $validator = Validator::make($input, $rules, $errors, $fields);
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first()], 400);
        }

        try {
            $process = $client->processes()->create([
                'process_id' => $input['process_id'],
                'price' => $input['price']
            ]);
            $tasks = InternalProcess::find($input['process_id'])->tasks;
            foreach ($tasks as $task){
                try {
                    $process->tasks()->create([
                        'client_id' => $client->id,
                        'task_id' => $task->id,
                        'price'=>0,
                    ]);
                }catch (\Exception $e){
                    $process->delete();
                    return response()->json(['message' => $e->getMessage()], 400);
                }
            }
            return response()->json(['message' => 'Processo cadastrado com sucesso'], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }

    }


    public function show(ClientProcess $clientProcess)
    {
        //
    }


    public function edit(ClientProcess $clientProcess)
    {
        //
    }


    public function update(Request $request, ClientProcess $clientProcess)
    {
        //
    }


    public function destroy(ClientProcess $clientProcess)
    {
        //
    }
}
