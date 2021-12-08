<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Validator;

use App\Models\Item;
use App\Models\PajakItem;

class ItemController extends Controller
{
    public function index()
    {
        $data = Item::select(['nama'])->get();
        return response()->json([
            'data' => $data,
        ]);
    }

    public function show($id)
    {
        $data = Item::where('id', $id)->select(['nama'])->first();
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
                $data = Item::create([
                    'nama' => $request->nama,
                ]);

                foreach ($request->id_pajak as $pajak) {
                    $newArr[] = [
                        'id_pajak' => $pajak,
                        'id_item' => $data->id,
                    ];
                }

                $pajakItem = PajakItem::insert($newArr);

                if ($data && $pajakItem) {
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
                $data = Item::where('id', $id)->update([
                    'nama' => $request->nama,
                ]);
                $dataUpdated = Item::where('id', $id)->select(['id', 'nama',])->first();

                $delPajakItem = PajakItem::where('id_item', $id)->delete();

                foreach ($request->id_pajak as $pajak) {
                    $newArr[] = [
                        'id_pajak' => $pajak,
                        'id_item' => $id,
                    ];
                }

                $pajakItem = PajakItem::insert($newArr);

                if ($data && $pajakItem) {
                    return response()->json([
                        'result' => 'success',
                        'msg' => 'Success Add Data',
                        'data' => $dataUpdated,
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
        } else {
            return response()->json([
                'result' => 'error',
                'msg' => 'minimum input 2 items',
            ], 501);
        }
    }

    public function delete($id)
    {
        $dataItem = Item::where('id', $id)->first();
        $dataPajakItem = PajakItem::where('id_item', $id)->first();

        try {
            if ($dataItem != NULL && ($dataPajakItem != NULL || $dataPajakItem != NULL)) {
                if ($dataItem->delete()) {
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
