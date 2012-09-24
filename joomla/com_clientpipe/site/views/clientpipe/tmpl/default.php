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

$jsurl = JURI::Base() . "?option=com_clientpipe";

$currPage = $jsurl;
$comWebPath =  JURI::Base() . "components" . DS . "com_clientpipe" . DS;

include(JPATH_COMPONENT_SITE . DS . 'usermenu.inc.php');

JHTML::script('cleanValidator.js', $comWebPath );
JHTML::stylesheet('clientpipe.css', $comWebPath ); 

?>

<script type="text/javascript">

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
	  var url = "<?php echo $currPage?>" + "&view=appform" + "&slotid=" + slot_id + "&tsdate=" + timestamp; 
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

<div class="clientpipe" style="" align="center">
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

<table style="display: none;" border="0" 
style="border: black 10px groove; background-color: #dfe0af; width: 700px" ><tr>
<td align="center" colspan="2"><h2></h2></td></tr>
<tr><td colspan="2" style="text-align:center;color: black;" height="20">Select Month &amp; Year:
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
