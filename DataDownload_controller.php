<?php

function DataDownload_controller()
{
    global $mysqli, $user, $session, $route;
	
	global $feed;

	require "Modules/feed/feed_model.php";
	$feed = new Feed($mysqli);
  
	require "Modules/input/input_model.php";
	$input = new Input($mysqli,$feed);
    
	require "Modules/DataDownload/DataDownload_model.php";
	$filetest = new File();
	
	/** Include PHPExcel */
	require "Modules/DataDownload/PHPExcel/Classes/PHPExcel.php";
	
	$userid = $session['userid'];
	
	
	require "Modules/DataDownload/calendar/classes/tc_calendar.php";
	
	
	if ($route->action == 'download'){ 
		$date1 = strtotime($_GET["date3"]) * 1000;
		$date2 = strtotime($_GET["date4"]) * 1000;
		$feeddata=$feed->get_data($_GET["feedid"],$date1,$date2,0);
		//var_dump($feeddata);
		//TODO Filename is selected date
		//$test = $filetest->Download_File($feeddata,$date1.".xls","\t");
		
		$output=$filetest->PHPExcel_Filedownload_xls($feeddata);
		}
	
	else if ($route->action == 'calender'){ 
		//todo add for no feeds available
		$FirstLastDateTime=$feed->get_timevalue_firstlast($_GET["feedid"]);
		$calenderObjects = $filetest->Init_Calender($FirstLastDateTime);
		$filetest->Calender_Draw($calenderObjects);
		$output= "";
		}
    
	else { 
		$inputlist = $input->getlist($session['userid']);
		$feeds = $feed->get_user_feed_names($userid);
		//$cocks = $filetest->Draw_Calender($calenderObjects);
		//$feedsid = $feed->get_user_feed_ids($userid);
		$output = view("Modules/DataDownload/view.php", array('inputlist' => $inputlist, 'feeds'=>$feeds));
		}

    return array('content'=>$output);
}
