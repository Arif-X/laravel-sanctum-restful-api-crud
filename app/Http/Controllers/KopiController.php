<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kopi;
use Validator;

class KopiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Kopi::get();
        return response()->json([
            'data' => $data
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validateData = [
            'jenis_kopi' => 'required|string',
            'harga' => 'required|integer'
        ];

        $validation = Validator::make($request->all(), $validateData);

        if($validation->fails()){
            return response()->json([
                'error' => 'validation error'
            ], 401);
        } else {
            $data = Kopi::insert([
                'jenis_kopi' => $request->jenis_kopi,
                'harga' => $request->harga
            ]);

            if(!$data){
                return response()->json([
                    'error' => 'insert error'
                ], 401);
            } else {
                return response()->json([
                    'data' => $data,
                    'message' => 'data ditambahkan'
                ], 200);
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $check = Kopi::where('id', $id)->first();

        if(!$check){
            return response()->json([
                'error' => 'data not found'
            ], 404);
        } else {
            $data = Kopi::where('id', $id)->get();
            return response()->json([
                'data' => $data
            ], 200);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $check = Kopi::where('id', $id)->first();

        if(!$check){
            return response()->json([
                'error' => 'data not found'
            ], 404);
        } else {
            $validateData = [
                'jenis_kopi' => 'required|string',
                'harga' => 'required|integer'
            ];

            $validation = Validator::make($request->all(), $validateData);

            if($validation->fails()){
                return response()->json([
                    'data' => $data
                ], 401);
            } else {
                $data = Kopi::where('id', $id)->update([
                    'jenis_kopi' => $request->jenis_kopi,
                    'harga' => $request->harga
                ]);
                if(!$data){
                    return response()->json([
                        'data' => $data,
                        'message' => 'data gagal diupdate'
                    ], 401);
                } else {
                    return response()->json([
                        'data' => $data,
                        'message' => 'data diupdate'
                    ], 200);
                }
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $check = Kopi::where('id', $id)->first();
        if(!$check){
            return response()->json([
                'error' => 'data not found'
            ], 404);
        } else {

            $data = Kopi::where('id', $id)->delete();
            if(!$data){
                return response()->json([
                    'data' => $data
                ], 401);
            } else {
                return response()->json([
                    'data' => $data,
                    'message' => 'data dihapus'
                ], 200);
            }
        }
    }
}
