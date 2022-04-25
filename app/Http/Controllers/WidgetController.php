<?php

namespace App\Http\Controllers;

use App\Client;
use App\ClientMandato;
use App\ClientProcess;
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
        $digitalCertificate = ClientSubscriptionTask::where('task_id', '15')->where('closed', '0')->count();
        return response()->json(['total' => $digitalCertificate], 200);
    }
}
