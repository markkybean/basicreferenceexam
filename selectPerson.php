<?php
// Include your existing database connection
include 'dbConnection.php';

// Initialize variables to avoid undefined variable errors
$totalCount = 0;
$totalAge = 0;
$totalAgeLessThan40 = 0;
$countAgeGreaterThan40 = 0;
$names = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve search criteria from the form
    $fname = $_POST['fname'] ?? '';
    $location = $_POST['location'] ?? '';
    $sortBy = $_POST['sortBy'] ?? '';
    $order = $_POST['order'] ?? '';

    // Determine the SQL query based on the search location
    if ($location == 'leftMost') {
        $sql = "SELECT `id`, `lname`, `mname`, `fname`, `age` FROM `person` WHERE `fname` LIKE ?";
        $param = $fname . '%';
    } else {
        $sql = "SELECT `id`, `lname`, `mname`, `fname`, `age` FROM `person` WHERE `fname` LIKE ?";
        $param = '%' . $fname . '%';
    }

    // Append sorting information to the SQL query
    $sortColumnMap = [
        'firstName' => 'fname',
        'lastMiddleName' => 'mname',
        'lastName' => 'lname',
        'age' => 'age',
    ];

    $orderMap = [
        'ascending' => 'ASC',
        'descending' => 'DESC',
    ];

    $sortColumn = isset($sortColumnMap[$sortBy]) ? $sortColumnMap[$sortBy] : 'fname'; // Default to first name if invalid
    $orderType = isset($orderMap[$order]) ? $orderMap[$order] : 'ASC'; // Default to ascending if invalid
    $sql .= " ORDER BY $sortColumn $orderType";

    // Prepare and execute the SQL statement
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $param);
    $stmt->execute();
    $result = $stmt->get_result();

    // Fetch results and calculate aggregates
    while ($row = $result->fetch_assoc()) {
        $names[] = $row;
        $totalAge += $row['age'];
        $totalCount++;
        if ($row['age'] < 40) {
            $totalAgeLessThan40++;
        }
        if ($row['age'] > 40) {
            $countAgeGreaterThan40++;
        }
    }

    // Close the connection
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results</title>

</head>

<body>

    <div class="container mt-5">
        <div class="card p-5 shadow bg-info bg-opacity-50 m-4">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="input-group flex-nowrap mt-4">
                    <span class="input-group-text" id="addon-wrapping">First name:</span>
                    <input type="text" class="form-control" name="fname" value="<?php echo htmlspecialchars($fname); ?>" aria-describedby="addon-wrapping" required>
                </div>
                <div class="container mt-5">
                    <div class="container m-3">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="location" id="leftMost" value="leftMost" checked <?php echo ($location == 'leftMost') ? 'checked' : ''; ?>>
                            <label class="form-check-label" for="leftMost">
                                Left Most
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="location" id="anywhere" value="anywhere" <?php echo ($location == 'anywhere') ? 'checked' : ''; ?>>
                            <label class="form-check-label" for="anywhere">
                                Anywhere
                            </label>
                        </div>
                    </div>

                    <h6>Sort By</h6>
                    <div class="container mt-5">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="container m-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="sortBy" id="firstName" value="firstName" checked <?php echo ($sortBy == 'firstName') ? 'checked' : ''; ?>>
                                        <label class="form-check-label" for="firstName">
                                            First Name
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="sortBy" id="lastMiddleName" value="lastMiddleName" <?php echo ($sortBy == 'lastMiddleName') ? 'checked' : ''; ?>>
                                        <label class="form-check-label" for="lastMiddleName">
                                            Last Middle Name
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="sortBy" id="lastName" value="lastName" <?php echo ($sortBy == 'lastName') ? 'checked' : ''; ?>>
                                        <label class="form-check-label" for="lastName">
                                            Last Name
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="sortBy" id="age" value="age" <?php echo ($sortBy == 'age') ? 'checked' : ''; ?>>
                                        <label class="form-check-label" for="age">
                                            Age
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="container m-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="order" id="ascending" value="ascending" checked <?php echo ($order == 'ascending') ? 'checked' : ''; ?>>
                                        <label class="form-check-label" for="ascending">
                                            Ascending
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="order" id="descending" value="descending" <?php echo ($order == 'descending') ? 'checked' : ''; ?>>
                                        <label class="form-check-label" for="descending">
                                            Descending
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-success mt-2">Refresh</button>
                </div>
            </form>
        </div>

        <div class="container mt-5">
            <h2>Search Results</h2>
            <?php if ($totalCount > 0) : ?>
                <table class="table table-bordered mt-3">
                    <thead>
                        <tr>
                            <th>Last Name</th>
                            <th>Middle Name</th>
                            <th>First Name</th>
                            <th>Age</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($names as $row) : ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['lname']); ?></td>
                                <td><?php echo htmlspecialchars($row['mname']); ?></td>
                                <td><?php echo htmlspecialchars($row['fname']); ?></td>
                                <td><?php echo htmlspecialchars($row['age']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <div class="card p-5 shadow bg-secondary bg-opacity-50 m-4 h-100">
                    <?php
                    $full_names = array_map(function ($row) {
                        return "{$row['lname']} {$row['mname']} {$row['fname']}";
                    }, $names);
                    ?>
                    <p>Names: <?php echo implode(', ', $full_names); ?></p>
                    <p>Total of all ages: <span><?php echo $totalAge; ?></span></p>
                    <p>Total count of all persons: <span><?php echo $totalCount; ?></span></p>
                    <p>Total of ages less than 40: <span><?php echo $totalAgeLessThan40; ?></span></p>
                    <p>Total count of person age greater than 40: <span><?php echo $countAgeGreaterThan40; ?></span></p>
                </div>
            <?php else : ?>
                <p>No results found.</p>
            <?php endif; ?>
        </div>
    </div>

</body>

</html>
