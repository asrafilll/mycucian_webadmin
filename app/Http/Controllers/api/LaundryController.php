<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Laundry;
use Illuminate\Http\Request;

class LaundryController extends Controller
{
   function readAll(){
        $laundries = Laundry::with('shop','user')->get();
        return response()->json([
            'success' => true,
            'message' => 'Laundry berhasil ditampilkan',
            'data' => $laundries
        ], 200);
   }

   function getLaundryByUser($id){
        $laundries = Laundry::with('shop','user')->where('user_id', $id)->get();
        return response()->json([
            'success' => true,
            'message' => 'Laundry berhasil ditampilkan',
            'data' => $laundries
        ], 200);
   }

   function claimLaundry(Request $request){
        $laundry = Laundry::where(
            ['id', $request->id],
            ['claim_code', $request->claim_code]
            )->first();

        if(!$laundry){
            return response()->json([
                'success' => false,
                'message' => 'Laundry tidak ditemukan',
                'data' => ''
            ], 404);
        }

        if($laundry->user_id !=0){
            return response()->json([
                'success' => false,
                'message' => 'Laundry sudah diambil',
                'data' => ''
            ], 404);
        }

        $laundry->user_id = $request->user_id;
        $laundry->save();
        return response()->json([
            'success' => true,
            'message' => 'Laundry berhasil diambil',
            'data' => $laundry
        ], 200);
   }
}
