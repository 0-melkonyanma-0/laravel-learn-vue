<?php

declare(strict_types=1);

namespace App\Services\Event;

use App\Models\Event\Event;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class StatisticService
{
    public function getStatistics(): Collection
    {
        if (request()->start === null && request()->end) {
            throw new Exception('null');
        }

        try {
            Carbon::setlocale(config('app.locale'));

            $statistics = Event::select()->where(function ($query) {
                $query->where('updated_at', '<=', request()->end)
                    ->where('updated_at', '>=', request()->start);
            })
                ->where('status', '=', '1');

            if (!Carbon::parse(request()->start)->diffInMonths(Carbon::parse(request()->end))) {
                return $this->selectFormatedStatistics($statistics);
            }

            return $this->selectFormatedStatistics($statistics, '%b. %Y', 'months');
        } catch (\Exception $e) {
            return collect([
                'error' => 'require start & end params'
            ]);
        }
    }

    protected function selectFormatedStatistics(
        Builder $builder,
        string  $select_date_format = '%d %b. %Y',
        string  $result_format = 'month'
    ): Collection
    {
        $statistic = collect([]);

        $builder->select(
            DB::raw(sprintf('DATE_FORMAT(events.updated_at, "%s") as date', $select_date_format)),
            DB::raw('COUNT(updated_at) as n')
        )
            ->groupByRaw('date, events.updated_at')
            ->orderByRaw('events.updated_at')
            ->get()->groupBy('date')->each(function ($item, $key) use (&$statistic, $result_format) {
                $data = explode(' ', $key);

                if ($result_format === 'month') {
                    $key = sprintf("%s %s %s", $data[0], __($data[1]), $data[2]);
                } else {
                    $key = sprintf("%s %s", __($data[0]), $data[1]);
                }

                $statistic->add([$key => collect($item)->pluck('n')->sum()]);
            });

        return $statistic;
    }
}
