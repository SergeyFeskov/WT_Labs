<!DOCTYPE html>
<head>
    <meta charset="UTF-8" lang="ru">
    <title>Test</title>
</head>
<body>
<main>
    <form method="POST">
        <p>Date for SmartDate class object: <input type="date" required name='smart_date'></p>
        <p>Date for getDatesDiff method: <input type="date" required name='diff_date'></p>
        <br>
        <p>Choose measure unit for getDatesDiff method:</p>
        <p><input type="radio" name='measure_unit' value='sec'> Seconds</p>
        <p><input type="radio" name='measure_unit' value='min'> Minutes</p>
        <p><input type="radio" name='measure_unit' value='hour'> Hours</p>
        <p><input type="radio" name='measure_unit' value='day'> Days</p>
        <p><input type="radio" name='measure_unit' value='month'> Months</p>
        <p><input type="radio" name='measure_unit' value='year'> Years</p>
        <br>
        <input type="submit" name="enter" value="Send">
    </form>
<?php

const IN_SEC = 1;
const IN_MIN = 60 * IN_SEC;
const IN_HOUR = 60 * IN_MIN;
const IN_DAY = 24 * IN_HOUR;
const IN_MONTH = 30 * IN_DAY;
const IN_YEAR = 364 * IN_MONTH;

const SECS_IN_MEASURE_UNITS = [
    'sec' => IN_SEC,
    'min' => IN_MIN,
    'hour' => IN_HOUR,
    'day' => IN_DAY,
    'month' => IN_MONTH,
    'year' => IN_YEAR];

class SmartDate {

    private int $date;

    function __construct(string $formatted_date) {
        $this->date = strtotime($formatted_date);
    }

    public function getDate() : string {
        return date('d/m/y', $this->date);
    }

    public function isWeekend() : bool {
        $day = date("D", $this->date);
        return $day == 'Sat' || $day == 'Sun';
    }

    public function isLeapYear() : bool {
        $year = (int)date("Y", $this->date);
        return ($year % 4 == 0 && !($year % 100 == 0 && $year % 400 != 0));
    }

    public function getDatesDiff(string $date, int $secs_in_unit = 1) : int {
        return (int)floor(abs($this->date - strtotime($date)) / $secs_in_unit);
    }
}

if (count($_POST) == 0) {
    exit();
}

if (!isset($_POST['measure_unit'])) {
    echo "You should choose measure unit!";
    exit();
}

$date_obj = new SmartDate($_POST['smart_date']);

echo "Date in SmartDate class object: " . $date_obj->getDate() . "<br>";

if ($date_obj->isWeekend()) {
    echo "It is weekend day. <br>";
} else {
    echo "It isn't weekend day. <br>";
}

echo $date_obj->isLeapYear() ? "It is leap year. <br>" : "It isn't leap year. <br>";

$measure_unit = $_POST['measure_unit'];
echo "Number of " . $measure_unit . "s between " .
    $_POST['smart_date'] . " and " . $_POST['diff_date'] .
    ": " . $date_obj->getDatesDiff($_POST['diff_date'], SECS_IN_MEASURE_UNITS[$_POST['measure_unit']]);