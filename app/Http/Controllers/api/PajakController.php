<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Validator;

use App\Models\Pajak;

class PajakController extends Controller
{
    public function index()
    {
        $data = Pajak::select(['id', 'nama', 'rate'])->get();
        return response()->json([
            'data' => $data,
        ]);
    }

    public function show($id)
    {
        $data = Pajak::where('id', $id)->select(['id', 'nama', 'rate'])->first();
        return response()->json([
            'data' => $data,
        ]);
    }

    public function store(Request $request)
    {
        $input = [
            'nama' => $request->nama,
            'rate' => $request->rate,
        ];

        $validator = Validator::make($input, [
            'nama' => 'required|max:255',
            'rate' => 'required|between:0,99.99'
        ]);

        try {
            $data = Pajak::create($input);

            if ($data) {
                return response()->json([
                    'result' => 'success',
                    'msg' => 'Success Add Data',
                    'data' => $data,
                ], 201);
            } else {
                return response()->json([
                    'result' => 'error',
                    'msg' => 'Something when wrong',
                ], 501);
            }
        } catch (QueryException $ex) {
            return response()->json([
                'result' => 'error',
                'msg' => $ex,
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $input = [
            'nama' => $request->nama,
            'rate' => $request->rate,
        ];

        $validator = Validator::make($input, [
            'nama' => 'required|max:255',
            'rate' => 'required|between:0,99.99'
        ]);

        try {
            $data = Pajak::where('id', $id)->update($input);
            $dataUpdated = Pajak::where('id', $id)->select(['id', 'nama', 'rate'])->first();

            if ($data) {
                return response()->json([
                    'result' => 'success',
                    'msg' => 'Success Update Data',
                    'data' => $dataUpdated,
                ], 200);
            } else {
                return response()->json([
                    'result' => 'error',
                    'msg' => 'Something when wrong',
                ], 501);
            }
        } catch (QueryException $ex) {
            return response()->json([
                'result' => 'error',
                'msg' => $ex,
            ], 500);
        }
    }

    public function delete($id)
    {
        $data = Pajak::where('id', $id)->first();

        try {
            if ($data->delete()) {
                return response()->json([
                    'result' => 'success',
                    'msg' => 'Success Delete Data',
                ], 200);
            } else {
                return response()->json([
                    'result' => 'error',
                    'msg' => 'Something when wrong',
                ], 501);
            }
        } catch (QueryException $ex) {
            return response()->json([
                'result' => 'error',
                'msg' => $ex,
            ], 500);
        }
    }
}
