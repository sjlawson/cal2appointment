<?php defined('_JEXEC') or die('Restricted access'); 
if(!isset($dbo))
$dbo =& JFactory::getDBO();

$sql = "SELECT * FROM `#__cp_staff` ORDER BY `lastname` ";
$dbo->setQuery($sql);
$objStaffList = $dbo->loadObjectList();

$sql = "SELECT * FROM `#__cp_slot` ORDER BY `default_slot`, `time_start` ";
$dbo->setQuery($sql);
$objSlotList = $dbo->loadObjectList();


//	<input class="text_area" type="text" name="slot_title" id="slot_title" size="32" maxlength="80" value="<?php echo $this->slot->slot_title;

?>
<form action="index.php" method="post" name="adminForm" id="adminForm">
<div class="col100">
	<fieldset class="adminform">
		<legend><?php echo JText::_( 'Details' ); ?></legend>

		<table class="admintable">
		<tr>
			<td width="100" align="right" class="key">
				<label for="slot_id">
					Slot <br />
					<small>(optional)</small>
				</label>
			</td>
			<td>
			<select name="slot_id" id="slot_id" >
			<option value="NULL" <?php if(!$this->exception->slot_id) echo "selected='selected' "; ?> >Choose one</option>
			<?php 
			foreach($objSlotList as $slot ) {
				echo "<option value='".$slot->slot_id."' ";
				if($slot->slot_id == $this->exception->slot_id)
					echo "selected='selected' ";
				echo ">".$slot->slot_title."</option>";
			}
			
			?>
			
			</select>
			</td>	
			</tr>
			<tr>
				
			</tr>
				<tr>
			<td width="100" align="right" class="key">
				<label for="exception_date">
					Date of exception 
				</label>
			</td>
			<td> 
			<?php  echo JHTML::calendar($this->exception->exception_date,'exception_date','exception_date','%Y-%m-%d'); ?>			
			</td>	
			</tr>
			
		<tr>
			<td width="100" align="right" class="key">
				<label for="on_staff_id_csv">
					Staff ON schedule
				</label>
			</td>
			<td>
			
				<select multiple name='on_staff_id_csv[]' id='on_staff_id_csv' size='10' >
				<option value="">none</option>
				<?php 
				$staffIdArray = explode(',',$this->exception->on_staff_id_csv);
				foreach($objStaffList as $staff) {
				echo "<option value='".$staff->staff_id."' ";
				if(in_array($staff->staff_id,$staffIdArray)) 
					echo " selected='selected' ";
				echo ">".$staff->firstname." ".$staff->lastname ."</option>";
				}
				?>
		</select>
		</td></tr>
		<tr>
			<td width="100" align="right" class="key">
				<label for="off_staff_id_csv">
					Staff OFF schedule
				</label>
			</td>
			<td>
			
				<select multiple name='off_staff_id_csv[]' id='off_staff_id_csv' size='10' >
				<option value="">none</option>
				<?php 					
				$staffIdArray = explode(',',$this->exception->off_staff_id_csv);
				
				foreach($objStaffList as $staff) {
				echo "<option value='".$staff->staff_id."' ";
				if( in_array($staff->staff_id,$staffIdArray) ) 
					echo " selected='selected' ";
				echo ">".$staff->firstname." ".$staff->lastname ."</option>";
				}
				?>
		</select>
		</td></tr>
		<tr>
			<td width="100" align="right" class="key">
				<label for="all_off">
					All Off<br />
					<small>Date is req'd, leave "slot" blank to schedule the whole day off, <br />
					or select a slot to only schedule off one slot.</small> 
				</label>
			</td>
			<td>
				<input type="checkbox" name="all_off" id="all_off" value='1' <?php if($this->exception->all_off) echo "checked='true' "; ?> />			
			</td>
		</tr>
		<tr>
			<td width="100" align="right" class="key">
				<label for="openings">
					Openings in this slot
				</label>
			</td>
			<td>
				<input class="text_area" type="text" name="openings" id="openings" size="32" maxlength="80" value="<?php echo $this->exception->openings;?>" />
			
			</td>
		</tr>
	</table>
	</fieldset>
</div>
<div class="clr"></div>

<input type="hidden" name="option" value="com_clientpipe" />
<input type="hidden" name="exception_id" value="<?php echo $this->exception->exception_id; ?>" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="controller" value="exception" />
</form>
