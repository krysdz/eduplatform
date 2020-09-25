<?php

namespace App\Http\Controllers;

use App\Models\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Builder;

class SectionFileController extends Controller
{
    public function show($sectionId, $fileName)
    {
        $file = File::whereHas('sectionFiles', function (Builder $q) use ($sectionId) {
            $q->where(['section_id' => $sectionId]);
        })->where(['name' => $fileName])->first();

        return Storage::download($file->path, null, [
            'Content-Type' => 'application/octet-stream',
        ]);
    }

    public function destroy($sectionId, $fileName)
    {
        $file = File::whereHas('sectionFiles', function (Builder $q) use ($sectionId) {
            $q->where(['section_id' => $sectionId]);
        })->where(['name' => $fileName])->first();

        Storage::delete($file->path);
        $file->delete();
        flash('Usuwanie pliku zakończone powodzeniem')->error();

        return redirect()->back();
    }
}
