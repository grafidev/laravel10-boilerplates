<?php

namespace App\Models\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

trait InteractsWithFile
{
    public function getFileUrlAttribute(): ?string
    {
        if ($this->file === null) {
            return null;
        }

        if (Storage::disk($this->diskName())->exists($this->file)) {
            return Storage::disk($this->diskName())->url($this->file);
        }

        return null;
    }

    public function getFilePathAttribute(): ?string
    {
        if ($this->file === null) {
            return null;
        }

        if (Storage::disk($this->diskName())->exists($this->file)) {
            return Storage::disk($this->diskName())->path($this->file);
        }

        return null;
    }

    public function getExtensionAttribute(): ?string
    {
        if ($this->name !== null) {
            return strtoupper(pathinfo($this->name, PATHINFO_EXTENSION));
        }

        return null;
    }

    public function getSizeAttribute(): ?string
    {
        return humanFilesize($this->attributes['size'] ?? 0);
    }

    protected function getArrayableAppends()
    {
        $this->appends = array_unique(array_merge($this->appends, ['file_path', 'file_url', 'size', 'extension']));

        return parent::getArrayableAppends();
    }

    public function saveFile(UploadedFile $file)
    {
        return $this->forceFill([
            'file' => $file->storePublicly('/', ['disk' => $this->diskName()]),
        ])->save();
    }
}
