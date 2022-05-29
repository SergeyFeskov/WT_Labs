<?php

class EmailsTable {
    private $servername = "localhost";
    private $username = "root";
    private $password = "sk8tenbd4me+U";
    private $dbname = "lab7";
    private $tablename = "emails";

    public $emails_str = "";
    public PDO $conn;

    public function Connect() {
        try {
            $this->conn = new PDO("mysql:host=$this->servername;dbname=$this->dbname;charset=utf8mb4", $this->username, $this->password);
        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }

    public function GetEmails() {
        if (!isset($this->conn)) {
            die("Not connected to database.");
        }

        $sql = "SELECT * FROM $this->tablename";

        if ($statement = $this->conn->query($sql)) {
            $arr = array();
            foreach ($statement as $row) {
                $email = $row["email"];
                $arr[] = $email;
            }
            $this->emails_str = implode(', ', $arr);
        } else {
            echo "Query $sql failed.";
        }

        unset($statement);
        unset($this->conn);
    }
}

if (!empty($_POST)) {
    $emails_table = new EmailsTable();
    $emails_table->Connect();
    $emails_table->GetEmails();

    echo "Letter recipients: $emails_table->emails_str <br>";

    $subject = '=?UTF-8?B?' . base64_encode($_POST["topic"]) . '?=';
    $message = base64_encode($_POST["text"]);

    $headers = 'Content-type: text/plain; charset=utf-8' . "\r\n";
    $headers .= 'Content-Transfer-Encoding: base64' . "\r\n";
    $headers .= 'From: test@mail.ru' . "\r\n";

    if (mail($emails_table->emails_str, $subject, $message, $headers)) {
        echo "Message was sent! <br>";
    }
    else {
        echo "Error is occurred! <br>";
    }
}
