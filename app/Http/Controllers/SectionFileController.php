<?php

namespace App\Http\Controllers;

use App\Models\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Builder;

class SectionFileController extends Controller
{
    public function show($sectionId, $fileId, $fileName)
    {
        $file = File::findOrFail($fileId);

        return response()->download(storage_path('app/'.$file->path), $fileName, [
            'Content-Type' => $file->mime_type,
//            'Content-Disposition' => 'filename="'.$file->name.'"',
        ], 'inline');
    }

    public function destroy($sectionId, $fileId)
    {
        $file = File::findOrFail($fileId);

        Storage::delete($file->path);
        $file->delete();
        flash('Usuwanie pliku zakończone powodzeniem')->error();

        return redirect()->back();
    }
}
