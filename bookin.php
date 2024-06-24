<?php
$host = "localhost";
$port = 3306;
$socket = "";
$user = "root";
$password = "1234";
$dbname = "property_rntal";

// Create connection
$conn = new mysqli($host, $user, $password, $dbname, $port, $socket);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get form data
$name = $_POST['name'];
$property_id = $_POST['property'];
$booking_date = $_POST['booking_date'];

// Check property availability
$sql = "SELECT availability FROM Property WHERE id='$property_id'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    if ($row['availability']) {
        // Insert booking
        $sql = "INSERT INTO Booking (property_id, user_name, booking_date) VALUES ('$property_id', '$name', '$booking_date')";
        if ($conn->query($sql) === TRUE) {
            // Update property availability
            $sql = "UPDATE Property SET availability=FALSE WHERE id='$property_id'";
            $conn->query($sql);
            echo "Booking successful!";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "Property is not available!";
    }
} else {
    echo "Property not found!";
}

$conn->close();
?>
