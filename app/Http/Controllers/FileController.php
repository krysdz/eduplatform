<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\Group;
use App\Models\Message;
use App\Models\Section;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Builder;

class FileController extends Controller
{
    public function show(File $file, $fileName)
    {
        switch (get_class(($file->fileable))) {
            case Message::class:
                $threadUsers = $file->fileable->thread->threadUsers;

                if (!$threadUsers->contains(auth()->user())) {
                    abort(403);
                }
                break;
            case Section::class:
                $group = $file->fileable->group;
                $isUnpublished = is_null($file->fileable->published_at);

                if ($isUnpublished) {
                    $isAuthorized = $group->teachers()->contains(auth()->user());
                } else {
                    $isAuthorized = $group->groupMembers->contains(auth()->user());
                }

                if (!$isAuthorized) {
                    abort(403);
                }
                break;
            default:
                abort(404);
        }

        return response()->download(storage_path('app/'.$file->path), $fileName, [
            'Content-Type' => $file->mime_type,
        ], 'inline');
    }

    public function destroy(File $file)
    {
        Storage::delete($file->path);
        $file->delete();

        return redirect()->back()->with('success', "Usuwanie pliku powiodło się");
    }
}
