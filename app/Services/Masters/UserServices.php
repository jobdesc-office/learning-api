<?php

namespace App\Services\Masters;

use App\Models\Masters\User;

class UserServices extends User
{

    public function datatables()
    {
        return $this->newQuery()->select('userid', 'userfullname', 'useremail', 'userphone', 'isactive');
    }
}
