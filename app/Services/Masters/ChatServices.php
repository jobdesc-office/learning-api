<?php

namespace App\Services\Masters;

use App\Collections\Files\FileUploader;
use App\Models\Masters\Chat;
use Carbon\Carbon;
use DB;
use DBTypes;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use TempFile;

class ChatServices extends Chat
{
    public function getAll(Collection $whereArr)
    {
        $query = $this->getQuery();

        $chatwhere = $whereArr->only($this->fillable);
        if ($chatwhere->isNotEmpty()) {
            $query = $query->where($chatwhere->toArray());
        }

        return $query->get();
    }

    public function getConversation($id1, $id2)
    {
        $query = $this->getQuery();
        $query->orWhere(function ($query) use ($id1, $id2) {
            $query->where('chatreceiverid', $id1)->where('createdby', $id2);
        });
        $query->orWhere(function ($query) use ($id1, $id2) {
            $query->where('chatreceiverid', $id2)->where('createdby', $id1);
        });

        return $query->get();
    }

    public function readMessages($userid)
    {
        $query = $this->getQuery();
        $query->where('createdby', $userid)->where('chatreceiverid', auth()->user()->userid);
        return $query->update(['chatreadat' => Carbon::now()->format('Y-m-d H:i:s')]);
    }

    public function storeChat(Collection $data)
    {
        $chat = $this->fill($data->toArray());
        $result = $chat->save();
        if ($result) {
            if ($data->has('chatfile')) {
                $tempfile = new TempFile($data->get('chatfile'));
                $filename = Str::replace(['/', '\\'], '', Hash::make(Str::random()));
                $transType = find_type()->in([DBTypes::chatfile])->get(DBTypes::chatfile)->getId();

                $file = new FileUploader($tempfile->getUri(), $filename, 'files/', $transType, $chat->chatid);
                $result  = $result && $file->upload() != null;

                $tempfile->close();
            }
        }
        return $this->getConversation($chat->createdby, $chat->chatreceiverid);
    }

    public function getQuery()
    {
        return $this->newQuery()->with([
            'chatbp',
            'chatreceiver',
            'createdbyuser',
            'chatfile' => function ($query) {
                $query->addSelect(DB::raw("*,concat('" . url('storage') . "', '/', \"directories\", '',\"filename\") as url"))
                    ->whereHas('transtype', function ($query) {
                        $query->where('typecd', DBTypes::chatfile);
                    });
            }
        ])->orderBy('createddate');
    }
}
