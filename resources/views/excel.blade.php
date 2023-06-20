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
                <td style="color: white; background-color: #009fd4; border: 1px solid black; text-align: center; font-weight: 700; display: flex; justify-content: center; align-items: center;" rowspan="2">Name</td>
                @foreach ($months as $month => $days)
                    <td style="border: 1px solid black; background-color: lightgray; text-align: center; font-weight: 700;" colspan="{{ $days }}">{{ $month }}</td>
                @endforeach
                <td style="color: white; background-color: #009fd4; border: 1px solid black; text-align: center ;font-weight: 700;" colspan="{{ $atttypes->count() }}">Summary</td>
            </tr>
            <tr style="display: flex">
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
                        echo "<td style='color: $cellColor; border: 1px solid black; text-align: center; font-weight: 700; background-color: lightgray;'>" . $currentDate->format('d') . "</td>";

                        $startDate = date('Y-m-d', strtotime($startDate . ' +1 day'));
                    }
                ?>
                @foreach($atttypes as $atttype)
                    <td style="color: white; background-color: #009fd4; border: 1px solid black; text-align: center; font-weight: 700;">{{ $atttype->typedesc == "H" ? "✔" : $atttype->typedesc }}</td>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach($data as $item)
            <tr>
                <td style="border: 1px solid black;">{{ $item['attuser']['userfullname'] }}</td>
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
                                    ? $hours >= 8 ? "<td style='border: 1px solid black; text-align: center; color: #4CAF50'>✓</td>" : "<td style='border: 1px solid black; text-align: center; color: red'>✓</td>" 
                                    : "<td style='border: 1px solid black; text-align: center; color: #c7c7c7'>✓</td>" ;
                            } else {
                                if (!$isWeekend && !$isHoliday) {
                                    $cellValue = "<td style='border: 1px solid black; text-align: center;'>A</td>";
                                    $attTypes['A']++;
                                } else {
                                    $cellValue = "<td style='border: 1px solid black; text-align: center;'></td>";
                                }
                            }
                            } else {
                                $cellValue = "<td style='border: 1px solid black; text-align: center;'>$attendanceType</td>";
                        }

                        echo $cellValue;

                        if ($attendanceEntry) $attTypes[$attendanceType]++;
                        
                        $startDate->addDay();
                    }
                    foreach ($attTypes as $atttype) {
                        echo "<td style='border: 1px solid black; text-align: center;'>$atttype</td>";
                    }
                @endphp
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>