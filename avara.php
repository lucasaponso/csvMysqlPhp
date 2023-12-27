<?php

function readCsv($filename)
{
    $data = []; // Initialize an empty array to store CSV data
    if (($handle = fopen($filename, "r")) !== FALSE) 
    {
        // Read each row from the CSV file and add it to the data array
        while (($row = fgetcsv($handle, 1000, ",")) !== FALSE) 
        {
            $data[] = $row;
        }
        fclose($handle);
    } 
    else 
    {
        echo "Failed to open file: $filename"; // Add an error message for debugging
    }
    return $data;
}
function executeSelect($columns, $table, $isAll)
{
    $data = readCsv($table);
    var_dump($data); // Add this line for debugging
    if ($isAll) 
    {
        return $data;
    } 

    else 
    {
        // Filter the columns based on the $columns array
        $result = [];
        foreach ($data as $row) 
        {
            $filteredRow = [];
            foreach ($columns as $column) 
            {
                if (isset($row[$column])) 
                {
                    $filteredRow[$column] = $row[$column];
                }
            }
            
            if (!empty($filteredRow)) 
            {
                $result[] = $filteredRow;
            }
        }
        return $result;
    }
}

// Command processor loop
function executeQry($qry)
{
    $queryParts = explode(' ', $qry); // Delimit incoming query by a space, then store the delimited values in an array
    $command = strtolower($queryParts[0]); // Set the command variable as the first element of the array
    $len = count($queryParts); // Find the number of elements in the array
    
    $isAll = false; // Initialize $isAll as false by default
    
    if ($queryParts[1] === "*") 
    {
        $isAll = true;
    }
    
    switch ($command) 
    {
        case 'select':
            $table = $queryParts[$len - 1]; // Get the table name from the end of the query
            $columns = explode(',', $queryParts[1]); // Split the columns by comma
            // Call the select function with $tableName and $columns
            $response = "Calling select function with table name: $table and columns: " . implode(', ', $columns);
            $result = executeSelect($columns, $table, $isAll);
            var_dump($result);
            return $result; // Return the result instead of assigning to $response
            break;
        case 'insert':
            // ... (code for INSERT query)
            break;
        case 'update':
            // ... (code for UPDATE query)
            break;
        case 'delete':
            // ... (code for DELETE query)
            break;
        case 'exit':
            // Exit the program
            exit();
        default:
            return "Invalid query. Please enter a valid SQL-like query or 'exit' to quit." . PHP_EOL;
            break;
    }
}

// Example usage
$qry = "select Name, Age FROM file.csv";
$response = executeQry($qry);
var_dump($response);

?>
