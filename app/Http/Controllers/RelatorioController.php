<?php

namespace App\Http\Controllers;

use App\ClientProcess;
use Illuminate\Http\Request;

class RelatorioController extends Controller
{
    public function processoAberto(){
        $processos = ClientProcess::where('closed', 0)->get();
        return view('relatorios.processosAbertos', compact('processos'));
    }

    public function processoFechado(){
        $processos = ClientProcess::where('closed', 1)->get();
        return view('relatorios.processosFechados', compact('processos'));
    }

    public function pagamentoAberto(){
        $processos = ClientProcess::where('closed', 0)->get();
        return view('relatorios.pagamentosAbertos', compact('processos'));
    }
}
