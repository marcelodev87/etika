<?php

namespace App\Http\Controllers;

use App\Client;
use App\ClientTask;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ClientTaskController extends Controller
{
    public function store(Request $request, Client $client)
    {
        $input = $request->all();
        $input['price'] = brlToNumeric($input['price']);
        $rules = [
            'task_id' => 'required|integer|exists:internal_tasks,id',
            'price' => 'required|numeric|min:0',
            'user_id' => 'required|integer|exists:users,id',
            'end_at' => 'required|date_format:d/m/Y H:i',
        ];
        $errors = [];
        $fields = [
            'task_id' => 'tarefa',
            'price' => 'preço',
            'user_id' => 'responsável',
            'end_at' => 'dt entrega',
        ];
        $validator = Validator::make($input, $rules, $errors, $fields);
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first()], 400);
        }

        try {
            $client->tasks()->create([
                'task_id' => $input['task_id'],
                'user_id' => $input['user_id'],
                'price' => $input['price'],
                'end_at' => Carbon::createFromFormat('d/m/Y H:i', $input['end_at'])->format('Y-m-d H:i:s'),
            ]);
            return response()->json([], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }

    }

    public function done(Client $client, ClientTask $clientTask)
    {
        if (!$clientTask->closed) {
            $clientTask->update([
                'closed' => 1,
                'closed_by' => auth()->user()->id,
                'closed_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ]);
            session()->flash('flash-success', 'Tarefa entregue!');
        } else {
            session()->flash('flash-warning', 'Essa tarefa já foi entregue.');
        }

        return redirect()->back();
    }
}
