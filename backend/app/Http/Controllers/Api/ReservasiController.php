<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Validator;
use App\Models\Reservasi;

class ReservasiController extends Controller
{
    public function index()
    {
        $reservasis = Reservasi::all();

        if(count($reservasis)>0)
        {
            return response([
                'message' => 'Retrieve All Success',
                'data' => $reservasis
            ],200);
        }

        return response([
            'message' => 'Empty',
            'data' => null
        ],400);
    }

    public function show($id)
    {
        $reservasi = Reservasi::find($id);

        if(!is_null($reservasi))
        {
            return response([
                'message' => 'Retrieve Reservasi Success',
                'data' => $reservasi
            ],200);
        }

        return response([
            'message' => 'Reservasi Not Found',
            'data' => null
        ],404);
    }

    public function store(Request $request)
    {
        $storeData = $request->all();
        $validate = Validator::make($storeData,[
            'nama_kamar' => 'required',
            'tanggal_reservasi' => 'required',
            'jam_reservasi' => 'required'
        ]);

        if($validate->fails())
            return response(['message' => $validate->errors()],400);

        $reservasi = Reservasi::create($storeData);    
        return response([
            'message' => 'Add Reservasi Success',
            'data' => $reservasi
        ],200);
    }

    public function destroy($id)
    {
        $reservasi = Reservasi::find($id);

        if(is_null($reservasi))
        {
            return response([
                'message' => 'Reservasi Not Found',
                'data' => null
            ],404);
        }

        if($reservasi->delete())
        {
            return response([
                'message' => 'Delete Reservasi Success',
                'data' => $reservasi
            ],200);
        }

        return response([
            'message' => 'Delete Reservasi Failed',
            'data' => null
        ],400);
    }

    public function update(Request $request,$id)
    {
        $reservasi = Reservasi::find($id);
        if(is_null($reservasi))
        {
            return response([
                'message' => 'Reservasi Not Found',
                'data' => null
            ],404);
        }

        $updateData = $request->all();
        $validate = Validator::make($updateData,[
            'nama_kamar' => 'required',
            'tanggal_reservasi' => 'required',
            'jam_reservasi' => 'required'
        ]);

        if ($validate->fails())
            return response(['message' => $validate->errors()],400);

        $reservasi->nama_kamar = $updateData['nama_kamar'];
        $reservasi->tanggal_reservasi = $updateData['tanggal_reservasi'];
        $reservasi->jam_reservasi = $updateData['jam_reservasi'];
      

        if($reservasi->save())
        {
            return response([
                'message' => 'Update Reservasi Success',
                'data' => $reservasi
            ],200);
        }

        return response([
            'message' => 'Update Reservasi Failed',
            'data' => null
        ],400);
    }
}
