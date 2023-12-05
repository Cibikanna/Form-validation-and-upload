<?php

class Mark
{
    public function Amark($mark1, $mark2, $mark3)
    {
        return ($mark1 + $mark2 + $mark3) / 3;
    }
}

$validate = true;

$firstname = "";
if (isset($_POST['fname'])) {
    $firstname = $_POST["fname"];
} else $validate = false;

$lastname = "";
if (isset($_POST["lname"])) {
    $lastname = $_POST["lname"];
} else $validate = false;

$mail = "";
if (isset($_POST["mail"])) {
    $mail = $_POST["mail"];

} else $validate = false;
$number = "";
if (isset($_POST["mail"])) {
    $number = $_POST["phone"];

} elseif (!strlen($number) == 10)
    $validate = false;
$address = "";
if (isset($_POST["address"])) {
    $address = $_POST["address"];

} else $validate = false;
$password = "";
if (isset($_POST["password"])) {
    $password = $_POST["password"];

} elseif (!strlen($password) >= 8)
    $validate = false;
$mark1 = 0;
$mark2 = 0;
$mark3 = 0;
if (isset($_POST["mark1"]) && isset($_POST["mark2"]) && isset($_POST["mark3"])) {
    $mark1 = $_POST["mark1"];
    $mark2 = $_POST["mark2"];
    $mark3 = $_POST["mark3"];
} else $validate = false;

$obj = new Mark();
$mark = $obj->Amark($mark1, $mark2, $mark3);

if ($validate) {
    $connection = new mysqli('localhost', 'root', '', 'registration');
    if ($connection->connect_error) {
        die('Connection failed :' . $connection->connect_error);
    } else {

        $sql = "INSERT INTO `userdata` (`Firstname`,`Lastname`,`Phone`,`Address`,`Email`,`Password`,`Mark`) VALUES (?,?,?,?,?,?,?)";
        $smt = $connection->prepare($sql);
        $smt->bind_param("sssssss", $firstname, $lastname, $number, $address, $mail, $password, $mark);
        if ($smt->execute())
            echo "successfull";
        else
            echo "Error";
        $smt->close();
        $connection->close();
    }
}
$host = "localhost";
$username = "root";
$password = "";
$database = "registration";


$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$sql = "SELECT * FROM userdata";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table border='1'>
            <tr>
                <th>ID</th>
                <th>FirstName</th>
                <th>LastName</th>
                <th>Phone</th>
                <th>Address</th>
                <th>Email</th>
                <th>Password</th>
                <th>Avg mark</th>
            </tr>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . $row['Id'] . "</td>
                <td>" . $row['Firstname'] . "</td>
                <td>" . $row['Lastname'] . "</td>
                <td>" . $row['Phone'] . "</td>
                <td>" . $row['Address'] . "</td>
                <td>" . $row['Email'] . "</td>
                <td>" . $row['Password'] . "</td>
                <td>" . $row['Mark'] . "</td>
              </tr>";
    }

    echo "</table>";
} else {
    echo "No data found.";
}

$conn->close();

