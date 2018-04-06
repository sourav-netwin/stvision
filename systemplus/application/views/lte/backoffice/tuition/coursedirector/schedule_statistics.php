<?php
$CI = & get_instance();
$testedStudents = "";
$studentsToBeTested = "";
$studentsLeavingTomorrow = "";
foreach ($monthDates as $dates) {
    $todaysDay = date('l', strtotime($dates));
    $dontAllowToSchedule = FALSE;
    if ($todaysDay == "Saturday" || $todaysDay == "Sunday") {
        $dontAllowToSchedule = TRUE;
    }
    $qResult = $CI->getStudentsStats($dates, $campusId);
    if ($qResult) {
        foreach ($qResult as $dayStats) {
            // Tested Students
            $testedStudents .= "<td class='" . ($dontAllowToSchedule ? 'satSun' : '') . "'>";
            if ($dontAllowToSchedule) {
                $testedStudents .= "<a href='javascript:void(0);'>--</a>";
            } else {
                $testedStudents .= "<a href='javascript:void(0);' data-title='Tested students list' data-campus-id='" . $campusId . "' data-classdate='" . $dates . "' data-uuid='" . $dayStats['std_uuids'] . "' class='showstdlist hlt-link-a'>";
                $testedStudents .= $dayStats['students_count'];
                $testedStudents .= "</a>";
            }
            $testedStudents .= "</td>";

            // Students to be tested
            $studentsToBeTested .= "<td class='" . ($dontAllowToSchedule ? 'satSun' : '') . "'>";
            if ($dontAllowToSchedule) {
                $studentsToBeTested .= "<a href='javascript:void(0);'>--</a>";
            } else {
                $studentsToBeTested .= "<a href='javascript:void(0);' data-title='To be tested students list' data-campus-id='" . $campusId . "' data-classdate='" . $dates . "' data-uuid='" . $dayStats['untested_std_uuids'] . "' class='showstdlist hlt-link-a'>";
                $studentsToBeTested .= $dayStats['untested_students_count'];
                $studentsToBeTested .= "</a>";
            }
            $studentsToBeTested .= "</td>";

            // Students leaving tomorrow
            $studentsLeavingTomorrow .= "<td class='" . ($dontAllowToSchedule ? 'satSun' : '') . "'>";

            $studentsLeavingTomorrow .= "<a href='javascript:void(0);' data-title='Leaving tomorrow students list' data-campus-id='" . $campusId . "' data-classdate='" . $dates . "' data-uuid='" . $dayStats['leavingto_std_uuids'] . "' class='showstdlist hlt-link-a'>";
            $studentsLeavingTomorrow .= $dayStats['leavingto_students_count'];
            $studentsLeavingTomorrow .= "</a>";

            $studentsLeavingTomorrow .= "</td>";
        }
    }
}
echo "<tr><td style='text-transform: uppercase;'>Tested Students</td>" . $testedStudents . "</tr>";
echo "<tr><td style='text-transform: uppercase;'>Students to be tested</td>" . $studentsToBeTested . "</tr>";
echo "<tr><td style='text-transform: uppercase;'>Students leaving tomorrow</td>" . $studentsLeavingTomorrow . "</tr>";


