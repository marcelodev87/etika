<?php

namespace App\Http\Controllers;

use App\Client;
use Illuminate\Http\Request;

class WidgetController extends Controller
{
    public function haveSomethingOpen()
    {
        $clients = Client::all();
        $count = 0;
        foreach ($clients as $client) {
            $current = $count;
            // check process
            if($client->processes()->where('closed', 0)->count()){
                $count++;
            }
            if($current == $count){
                foreach ($client->processes as $process){
                    if($process->tasks()->where('closed', 0)->count()){
                        $count++;
                        break;
                    }
                }
            }
        }
        return response()->json(['total' => $count], 200);
    }
}
