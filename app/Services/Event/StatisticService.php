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
    protected function selectFormatedStatistics(
        Builder $builder,
        string  $select_date_format = '%d %b.',
        string  $result_format = 'month'
    ): Collection
    {
        return $builder->select(
            DB::raw(sprintf('DATE_FORMAT(events.updated_at, "%s") as date', $select_date_format)),
            DB::raw('COUNT(updated_at) as n')
        )
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->mapToGroups(function ($data) use ($result_format) {

                $date = explode(' ', $data['date']);

                if ($result_format === 'month') {
                    return [mb_convert_case(sprintf('%s %s', $date[0], __($date[1])), MB_CASE_TITLE) => $data['n']];
                }

                return [mb_convert_case(sprintf('%s', __($date[0])), MB_CASE_TITLE) => $data['n']];
            });
    }

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

            return $this->selectFormatedStatistics($statistics, '%b.', 'months');
        } catch (\Exception $e) {
            return collect([
                'error' => 'require start & end params'
            ]);
        }
    }

}
