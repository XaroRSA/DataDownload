<?php global $path, $feed; ?>
<link href="/Modules/DataDownload/calendar/calendar.css" rel="stylesheet" type="text/css" />
<script language="javascript" src="/Modules/DataDownload/calendar/calendar.js"></script>


<form id="fileform" action="download.php" method="get" onsubmit="return false">
      
	  <select id="feedselect" name="feedselect" style="width:160px; margin:0px;">
		  <?php foreach ($feeds as $feed){ ?>
			<option value="<?php echo $feed['id']; ?>"><?php echo $feed['name']; ?></option>
		  <?php } ?>
      </select>
	  
	  <div id="calender"></div>
	
	<div id="Submit" class="btn btn-info">Download</div>
	
</form>


<script>
var path =   "<?php echo $path; ?>";
var feedselect = $("#feedselect").val();

$("#feedselect").change(function() {
	feedselect = $(this).val();
	$( "#calender" ).load(path+'DataDownload/calender','feedid='+feedselect);
});
  
$("#Submit").click(function() {

	feedselect = $("#feedselect").val();
	var fromdate =$( "#date3" ).val();
	var todate = $( "#date4" ).val();
	window.open(path+'DataDownload/download?feedid=' + feedselect + '&date3=' + fromdate + '&date4=' + todate);

});  
 jQuery(document).ready(function(){
	$( "#calender" ).load(path+'DataDownload/calender','feedid='+feedselect);
 });

</script>