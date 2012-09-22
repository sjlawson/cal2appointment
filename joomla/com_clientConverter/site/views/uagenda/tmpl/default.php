<?php // no direct access
defined('_JEXEC') or die('Restricted access');
include(JPATH_COMPONENT_SITE . DS . 'usermenu.inc.php');


if(!isset($user))
$user =& Jfactory::getUser();

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


if(strpos($_SERVER['REQUEST_URI'],"?"))
$relativeBaseUrl = substr($_SERVER['REQUEST_URI'],0,(strpos($_SERVER['REQUEST_URI'],"?") ) );
else 
$relativeBaseUrl = $_SERVER['REQUEST_URI'];


if(strpos($_SERVER['REQUEST_URI'],'?'))
$jsurl=substr($_SERVER['REQUEST_URI'],0,strpos($_SERVER['REQUEST_URI'],'?'));
else
$jsurl=$_SERVER['REQUEST_URI'].'?';
if(!strpos($jsurl,'?'))
$jsurl .= "?";

$path = $_SERVER['PATH_TRANSLATED'];
$currPage = $jsurl;
$comWebPath = "components" . DS . "com_nucleocal" . DS;

// <link rel="stylesheet" type="text/css" href="<?php echo $comWebPath; nucleoCal.css" />
//<script type="text/javascript" src="<?php echo $comWebPath; hintbox.js" ></script>

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

function bookAppointment(slot_id, timestamp) {
	  var dt = new Date(timestamp * 1000);
	  var mm = mmToMonth[dt.getMonth()];
	  var stringDate = dt.getDate() + "-" + mm + "-" + dt.getFullYear() ;
	  var url = "<?php echo $jsurl ?>" + "slotid=" + slot_id + "&tsdate=" + timestamp; 
	  //alert(url);
	  getNewContent(url,'calendarDiv');
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

if($ncOptions['display_title'])
echo "<div class='ncTitle'>".$this->ncTitle."</div>";

if($ncOptions['display_greeting'])
echo "<div class='ncGreeting'>".$this->greeting."</div>";


?>

</div>
<?php 
if($this->appointments){ ?>
	<table class='userAgenda'><tr>
	<th>Date</th><th>Time Slot</th><th><?php echo $this->ncOptions['staff_display_title'] ?> </th><th>Notes</th></tr>
	
<?php 	foreach($this->appointments as $item ) {
		echo "<tr><td>".date("d M Y", strtotime($item->app_date))."</td>
		<td>".date("g:ia",strtotime($item->StartTime));
		if($item->EndTime)
			echo " to ".date("g:ia",strtotime($item->EndTime));
		echo "</td><td>";
		
		if($item->staff_id) {
		 $Staff = NucleocalModelUagenda::getStaff($item->staff_id);
		 echo $Staff->StaffName;	 
		} else echo "unassigned";
		
		echo "</td>";
			
		if($item->notes) echo "<td>".$item->notes."</td></tr>";
			else echo "<td>none</td></tr>";
		
	}
	?>
	</table>
	<?php 
} else if(!$user->guest) {
	echo "<h3>No appointments have been scheduled</h3>";
} else {
	echo "<h3>Please sign-in or create an account to view your scheduled appointments.</h3>";
}
?>
</div>
 </div>
