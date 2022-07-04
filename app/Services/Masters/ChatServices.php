<?php

namespace App\Services\Masters;

use App\Models\Masters\Chat;
use Illuminate\Support\Collection;

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

    public function getQuery()
    {
        return $this->newQuery()->with([
            'chatbp',
            'chatreceiver',
            'createdbyuser'
        ]);
    }
}
