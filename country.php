<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the selected country from the form submission
    $country = $_POST['country'];

    // Sanitize the input to prevent XSS or other security issues
    $country = htmlspecialchars($country);

    // Initialize the cities variable
    $cities = "";

    // Use a switch statement to assign cities based on the selected country
    switch ($country) {
        case 'Australia':
            $cities = "Sydney, Melbourne, Brisbane";
            break;
        case 'England':
            $cities = "London, Birmingham";
            break;
        case 'Germany':
            $cities = "Berlin, Hamburg";
            break;
        case 'Philippines':
            $cities = "Manila, Quezon, Makati";
            break;
        default:
            echo "Invalid country selected.";
            exit;
    }

    // Store the cities in the session
    $_SESSION['cities'] = $cities;

    // Redirect back to index.php
    header("Location: index.php");
    exit;
} else {
    echo "Invalid request.";
}
?>
