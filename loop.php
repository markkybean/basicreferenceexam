<?php
// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if input field is empty
    if (empty($_POST['palindrome'])) {
        $result = "Please enter a string to check.";
    } else {
        $input = $_POST['palindrome'];

        // Convert input to lowercase
        $input = strtolower($input);

        if (isset($_POST['submit_for'])) {
            // Check using for loop
            $backward = "";
            $length = strlen($input);

            for ($i = $length - 1; $i >= 0; $i--) {
                $backward .= $input[$i];
            }
            if ($backward == $input) {
                $result = "for loop: Palindrome";
            } else {
                $result = "for loop: Not a palindrome";
            }

        } elseif (isset($_POST['submit_while'])) {
            // Check using while loop
            $backward = "";
            $i = strlen($input) - 1;

            while ($i >= 0) {
                $backward .= $input[$i];
                $i--;
            }

            if ($backward == $input) {
                $result = "while loop: Palindrome";
            } else {
                $result = "while loop: Not a palindrome";
            }


        } elseif (isset($_POST['submit_foreach'])) {
            // Check using foreach loop
            $backward = "";

            // Convert string to array of characters
            $characters = str_split($input);

            // Reverse the array and concatenate characters
            foreach (array_reverse($characters) as $char) {
                $backward .= $char;
            }

            if ($backward == $input) {
                $result = "foreach: Palindrome";
            } else {
                $result = "foreach: Not a palindrome";
            }

        }

    }
    
    // Redirect to index.php with the result as a URL parameter
    header("Location: index.php?result=" . urlencode($result));
    exit();

    $num = $_POST['num'];
    echo $input;
}
?>
