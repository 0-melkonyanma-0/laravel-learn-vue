<?php

declare(strict_types=1);

namespace App\Services\User;

use App\Models\User\JobTitle;
use Illuminate\Support\Collection;

class JobTitleService
{
    public function getAll(): Collection
    {
        return JobTitle::all();
    }

    public function show(int $id): Collection
    {
        return JobTitle::whereId($id)->get();
    }

    public function update(array $data, int $id): void
    {
        JobTitle::find($id)->update($data);
    }

    public function save(array $data): void
    {
        JobTitle::create($data);
    }

    public function delete(int $id): void
    {
        JobTitle::find($id)->delete();
    }
}
