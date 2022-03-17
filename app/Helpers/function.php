<?php

use App\Actions\FindTypeAction;

function find_type($key = 'typecd', $keys = [], $items = []) {
    return (new FindTypeAction());
}
