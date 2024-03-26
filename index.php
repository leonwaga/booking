<?php

// Establish database connection
$servername = "localhost";
$username = "username";
$password = "password";
$dbname = "booking";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to create a booking
function createBooking() {
    global $conn;
    echo "Enter your Name: ";
    $name = readline();
    echo "Enter your Date of Birth (YYYY-MM-DD): ";
    $dob = readline();
    echo "Enter your Gender: ";
    $gender = readline();
    echo "Enter your Contact Number: ";
    $contact = readline();
    echo "Enter your City: ";
    $city = readline();
    echo "Enter the Clinic: ";
    $clinic = readline();
    echo "Enter the Doctor: ";
    $doctor = readline();
    echo "Enter the Date of Visit (YYYY-MM-DD): ";
    $date_of_visit = readline();

    // Insert the booking into the database
    $sql = "INSERT INTO bookings (name, dob, gender, contact, city, clinic, doctor, date_of_visit) VALUES ('$name', '$dob', '$gender', '$contact', '$city', '$clinic', '$doctor', '$date_of_visit')";

    if ($conn->query($sql) === TRUE) {
        echo "Booking successful!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Function to check booking status
function checkBooking() {
    global $conn;
    echo "Enter your Name: ";
    $name = readline();
    echo "Enter your Date of Birth (YYYY-MM-DD): ";
    $dob = readline();

    // Fetch booking details from the database
    $sql = "SELECT * FROM bookings WHERE name='$name' AND dob='$dob'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Output booking details
        while($row = $result->fetch_assoc()) {
            echo "Name: " . $row["name"]. ", DOB: " . $row["dob"]. ", Gender: " . $row["gender"]. ", Contact: " . $row["contact"]. ", City: " . $row["city"]. ", Clinic: " . $row["clinic"]. ", Doctor: " . $row["doctor"]. ", Date of Visit: " . $row["date_of_visit"]. "<br>";
        }
    } else {
        echo "Booking not found";
    }
}

// Function to delete a booking
function deleteBooking() {
    global $conn;
    echo "Enter your Name: ";
    $name = readline();
    echo "Enter your Date of Birth (YYYY-MM-DD): ";
    $dob = readline();

    // Confirm deletion
    echo "Are you sure you want to delete your booking? (1: Yes / 0: No)";
    $confirm = readline();

    if ($confirm == 1) {
        // Delete the booking from the database
        $sql = "DELETE FROM bookings WHERE name='$name' AND dob='$dob'";
        if ($conn->query($sql) === TRUE) {
            echo "Booking deleted successfully!";
        } else {
            echo "Error deleting booking: " . $conn->error;
        }
    } else {
        echo "Booking deletion cancelled";
    }
}

// Main menu
while (true) {
    echo "\nMenu:\n";
    echo "1. Create Booking\n";
    echo "2. Check Booking Status\n";
    echo "3. Delete Booking\n";
    echo "4. Exit\n";
    echo "Choose an option: ";

    $option = readline();

    switch ($option) {
        case 1:
            createBooking();
            break;
        case 2:
            checkBooking();
            break;
        case 3:
            deleteBooking();
            break;
        case 4:
            echo "Exiting...";
            exit();
            break;
        default:
            echo "Invalid option, please try again";
    }
}

// Close database connection
$conn->close();

?>
