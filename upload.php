<?php
    $this->load->library('PHPExcel');
    if (isset($_FILES["file"]["name"])) 
    {
        $path = $_FILES["file"]["tmp_name"];
    //            print_r($_FILES);exit;
        $object = PHPExcel_IOFactory::load($path);
        $i=1;
        foreach ($object->getWorksheetIterator() as $worksheet) {
            $highestRow = $worksheet->getHighestRow();
            $highestColumn = $worksheet->getHighestColumn();
            for ($row = 2; $row <= $highestRow; $row++) { // 2 means from data fetch start from 2nd row
                $data['rawTmpTmNo'] = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
                $data['rawTmpEnNo'] = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
                $data['rawTmpName'] = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
                $data['rawTmpGmNo'] = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
                $data['rawTmpMode'] = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
                $data['rawTmpDateTime'] = date('Y-m-d H:i
    :s
    ', PHPExcel_Shared_Date::ExcelToPHP($worksheet->getCellByColumnAndRow(5, $row)->getValue()));
                $this->MAttendance->save_raw($data);
            }
        }
        
    //            echo $this->db->last_query();exit;
        echo '<script>alert("Data Import Completed!"); window.location="'.site_url('home').'";</script>';
        
    }
?>