<?php

namespace App\Http\Controllers;

use App\Client;
use App\ClientMandato;
use App\ClientProcess;
use App\ClientSubscription;
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

    public function newClientsSubscription()
    {
        $newClientsSubscription = ClientSubscription::whereMonth('created_at','=',date('m'))->whereYear('created_at','=',date('Y'))->count();
        return response()->json(['total' => $newClientsSubscription], 200);
    }

    public function expiredTerms()
    {
        $expiredTerms = ClientMandato::whereDate('end_at', '<' , date('Ymd'))->whereYear('created_at','=',date('Y'))->count();
        return response()->json(['total' => $expiredTerms], 200);
    }
}
