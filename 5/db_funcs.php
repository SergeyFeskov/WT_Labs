<?php

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

function add_cleaner(mysqli $db, string $name, string $phone_number, string $city, string $rating) : bool {
    $sql = "INSERT INTO cleaners (`id`, `name`, `phone_number`, `city`, `rating`) VALUES (NULL, '$name', '$phone_number', '$city', '$rating');";
    if (!$db->query($sql)) {
        echo "ERROR: $sql query returned empty result.";
        return false;
    }
    return true;
}

function delete_cleaner(mysqli $db, string $id_field, string $field_value) : bool {
    $sql = "DELETE FROM cleaners WHERE `cleaners`.`$id_field` = '$field_value'";
    if (!$db->query($sql)) {
        echo "ERROR: $sql query returned empty result.";
        return false;
    }
    return true;
}

function update_cleaner(mysqli $db, string $id, string $name, string $phone_number, string $city, string $rating) : bool {
    $update_fields_str = '';
    if ($name != '') {
        $update_fields_str .= "`name` = '$name', ";
    }
    if ($phone_number != '') {
        $update_fields_str .= "`phone_number` = '$phone_number', ";
    }
    if ($city != '') {
        $update_fields_str .= "`city` = '$city', ";
    }
    if ($rating != '') {
        $update_fields_str .= "`rating` = '$rating', ";
    }

    if ($update_fields_str != '') {
        $update_fields_str = substr($update_fields_str, 0, -2);
        $sql = "UPDATE `cleaners` SET $update_fields_str WHERE `cleaners`.`id` = '$id'";
        if (!$db->query($sql)) {
            echo "ERROR: $sql query returned empty result.";
            return false;
        }
    } else {
        echo "ERROR: enter new value for any field.";
        return false;
    }
    return true;
}
?>