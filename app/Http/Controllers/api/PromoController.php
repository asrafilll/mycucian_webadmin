<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Promo;
use Illuminate\Http\Request;

class PromoController extends Controller
{
    function readAll() {
        $promos = Promo::with('shop')->get();
        return response()->json([
            'success' => true,
            'message' => 'Promo berhasil ditampilkan',
            'data' => $promos
        ], 200);
    }

    function readLimit(){
        $promos = Promo::orderBy('created_at', 'desc')
                ->limit(5)
                ->with('shop')
                ->get();

        if($promos->isEmpty()){
            return response()->json([
                'success' => false,
                'message' => 'Promo tidak ditemukan',
                'data' => ''
            ], 404);
        }
        
        return response()->json([
            'success' => true,
            'message' => 'Promo berhasil ditampilkan',
            'data' => $promos
        ], 200);
    }
}
