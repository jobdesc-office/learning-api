<?php

namespace App\Http\Controllers\Masters;

use App\Http\Controllers\Controller;
use App\Services\Masters\ChatServices;
use Illuminate\Http\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Storage;
use TempFile;

class ChatController extends Controller
{

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

    public function usersUnreadMessages(Request $req, ChatServices $chatServices)
    {
        $request = collect($req->all())->filter();
        $result = $chatServices->getUsersUnreadMessages($request);
        return response()->json($result);
    }

    public function all(Request $req, ChatServices $chatservices)
    {
        $whereArr = collect($req->all())->filter();
        $businesspartners = $chatservices->getAll($whereArr);
        return response()->json($businesspartners);
    }

    public function store(Request $req, ChatServices $chatservices)
    {
        $insert = collect($req)->filter()
            ->except('updatedby');
        $insert->put('createdby', auth()->user()->userid);

        $chats = $chatservices->storeChat($insert);
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
}
