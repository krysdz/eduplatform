<?php

namespace App\Service;

use App\Models\File;
use App\Models\Message;
use App\Models\Section;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class FileService
{
    private ?string $path = null;
    private ?string $filename = null;

    /**
     * @throws Exception
     */
    public function handleRequestSectionFiles(Request $request, Section $section): void
    {
        if (!$request->hasFile('files')) {
            return;
        }

        $uploadedFiles = $this->getValidatedRequestFiles($request);

        foreach ($uploadedFiles as $uploadedFile) {
            $this->path = '/files/section_' . $section->id . '/';
            $this->filename = $uploadedFile->getClientOriginalName();

            $this->storeUploadedFile($uploadedFile);

            $section->files()->save(
                $this->makeFileModel($uploadedFile),
            );
        }
    }

    /**
     * @throws Exception
     */
    public function handleRequestMessageFiles(Request $request, Message $message): void
    {
        if (!$request->hasFile('files')) {
            return;
        }

        $uploadedFiles = $this->getValidatedRequestFiles($request);

        foreach ($uploadedFiles as $uploadedFile) {
            $this->path = '/files/message_' . $message->id . '/';
            $this->filename = $uploadedFile->getClientOriginalName();

            $this->storeUploadedFile($uploadedFile);

            $message->files()->save(
                $this->makeFileModel($uploadedFile),
            );
        }
    }

    /**
     * @throws Exception
     */
    public function handleFileDeletion(File $file): void
    {
        if (!Storage::delete($file->path . $file->filename)) {
            throw new Exception('Wystąpił błąd podczas usuwania pliku.');
        }

        if (empty(Storage::files($file->path))) {
            Storage::deleteDirectory($file->path);
        }

        if (!$file->delete()) {
            throw new Exception('Wystąpił błąd podczas usuwania danych o pliku.');
        }
    }

    /**
     * @return UploadedFile[]
     */
    protected function getValidatedRequestFiles(Request $request): array
    {
        $validatedFiles = $request->validate([
            'files.*' => 'nullable|file|mimes:jpeg,png,gif,webp,doc,docx,pdf,txt,odt,pptx,ppt,odp|max:5120'
        ]);

        return $validatedFiles['files'];
    }

    /**
     * @throws Exception
     */
    protected function storeUploadedFile(UploadedFile $uploadedFile): bool
    {
        if (Storage::exists($this->path . $this->filename)) {
            throw new Exception('Plik o podanej nazwie już istnieje.');
        }

        if (!$uploadedFile->storeAs($this->path, $this->filename)) {
            throw new Exception('Wystąpił błąd podczas zapisywania pliku.');
        }

        return true;
    }

    protected function makeFileModel(UploadedFile $uploadedFile): File
    {
        $file = new File();

        return $file->fill([
            'filename' => $this->filename,
            'extension' => $uploadedFile->getClientOriginalExtension(),
            'path' => $this->path,
            'mimetype' => $uploadedFile->getClientMimeType(),
            'size' => $uploadedFile->getSize(),
            'user_id' => request()->user()->id,
            'title' => $this->filename,
        ]);
    }
}
