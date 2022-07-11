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

    public function store(Request $req, ChatServices $chatservices)
    {
        var_dump($req->hasFile('chatfile'));
        return;
        $insert = collect($req)->filter()
            ->except('updatedby');
        $insert->put('createdby', auth()->user()->userid);

        $chatservices->fill($insert->toArray())->save();
        $chats = $chatservices->getConversation($chatservices->createdby, $chatservices->chatreceiverid);
        return response()->json($chats);
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

    public function getConversation(Request $req, ChatServices $chatservices)
    {
        $whereArr = collect($req->all())->filter();
        $chats = $chatservices->getConversation($whereArr->get('user1'), $whereArr->get('user2'));
        return response()->json($chats);
    }

    public function readMessage(Request $req, ChatServices $chatServices)
    {
        $request = collect($req->all())->filter();
        $chatServices->readMessages($request->get('userid'));
        $chats = $chatServices->getConversation(auth()->user()->userid, $request->get('userid'));
        return response()->json($chats);
    }
}
