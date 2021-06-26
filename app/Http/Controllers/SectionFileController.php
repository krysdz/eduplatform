<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\Group;
use App\Models\Section;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Builder;

class SectionFileController extends Controller
{
    public function show(Group $group, Section $section, $fileId, $fileName)
    {
        $file = File::findOrFail($fileId);

        return response()->download(storage_path('app/'.$file->path), $fileName, [
            'Content-Type' => $file->mime_type,
//            'Content-Disposition' => 'filename="'.$file->name.'"',
        ], 'inline');
    }

    public function destroy(Group $group, Section $section, $fileId)
    {
        $file = File::findOrFail($fileId);

        Storage::delete($file->path);
        $file->delete();
        flash('Usuwanie pliku zakończone powodzeniem')->error();

//        return redirect()->back();
    }
}
