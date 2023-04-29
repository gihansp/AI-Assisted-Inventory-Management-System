<?php
// Connect to the database
$dsn = "mysql:host=localhost;dbname=phoenix";
$username = "root";
$password = "root";
$options = array(
    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
);
try {
    $conn = new PDO($dsn, $username, $password, $options);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

// Get all the table names in the database
$tables = array();
$stmt = $conn->query("SHOW TABLES");
while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
    $tables[] = $row[0];
}

// Write the data to a backup file
$backup_file = "mydatabase_backup.sql";
$file_handle = fopen($backup_file, "w");

foreach ($tables as $table) {
    // Write the SQL to create the table
    $stmt = $conn->query("SHOW CREATE TABLE $table");
    $row = $stmt->fetch(PDO::FETCH_NUM);
    fwrite($file_handle, "-- Table structure for table `$table`\n");
    fwrite($file_handle, $row[1] . ";\n");

    // Write the data to the table
    $stmt = $conn->query("SELECT * FROM $table");
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $keys = array_keys($row);
        $values = array_map(function($value) use ($conn) {
            return $conn->quote($value);
        }, array_values($row));
        fwrite($file_handle, "INSERT INTO `$table` (" . implode(", ", $keys) . ") VALUES (" . implode(", ", $values) . ");\n");
    }
}

fclose($file_handle);

// Force download of the backup file
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename=' . basename($backup_file));
header('Content-Length: ' . filesize($backup_file));
readfile($backup_file);

// Delete the backup file after the download is complete
unlink($backup_file);


?>
