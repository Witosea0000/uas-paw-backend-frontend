<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Validator;
use App\Models\Kamar;

class KamarController extends Controller
{
    public function index()
    {
        $kamars = Kamar::all();

        if(count($kamars)>0)
        {
            return response([
                'message' => 'Retrieve All Success',
                'data' => $kamars
            ],200);
        }

        return response([
            'message' => 'Empty',
            'data' => null
        ],400);
    }

    public function show($id)
    {
        $kamar = Kamar::find($id);

        if(!is_null($kamar))
        {
            return response([
                'message' => 'Retrieve Kamar Success',
                'data' => $kamar
            ],200);
        }

        return response([
            'message' => 'Kamar Not Found',
            'data' => null
        ],404);
    }

    public function store(Request $request)
    {
        $storeData = $request->all();
        $validate = Validator::make($storeData,[
            'kamar' => 'required',
            'jumlah' => 'required'
        ]);

        if($validate->fails())
            return response(['message' => $validate->errors()],400);

        $kamar = Kamar::create($storeData);    
        return response([
            'message' => 'Add Kamar Success',
            'data' => $kamar
        ],200);
    }

    public function destroy($id)
    {
        $kamar = Kamar::find($id);

        if(is_null($kamar))
        {
            return response([
                'message' => 'Kamar Not Found',
                'data' => null
            ],404);
        }

        if($kamar->delete())
        {
            return response([
                'message' => 'Delete Kamar Success',
                'data' => $kamar
            ],200);
        }

        return response([
            'message' => 'Delete Kamar Failed',
            'data' => null
        ],400);
    }

    public function update(Request $request,$id)
    {
        $kamar = Kamar::find($id);
        if(is_null($kamar))
        {
            return response([
                'message' => 'Kamar Not Found',
                'data' => null
            ],404);
        }

        $updateData = $request->all();
        $validate = Validator::make($updateData,[
            'kamar' => 'required',
            'jumlah' => 'required'
        ]);

        if ($validate->fails())
            return response(['message' => $validate->errors()],400);

        $kamar->kamar = $updateData['kamar'];
        $kamar->jumlah = $updateData['jumlah'];
      

        if($kamar->save())
        {
            return response([
                'message' => 'Update Kamar Success',
                'data' => $kamar
            ],200);
        }

        return response([
            'message' => 'Update Kamar Failed',
            'data' => null
        ],400);
    }
}
