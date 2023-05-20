<?php
// Retrieve search criteria
$searchKeyword = $_POST['searchKeyword'];
$searchAge = $_POST['searchAge'];
$searchBookType = $_POST['searchBookType'];

// Construct the WHERE clause for the SQL query based on the provided search criteria
$whereClause = "";
if (!empty($searchKeyword)) {
    $whereClause .= "bookName LIKE '%$searchKeyword%' OR publisherName LIKE '%$searchKeyword%' OR ";
}
if (!empty($searchAge)) {
    $whereClause .= "age = $searchAge OR ";
}
if (!empty($searchBookType)) {
    $whereClause .= "bookType IN ('" . implode("', '", $searchBookType) . "') OR ";
}
// Remove the trailing "OR" from the WHERE clause
$whereClause = rtrim($whereClause, " OR ");

// Connect to the MySQL database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "book_information";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Prepare and execute the SQL query to search for matching data
$sql = "SELECT * FROM books";
if (!empty($whereClause)) {
    $sql .= " WHERE $whereClause";
}

$result = $conn->query($sql);

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Search Results</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }
        
        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
    </style>
</head>
<body>
    <h1>Search Results</h1>
    <?php if ($result->num_rows > 0) { ?>
        <table>
            <tr>
                <th>SL No</th>
                <th>Book Name</th>
                <th>Publisher Name</th>
                <th>Age</th>
                <th>Page No</th>
                <th>Publish Date</th>
                <th>Book Type</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['bookName']; ?></td>
                    <td><?php echo $row['publisherName']; ?></td>
                    <td><?php echo $row['age']; ?></td>
                    <td><?php echo $row['pageNo']; ?></td>
                    <td><?php echo $row['publishDate']; ?></td>
                    <td><?php echo $row['bookType']; ?></td>
                </tr>
            <?php } ?>
        </table>
    <?php } else { ?>
        <p>No matching results found.</p>
    <?php } ?>
</body>
</html>