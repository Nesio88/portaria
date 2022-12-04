<?php

namespace App\Http\Controllers;

use App\Models\Delivery;
use App\Models\Record;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DeliveryController extends Controller
{   
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function listCheckin()
    {
        return Record::listCheckin();         
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        date_default_timezone_set('America/Sao_Paulo');

        $delivery = Delivery::create([
            'name' => $request->name,
            'cpf' => $request->cpf
        ]);        

        Record::create([
            'deliveryman_id' => $delivery->id,
            'empresa' => $request->empresa,
            'bloco' => $request->bloco,
            'apartamento' => $request->apartamento,
            'status' => 1
        ]);         

        return ["status" => "success"];

    }

    /**
     * Display the specified resource.
     *
     * @param  string  $cpf
     * @return \Illuminate\Http\Response
     */
    public function buscaCpf($cpf)
    {
        return Delivery::where(['cpf' => $cpf])->first();         
    } 

    /**
     * 
     */
    public function registrarEntrada(Request $request) 
    {
        date_default_timezone_set('America/Sao_Paulo');

        Record::create([
            'deliveryman_id' => $request->deliveryman,
            'empresa' => $request->empresa,
            'bloco' => $request->bloco,
            'apartamento' => $request->apartamento,
            'status' => 1
        ]); 

        return ["status" => "success"];
    }

    /**
     * 
     */
    public function registrarSaida(Request $request) 
    {
        date_default_timezone_set('America/Sao_Paulo');
        
        DB::table('records')
            ->where('id', $request->deliveryman)
            ->update(['status' => 0, 'saida' => date('Y-m-d H:i:s')]);

        return ["status" => "success"];
    }
}
