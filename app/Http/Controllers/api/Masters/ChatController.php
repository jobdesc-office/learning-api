<?php

namespace App\Http\Controllers\api\masters;

use App\Http\Controllers\Controller;
use App\Services\Masters\ChatServices;
use App\Services\Masters\SubdistrictServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChatController extends Controller
{

    public function all(Request $req, ChatServices $chatservices)
    {
        $whereArr = collect($req->all())->filter();
        $businesspartners = $chatservices->getAll($whereArr);
        return response()->json($businesspartners);
    }

    public function store(Request $req, ChatServices $modelChatServices)
    {
        $insert = collect($req)->filter()
            ->except('updatedby');
        $insert->put('createdby', auth()->user()->userid);

        $modelChatServices->fill($insert->toArray())->save();

        return response()->json(['message' => \TextMessages::successCreate]);
    }

    public function show($id, ChatServices $chatServices)
    {
        $row = $chatServices->find($id);
        return response()->json($row);
    }

    public function update($id, Request $req, ChatServices $modelChatServices)
    {
        $row = $modelChatServices->findOrFail($id);

        $update = collect($req)->filter()
            ->except('createdby');

        $row->fill($update->toArray())->save();

        return response()->json(['message' => \TextMessages::successEdit]);
    }

    public function destroy($id, ChatServices $modelChatServices)
    {
        DB::beginTransaction();
        try {
            $modelChatServices->findOrFail($id)->delete();
            DB::commit();
            return response()->json(['message' => \TextMessages::successDelete]);
        } catch (\Throwable $th) {
            DB::rollBack();
        }
    }
}
