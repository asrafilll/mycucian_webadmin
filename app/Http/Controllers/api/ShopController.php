<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Shop;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    function readAll(){
        $shops = Shop::all();
        return response()->json([
            'success' => true,
            'message' => 'Shop berhasil ditampilkan',
            'data' => $shops
        ], 200);
    }

    function readRecommendationLimit(){
        $shops = Shop::orderBy('rate', 'desc')
                ->limit(5)
                ->get();

        if($shops->isEmpty()){
            return response()->json([
                'success' => false,
                'message' => 'Shop tidak ditemukan',
                'data' => ''
            ], 404);
        }
        
        return response()->json([
            'success' => true,
            'message' => 'Shop berhasil ditampilkan',
            'data' => $shops
        ], 200);
    }

    function searchByCity($name){
        $shops = Shop::where('city', 'like', '%'.$name.'%')
                ->orderBy('name')
                ->get();

        if($shops->isEmpty()){
            return response()->json([
                'success' => false,
                'message' => 'Shop tidak ditemukan',
                'data' => ''
            ], 404);
        }
        
        return response()->json([
            'success' => true,
            'message' => 'Shop berhasil ditampilkan',
            'data' => $shops
        ], 200);
    }
}
