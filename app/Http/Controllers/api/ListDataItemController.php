<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ListDataItemController extends Controller
{
    public function listDataItem()
    {
        $data = DB::table("item")
            ->select(DB::raw("JSON_OBJECT('id', item.id,'nama', item.nama, 'pajak',(SELECT CAST(CONCAT('[',
                            GROUP_CONCAT(
                            JSON_OBJECT('id', pajak.id , 'name', pajak.nama, 'rate', CONCAT(TRIM(pajak.rate)+0,'%'))),
                            ']') AS JSON)
                            FROM pajak, pajak_item
                            WHERE pajak.id = pajak_item.pajak_id AND item.id = pajak_item.item_id 
                            ))AS json_data"))
            ->get();
        $arr = [];
        foreach ($data as $key => $val) {
            $jsonData = json_decode($val->json_data, true);
            $arr[$key] = $jsonData;
        }
        return response()->json([
            'data' => $arr,
        ]);
    }
}
