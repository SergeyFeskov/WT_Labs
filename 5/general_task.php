<style>
    table, th, td {
        border: 1px solid black;
    }

    th, td {
        padding-left: 5px;
        padding-right: 5px;
    }

    .flex_container {
        display: flex;
        justify-content: space-between;
        padding-bottom: 20px;
    }
</style>
<?php
$cleaning_service_db = new mysqli('localhost', 'root', 'sk8tenbd4me+U', 'cleaning_service');

if ($cleaning_service_db->connect_errno) {
    echo '<pre>';
    echo "CONNECTION ERROR $cleaning_service_db->connect_errno: $cleaning_service_db->connect_error";
    echo '</pre>';
    exit(1);
}

$cleaning_service_db->set_charset('UTF-8');

function output_db_table(mysqli $db, string $table_name, string $sort_field = 'id',
                         bool $sort_ascending = true, int $els_limit = -1) : bool {
    if (!$db->query("SHOW TABLES LIKE '$table_name'")) {
        echo "ERROR: Table $table_name does not exist";
        return false;
    }
    if (!$db->query("SHOW COLUMNS FROM `$table_name` LIKE '$sort_field'")) {
        echo "ERROR: Field $sort_field in table $table_name does not exist";
        return false;
    }
    $sort_order = $sort_ascending ? 'ASC' : 'DESC';
    $limit_code = ($els_limit === -1) ? '' : "LIMIT $els_limit";

    // get table field's names
    $sql = "SELECT `COLUMN_NAME` FROM `INFORMATION_SCHEMA`.`COLUMNS` WHERE `TABLE_NAME`='$table_name'";
    $field_names = [];
    if ($result = $db->query($sql)) {
        foreach ($result as $row) {
            $field_names[] = $row['COLUMN_NAME'];
        }
    } else {
        echo "ERROR: $sql query returned empty result.";
        return false;
    }

    $sql = "SELECT * FROM $table_name ORDER BY $sort_field $sort_order $limit_code";
    if ($result = $db->query($sql)) {
        echo "<table><tr>";
        foreach ($field_names as $field_name) {
            echo "<th>$field_name</th>";
        }
        echo "</tr>";
        foreach ($result as $row) {
            echo  "<tr>";
            foreach ($field_names as $field_name) {
                echo "<td>" . $row[$field_name] . "</td>";
            }
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "ERROR: $sql query returned empty result.";
        return false;
    }

    return true;
}

?>
<div class="flex_container">
    <?php
    output_db_table($cleaning_service_db, 'cleaners', 'rating');
    output_db_table($cleaning_service_db, 'orders', 'start_datetime', true);
    ?>
</div>
<?php
$sql = "SELECT DISTINCT cleaner_id FROM `orders` ORDER BY cleaner_id";
$cleaners_id = [];
if ($result = $cleaning_service_db->query($sql)) {
    foreach ($result as $row) {
        $cleaners_id[] = $row['cleaner_id'];
    }
} else {
    echo "ERROR: $sql query returned empty result.";
    $cleaning_service_db->close();
    exit(1);
}

$str = implode(',', $cleaners_id);
$sql = "SELECT name, id FROM cleaners WHERE id IN ($str) ORDER BY id";
if ($result = $cleaning_service_db->query($sql)) {
    $cleaners_names = array_column($result->fetch_all(MYSQLI_ASSOC), 'name', 'id');
} else {
    echo "ERROR: $sql query returned empty result.";
    $cleaning_service_db->close();
    exit(1);
}

$sql = "SELECT city, address, start_datetime, cleaner_id FROM `orders` ORDER BY cleaner_id";
if ($result = $cleaning_service_db->query($sql)) {
    echo "<table><tr><th rowspan='2'>Cleaner name</th><th colspan='3'>Order info</th></tr>";
    echo "<tr><th>City</th><th>Address</th><th>Start datetime</th></tr>";
    $curr_cleaner_id = $cleaners_id[0];
    $order_info = $result->fetch_array(MYSQLI_ASSOC);
    while ($order_info) {
        $orders_count = 0;
        $cleaner_orders_info = [];
        while ($order_info && $order_info['cleaner_id'] == $curr_cleaner_id) {
            $orders_count++;
            unset($order_info['cleaner_id']);
            array_push($cleaner_orders_info, $order_info);
            $order_info = $result->fetch_array(MYSQLI_ASSOC);
        }
        $name = $cleaners_names[$curr_cleaner_id];
        echo "<tr><td rowspan='$orders_count'>$name</td>";
        $city = $cleaner_orders_info[0]['city'];
        echo "<td>$city</td>";
        $address = $cleaner_orders_info[0]['address'];
        echo "<td>$address</td>";
        $datetime = $cleaner_orders_info[0]['start_datetime'];
        echo "<td>$datetime</td></tr>";
        for ($i = 1; $i < $orders_count; $i++) {
            $city = $cleaner_orders_info[$i]['city'];
            echo "<td>$city</td>";
            $address = $cleaner_orders_info[$i]['address'];
            echo "<td>$address</td>";
            $datetime = $cleaner_orders_info[$i]['start_datetime'];
            echo "<td>$datetime</td></tr>";
        }
        if ($order_info !== null) {
            $curr_cleaner_id = $order_info['cleaner_id'];
        }
    }
    echo "</table>";
    $cleaning_service_db->close();
} else {
    echo "ERROR: $sql query returned empty result.";
    $cleaning_service_db->close();
    exit(1);
}