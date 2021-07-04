<?php

namespace App\Observers;

use App\Models\Section;
use App\Notifications\SectionNotification;
use App\Service\FileService;
use Illuminate\Support\Facades\Notification;

class SectionObserver
{
    private FileService $fileService;

    public function __construct(FileService $fileService)
    {
        $this->fileService = $fileService;
    }

    /**
     * Handle the Section "created" event.
     *
     * @param  \App\Models\Section  $section
     * @return void
     */
    public function created(Section $section)
    {
        if ($section->published_at) {
            Notification::send(
                $section->group->students(),
                new SectionNotification((string) $section->group, $section->name)
            );
        }
    }

    /**
     * Handle the Section "updated" event.
     *
     * @param  \App\Models\Section  $section
     * @return void
     */
    public function updated(Section $section)
    {
        if ($section->published_at) {
            Notification::send(
                $section->group->students(),
                new SectionNotification((string) $section->group, $section->name)
            );
        }
    }

    /**
     * Handle the Section "deleted" event.
     *
     * @param  \App\Models\Section  $section
     * @return void
     */
    public function deleted(Section $section)
    {
        $sectionFiles = $section->files;

        foreach ($sectionFiles as $sectionFile) {
            try {
                $this->fileService->handleFileDeletion($sectionFile);
            } catch (\Exception $e) {
                report($e->getMessage());
            }
        }
    }

    /**
     * Handle the Section "restored" event.
     *
     * @param  \App\Models\Section  $section
     * @return void
     */
    public function restored(Section $section)
    {
        //
    }

    /**
     * Handle the Section "force deleted" event.
     *
     * @param  \App\Models\Section  $section
     * @return void
     */
    public function forceDeleted(Section $section)
    {
        //
    }
}
