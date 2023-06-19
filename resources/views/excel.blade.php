<?php use Carbon\Carbon; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
</head>
<body>
    <table>
        <thead>
            <tr>
                <td style="color: white; background-color: #0095ff; border: 1px solid black;" rowspan="2">Name</td>
                <?php
                    $startDate = Carbon::createFromFormat('Y-m-d', $startdate);
                    $endDate = Carbon::createFromFormat('Y-m-d', $enddate);

                    while (strtotime($startDate) <= strtotime($enddate)) {
                        $currentDate = Carbon::parse($startDate);

                        $isHoliday = false;
                        foreach ($holidays as $holiday) {
                            if ($holiday->date == $currentDate->format('Y-m-d')) {
                                $isHoliday = true;
                                break;
                            }
                        }

                        $cellColor = $currentDate->isWeekend() || $isHoliday ? 'red' : 'black';
                        echo "<td style='color: $cellColor; border: 1px solid black; place-self: center' rowspan='2'>" . $currentDate->format('d M Y') . "</td>";

                        $startDate = date('Y-m-d', strtotime($startDate . ' +1 day'));
                    }
                ?>
                <td style="color: white; background-color: #0095ff; border: 1px solid black;" colspan="{{ $atttypes->count() }}">Summary</td>
            </tr>
            <tr style="display: flex">
                @foreach($atttypes as $atttype)
                    <td style="color: white; background-color: #0095ff; border: 1px solid black;">{{ $atttype->typedesc == "H" ? "✔" : $atttype->typedesc }}</td>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach($data as $item)
            <tr>
                <td>{{ $item['attuser']['userfullname'] }}</td>
                @php
                    $attTypes = [];
                    
                    foreach ($atttypes as $atttype) {
                        $attTypes[$atttype->typedesc] = 0;
                    }

                    $startDate = Carbon::createFromFormat('Y-m-d', $startdate);
                    $endDate = Carbon::createFromFormat('Y-m-d', $enddate);

                    while ($startDate->lessThanOrEqualTo($endDate)) { 
                        $currentDate = $startDate->format('Y-m-d');
                        $attendanceEntry = null;

                        foreach ($item['attendance'] as $entry) {
                            if ($entry['attdate'] == $currentDate) {
                                $attendanceEntry = $entry;
                                break;
                            }
                        }

                        $isWeekend = $startDate->isWeekend();

                        $isHoliday = false;
                        foreach ($holidays as $holiday) {
                            if ($holiday->date == $currentDate) {
                                $isHoliday = true;
                                break;
                            }
                        }
                        
                        $attendanceTypecd = $attendanceEntry['atttypecd'] ?? "attpresent";
                        $attendanceType = $attendanceEntry ? $attendanceEntry['atttypedesc'] ?? "H" : "";
                        $attendanceDuration = $attendanceEntry['attduration'] ?? "";
                        $hours = 0;
                        
                        if (!empty($attendanceDuration)) {
                            $timeParts = explode(':', $attendanceDuration);
                            $hours = (int)$timeParts[0];
                        }

                        $cellValue = null;

                        if ($attendanceTypecd == "attpresent") {
                            if ($attendanceEntry) {
                                $cellValue = $attendanceDuration != ''
                                    ? $hours >= 8 ? "<td style='color: #4CAF50'>✓</td>" : "<td style='color: red'>✓</td>" 
                                    : "<td style='color: #c7c7c7'>✓</td>" ;
                            } else {
                                if (!$isWeekend && !$isHoliday) {
                                    $cellValue = "<td>A</td>";
                                    $attTypes['A']++;
                                } else {
                                    $cellValue = "<td></td>";
                                }
                            }
                            } else {
                                $cellValue = "<td>$attendanceType</td>";
                        }

                        echo $cellValue;

                        if ($attendanceEntry) $attTypes[$attendanceType]++;
                        
                        $startDate->addDay();
                    }
                    foreach ($attTypes as $atttype) {
                        echo "<td>$atttype</td>";
                    }
                @endphp
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>