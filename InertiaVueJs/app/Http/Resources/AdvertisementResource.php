<?php

namespace App\Http\Resources;

use App\Models\Advertisement;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AdvertisementResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        if ($request->user()->interactsWithApp()) {
            return [
                'id' => $this->id,
                'title' => $this->title,
                'description' => $this->description,
                'type' => $this->type,
                'start_date' => $this->start_date,
                'end_date' => $this->end_date,
                'content' => $this->content,
                'file_url' => $this->file_url,
            ];
        }

        return [
            ...parent::toArray($request),
            'type_label' => Advertisement::getLabelType($this->type),
        ];
    }
}
