<?php

namespace App\Http\Controllers;

use App\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clients = Client::all();
        return view('clients.index', compact('clients'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('clients.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|string|min:5|max:50',
            'document' => 'required|string|min:14|max:18',
            'type' => 'required',
            'internal_code' => 'nullable|integer',
        ];

        $errors = [];
        $fields = [
            'name' => '\'nome completo\'',
            'document' => '\'documento\'',
            'type' => '\'tipo\'',
            'internal_code' => '\'codigo interno\'',
        ];

        $validator = Validator::make($request->all(), $rules, $errors, $fields);
        if($validator->fails()){
            return response()->json(['message' => $validator->errors()->first()], 400);
        }

        try {
            Client::create([
                'name' => $request->name,
                'document' => $request->document,
                'type' => $request->type,
                'internal_code' => $request->internal_code,
            ]);
            return response()->json(['message' => 'Novo cliente criado com sucesso'], 201);
        } catch (\Exception $e) {
            return response()->json(['message' =>  $e->getMessage()], 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function show(Client $client)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function edit(Client $client)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Client $client)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function destroy(Client $client)
    {
        //
    }
}
