<?php
// Retrieve form data
$bookName = $_POST['bookName'];
$publisherName = $_POST['publisherName'];
$age = $_POST['age'];
$pageNo = $_POST['pageNo'];
$publishDate = $_POST['publishDate'];
$bookType = $_POST['bookType'];

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

// Prepare and execute the SQL query to insert data into the table
$sql = "INSERT INTO books (bookName, publisherName, age, pageNo, publishDate, bookType)
        VALUES ('$bookName', '$publisherName', '$age', '$pageNo', '$publishDate', '$bookType')";

if ($conn->query($sql) === TRUE) {
    echo "Data saved successfully!";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Close the database connection
$conn->close();
?>