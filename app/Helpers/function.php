<?php

use App\Actions\FindTypeAction;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

function find_type($key = 'typecd', $keys = [], $items = [])
{
    return (new FindTypeAction());
}

function uploadFile($input_name, $file_name = null)
{
    $path = $_FILES[$input_name]['tmp_name'];
    $original_name = $_FILES[$input_name]['name'];
    $mime_type = $_FILES[$input_name]['type'];
    $error = $_FILES[$input_name]['error'];

    $image = new UploadedFile($path, $original_name, $mime_type, $error);

    if ($file_name == null) {
        $file_name = Str::random(20) . '.' . $image->getClientOriginalExtension();
    }
    $image->storeAs('public/images', $file_name);

    return url('/storage/images/' . $file_name);
}
