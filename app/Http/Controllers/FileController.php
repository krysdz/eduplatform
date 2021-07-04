<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Service\FileService;
use Illuminate\Http\RedirectResponse;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class FileController extends Controller
{
    private FileService $fileService;

    public function __construct(FileService $fileService)
    {
        $this->fileService = $fileService;
    }

    public function show(File $file, $fileName): BinaryFileResponse
    {
        return response()->download(storage_path('app' . $file->path . $file->filename), $fileName, [
            'Content-Type' => $file->mimetype,
        ], 'inline');
    }

    public function destroy(File $file): RedirectResponse
    {
        try {
            $this->fileService->handleFileDeletion($file);
        } catch (\Exception $e) {
            report('Wystąpił błąd podczas usuwania danych o pliku.');

            return redirect()->back()
                ->with('error', $e->getMessage());
        }

        return redirect()->back()
            ->with('success', 'Plik został usunięty.');
    }
}
