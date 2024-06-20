<?php
$num = $_POST['num'];
$output = '';

// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST['num'])) {
        echo "Please enter a number.";
    } else {
        $num = intval($_POST['num']); // Ensure $num is an integer
        for ($i = 1; $i <= $num; $i++) {
            for ($j = $i; $j <= $num; $j++) {
                $output .= $j;
                $output .= "\t";
            }
            $output .= "<br>";
        }

        // Start a session to store $output temporarily
        session_start();
        $_SESSION['output'] = $output;
        
        // Redirect to index.php
        header("Location: index.php");
        exit();
    }
}
?>
