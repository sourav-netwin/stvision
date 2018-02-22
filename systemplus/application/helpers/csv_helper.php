<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// ------------------------------------------------------------------------

/**
 * CSV Helpers
 * Inspiration from PHP Cookbook by David Sklar and Adam Trachtenberg
 * 
 * @author		J�r�me Jaglale
 * @link		http://maestric.com/en/doc/php/codeigniter_csv
 */

// ------------------------------------------------------------------------

/**
 * Array to CSV
 *
 * download == "" -> return CSV string
 * download == "toto.csv" -> download file toto.csv
 */
if ( ! function_exists('array_to_csv'))
{
	function array_to_csv($array, $download = "")
	{
	
		/*
		if ($download != "")
		{	
			header('Content-Type: application/csv');
			header('Content-Encoding: UTF-8');
			header('Content-Type: text/csv; charset=UTF-8');
			header('Content-Disposition: attachement; filename="' . $download . '"');
		}	
		*/

		ob_start();
		$uniqueName = CMCSV_PATH;
		$f = fopen($uniqueName, 'w+') or show_error("Can't write file");
		$n = 0;		
		foreach ($array as $line)
		{
			$n++;
			if ( ! fputcsv($f, $line,';'))
			{
				show_error("Can't write line $n: $line");
			}
		}
		fclose($f) or show_error("Can't close file");
		$str = ob_get_contents();
		ob_end_clean();

		/*
		if ($download == "")
		{
			return $str;	
		}
		else
		{	
			echo $str;
		}	
		*/
		
		return $uniqueName;
		
	}
}

// ------------------------------------------------------------------------

/**
 * Query to CSV
 *
 * download == "" -> return CSV string
 * download == "toto.csv" -> download file toto.csv
 */
if ( ! function_exists('query_to_csv'))
{
	function query_to_csv($query, $headers = TRUE, $download = "")
	{
		if ( ! is_object($query) OR ! method_exists($query, 'list_fields'))
		{
			show_error('invalid query');
		}
		
		$array = array();
		
		if ($headers)
		{
			$line = array();
			foreach ($query->list_fields() as $name)
			{
				$line[] = $name;
			}
			$array[] = $line;
		}
		
		foreach ($query->result_array() as $row)
		{
			$line = array();
			foreach ($row as $item)
			{
				$line[] = $item;
			}
			$array[] = $line;
		}

		echo array_to_csv($array, $download);
	}
}

if ( ! function_exists('array_to_csv_export'))
{
/**
 * array_to_csv_export
 * This function can be use to export array content in csv file 
 *
 * @param array $array data to write into csv
 * @param string $download to force download of the file you can pass second parameter as downloadable file name
 * @param boolean $keep_file to remove this file from server pass last param as FALSE else file will be saved to server by default.
 * @return string 
 */
function array_to_csv_export($array, $download = "",$keep_file = true)
	{
	
		
		if ($download != "")
		{	
			header('Content-Type: application/csv');
			header('Content-Encoding: UTF-8');
			header('Content-Type: text/csv; charset=UTF-8');
			header('Content-Disposition: attachement; filename="' . $download . '"');
		}	
		

		ob_start();
		//$uniqueName = "/var/www/html/www.plus-ed.com/vision_ag/downloads/export_csv/".time()."_pax_list.csv";
		$uniqueName = "downloads/export_csv/".time()."_pax_list.csv";
		$f = fopen($uniqueName, 'w+') or show_error("Can't write file");
		$n = 0;		
                $h = array();
                $headerSet = 0;
		foreach ($array as $line)
		{
                    foreach($line as $key=>$val){
                    if(!in_array($key, $h)){
                    $h[] = $key;   
                    }
                    }
                    if(!$headerSet)
                    if ( ! fputcsv($f, $h,';'))
                    {
                            show_error("Can't write line $n: $line");
                    }
                    else
                        $headerSet = 1;
                    
			$n++;
			if ( ! fputcsv($f, $line,';'))
			{
				show_error("Can't write line $n: $line");
			}
		}
		fclose($f) or show_error("Can't close file");
		$str = ob_get_contents();
		ob_end_clean();
                $str = file_get_contents($uniqueName, true);
                
		
		if ($download == "")
		{
			return $str;	
		}
		else
		{	
			echo $str;
                        if(!$keepFile)
                            @unlink($uniqueName);
		}	
		
		
		return $uniqueName;
		
	}
}

/* End of file csv_helper.php */
/* Location: ./system/helpers/csv_helper.php */