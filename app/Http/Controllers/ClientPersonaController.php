<?php

namespace App\Http\Controllers;

use App\Client;
use App\ClientPersonaAddress;
use Illuminate\Support\Facades\Validator;
use App\ClientPersona;
use Illuminate\Http\Request;

class ClientPersonaController extends Controller
{

    public function index(Client $client)
    {
        return view('clients.members.index', compact('client'));
    }


    public function store(Client $client, Request $request)
    {
        $rules = [
            'name' => 'required|string|min:3|max:191',
            'document' => 'required|string|min:14|max:14',
            'role' => 'required|string|min:3|max:191',
            'gender' => 'required|string',
            'marital_status' => 'nullable|string|min:3',
            'profession' => 'nullable|string|min:3',
        ];
        $errors = [];
        $fields = [
            'name' => 'nome completo',
            'document' => 'documento',
            'role' => 'cargo',
            'gender' => 'sexo',
            'marital_status' => 'estado civil',
            'profession' => 'profissão',
        ];
        $validator = Validator::make($request->all(), $rules, $errors, $fields);
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first()], 400);
        }
        try {
            $member = $client->members()->create([
                'name' => $request->name,
                'document' => $request->document,
                'role' => $request->role,
                'gender' => $request->gender,
                'marital_status' => $request->marital_status,
                'profession' => $request->profession
            ]);
            return response()->json(['data' => $member], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }


    public function show(Client $client, ClientPersona $clientPersona)
    {

        return response()->json(['data' => $clientPersona], 200);
    }


    public function update(Request $request, Client $client, ClientPersona $clientPersona)
    {
        $rules = [
            'name' => 'required|string|min:3|max:191',
            'document' => 'required|string|min:14|max:14',
            'role' => 'required|string|min:3|max:191',
            'gender' => 'required|string',
            'marital_status' => 'nullable|string|min:3',
            'profession' => 'nullable|string|min:3',
        ];
        $errors = [];
        $fields = [
            'name' => 'nome completo',
            'document' => 'documento',
            'role' => 'cargo',
            'gender' => 'sexo',
            'marital_status' => 'estado civil',
            'profession' => 'profissão',
        ];
        $validator = Validator::make($request->all(), $rules, $errors, $fields);
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first()], 400);
        }
        try {
            $clientPersona->update([
                'name' => $request->name,
                'document' => $request->document,
                'role' => $request->role,
                'gender' => $request->gender,
                'marital_status' => $request->marital_status,
                'profession' => $request->profession
            ]);
            return response()->json(['data' => $clientPersona], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }


    public function information(Client $client, ClientPersona $clientPersona)
    {
        $persona = $clientPersona;
        $emails = $clientPersona->emails;
        $phones = $clientPersona->phones;
        $addresses = $clientPersona->addresses;
        return response()->json(['data' => [
            'persona' => $persona,
            'emails' => $emails,
            'phones' => $phones,
            'addresses' => $addresses,
        ]], 200);
    }


    public function destroy(Client $client, ClientPersona $clientPersona)
    {
        $name = $clientPersona->name;
        try {
            $clientPersona->delete();
            return response()->json(['message' => 'O cliente ' . $name . ' foi excluído.'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }

    }
}
