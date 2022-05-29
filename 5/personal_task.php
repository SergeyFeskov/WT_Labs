<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>WT Lab 5. Personal task. Variant 1</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h2>
        Cleaners table
    </h2>
<?php
require 'db_funcs.php';

$cleaning_service_db = new mysqli('localhost', 'root', 'sk8tenbd4me+U', 'cleaning_service');
if ($cleaning_service_db->connect_errno) {
    echo '<pre>';
    echo "CONNECTION ERROR $cleaning_service_db->connect_errno: $cleaning_service_db->connect_error";
    echo '</pre>';
    exit(1);
}
$cleaning_service_db->set_charset('UTF-8');
if (isset($_POST['query_type'])) {
    switch ($_POST['query_type']) {
        case 'add':
            add_cleaner($cleaning_service_db, $_POST['name'], $_POST['phone_number'], $_POST['city'], $_POST['rating']);
            break;
        case 'delete':
            delete_cleaner($cleaning_service_db, $_GET['id_field'], $_POST['field_value']);
            break;
        case 'update':
            update_cleaner($cleaning_service_db, $_POST['id'], $_POST['name'], $_POST['phone_number'], $_POST['city'], $_POST['rating']);
//            echo "<pre>";
//            echo "Name: ";
//            var_dump($_POST['name']);
//            echo "<br>";
//            echo "Phone: ";
//            var_dump($_POST['phone_number']);
//            echo "<br>";
//            echo "City: ";
//            var_dump($_POST['city']);
//            echo "<br>";
//            echo "Rating: ";
//            var_dump($_POST['rating']);
//            echo "</pre>";
            break;
    }
}

//
//    if (isset($_POST['delete']))
//    {
//        $link = mysqli_connect('localhost','root','28103123','Shop');
//        if (mysqli_connect_errno()) {
//            echo 'Произошла ошибка при подключении с кодом '.mysqli_connect_errno().' : '.mysqli_connect_error();
//            exit();
//        }
//        if (isset($_POST['id']) && $_POST['id'] !== "") {
//            $id = $_POST['id'];
//            $sql = "DELETE FROM `Users information` WHERE `Users information`.`id` = '$id';";
//            $result = mysqli_query($link, $sql);
//            if (!$result) {
//                echo "Произошла ошибка при отправке запроса";
//            }
//        }
//        if (isset($_POST['name']) && $_POST['name'] !== "") {
//            $name= $_POST['name'];
//            $sql = "DELETE FROM `Users information` WHERE `Users information`.`name` = '$name';";
//            $result = mysqli_query($link, $sql);
//            if (!$result) {
//                echo "Произошла ошибка при отправке запроса";
//            }
//        }
//        if (isset($_POST['login']) && $_POST['login'] !== "") {
//            $login = $_POST['login'];
//            $sql = "DELETE FROM `Users information` WHERE `Users information`.`login` = '$login';";
//            $result = mysqli_query($link, $sql);
//            if (!$result) {
//                echo "Произошла ошибка при отправке запроса";
//            }
//        }
//        mysqli_close($link);
//    }
//
//    if (isset($_POST['change']))
//    {
//        $link = mysqli_connect('localhost','root','28103123','Shop');
//        if (mysqli_connect_errno()) {
//            echo 'Произошла ошибка при подключении с кодом '.mysqli_connect_errno().' : '.mysqli_connect_error();
//            exit();
//        }
//        $idNew = $_POST['id'];
//        $nameNew = $_POST['name'];
//        $loginNew = $_POST['login'];
//        $passwordNew = $_POST['password'];
//
//        $sql = "UPDATE `Users information` SET `name` = '$nameNew', `login` = '$loginNew', `password` = '$passwordNew' WHERE `Users information`.`id` = '$idNew';";
//        $result = mysqli_query($link, $sql);
//        if (!$result) {
//            echo "Произошла ошибка при отправке запроса";
//        }
//        mysqli_close($link);
//    }
output_db_table($cleaning_service_db, 'cleaners');
$cleaning_service_db->close();
?>
    <h2>Add new cleaner</h2>
    <form action="personal_task.php" method="post" class="form">
        <label for="name">Name:</label>
        <input type="text" id="name" placeholder="Name" name="name" maxlength="60" class="input" required>
        <label for="phone_number">Phone number</label>
        <input type="text" id="phone_number" placeholder="Phone number:" name="phone_number" maxlength="13" class="input" required>
        <label for="password">City:</label>
        <input type="text" id="city" placeholder="City" name="city" maxlength="30" class="input" required>
        <label for="password">Rating:</label>
        <input type="number" id="rating" placeholder="Rating" name="rating" class="input">
        <input type="submit" name="query_type" value="add" class="btn">
    </form>

    <h2>Delete information about user</h2>
    <form action="personal_task.php" method="get" class="form">
        <p>
            Select field, by which you want to delete cleaner:
        </p>
        <input type="submit" name="id_field" value="id" alt="ID" class="btn">
        <input type="submit" name="id_field" value="name" class="btn">
        <input type="submit" name="id_field" value="phone_number" class="btn">
    </form>
    <?php
    if (isset($_GET['id_field'])) {
        $id_field = $_GET['id_field'];
        echo "<form action='personal_task.php?id_field=$id_field' method='post' class='form'>";
        switch ($_GET['id_field']) {
            case 'id':
                echo '<input type="number" id="field_value" placeholder="ID" name="field_value" class="input" required>;';
                break;
            case 'name':
                echo '<input type="text" id="field_value" placeholder="Name" name="field_value" maxlength="60" class="input" required>;';
                break;
            case 'phone_number':
                echo '<input type="text" id="field_value" placeholder="Phone number" name="field_value" maxlength="13" class="input" required>;';
                break;
        }
        echo '<p><input type="submit" name="query_type" value="delete" class="btn"></p>';
        echo "</form>";
    }
    ?>

    <h2>Change information about the user</h2>
    <form action="personal_task.php" method="post" class="form">
        <label for="name">ID:</label>
        <input type="number" id="id" placeholder="ID" name="id" class="input">
        <label for="name">Name:</label>
        <input type="text" id="name" placeholder="Name" name="name" maxlength="60" class="input">
        <label for="phone_number">Phone number</label>
        <input type="text" id="phone_number" placeholder="Phone number:" name="phone_number" maxlength="13" class="input">
        <label for="password">City:</label>
        <input type="text" id="city" placeholder="City" name="city" maxlength="30" class="input">
        <label for="password">Rating:</label>
        <input type="number" id="rating" placeholder="Rating" name="rating" class="input">
        <input type="submit" name="query_type" value="update" class="btn">
    </form>
</body>
</html>

