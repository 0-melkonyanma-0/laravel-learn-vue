<?php

declare(strict_types=1);

namespace App\Services\Event;

use App\Models\Event\Event;
use Illuminate\Support\Collection;

class EventService
{
    public function getAll(): Collection
    {
        if (auth()->user()->hasRole('admin')) {
            return Event::where(function ($query) {
                $query->where('start', '<=', request()->end)
                    ->where('end', '>=', request()->start);
            })->orWhere(function ($query) {
                $query->where('end', '<=', request()->start)
                    ->where('start', '>=', request()->end);
            })->get();
        }

        return Event::where(function ($query) {
            $query->where('user_id', '=', auth()->user()->id)
                ->orWhere('author_id', '=', auth()->user()->id);
        })->where(function ($query) {
            $query->where(function ($query) {
                $query->where('start', '<=', request()->start)
                    ->where('end', '>=', request()->end);
            })->orWhere(function ($query) {
                $query->where('end', '<=', request()->start)
                    ->where('start', '>=', request()->end);
            });
        })->get();
    }

    public function show(int $id): Collection
    {
        return Event::whereId($id)->get();
    }

    public function save(array $data): void
    {
        Event::create([
            ...$data,
            "author_id" => auth()->user()->id,
        ]);
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

    public function update(array $data, int $id): void
    {
        Event::find($id)->update($data);
    }
}
