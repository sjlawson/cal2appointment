<?php // no direct access
defined('_JEXEC') or die('Restricted access');


if(strpos($_SERVER['REQUEST_URI'],'?'))
$jsurl=substr($_SERVER['REQUEST_URI'],0,strpos($_SERVER['REQUEST_URI'],'?'));
else
$jsurl=$_SERVER['REQUEST_URI'].'?';
if(!strpos($jsurl,'?'))
$jsurl .= "?";

$path = $_SERVER['PATH_TRANSLATED'];


$currPage = $jsurl;
$comWebPath = "components" . DS . "com_clientpipe" . DS;



JHTML::script('cleanValidator.js', $comWebPath );
JHTML::stylesheet('clientpipe.css', $comWebPath ); 
JHTML::script('hintbox.js', $comWebPath );

?>
<div class="clientpipe" style="" align="center">
<?php 
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


include(JPATH_COMPONENT_SITE . DS . 'usermenu.inc.php');
if(!isset($_REQUEST['slotid']) || $_REQUEST['slotid'] == "" || !isset($_REQUEST['tsdate']) || $_REQUEST['tsdate'] == "") {
	echo "<h3>Sorry, there was an error in the data that was submitted</h3>";
}
	
	
	$slot_id = $_REQUEST['slotid'];
	$tsdate = $_REQUEST['tsdate'];
	$strDateDisplay = date("d-M-Y", $tsdate);
	$strDate = date("Y-m-d", $tsdate);
	$month = date("m", $tsdate);
	$year = date("Y", $tsdate );
	
	//first check that the day is open
	$strQuery = "SELECT * FROM `#__cp_exception` WHERE `exception_date` LIKE '$strDate%' AND all_off = 1";
	$dbo->setQuery($strQuery);
	$objAllOff = $dbo->loadObject();
	if($objAllOff) {
		echo "<h3>Sorry, the selected date/time slot is unavailable</h3>";
		exit;
	}
	
	$strQuery = "SELECT * FROM `#__cp_slot` WHERE `slot_id` = $slot_id";
	$dbo->setQuery($strQuery);
	$objSlot = $dbo->loadObject();
	
	$strQuery = "SELECT * FROM `#__cp_exception` WHERE `exception_date` LIKE '$strDate%' AND slot_id = $slot_id";
	$dbo->setQuery($strQuery);
	$objException = $dbo->loadObject();
	
	$strQuery = "SELECT s.* FROM `#__cp_staff` s, `#__cp_slot_alloc` a 
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
	if(!in_array(date('D',$tsdate),$slotWeekdays) ) {
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
	From <?php echo date("g:ia" , strtotime(date('Y-m-d',$tsdate)." ".$objSlot->time_start) );
		if($objSlot->time_end)
			 echo " to ".date("g:ia" , strtotime(date('Y-m-d',$tsdate)." ".$objSlot->time_end) );
			 ?>
	</div>
	<br />
	<?php 
if(strpos($_SERVER['REQUEST_URI'],"?"))
$relativeBaseUrl = substr($_SERVER['REQUEST_URI'],0,strpos($_SERVER['REQUEST_URI'],"?") );
else 
$relativeBaseUrl = $_SERVER['REQUEST_URI'];

//echo "$relativeBaseUrl = ".$_SERVER['REQUEST_URI'];
?>
		
	<form name='appointment' id='appointment' action='<?php echo JURI::Base() . "?option=com_clientpipe"; ?>' method="post" >
	<input type="hidden" name='ncFormtoken' value="<?php echo md5("clientpipe"); ?>" />
	<input type="hidden" name="slot_id" value="<?php echo $slot_id ?>" />
	<input type="hidden" name="app_date" value="<?php echo $strDate ?>" />
	<input type="hidden" name="strAppTime" value="<?php 
				echo date("g:ia" , strtotime(date('Y-m-d',$tsdate)." ".$objSlot->time_start) );
				if($objSlot->time_end)
					 echo " to ".date("g:ia" , strtotime(date('Y-m-d',$tsdate)." ".$objSlot->time_end) ) ?>" /> 
					 
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
	<tr><td colspan='2'></td></tr>
	<tr><td>
	<input type="submit" value="Schedule Appointment" />
	
	</form>
	<!-- <a class='AppointmentLinkButton' style="cursor:pointer;" onclick="appointment.submit();" >
	Schedule Appointment</a> --> 
	</td>
	<td align="right">
	<a class='AppointmentLinkButton' style="cursor:pointer;" onclick="document.location.href='<?php echo $relativeBaseUrl ?>?month=<?php echo $month ?>&year=<?php echo $year ?>';">Cancel</a>
	
	</td></tr>
	</table>
		
	

<script type="text/javascript">
		 cleanValidator.init({
		        formId: 'appointment',
		        inputColors: ['#EDEDED', '#FFFFFF'],
		        errorColors: ['#FFFF99', '#CF3339'],
		        isRequired: ['Firstname','Lastname','Email','Phone'],
		        isEmail: ['Email']
		    });
				
</script>
	</div>