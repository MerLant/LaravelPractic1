<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WarehouseController;

Route::get('/', function () {
    return redirect()->route('warehouses.index');
});

Route::resource('warehouses', WarehouseController::class);
