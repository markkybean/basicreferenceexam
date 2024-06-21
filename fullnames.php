<?php
session_start(); // Start the session

// Include your database connection script
include "dbConnection.php";

$sql = "SELECT `lname`, `mname`, `fname` FROM `person` WHERE 1";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Initialize an array to store full names
    $full_names = [];

    // Fetch data and save it to variables or process as needed
    while ($row = $result->fetch_assoc()) {
        $lname = $row['lname'];
        $mname = $row['mname'];
        $fname = $row['fname'];

        // Extract the middle initial if it exists
        $middle_initial = !empty($mname) ? substr($mname, 0, 1) . '.' : '';

        // Concatenate last name, first name, and middle initial with dot
        $full_name = "$lname, $fname $middle_initial";

        // Add to the array of full names
        $full_names[] = $full_name;
    }

    // Join all full names into a single string separated by new lines
    $all_names = implode("\n", $full_names);

    // Store the full names in a session variable
    $_SESSION['all_names'] = $all_names;
} else {
    echo "0 results";
}

// Close the database connection
$conn->close();

// Redirect to index.php with all_names parameter
header("Location: index.php?all_names=" . urlencode($all_names));
exit();
?>
