<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\DeliveryController;

Route::view('/', "index");
Route::get("busca-cpf/{cpf}", [DeliveryController::class, 'buscaCpf']);
Route::get("list-checkin", [DeliveryController::class, 'listCheckin']);
Route::post("registrar", [DeliveryController::class, 'registrarEntrada']);
Route::post("remover", [DeliveryController::class, 'registrarSaida']);
Route::resource("deliveryman", DeliveryController::class);