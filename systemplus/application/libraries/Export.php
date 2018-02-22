<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Export{

    function to_excel($array, $filename ) {

        header('Content-type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename='.$filename.'.xls');
        header("Pragma: no-cache");
        header("Expires: 0");
         //Filter all keys, they'll be table headers
        $h = array();
        foreach($array as $row){
            foreach($row as $key=>$val){
                if(!in_array($key, $h)){
                 $h[] = $key;
                }
                }
                }
                //echo the entire table headers
                echo '<table><tr>';
                foreach($h as $key) {
                    $key = ucwords($key);
                    echo '<th width="250">'.$key.'</th>';
                }
                echo '</tr>';

                foreach($array as $row){
                  echo '<tr>';
                  foreach($row as $key => $val)
                  {
                    $green_color = ( $key == 'Balance' && $val <= 2 ) ? 1 : 0;
                    $this->writeRow($val, $green_color);
                  }
                }
                echo '</tr>';
                echo '</table>';

        }
    function writeRow($val, $green_color) {
      if( $green_color == 1 )
        echo "<td width='350' style='background-color: #9c9;'>".utf8_decode($val).'</td>';
      else
        echo "<td width='350'>".utf8_decode($val).'</td>';
    }


    function exportUsingPhpExcel($array, $filename, $dateCols = array()){
        ini_set('date.timezone', 'UTC');
        $CI = & get_instance();
        $CI -> load -> library('excel_180');
        $headArray[0] = array();
        foreach ($array as $row) {
            foreach ($row as $key => $val) {
                $key = str_replace("<br />","\n",$key);
                if (!in_array($key, $headArray[0])) {
                    $headArray[0][] = $key;
                }
            }
        }

        $ABCD = "A";
        foreach ($headArray[0] as $th){
            $CI -> excel_180 -> getActiveSheet() -> getColumnDimension($ABCD) -> setAutoSize(TRUE);
//            $rowCount = $CI -> excel_180 ->getActiveSheet()->getHighestRow();
//            $CI -> excel_180 ->getActiveSheet()->getStyle($ABCD.'1:'.$ABCD.$rowCount)
//                                        ->getNumberFormat()
//                                        ->setFormatCode(PHPExcel_Style_NumberFormat::toFormattedString());
            $ABCD++;
        }

        $cnt = 1;
        foreach($array as $row){
            $cnt++;
            if(count($dateCols))
            foreach($dateCols as $dtcolKey => $dtcolVal){
                $ABCD = "A";
                foreach($row as $key => $val){
                    if($dtcolVal == nl2br($key)){
                        $row[$key] = $val ? PHPExcel_Shared_Date::PHPToExcel(strtotime($val)) : '';
                        $CI -> excel_180->getActiveSheet() ->getStyle($ABCD.$cnt) ->getNumberFormat() ->setFormatCode( PHPExcel_Style_NumberFormat::FORMAT_DATE_DDMMYYYY2 );
                    }
                    $ABCD++;
                }
            }
            array_push($headArray, $row);
        }
        
        $CI -> excel_180 -> getActiveSheet() -> fromArray($headArray, NULL, 'A1');
        $writeObj = PHPExcel_IOFactory::createWriter($CI -> excel_180, 'Excel5');
        header('Content-type: application/application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="' . $filename . '.xls"');
        $writeObj -> save('php://output'); //download file via browser
    }

    function exportUsingPhpExcelWithLink($array, $filename, $dateCols = array(), $colStringArray = array()) {
        ini_set('date.timezone', 'UTC');
        $CI = & get_instance();
        $CI -> load -> library('excel_180');
        
        $headArray[0] = array();
        foreach ($array as $row) {
            foreach ($row as $key => $val) {
                $key = str_replace("<br />","\n",$key);
                if (!in_array($key, $headArray[0])) {
                    $headArray[0][] = $key;
                }
            }
        }

        $ABCD = "A";
        foreach ($headArray[0] as $th){
            $CI -> excel_180 -> getActiveSheet() -> getColumnDimension($ABCD) -> setAutoSize(TRUE);
            $ABCD++;
        }

        $cnt = 1;
        foreach($array as $row){
            $cnt++;
            if(count($dateCols))
            foreach($dateCols as $dtcolKey => $dtcolVal){
                $ABCD = "A";
                foreach($row as $key => $val){
                    if($dtcolVal == nl2br($key)){
                        $row[$key] = $val ? PHPExcel_Shared_Date::PHPToExcel(strtotime($val)) : '';
                        $CI -> excel_180->getActiveSheet() ->getStyle($ABCD.$cnt) ->getNumberFormat() ->setFormatCode( PHPExcel_Style_NumberFormat::FORMAT_DATE_DDMMYYYY2 );
                    }
                    $ABCD++;
                }
            }
           
            // hyperlink for passport
            $ABCD = "A";
            foreach($row as $key => $val){
                if($key == "Passport" && !empty($val))
                {
                    if(strpos($val, 'http://') >= 0)
                    {
                        $val = str_replace('http://', '', $val);
                        $val = str_replace('www.', '', $val);
                    }
                    $CI -> excel_180->getActiveSheet()->getCell($ABCD.$cnt)->getHyperlink()->setUrl('http://www.' . $val);
                }
                $ABCD++;
            }
            array_push($headArray, $row);
        }
        
        // Instantiate our custom binder, with a list of columns, and tell PHPExcel to use it
        // Added on: 27-July-2017 SK
        if(!empty($colStringArray) && is_array($colStringArray))
            PHPExcel_Cell::setValueBinder(new PHPExcel_Cell_MyColumnValueBinder($colStringArray));
        
        $CI -> excel_180 -> getActiveSheet() -> fromArray($headArray, NULL, 'A1');
        
        $writeObj = PHPExcel_IOFactory::createWriter($CI -> excel_180, 'Excel5');
        header('Content-type: application/application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="' . $filename . '.xls"');
        $writeObj -> save('php://output'); //download file via browser
    }
}


