<?php

namespace App\Http\Controllers;

use App\Client;
use App\ClientSubscription;
use App\ClientSubscriptionTask;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ClientSubscriptionTaskController extends Controller
{
    public function done(Client $client, ClientSubscription $clientSubscription, ClientSubscriptionTask $clientSubscriptionTask)
    {

        if(!$clientSubscriptionTask->closed){
            if ($clientSubscriptionTask->client_subscription_id == $clientSubscription->id && $clientSubscription->client_id == $client->id) {
                if($clientSubscriptionTask->user_id == auth()->user()->id || auth()->user()->hasRole('adm')){
                    $clientSubscriptionTask->update([
                        'closed' => 1,
                        'closed_by' => auth()->user()->id,
                        'closed_at' => Carbon::now()->format('Y-m-d H:i:s')
                    ]);
                    session()->flash('flash-success', 'Tarefa finalizada com sucesso');
                }else{
                    session()->flash('flash-warning', 'Você não pode fechar essa tarefa');
                }
            }else{
                session()->flash('flash-warning', 'Não podemos fechar essa tarefa.');
            }
        }else{
            session()->flash('flash-warning', 'Tarefa já está fechada');
        }
        return redirect()->back();
    }

    public function delay(Request $request)
    {
        $rules = [
            'task_id' => 'required|integer|exists:client_subscription_tasks,id',
            'tipo' => 'required|string|in:h,d',
            'qt' => 'required|integer|min:1|max:24',
        ];
        $errors = [];
        $fields = [
            'task_id' => 'tarefa',
            'tipo' => 'tipo',
            'qt' => 'quantidade'
        ];
        $validator = Validator::make($request->all(), $rules, $errors, $fields);
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first()], 400);
        }
        $hours = $request->qt;
        if($request->tipo == 'd'){
            $hours = $request->qt * 24;
        }

        $task = ClientSubscriptionTask::find($request->task_id);

        // atualiza
        $oldHour = $task->end_at ?? Carbon::now()->second(0);
        $newHour = Carbon::parse($oldHour)->addHours($hours);
        $task->update([
            'end_at' => $newHour->format('Y-m-d H:i:s')
        ]);
        $task->comments()->create([
            'user_id' => auth()->user()->id,
            'comment' => '<b>fez o adiamento</b> antigo: '.$oldHour->format('d/m/Y H:i:s') . ' ~ novo ' . $newHour->format('d/m/Y H:i:s') . '; total de '. $hours . ' hora(s) adicionada.'
        ]);

        return response()->json(['message' => 'atualizado com sucesso'], 200);
    }
}
