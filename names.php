<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>

    <div class="container mt-4">
        <h2>Employee Details</h2>
        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead class="table-secondary">
                    <tr>
                        <th scope="col">Last Name</th>
                        <th scope="col">Middle Name</th>
                        <th scope="col">First Name</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    include "dbConnection.php";

                    // Fetch all employees
                    $sql = "SELECT * FROM `person`";
                    $stmt = $conn->prepare($sql);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    // Check if there are any records
                    if ($result->num_rows > 0) {
                        // Display each employee as a table row
                        while ($row = $result->fetch_assoc()) {
                    ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['lname']); ?></td>
                                <td><?php echo htmlspecialchars($row['mname']); ?></td>
                                <td><?php echo htmlspecialchars($row['fname']); ?></td>
                            </tr>
                    <?php
                        }
                    } else {
                        // Display a message if no records are found
                        echo '<tr><td colspan="3" class="text-center">No employees found.</td></tr>';
                    }

                    $stmt->close();
                    $conn->close();
                    ?>
                </tbody>
            </table>
        </div>
    </div>

  




</body>

</html>