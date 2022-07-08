<?php

namespace App\Http\Controllers\api\masters;

use App\Http\Controllers\Controller;
use App\Services\Masters\FilesServices;
use Illuminate\Http\Request;

class FilesController extends Controller
{

    public function all(Request $req, FilesServices $filesService)
    {
        $whereArr = collect($req->all())->filter();
        $files = $filesService->getAll($whereArr);
        return response()->json($files);
    }

    public function store(Request $req, FilesServices $fileServices)
    {
        $insert = collect($req->only($fileServices->getFillable()))->filter()
            ->except('updatedby');

        $fileServices->create($insert->toArray());

        return response()->json(['message' => \TextMessages::successCreate]);
    }

    public function show($id, FilesServices $businessPartnerService)
    {
        $row = $businessPartnerService->find($id);
        return response()->json($row);
    }

    public function update($id, Request $req, FilesServices $fileServices)
    {
        $row = $fileServices->findOrFail($id);

        $update = collect($req->only($fileServices->getFillable()))->filter()
            ->except('createdby');
        $row->update($update->toArray());

        return response()->json(['message' => \TextMessages::successEdit]);
    }

    public function destroy($id, FilesServices $fileServices)
    {
        $fileServices->find($id)->delete();
        return response()->json(['message' => \TextMessages::successDelete]);
    }
}
