<?php

declare(strict_types=1);

namespace App\Services\Event;

use App\Models\Event\Event;
use Illuminate\Support\Collection;

class EventService
{
    public function getAll(): Collection
    {
        return Event::with(['user'])->get();
    }

    public function show(int $id): Collection
    {
        return Event::whereId($id)->get();
    }

    public function update(array $data, int $id): void
    {
        Event::find($id)->update($data);
    }

    public function save(array $data): void
    {
        Event::create($data);
    }

    public function delete(int $id): void
    {
        Event::find($id)->delete();
    }

    public function updateStatus(int $id)
    {
        Event::find($id)->update([
            'status' => true
        ]);
    }
}
