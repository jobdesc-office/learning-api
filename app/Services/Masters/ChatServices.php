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

    public function getQuery()
    {
        return $this->newQuery()->with([
            'chatbp',
            'chatreceiver',
            'createdbyuser'
        ]);
    }
}
