<?php
include_once 'csvHandler.php';
include_once 'queryExecutor.php';

$queryExecutor = new QueryExecutor();
$qry = "SELECT City FROM db1/file.csv";
$response = $queryExecutor->executeQry($qry);

if (is_array($response)) {
    // Print the output as an HTML table
    echo '<table border="1">';
    foreach ($response as $row) {
        echo '<tr>';
        foreach ($row as $value) {
            echo '<td>' . $value . '</td>';
        }
        echo '</tr>';
    }
    echo '</table>';
} else {
    // Display the error message
    echo $response;
}
?>
