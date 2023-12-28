<?php
include_once 'csvHandler.php';

class QueryExecutor
{
    private $csvHandler;

    public function __construct()
    {
        $this->csvHandler = new CsvHandler();
    }

    private function executeSelect($columns, $table, $isAll)
    {
        $data = $this->csvHandler->readCsv($table);
        if ($isAll) 
        {
            return $data;
        } 
        else 
        {
            $headers = array_shift($data);
            foreach ($columns as $column) 
            {
                if (!in_array($column, $headers)) 
                {
                    return "Column '$column' does not exist in the CSV file.";
                }
            }
    
            $assocData = [];
            foreach ($data as $row) 
            {
                $assocRow = [];
                foreach ($row as $index => $value) 
                {
                    if (isset($headers[$index])) 
                    {
                        $assocRow[$headers[$index]] = $value;
                    }
                }
                
                $assocData[] = $assocRow;
            }
    
            $result = [];
            foreach ($assocData as $row) 
            {
                $filteredRow = [];
                foreach ($columns as $column) 
                {
                    if (isset($row[$column])) 
                    {
                        $filteredRow[$column] = $row[$column];
                    }
                    else
                    {
                        $filteredRow[$column] = '';
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

    public function executeQry($strQry)
    {
        $qry = explode(' ', $strQry); 
        $operation = strtolower($qry[0]);
        $len = count($qry);
        $table = $qry[$len - 1];

        $columns = [];
        if ($operation === 'select') 
        {
            if (isset($qry[1]) && strpos($qry[1], ',') !== false) 
            {
                $columns = explode(',', $qry[1]);
            } 
            else 
            {
                $columns[] = $qry[1];
            }
        }

        $isAll = ($qry[1] === "*");

        switch ($operation) 
        {
            case 'select':
                return $this->executeSelect($columns, $table, $isAll);
            // Add cases for other operations (insert, update, delete) if needed
            default:
                return "Invalid query. Please enter a valid SQL-like query or 'exit' to quit." . PHP_EOL;
        }
    }
}
?>
