<?php

namespace App\Services;

use DB;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;

class ReportService extends Service
{
    private $query;

    /**
     * Processes dates for filter and maked default dates
     * (7 days by default)
     *
     * @param string|null $start
     * @param string|null $end
     * @return array
     */
    public function getDatesForFilter(?string $start, ?string $end): array
    {
        $from = !empty($start) ? Carbon::parse($start) : Carbon::now()->subDays(7);
        $to = !empty($end) ? Carbon::parse($end) : Carbon::now();

        return [
            $from,
            $to
        ];
    }

    /**
     * Gets report filtered data
     *
     * @param array $params
     * @return paginated
     */
    public function getReportData(array $params)
    {
        $this->prepareQuery();
        $this->applyFilters($params['filters']);

        if (!empty($params['sort'])) {
            $this->applySort($params['sort']);
        }

        return $this->runQuery();
    }

    /**
     * Prepares a query before applying filters
     * 
     * @return void
     */
    private function prepareQuery()
    {
        $this->query = User::query()
            ->withCount('lineReads')
            ->withCount(['timeReads as minutes' => function($query) {
                $query->select(DB::raw('sum(amount)'));
            }])
            ->withCount(['transactions as reward' => function($query) {
                $query->select(DB::raw('sum(amount)'));
            }]);
    }

    /**
     * Gets results of report
     * 
     * @return paginated
     */
    private function runQuery()
    {
        return $this->query->paginate();
    }

    /**
     * High level sort applicator
     *
     * @param array $sort
     * @return void
     */
    private function applySort(array $sort)
    {
        $sort = reset($sort);
        if (empty($sort)) {
            return;
        }

        $params = explode('|', $sort);
        if (count($params) < 2) {
            return;
        }

        $this->query->orderBy($params[0], $params[1]);
    }

    /**
     * High level filters applicator
     *
     * @param string $filters
     * @return void
     */
    private function applyFilters(string $filters)
    {
        $filters = json_decode($filters, true);
        foreach ($filters as $key => $values) {
            $method = 'apply' . ucfirst($key) . 'Filters';

            $this->$method($values);
        }

    }

    /**
     * Applies filters of User entity
     *
     * @param array $filters
     * @return void
     */
    private function applyUserFilters(array $filters)
    {
        foreach ($filters as $field => $value) {
            if (empty($value)) continue;

            $method = 'applyUser'.ucfirst($field);
            if (method_exists($this, $method)) {
                $this->$method($value);
            } else {
                $this->query->where($field, $value);
            }
        }
    }

    /**
     * Applies filter of user age
     *
     * @param Number $age
     * @return void
     */
    private function applyUserAge($age)
    {
        $date = Carbon::now();
        $date->subYears($age);
        $year = $date->format('Y-m-d');

        $this->query->where('birth', '<', $date);
    }

    /**
     * Applies filter of user role
     *
     * @param string $name
     * @return void
     */
    private function applyUserRole(string $name)
    {
        $this->query->whereHas('role', function ($q) use ($name) {
            $q->where('name', $name);
        });
    }

    /**
     * Applies filters of LinesRead entity
     *
     * @param array $filters
     * @return void
     */
    private function applyLinesReadsFilters(array $filters)
    {
        $service = $this;
        $this->query->whereHas('lineReads', function ($q) use ($service, $filters) {
            
            $dates = $service->getDatesForFilter($filters['from'], $filters['to']);
            $q->whereBetween('created_at', $dates);
        });

        if (!empty($filters['more_than'])) {
            $this->query->has('lineReads', '>', $filters['more_than']);
        }
    }

    /**
     * Applies filters of LTimesRead entity
     *
     * @param array $filters
     * @return void
     */
    private function applyTimesReadsFilters(array $filters)
    {
        $service = $this;
        $this->query->whereHas('timeReads', function ($q) use ($service, $filters) {
            
            $dates = $service->getDatesForFilter($filters['from'], $filters['to']);
            $q->whereBetween('created_at', $dates);
           
            if (!empty($filters['more_than'])) {
                $q->havingRaw('SUM(amount) >= ?', [$filters['more_than']]);
            }
        });
    }

    /**
     * Applies filters of Transaction entity
     *
     * @param array $filters
     * @return void
     */
    private function applyTransactionsFilters(array $filters)
    {
        $service = $this;
        $this->query->whereHas('transactions', function ($q) use ($service, $filters) {
            $dates = $service->getDatesForFilter($filters['from'], $filters['to']);
            $q->whereBetween('created_at', $dates);

            if (!empty($filters['more_than'])) {
                $q->havingRaw('SUM(amount) >= ?', [$filters['more_than']]);
            }

            $type = strtolower($filters['type']);
            if ( $type != 'all') {
                $q->where('type', $type);
            }
        });
    }

}