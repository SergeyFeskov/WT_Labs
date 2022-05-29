<?php
ob_start();

function print_return() {
    echo "<br>";
    echo "<a href='metoda_var5.html'>Return</a>";
}

function create_calendar(string $year_str) : array {
    $year = (int)$year_str;
    $feb_days = ($year % 4 == 0 && !($year % 100 == 0 && $year % 400 != 0)) ? 29 : 28;
    $days = array(31, $feb_days, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);
    $wday = array( '', '', '', '', '', '', '' );
    $months_calendar = array();
    for ($i = 0; $i < 12; $i++) {
        $firstday = getdate(strtotime(($i + 1).'/1/'.$year_str));
        $fromday = $firstday['wday'];
        $leftday =  7 - ( $fromday + $days[$i] ) % 7;
        $months_calendar[] = array_merge(
            array_slice($wday, 0, $fromday),
            range(1, $days[$i]),
            array_slice($wday, 0, $leftday)
        );
    }

    return $months_calendar;
}

function output_calendar(string $year_str, array $year_calendar, array $month_names, array $holidays) {
    for ($i = 0; $i < 12; $i++) {
        echo
            "<table>\n
                <thead>\n
                    <tr><th colspan='7'>$month_names[$i] $year_str</th></tr>\n
                    <tr><th>Sun</th><th>Mon</th><th>Tue</th><th>Wed</th><th>Thu</th><th>Fri</th><th>Sat</th>\n
                </thead>\n
                <tbody>\n
                    <tr>\n";
        foreach($year_calendar[$i] as $k => $v) {
            if ($k && !($k % 7)) {
                echo "</tr><tr>";
            }

            if (in_array([$v, $i + 1], $holidays)) {
                echo "<td style='background-color: #DD0000'>{$v}</td>";
            } else {
                echo "<td>{$v}</td>";
            }
        }
        echo
                    "</tr>
                </tbody>
            </table>";
    }
}

if (count($_GET) != 1 || !isset($_GET['year'])) {
    echo "Invalid GET params. Use metoda_var5.html to execute this script.";
    print_return();
    exit(1);
}

$year = htmlspecialchars($_GET['year']);

if (!is_numeric($year) ||
    !(strpos($year, '.') === false && strpos($year, 'e') === false) ||
    $year < 1970) {
    echo "Year should be integer number in range from 1970.";
    print_return();
    exit(1);
}

$calendar = create_calendar($year);
$month_names =  array('Jan', 'Feb', 'Mar', 'Apr', 'May', 'June', 'July', 'Aug', 'Sept', 'Oct', 'Nov', 'Dec');
$holidays = [[31,12], [1,1], [3,7]];
output_calendar($year, $calendar, $month_names, $holidays);

$html_calendar = ob_get_contents();
ob_end_clean();
echo $html_calendar;

if (!file_put_contents(getcwd() . '/' . $year . '_calendar.html', $html_calendar)) {
    echo "<script>alert('Saving calendar to file executed with errors!');</script>";
} else {
    echo "<script>alert('Saving calendar to file executed successfully!');</script>";
}
