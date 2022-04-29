<?php

namespace App\Http\Controllers;

use App\Client;
use App\ClientMandato;
use App\ClientProcess;
use App\ClientProcessTask;
use App\ClientSubscription;
use App\ClientSubscriptionTask;
use App\InternalTask;
use Carbon\Carbon;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WidgetController extends Controller
{
    public function clientsRegistred()
    {
        $clients = Client::count();
        return response()->json(['total' => $clients], 200);
    }

    public function newProcesses()
    {
        $newProcesses = ClientProcess::whereMonth('created_at','=',date('m'))->whereYear('created_at','=',date('Y'))->count();
        return response()->json(['total' => $newProcesses], 200);
    }

    public function closedProcesses()
    {
        $closedProcesses = ClientProcess::where('closed', 1)->whereMonth('updated_at','=',date('m'))->whereYear('updated_at','=',date('Y'))->count();
        return response()->json(['total' => $closedProcesses], 200);
    }

    public function closedProcesses30()
    {
        $closedProcesses30 = ClientProcess::where('closed', 1)->where('updated_at','>', Carbon::now()->subDays(30))->count();
        return response()->json(['total' => $closedProcesses30], 200);
    }

    public function newClientsSubscription()
    {
        $newClientsSubscription = ClientSubscription::whereMonth('created_at','=',date('m'))->whereYear('created_at','=',date('Y'))->count();
        return response()->json(['total' => $newClientsSubscription], 200);
    }

    public function expiredTerms()
    {
        $expiredTerms = ClientMandato::whereDate('end_at', '<' , date('Ymd'))->count();
        return response()->json(['total' => $expiredTerms], 200);
    }

    public function digitalCertificate()
    {
        $digitalCertificate = DB::table('internal_tasks')
            ->join('client_subscription_tasks', 'client_subscription_tasks.task_id', '=' , 'internal_tasks.id')
            ->where('internal_tasks.name', 'like', 'Certificado Digital')
            ->where('client_subscription_tasks.closed' , '=' , '0')
            ->count();

        return response()->json(['total' => $digitalCertificate], 200);
    }

    public function lawyerSignature()
    {
        $lawyerSignature = DB::table('internal_tasks')
            ->join('client_process_tasks', 'client_process_tasks.task_id', '=' , 'internal_tasks.id')
            ->where('internal_tasks.name', 'like', 'Assinatura Advogado')
            ->where('client_process_tasks.closed' , '=' , '0')
            ->where('client_process_tasks.updated_at','>', Carbon::now()->subDays(60))
            ->count();

        return response()->json(['total' => $lawyerSignature], 200);
    }

    public function sentProcesses()
    {
        $sentProcesses = DB::table('internal_tasks')
            ->join('client_process_tasks', 'client_process_tasks.task_id', '=' , 'internal_tasks.id')
            ->where('internal_tasks.name', 'like', 'Enviar documentos para registro')
            ->where('client_process_tasks.closed' , '=' , '1')
            ->where('client_process_tasks.updated_at','>', Carbon::now()->subDays(60))
            ->count();
        return response()->json(['total' => $sentProcesses], 200);
    }

    public function pendingTasksSubscription()
    {
        $pendingTasksSubscription = DB::table('internal_tasks')
            ->join('client_subscription_tasks', 'client_subscription_tasks.task_id', '=' , 'internal_tasks.id')
            ->where('client_subscription_tasks.closed' , '=' , '0')
            ->count();

        return response()->json(['total' => $pendingTasksSubscription], 200);
    }

    public function pendingTasks()
    {
        $pendingTasks = DB::table('internal_tasks')
            ->join('client_tasks', 'client_tasks.task_id', '=' , 'internal_tasks.id')
            ->where('client_tasks.closed' , '=' , '0')
            ->count();

        return response()->json(['total' => $pendingTasks], 200);
    }
}
