<?php
/*
 All Emoncms code is released under the GNU Affero General Public License.
 See COPYRIGHT.txt and LICENSE.txt.

 ---------------------------------------------------------------------
 Emoncms - open source energy visualisation
 Part of the OpenEnergyMonitor project:
 http://openenergymonitor.org
 */

// no direct access
defined('EMONCMS_EXEC') or die('Restricted access');

class File
{
    public function Download_File($data, $filename, $delimiter)
	{
	$i =0;
	$processeddata=array();
	foreach($data as $line){
		$processeddata[$i][0] = date('r', $line[0]/1000);
		$processeddata[$i][1] = $line[1];
		$i++;
	}
	
    // open raw memory as file so no temp files needed, you might run out of memory though
    $f = fopen('php://memory', 'w'); 
    // loop over the input array
    foreach ($processeddata as $line) { 
        // generate csv lines from the inner arrays
        fputcsv($f, $line, $delimiter); 
    }
    // rewrind the "file" with the csv lines
    fseek($f, 0);
    // tell the browser it's going to be a csv file
    //header('Content-Type: application/csv');
	header("Content-Type: application/vnd.ms-excel");
	
    // tell the browser we want to save it instead of displaying it
   header('Content-Disposition: attachement; filename="'.$filename.'"');
	
    // make php send the generated csv lines to the browser
    fpassthru($f);	
	fclose($f);
	return ;
	}
	
	public function PHPExcel_Filedownload_xls($feeddata)
	{
		// Create new PHPExcel object
		$objPHPExcel = new PHPExcel();

		// Set document properties
		$objPHPExcel->getProperties()
									->setCreator("Electron Flow Design");
/* 									 ->setLastModifiedBy("Maarten Balliauw")
									 ->setTitle("Office 2007 XLSX Test Document")
									 ->setSubject("Office 2007 XLSX Test Document")
									 ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
									 ->setKeywords("office 2007 openxml php")
									 ->setCategory("Test result file"); */


		// Add some data
		
		$i =0;
		$processeddata=array();
		foreach($feeddata as $line){
		$processeddata[$i][0] = date('r', $line[0]/1000);
		$processeddata[$i][1] = $line[1];
		$i++;
	}
		$objPHPExcel->getActiveSheet()->fromArray($processeddata, NULL, 'A1');
		// Rename worksheet
		$objPHPExcel->getActiveSheet()->setTitle('Simple');


		// Set active sheet index to the first sheet, so Excel opens this as the first sheet
		$objPHPExcel->setActiveSheetIndex(0);


		// Redirect output to a client’s web browser (Excel5)
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="01simple.xls"');
		header('Cache-Control: max-age=0');
		// If you're serving to IE 9, then the following may be needed
		header('Cache-Control: max-age=1');

		// If you're serving to IE over SSL, then the following may be needed
		header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
		header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
		header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
		header ('Pragma: public'); // HTTP/1.0

		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save('php://output');
		exit;
	}
	
	public function Calender_Draw($calenderObjects){
		foreach ($calenderObjects as $item){
				$item->writeScript();
		}
		exit;
	}
	
	public function Init_Calender($FirstLastDateTime)
	{
		
	  $datefirst= gmdate("Y-m-d", $FirstLastDateTime[0]);
	  $datelast= gmdate("Y-m-d", $FirstLastDateTime[1]);
	  
	  $date3_default = $datefirst;
      $date4_default = $datelast;

	  $myCalendar1 = new tc_calendar("date3", true, false);
	  $myCalendar1->setIcon("Modules/DataDownload/calendar/images/iconCalendar.gif");
	  $myCalendar1->setDate(date('d', strtotime($date3_default))
            , date('m', strtotime($date3_default))
            , date('Y', strtotime($date3_default)));
	  $myCalendar1->setPath("/Modules/DataDownload/calendar/");
	  $myCalendar1->dateAllow($datefirst,$datelast);
	  $myCalendar1->setYearInterval(1970, 2020);
	  $myCalendar1->setAlignment('left', 'bottom');
	  $myCalendar1->setDatePair('date3', 'date4', $date4_default);
	  //var_dump($myCalendar1);
	 // $myCalendar1->writeScript();	  
	  
	  $myCalendar2 = new tc_calendar("date4", true, false);
	  $myCalendar2->setIcon("Modules/DataDownload/calendar/images/iconCalendar.gif");
	  $myCalendar2->setDate(date('d', strtotime($date4_default))
           , date('m', strtotime($date4_default))
           , date('Y', strtotime($date4_default)));
	  $myCalendar2->setPath("/Modules/DataDownload/calendar/");
	  $myCalendar2->dateAllow($datefirst,$datelast);
	  $myCalendar2->setYearInterval(1970, 2020);
	  $myCalendar2->setAlignment('left', 'bottom');
	  $myCalendar2->setDatePair('date3', 'date4', $date3_default);
	 // $myCalendar2->writeScript();	
	 $calenderArray = Array($myCalendar1,$myCalendar2);
	 return $calenderArray;
	 
	}
}
