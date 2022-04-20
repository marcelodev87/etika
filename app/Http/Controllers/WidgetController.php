<?php

namespace App\Http\Controllers;

use App\Client;
use App\ClientProcess;
use Illuminate\Http\Request;

class WidgetController extends Controller
{
    public function clientsRegistred()
    {
        $clients = Client::count();
        return response()->json(['total' => $clients], 200);
    }

    public function newProcesses()
    {
        $newProcesses = ClientProcess::count()->whereMonth('created_at', date('m'));
        return response()->json(['total' => $newProcesses], 200);
    }
}
