<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\File;

class FileController extends Controller
{
    public function upload(Request $request)
    {
        if ($request->hasFile('file') && $request->file('file')->isValid()) {

            //is image?
            if (in_array($request->file->extension(), ['jpeg', 'jpg', 'tiff', 'png', 'bmp', 'gif'])) {
                $stored = $request->file->store('images', 'public');
            } else {
                $stored = $request->file->store('/', 'public');
            }

            $user = \Auth::user();

            $fileModel            = new File;
            $fileModel->extension = $request->file->extension();
            $fileModel->path      = $stored;

            $user->files()->save($fileModel);

            return $fileModel;
        }

        return response('Upload failed', 422);
    }
}
