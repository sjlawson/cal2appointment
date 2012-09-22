<?php // no direct access
defined('_JEXEC') or die('Restricted access');


if($_REQUEST['month'])
$month = $_REQUEST['month'];
else
$month = date('m');
if($_REQUEST['year'])
$year = $_REQUEST['year'];
else
$year = date('Y');

if(!isset($dbo))
$dbo =& JFactory::getDBO();

$oCalendar = new inc_calendar();
$oCalendar->dateNow($month,$year);
$oCalendar->loadOptions();

if(strpos($_SERVER['REQUEST_URI'],"?"))
$relativeBaseUrl = substr($_SERVER['REQUEST_URI'],0,(strpos($_SERVER['REQUEST_URI'],"?") ) );
else 
$relativeBaseUrl = $_SERVER['REQUEST_URI'];
/*
if(isset($_REQUEST['slotid']) && $_REQUEST['slotid'] != "" && isset($_REQUEST['tsdate']) && $_REQUEST['tsdate'] != "") {
	
	
	$slot_id = $_REQUEST['slotid'];
	$tsdate = $_REQUEST['tsdate'];
	$strDateDisplay = date("d-M-Y", $tsdate);
	$strDate = date("Y-m-d", $tsdate);
	$month = date("m", $tsdate);
	$year = date("Y", $tsdate );
	
	//first check that the day is open
	$strQuery = "SELECT * FROM `#__nc_exception` WHERE `exception_date` LIKE '$strDate%' AND all_off = 1";
	$dbo->setQuery($strQuery);
	$objAllOff = $dbo->loadObject();
	if($objAllOff) {
		echo "<h3>Sorry, the selected date/time slot is unavailable</h3>";
		exit;
	}
	
	$strQuery = "SELECT * FROM `#__nc_slot` WHERE `slot_id` = $slot_id";
	$dbo->setQuery($strQuery);
	$objSlot = $dbo->loadObject();
	
	$strQuery = "SELECT * FROM `#__nc_exception` WHERE `exception_date` LIKE '$strDate%' AND slot_id = $slot_id";
	$dbo->setQuery($strQuery);
	$objException = $dbo->loadObject();
	
	$strQuery = "SELECT s.* FROM `#__nc_staff` s, `#__nc_slot_alloc` a 
			WHERE (a.`slot_id` = $slot_id 
			AND a.`staff_id` = s.`staff_id` ";
	
	if($objException && $objException->off_staff_id_csv)
		$strQuery .= " AND s.`staff_id` NOT IN (". $objException->off_staff_id_csv .") ";
	
	$strQuery .= ' ) ';
	
	if($objException && $objException->on_staff_id_csv)
		$strQuery .= "OR s.`staff_id` IN (". $objException->on_staff_id_csv .")";
		
	$dbo->setQuery($strQuery);
	$objStaffList = $dbo->loadObjectList();
	

	
	
	$slotWeekdays = explode(',',$objSlot->weekdays_csv);
	if(!in_array(date('D'),$slotWeekdays) ) {
			echo "<h3>Sorry, the selected date/time slot is unavailable on that day of the week</h3>";
		exit;
	}
	
	if(!$objSlot) {
		echo "<h3>Sorry, the selected date/time slot is unavailable</h3>";
		exit;
	}
	
	?>
	
	<div class="appointmentTitle">
	Booking appointment on <?php echo $strDateDisplay ?><br />
	From <?php echo date("g:ia" , strtotime(date('Y-m-d')." ".$objSlot->time_start) );
		if($objSlot->time_end)
			 echo " to ".date("g:ia" , strtotime(date('Y-m-d')." ".$objSlot->time_end) );
			 ?>
	</div>
	<br />
		
	<form name='appointment' id='appointment' action='<?php $relativeBaseUrl ?>' method="post" >
	<input type="hidden" name='ncFormtoken' value="<?php echo md5("nucleocal"); ?>" />
	<input type="hidden" name="slot_id" value="<?php echo $slot_id ?>" />
	<input type="hidden" name="app_date" value="<?php echo $strDate ?>" />
	<input type="hidden" name="strAppTime" value="<?php 
				echo date("g:ia" , strtotime(date('Y-m-d')." ".$objSlot->time_start) );
				if($objSlot->time_end)
					 echo " to ".date("g:ia" , strtotime(date('Y-m-d')." ".$objSlot->time_end) ) ?>" /> 
					 
	<table border='0' class='appointmentFormTable'>
	<?php if($oCalendar->nc_options['show_staff']) { ?>
	<tr><th>Preferred <?php echo $oCalendar->nc_options['staff_display_title']; ?></tr>
	<tr>
	<td align="left">
	<select name="req_staff_id">
		<option value="NULL" selected="selected">Choose one</option>
		<?php 
		$stafflist = "";
		if(isset($_REQUEST['staffid']))
		 $reqStaff = $_REQUEST['staffid'];
		else $reqStaff = null;
			foreach($objStaffList as $staff) {
				$stafflist .= $staff->staff_id.",";
				
				echo "<option value='".$staff->staff_id."' ";
				if($reqStaff == $staff->staff_id)
					echo "selected='selected'";
				echo " >".$staff->firstname." ".$staff->lastname."</option>\n";
			}
		$stafflist = substr($stafflist,0,-2);
		
		?>
		
	</select>
	<input type="hidden" name="stafflist" value="<?php echo $stafflist ?>" />
	</td>
	
	<?php } else {
		$stafflist = "";
			foreach($objStaffList as $staff) {
				$stafflist .= $staff->staff_id.",";
			}
			//echo "Stafflist: $stafflist";
		$stafflist = substr($stafflist,0,-1);
		?>
	<input type="hidden" name="stafflist" value="<?php echo $stafflist ?>" />
	<input type="hidden" name="req_staff_id" value="NULL" />
	<?php } ?>
	</tr>
	<tr>
	<th>First Name: <span style="color: red;font-weight:bold">*</span></th>
	<td align="left"><input type="text" id="Firstname" name="firstname" size="20" /></td></tr>
	<tr>
	<th>Last Name: <span style="color: red;font-weight:bold">*</span></th>
	<td align="left"><input type="text" id="Lastname" name="lastname" size="20" /></td></tr>
	<tr>
	<th>Email: <span style="color: red;font-weight:bold">*</span></th>
	<td align="left"><input type="text" id="Email" name="email" size="40" /></td></tr>
	<tr>
	<th>Phone: <span style="color: red;font-weight:bold">*</span></th>
	<td align="left"><input type="text" id="Phone" name="phone" size="20" /></td></tr>
	<tr>
	<th colspan='2'>Notes and other information: </th></tr>
	<tr>
	<td colspan='2'><textarea rows="4" cols="40" name="notes" ></textarea>  </td></tr>
	<tr><td>
	<a class='AppointmentLinkButton' style="cursor:pointer;" onclick="submitApp();" >
	Schedule Appointment</a> </td>
	<td align="right">
		<a class='AppointmentLinkButton' href="<?php echo $relativeBaseUrl ?>?month=<?php echo $month ?>&year=<?php echo $year ?>" >
	Cancel</a>
	</td></tr>
	</table>

	
	</form>
<script type="text/javascript">
		 cleanValidator.init({
		        formId: 'appointment',
		        inputColors: ['#EDEDED', '#FFFFFF'],
		        errorColors: ['#FFFF99', '#CF3339'],
		        isRequired: ['Firstname','Lastname','Email','Phone'],
		        isEmail: ['Email']
		    });
				
function submitApp() {
    
     appointment.submit();
}
</script>
	<?php
	exit;
}
*/

 
/*
if(!strpos( $_SERVER['REQUEST_URI'] , "?"))
	$jsurl = $_SERVER['REQUEST_URI']."?";
else 
	$jsurl = $_SERVER['REQUEST_URI']."&";
*/
if(strpos($_SERVER['REQUEST_URI'],'?'))
$jsurl=substr($_SERVER['REQUEST_URI'],0,strpos($_SERVER['REQUEST_URI'],'?'));
else
$jsurl=$_SERVER['REQUEST_URI'].'?';
if(!strpos($jsurl,'?'))
$jsurl .= "?";

//$currPage = $_SERVER['QUERY_STRING'];
$path = $_SERVER['PATH_TRANSLATED'];
//$currPage = $path."?".$currPage."&";

//$currPage = "$path?option=com_nucleocal&";

$currPage = $jsurl;
$comWebPath = "components" . DS . "com_nucleocal" . DS;
//$comWebPath = str_replace($_SERVER['DOCUMENT_ROOT'],"",DS. JPATH_COMPONENT . DS);

include(JPATH_COMPONENT_SITE . DS . 'usermenu.inc.php');
/*
 * 
<link rel="stylesheet" type="text/css" href="<?php echo $comWebPath; ?>nucleoCal.css" />

<script type="text/javascript" src="<?php echo $comWebPath; ?>hintbox.js" ></script>

 */
JHTML::script('cleanValidator.js', $comWebPath );
JHTML::stylesheet('nucleoCal.css', $comWebPath ); 
JHTML::script('hintbox.js', $comWebPath );

?>

<script language="javascript">

var http = createRequestObject();
function createRequestObject() {
var objAjax;
var browser = navigator.appName;
if(browser == "Microsoft Internet Explorer") {
          objAjax = new ActiveXObject("Microsoft.XMLHTTP");
     }
else {
          objAjax = new XMLHttpRequest();
     }

return objAjax;
}


function getNewContent(url,element) {
     http.open('get',url);
     http.onreadystatechange = function () {
if(http.readyState == 4) {
               document.getElementById(element).innerHTML = http.responseText;
          }
     }
     http.send(null);
return false;
}

var mmToMonth = new Array("Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec");

function bookAppointment(slot_id, timestamp, staffid) {
	  var dt = new Date(timestamp * 1000);
	  var mm = mmToMonth[dt.getMonth()];
	  var stringDate = dt.getDate() + "-" + mm + "-" + dt.getFullYear() ;
	  var url = "<?php echo $jsurl ?>" + "view=appform" + "&slotid=" + slot_id + "&tsdate=" + timestamp; 
	  if(staffid)
		  url += "&staffid=" + staffid;
	  //alert(url);
	  //getNewContent(url,'calendarDiv');
	  document.location.href = url;
}

function showCalRow(rownum) {
	var i;
	
	for(i=1;i<=6;i++) {
		if(document.getElementById("calrow"+i)){
			document.getElementById("calrow"+i).className = "rowMinimise";
		}
	}
	
	document.getElementById("calrow"+rownum).className = "rowMaximise";
}


function showPrevMonth()
{
	document.cform.mon.value="" + "<?php echo $month; ?>";
	document.cform.yr.value="" + "<?php echo $year;?>";
	if(document.cform.mon.value == "")
	{
		getMonthYear();
	}
	m = eval(document.cform.mon.value + "-" + 1);
  y = document.cform.yr.value;
	if(m < 1)
	{
		m = 12;
		y = eval(y + "-" + 1);
	}
	window.location.href="<?php echo $currPage?>month=" + m + "&year=" + y;
}
function showNextMonth()
{
	document.cform.mon.value="" + "<?php echo $month; ?>";
	document.cform.yr.value="" + "<?php echo $year;?>";
	if(document.cform.mon.value == "")
	{
		getMonthYear();
	}
	m = eval(document.cform.mon.value + "+" + 1);
  y = document.cform.yr.value;
	if(m > 12)
	{
		m = 1;
		y = eval(y + "+" + 1);
	}
	window.location.href="<?php echo $currPage?>month=" + m + "&year=" + y;
}
function getMonthYear()
{
		cdate = new Date();
		mvalue = cdate.getMonth();
		yvalue = cdate.getYear();
		document.cform.mon.value = mvalue;
		document.cform.yr.value = yvalue;
}

</script>

<div class="nucleoCal" style="" align="center">
 <div class="headerspace">
 <?php 
if($this->resultMsg != "")
echo "<div class='resultMessage'>".$this->resultMsg."</div><br />";

if($oCalendar->nc_options['display_title'])
echo "<div class='ncTitle'>".$this->ncTitle."</div>";

if($oCalendar->nc_options['display_greeting'])
echo "<div class='ncGreeting'>".$this->greeting."</div>";
?>

</div>


<form name="cform" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">

<table style="display: none;"  width="700" cellpadding="0" cellspacing="0" border="0" 
style="border: black 10px groove;" bgcolor="#dfe0af"><tr>
<td align="center" colspan="2"><h2></h2></td></tr>
<tr><td colspan="2" style="text-align:center;color: black;" height="20">Select Month & Year:
<select name="month">
	<option value=""></option>
<?php
	for($i=1;$i<=12;$i++) {
		print '<option value="'.$i.'" ';
			if($i == date('n'))	
				print " selected='selected' ";
		print '>'.$i. '</option>';
	}
?>

</select>
&nbsp;&nbsp;&nbsp;
<select name="year">
	<option value=""></option>
<?php
	for($i=date('Y')-1;$i<date('Y')+10;$i++) {
		print '<option value="'.$i.'"';
			if($i == date('Y'))
				print " selected='selected' ";
		print '>'.$i. '</option>';
	}
?>
</select>
&nbsp;&nbsp;&nbsp;
<input type="submit" value="Show">
</td></tr>
<tr>
<td><input type="button" name="prev" value="<<Prev" onclick="showPrevMonth();"></td>
<td align="right"><input type="button" name="next" value="Next>>" onclick="showNextMonth();">
<input type="hidden" name="mon"><input type="hidden" name="yr"></td>
</tr></table>
</form>
<br />
<div id="calendarDiv" >

<?
if(strlen((string)$month) == 1) $month = "0".$month;
$oCalendar->showThisMonth($month,$year);
?>
</div>
 </div>
