<?php

namespace App\Http\Controllers;

use App\Client;
use App\ClientSubscription;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ClientSubscriptionController extends Controller
{

    public function show(Client $client, ClientSubscription $clientSubscription)
    {
        return view('clients.subscriptions.index', compact('client', 'clientSubscription'));
    }

    public function store(Request $request, Client $client)
    {
        if ($client->subscriptions()->where('active', 1)->count()) {
            return response()->json(['message' => 'O cliente já tem uma assinatura ativa'], 400);
        }

        try {
            $client->subscriptions()->create([
                'subscription_id' => $request->subscription_id,
                'price' => brlToNumeric($request->price),
            ]);
            session()->flash('flash-success', 'Assinatura adicionada com sucesso');
            return response()->json([], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }

    public function close(Client $client, ClientSubscription $clientSubscription)
    {
        try {
            $clientSubscription->update([
                'active' => 0,
                'terminate_at' => Carbon::now()->format('Y-m-d H:i:s')
            ]);
            session()->flash('flash-success', 'Assinatura terminada com sucesso');
        }catch (\Exception $e){
            session()->flash('flash-warning', $e->getMessage());
        }
        return redirect()->back();
    }
}
