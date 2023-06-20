<?php

namespace App\Http\Controllers\masters;

use Carbon\Carbon;
use DBTypes;
use Illuminate\Support\Collection;
use Log;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithMapping;

class ExportData implements FromView, ShouldAutoSize
{
    use Exportable;

    protected $data;
    protected $typecodes;
    protected $startDate;
    protected $endDate;
    protected $atttypes;
    protected $holidays;

    public function __construct($data, $startDate, $endDate, $typecodes, $atttypes, $holidays)
    {
        $this->data = $data;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->typecodes = $typecodes;
        $this->atttypes = $atttypes;
        $this->holidays = json_decode($holidays);
    }

    public function view(): View
    {
        $startDate = Carbon::createFromFormat('Y-m-d', $this->startDate);
        $endDate = Carbon::createFromFormat('Y-m-d', $this->endDate);
        $daysInMonth = $endDate->diffInDays($startDate);

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


    // public function collection()
    // {
    //     return new Collection($this->data);
    // }

    // public function headings(): array
    // {
    //     $headers = ['Name'];
    //     $startDate = Carbon::createFromFormat('Y-m-d', $this->startDate);
    //     $endDate = Carbon::createFromFormat('Y-m-d', $this->endDate);
    //     $daysInMonth = $endDate->diffInDays($startDate);

    //     $currentDate = clone $startDate;

    //     for ($i = 0; $i < $daysInMonth; $i++) {
    //         $headers[] = $currentDate->format('Y-m-d');
    //         $currentDate->modify('+1 day');
    //     }

    //     array_push($headers, "Summary");

    //     return $headers;
    // }


    // public function map($item): array
    // {
    //     $attendance = $item['attendance'];
    //     $user = $item['attuser'];

    //     $nameColumnIndex = array_search('Name', $this->headings());
    //     $row[$nameColumnIndex] = $user['userfullname'];

    //     $startDate = Carbon::createFromFormat('Y-m-d', $this->startDate);
    //     $endDate = Carbon::createFromFormat('Y-m-d', $this->endDate);

    //     while ($startDate->lessThanOrEqualTo($endDate)) {
    //         $currentDate = $startDate->format('Y-m-d');
    //         $attendanceEntry = null;

    //         foreach ($attendance as $entry) {
    //             if ($entry['attdate'] == $currentDate) {
    //                 $attendanceEntry = $entry;
    //                 break;
    //             }
    //         }

    //         $attendanceTypecd = $attendanceEntry['atttypecd'] ?? "attpresent";
    //         $attendanceType = $attendanceEntry['atttypedesc'] ?? "H";
    //         $attendanceDuration = $attendanceEntry['attduration'] ?? "";
    //         $hours = 0;

    //         if (!empty($attendanceDuration)) {
    //             $timeParts = explode(':', $attendanceDuration);
    //             $hours = (int)$timeParts[0];
    //         }

    //         $isWeekend = $startDate->isWeekend();
    //         $dateColumnIndex = array_search($currentDate, $this->headings());

    //         if ($dateColumnIndex !== false && $dateColumnIndex >= 1) {
    //             $row[$dateColumnIndex] = $attendanceTypecd == "attpresent"
    //                 ? (($attendanceEntry)
    //                     ? (!empty($attendanceDuration) ? ($hours >= 8 ? "✔" : "Hadir") : "✔ (No Clock out)")
    //                     : (!$isWeekend ? "A" : ""))
    //                 : $attendanceType;
    //         }

    //         $startDate->addDay();
    //     }

    //     $attSummaryColumnIndex = array_search('Summary', $this->headings()) + 1;
    //     $row[] = "";
    //     $text = '';
    //     foreach ($this->typecodes as $typecode) {
    //         $text = $typecode->typecd == "attpresent" ? $text . "✔ = " . $item['attsummary'][$typecode->typecd] . " " : $text . "$typecode->typecd = " . $item['attsummary'][$typecode->typecd] . " ";
    //     }
    //     $row[$attSummaryColumnIndex] = $text;

    //     return $row;
    // }
}
