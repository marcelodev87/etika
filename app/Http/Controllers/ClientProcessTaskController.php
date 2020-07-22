<?php

namespace App\Http\Controllers;

use App\Client;
use App\ClientProcess;
use App\ClientProcessLog;
use App\ClientProcessTask;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ClientProcessTaskController extends Controller
{


    public function store(Request $request, Client $client, ClientProcess $clientProcess)
    {
        $input = $request->all();
        $input['price'] = str_replace(['.', ','], ['', '.'], $input['price']);
        $rules = [
            'task_id' => 'required|integer|exists:internal_tasks,id',
            'price' => 'required|numeric|min:0'
        ];
        $errors = [];
        $fields = [
            'price' => 'preço',
            'task_id' => 'tarefa'
        ];
        $validator = Validator::make($input, $rules, $errors, $fields);
        if ($validator->fails()) {
            session()->flash('flash-warning', $validator->errors()->first());
            return redirect()->back()->withInput($request->all());
        }
        try {
            $new = ClientProcessTask::create([
                'client_id' => $client->id,
                'client_process_id' => $clientProcess->id,
                'task_id' => $input['task_id'],
                'price' => $input['price'],
            ]);
            $clientProcess->update(['closed' => 0]);

            $log = ClientProcessLog::create([
                'user_id' => auth()->user()->id,
                'client_process_id' => $clientProcess->id,
                'action' => 'adicionou uma tarefa ao processo',
                'type' => 'task',
                'refer_id' => $new->id
            ]);
            session()->flash('flash-success', 'Inserido com sucesso');
            return redirect()->back();
        } catch (\Exception $e) {
            session()->flash('flash-warning', $e->getMessage());
            return redirect()->back()->withInput($request->all());
        }
    }

    public function done(Client $client, ClientProcess $clientProcess, ClientProcessTask $clientProcessTask)
    {
        $now = Carbon::now();
        try {
            $clientProcessTask->update([
                'end_at' => $now->format('Y-m-d H:i:s'),
                'closed' => 1,
                'closed_by' => auth()->user()->id
            ]);
            session()->flash('flash-success', 'Tarafa fechada em ' . $now->format('d/m/Y H:i:s'));
            $log = ClientProcessLog::create([
                'user_id' => auth()->user()->id,
                'client_process_id' => $clientProcess->id,
                'action' => 'finalizou uma tarefa do processo',
                'type' => 'task',
                'refer_id' => $clientProcessTask->id
            ]);
            if ($clientProcess->tasks()->where('closed', 0)->count() == 0) {
                $clientProcess->update(['closed' => 1]);

            } else {
                $clientProcess->update(['closed' => 0]);
            }

        } catch (\Exception $e) {
            session()->flash('flash-warning', $e->getMessage());
        }
        return redirect()->back();
    }

    public function destroy(Client $client, ClientProcess $clientProcess, ClientProcessTask $clientProcessTask)
    {
        if ($clientProcess->tasks->contains($clientProcessTask->id)) {
            $clientProcessTask->delete();
            session()->flash('flash-success', 'Deletado com sucesos');
        } else {
            session()->flash('flash-warning', 'Não há essa tarefa ligada a esse processo');
        }
        if ($clientProcess->tasks()->where('closed', 0)->count() == 0) {
            $clientProcess->update(['closed' => 1]);
        } else {
            $clientProcess->update(['closed' => 0]);
        }
        return redirect()->back();
    }
}
