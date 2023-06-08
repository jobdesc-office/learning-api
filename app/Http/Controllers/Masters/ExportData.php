<?php

namespace App\Http\Controllers\masters;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use Log;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithMapping;

class ExportData implements FromCollection, WithMapping, WithHeadings
{
    use Exportable;

    protected $data;
    protected $typenames;
    protected $startDate;
    protected $endDate;
    protected $headers;

    public function __construct($data, $startDate, $endDate, $typenames)
    {
        $this->data = $data;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->typenames = $typenames;
    }

    public function collection()
    {
        return new Collection($this->data);
    }

    public function headings(): array
    {
        $headers = ['Name'];
        $startDate = Carbon::createFromFormat('Y-m-d', $this->startDate);
        $endDate = Carbon::createFromFormat('Y-m-d', $this->endDate);
        $daysInMonth = $endDate->diffInDays($startDate) + 1;

        $currentDate = clone $startDate;

        for ($i = 0; $i < $daysInMonth; $i++) {
            $headers[] = $currentDate->format('Y-m-d');
            $currentDate->modify('+1 day');
        }

        array_push($headers, "Summary");

        return $headers;
    }


    public function map($item): array
    {
        $attendance = $item['attendance'];
        $user = json_decode($item['attuser']);

        $nameColumnIndex = array_search('Name', $this->headings());
        $row[$nameColumnIndex] = $user->userfullname;

        $startDate = Carbon::createFromFormat('Y-m-d', $this->startDate);
        $endDate = Carbon::createFromFormat('Y-m-d', $this->endDate);

        while ($startDate->lessThanOrEqualTo($endDate)) {
            $currentDate = $startDate->format('Y-m-d');
            $attendanceEntry = null;

            foreach ($attendance as $entry) {
                if ($entry['attdate'] == $currentDate) {
                    $attendanceEntry = $entry;
                    break;
                }
            }

            $attendanceType = $attendanceEntry['atttype'] ?? "";
            $attendanceDuration = $attendanceEntry['attduration'] ?? "";
            $hours = 0;

            if (!empty($attendanceDuration)) {
                $timeParts = explode(':', $attendanceDuration);
                $hours = (int)$timeParts[0];
            }

            $isWeekend = $startDate->isWeekend();
            $dateColumnIndex = array_search($currentDate, $this->headings());

            if ($dateColumnIndex !== false && $dateColumnIndex >= 2) {
                $row[$dateColumnIndex] = $attendanceType == "H" || $attendanceType == null
                    ? (($attendanceEntry)
                        ? (!empty($attendanceDuration) ? ($hours >= 8 ? "✔" : "A") : "✔ (No Clock out)")
                        : (!$isWeekend ? $attendanceType : "")) : "";
            }

            $startDate->addDay();
        }

        $attSummaryColumnIndex = array_search('Summary', $this->headings()) + 1;
        $row[] = "";
        $text = '';
        foreach ($this->typenames as $typename) {
            $text = $typename == "H" ? $text . "✔ = " . $item['attsummary'][$typename] . " " : $text . "$typename = " . $item['attsummary'][$typename] . " ";
        }
        $row[$attSummaryColumnIndex] = $text;

        return $row;
    }
}
