<?php

namespace App\Http\Controllers\masters;

use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ExportData implements FromView, ShouldAutoSize
{
    use Exportable;

    protected $data;
    protected $startDate;
    protected $endDate;
    protected $atttypes;
    protected $holidays;

    public function __construct($data, $startDate, $endDate, $atttypes, $holidays)
    {
        $this->data = $data;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->atttypes = $atttypes;
        $this->holidays = json_decode($holidays);
    }

    public function view(): View
    {
        $startDate = Carbon::createFromFormat('Y-m-d', $this->startDate);
        $endDate = Carbon::createFromFormat('Y-m-d', $this->endDate);
        $daysInMonth = $endDate->diffInDays($startDate);

        // Generate month and year header
        $months = [];
        $currentDate = $startDate->copy()->startOfMonth();
        while ($currentDate->lt($endDate)) {
            $month = $currentDate->format('F');

            if ($currentDate->isSameMonth($startDate) && $currentDate->isSameMonth($endDate)) {
                $daysDiff = $endDate->diffInDays($startDate);
            } elseif ($currentDate->isSameMonth($startDate)) {
                $daysDiff = $currentDate->copy()->endOfMonth()->diffInDays($startDate) + 1;
            } elseif ($currentDate->isSameMonth($endDate)) {
                $daysDiff = $endDate->diffInDays($currentDate) + 1;
            } else {
                $daysDiff = $currentDate->copy()->endOfMonth()->diffInDays($currentDate);
            }

            $months[$month . ' ' . $currentDate->year] = $daysDiff;
            $currentDate->addMonth()->startOfMonth();
        }

        return view('excel', [
            'data' => $this->data,
            'startdate' => $this->startDate,
            'enddate' => $this->endDate,
            'holidays' => $this->holidays,
            'atttypes' => $this->atttypes,
            'daysInMonth' => $daysInMonth,
            'months' => $months,
        ]);
    }
}
