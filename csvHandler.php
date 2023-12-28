<?php
class CsvHandler
{
    public function readCsv($filename)
    {
        $data = [];
        if (($handle = fopen($filename, "r")) !== FALSE) 
        {
            while (($row = fgetcsv($handle, 1000, ",")) !== FALSE) 
            {
                $data[] = $row;
            }
            fclose($handle);
        } 
        else 
        {
            echo "Failed to open db: $filename";
        }
        return $data;
    }
}
?>
