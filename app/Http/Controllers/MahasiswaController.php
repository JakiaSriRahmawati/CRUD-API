<?php

namespace App\Http\Controllers;

use App\Models\mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use PhpParser\Node\Stmt\TryCatch;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class MahasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()     
    {
        $data = mahasiswa::all();
        return response()->json([ 
            'status'=>true,
            'message'=>'data tersedia',
            'data'=>$data,
        ],200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validate=Validator::make($request->all(),[
            'username' => 'required',
            'address' => 'required',
            'email' => 'required',
            'password' => 'required',
        ]);
        if($validate->fails()){
            return response()->json([ 
                'status'=>false,
                'message'=>'validasi eror',
                'eror'=>$validate->errors(),
            ],400);
        }
        $mahasiswa = mahasiswa::create($request->all());
        return response()->json([ 
            'status'=>true,
            'message'=>'data tersedia',
            'data'=>$mahasiswa,
        ],200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\mahasiswa  $mahasiswa
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try{
            $mahasiswa = mahasiswa::findOrFail($id);
            return response()->json([
                'status' => true,
                'message' => 'User found',
                'data' => $mahasiswa
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => false,
                'message' => 'User not found',
            ], 404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\mahasiswa  $mahasiswa
     * @return \Illuminate\Http\Response
     */
    public function edit(mahasiswa $mahasiswa)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\mahasiswa  $mahasiswa
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validate = Validator::make($request->all(), [
            // 'name' => 'required|string|max:255',    
            // 'address' => 'required|string|max:255',
            'email' => 'sometimes|unique:mahasiswa|max:255',
            // 'password' => 'required|max:255',
        ]);
        if($validate->fails()){
            return response()->json([ 
                'status'=>false,
                'message'=>'validasi eror',
                'eror'=>$validate->errors(),
            ],400);
        }
        try {
            $mahasiswa = mahasiswa::findOrFail($id);
            $mahasiswa->update($request->all());
            return response()->json([
                'status' => true,
                'message' => 'Updated successfully',
                'data' => $mahasiswa
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => false,
                'message' => 'User not found',
            ], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\mahasiswa  $mahasiswa
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $mahasiswa = mahasiswa::findOrFail($id);
            $mahasiswa->delete();
            return response()->json([
                'status' => true,
                'message' => 'Delete successfully'
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status' => false,
                'message' => 'User not found',
            ], 404);
        }
    }
}
