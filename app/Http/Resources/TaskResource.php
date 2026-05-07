<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
{
    /**
     * US13 – Transform a Task for the API response.
     * Includes status_label accessor and deadline_status accessor.
     */
    public function toArray(Request $request): array
    {
        return [
            'id'              => $this->id,
            'title'           => $this->title,
            'description'     => $this->description,
            'status'          => $this->status,
            'status_label'    => $this->status_label,      // accessor
            'priority'        => $this->priority,
            'deadline'        => $this->deadline?->toDateString(),
            'deadline_status' => $this->deadline_status,   // accessor
            'assigned_to'     => $this->user ? [
                'id'   => $this->user->id,
                'name' => $this->user->name,
            ] : null,
            'project'         => [
                'id'    => $this->project->id,
                'title' => $this->project->title,
            ],
            'created_at'      => $this->created_at->toDateTimeString(),
        ];
    }
}
