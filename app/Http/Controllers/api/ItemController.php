<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Validator;

use App\Models\Item;

class ItemController extends Controller
{
    public function index()
    {
        $data = Item::get();
        return response()->json([
            'data' => $data,
        ]);
    }

    public function show($id)
    {
        $data = Item::find($id);
        return response()->json([
            'data' => $data,
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|max:255',
        ]);

        if ((is_array($request->id_pajak) || is_object($request->id_pajak)) && (is_countable($request->id_pajak) && count($request->id_pajak) > 1)) {
            try {
                foreach ($request->id_pajak as $val) {
                    $pajak[] = $val;
                }

                $data = Item::create([
                    'nama' => $request->nama,
                ]);

                $newData = Item::find($data->id);
                $newData->pajaks()->attach($pajak);

                return response()->json([
                    'result' => 'success',
                    'msg' => 'Success Add Data',
                    'data' => $newData,
                ], 201);
            } catch (QueryException $ex) {
                return response()->json([
                    'result' => 'error',
                    'msg' => $ex,
                ], 500);
            }
        } else {
            return response()->json([
                'result' => 'error',
                'msg' => 'minimum input 2 items',
            ], 501);
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|max:255',
        ]);

        if ((is_array($request->id_pajak) || is_object($request->id_pajak)) && (is_countable($request->id_pajak) && count($request->id_pajak) > 1)) {
            try {
                foreach ($request->id_pajak as $val) {
                    $pajak[] = $val;
                }

                $data = Item::where('id', $id)->update([
                    'nama' => $request->nama,
                ]);

                $dataUpdated = Item::where('id', $id)->select(['id', 'nama',])->first();

                $newData = Item::find($id);
                $newData->pajaks()->sync($pajak);

                return response()->json([
                    'result' => 'success',
                    'msg' => 'Success Update Data',
                    'data' => $newData,
                ], 200);
            } catch (QueryException $ex) {
                return response()->json([
                    'result' => 'error',
                    'msg' => $ex,
                ], 500);
            }
        } else {
            return response()->json([
                'result' => 'error',
                'msg' => 'minimum input 2 items',
            ], 501);
        }
    }

    public function delete($id)
    {
        try {
            $data = Item::find($id);
            $data->delete($id);

            return response()->json([
                'result' => 'success',
                'msg' => 'Success Delete Data',
            ], 200);
        } catch (QueryException $ex) {
            return response()->json([
                'result' => 'error',
                'msg' => $ex,
            ], 500);
        }
    }
}
