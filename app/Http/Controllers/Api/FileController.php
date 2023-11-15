<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\FileResource;
use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class FileController extends Controller
{
    public function upload(Request $request)
    {
        $file = $request->file('file');
        $folderName = $request->input('folderName');

        $path = $file->store($folderName,'public');

        $image = new File();
        $image->key = Str::uuid();;
        $image->name = $file->getClientOriginalName();
        $image->type = "Customer";
        $image->way = 'storage/'.$path;
        $image->save();

        return [
           'status' => "success",
           'message' => "Dosya Yüklendi",
           'image' => FileResource::make($image),
        ];
    }


    public function get(Request $request)
    {
        $image = File::where('key', $request->input('key'))->first();
        return response()->json([
            'image' => FileResource::make($image),
        ]);
    }
}
