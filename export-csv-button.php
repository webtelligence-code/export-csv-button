<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "matoscarroot";
$dbname = "amatoscar";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if (isset($_POST['export'])) {
    // Get selected row ID
    $rowId = $_POST['row_id'];

    // Fetch data from the selected row
    $sql = "SELECT * FROM testing WHERE id = $rowId";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Create a new CSV file
        $csvFile = fopen('exported_data.csv', 'w');

        // Write headers to the CSV file
        fputcsv($csvFile, ['Column 1', 'Column 2', 'Column 3']);

        // Fetch and write row data to the CSV file
        $row = $result->fetch_assoc();
        fputcsv($csvFile, [$row['column1'], $row['column2'], $row['column3']]);

        // Close the CSV file
        fclose($csvFile);

        // Set appropriate headers for file download
        header('Content-Type: application/csv');
        header('Content-Disposition: attachment; filename=exported_data.csv');
        header('Pragma: no-cache');

        // Output the file content
        readfile('exported_data.csv');

        // Delete the temporary file
        unlink('exported_data.csv');

        // Delete the row from the database
        $deleteSql = "DELETE FROM testing WHERE id = $rowId";
        $conn->query($deleteSql);

        exit;
    } else {
        echo "No data found for the selected row.";
    }
}

// Fetch all rows from the table
$sql = "SELECT * FROM testing";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Export and Delete Data</title>
    <style>
        table {
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
            padding: 5px;
        }
    </style>
</head>
<body>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Column 1</th>
                <th>Column 2</th>
                <th>Column 3</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['column1']; ?></td>
                        <td><?php echo $row['column2']; ?></td>
                        <td><?php echo $row['column3']; ?></td>
                        <td>
                            <form method="post">
                                <input type="hidden" name="row_id" value="<?php echo $row['id']; ?>">
                                <button type="submit" name="export">Export and Delete</button>
                            </form>
                        </td>
                    </tr>
                    <?php
                }
            } else {
                ?>
                <tr>
                    <td colspan="5">No data available</td>
                </tr>
                <?php
            }
            ?>
        </tbody>
    </table>
</body>
</html>
