<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChartController extends Controller
{
    public function received()
    {
        setlocale(LC_ALL, 'pt_BR.utf-8', 'ptb', 'pt_BR', 'portuguese-brazil', 'portuguese-brazilian', 'bra', 'brazil', 'br');
        $period = [];
        $values = [];
        $log = [];
        $months = 11;
        for ($i = 0; $i < $months + 1; $i++) {

            $s = Carbon::now()->startOfMonth()->subMonths($months)->addMonths($i);
            $e = Carbon::now()->endOfMonth()->subMonths($months)->addMonths($i)->subDay();

            $sum = DB::table('client_process_payments')->whereBetween('payed_at', [$s->format('Y-m-d'), $e->format('Y-m-d')]);
            array_push($period, $s->formatLocalized('%b/%y'));
            array_push($values, (float)$sum->sum('value'));
            array_push($log, [$s, $e, $sum->get()]);
        }
        return response()->json(['periods' => $period, 'values' => $values], 200);
    }
}
