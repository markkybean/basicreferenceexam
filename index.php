<?php

session_start();
// Retrieve and clear the output for loop1.php
$output = isset($_SESSION['output']) ? $_SESSION['output'] : '';
unset($_SESSION['output']); // Clear the session variable after use

// Retrieve and clear the cities for country selection
$cities = isset($_SESSION['cities']) ? $_SESSION['cities'] : '';
unset($_SESSION['cities']); // Clear the session variable after use

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Basic Reference Exam Week 1</title>
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body class="bg-info bg-opacity-25">
    <div class="container m-5">
        <form action="loop.php" method="post">
            <div class="input-group flex-nowrap mt-4">
                <span class="input-group-text" id="addon-wrapping">Input:</span>
                <input type="text" class="form-control" id="palindrome" name="palindrome" aria-describedby="addon-wrapping">
            </div>
            <button type="submit" class="btn btn-success mt-2" name="submit_for">Check using for loop</button>
            <button type="submit" class="btn btn-success mt-2" name="submit_while">Check using while loop</button>
            <button type="submit" class="btn btn-success mt-2" name="submit_foreach">Check using foreach loop</button>
            <?php
            // Check if 'result' parameter is set in the URL
            if (isset($_GET['result'])) {
                $result = $_GET['result'];
                echo '<h4 class="mt-2">Result: <span>' . htmlspecialchars($result) . '</span></h4>';
            }
            ?>
        </form>
    </div>

    <hr>


    <div class="container mt-5">
        <div class="row">

            <div class="col-md-1"></div>
            <div class="col-md-3 card p-5 shadow bg-info bg-opacity-50 m-4">
                <form action="loop1.php" method="post">
                    <div class="input-group flex-nowrap mt-4">
                        <span class="input-group-text" id="addon-wrapping">Input:</span>
                        <input type="number" class="form-control" name="num" value="5" aria-describedby="addon-wrapping">
                    </div>

                    <div class="container p-2 bg-secondary mt-2"><?php echo $output; ?></div>
                    <button type="submit" class="btn btn-success mt-2">Submit</button>

                </form>
            </div>


            <div class="col-md-3 card p-5 shadow bg-info bg-opacity-50 m-4">
                <form action="" method="post">
                    <div class="input-group flex-nowrap mt-4">
                        <span class="input-group-text" id="addon-wrapping">Enter a number:</span>
                        <input type="number" class="form-control" name="number" aria-describedby="addon-wrapping" required>
                    </div>


                    <?php
                    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['number'])) {
                        $num = $_POST['number'];
                        if ($num % 2 == 0) {
                            $result = 'even number';
                        } else {
                            $result = 'odd number';
                        }
                    }
                    ?>
                    <?php echo "<h6 class='p-3 bg-secondary mt-2'>Entered number is an <span>$result</span></h6>"; ?>
                    <button type="submit" class="btn btn-success mt-2">Submit</button>
                </form>
            </div>

            <div class="col-md-3 card p-5 shadow bg-info bg-opacity-50 m-4">

                <form action="country.php" method="post">
                    <div class="input-group flex-nowrap mt-4">
                        <select class="form-select" name="country" required>
                            <option value="" disabled selected>Select your country</option>
                            <option value="Australia">Australia</option>
                            <option value="England">England</option>
                            <option value="Germany">Germany</option>
                            <option value="Philippines">Philippines</option>
                        </select>
                    </div>
                    <div class="container bg-secondary mt-2 p-2">
                        <h5>City: <span><?php echo htmlspecialchars($cities); ?></span></h5>
                    </div>
                    <button type="submit" class="btn btn-success mt-2">Submit</button>
                </form>
            </div>



            <hr>


            <center>
                <p>January-February March April May June July August/September.October November#December</p>
            </center>



            <div class="row">

                <div class="col-md-1"></div>

                <div class="col-md-4 card p-5 shadow bg-info bg-opacity-50 m-4">
                    <form action="cleanMonth.php" method="post">
                        <p>Generate to remove special characters</p>
                        <button type="submit" class="btn btn-success mt-2" name="clean">Generate</button>
                        <div class="container m-2">
                            <p><?php echo isset($_GET['cleanMonth']) ? htmlspecialchars($_GET['cleanMonth']) : ''; ?></p>
                        </div>
                    </form>
                </div>



                <div class="col-md-4 card p-5 shadow bg-info bg-opacity-50 m-4">
                    <form action="sortMonth.php" method="post">
                        <p>Generate to sort the months</p>
                        <button type="submit" class="btn btn-success mt-2" name="sorted">Generate</button>
                        <div class="container m-2">
                            <p> <?php
                                if (isset($_GET['sortMonth'])) {
                                    echo $_GET['sortMonth'];
                                }
                                ?></p>
                        </div>
                    </form>
                </div>



            </div>


        </div>

        <hr>
        <br>
        <?php
        include "names.php";
        ?>


        <center>
            <div class="container mt-4">
                <form method="post" action="fullnames.php">
                    <button type="submit" id="generateButton" name="generate" class="btn btn-success">Generate Full Names</button>
                </form>

                <div class="container mt-4">
                    <h2>Full Names</h2>

                    <div class="col-md-4 card p-5 shadow bg-info bg-opacity-50 m-4">
                        <p>
                            <?php
                            // Check if all_names is set in the GET parameters
                            if (isset($_GET['all_names'])) {
                                // Output the decoded and sanitized all_names with line breaks
                                echo nl2br(htmlspecialchars($_GET['all_names']));
                            }
                            ?>
                        </p>
                        </ddi>
                    </div>



                </div>

        </center>
</body>

</html>