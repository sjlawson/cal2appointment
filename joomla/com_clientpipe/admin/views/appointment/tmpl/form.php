<?php defined('_JEXEC') or die('Restricted access'); ?>

<form action="index.php" method="post" name="adminForm" id="adminForm">
<div class="col100">
	<fieldset class="adminform">
		<legend><?php echo JText::_( 'Details' ); ?></legend>

		<table class="admintable">
		<tr>
			<td width="100" align="right" class="key">
				<label for="firstname">
					First Name
				</label>
			</td>
			<td>
				<input class="text_area" type="text" name="firstname" id="firstname" size="32" maxlength="80" value="<?php echo $this->appointment->firstname;?>" />
			</td>	
			</tr>
			<tr>
			<td width="100" align="right" class="key">
				<label for="lastname">
					Last Name
				</label>
			</td>
			<td>
				<input class="text_area" type="text" name="lastname" id="lastname" size="32" maxlength="80" value="<?php echo $this->appointment->lastname;?>" />
			</td>	
			</tr>
				<tr>
			<td width="100" align="right" class="key">
				<label for="email">
					Email
				</label>
			</td>
			<td>
				<input class="text_area" type="text" name="email" id="email" size="32" maxlength="80" value="<?php echo $this->appointment->email;?>" />
			</td>	
			</tr>
				<tr>
			<td width="100" align="right" class="key">
				<label for="phone">
					Phone
				</label>
			</td>
			<td>
				<input class="text_area" type="text" name="phone" id="phone" size="32" maxlength="80" value="<?php echo $this->appointment->phone;?>" />
			</td>	
			</tr>
				<tr>
			<td width="100" align="right" class="key">
				<label for="app_date">
					Appointment Date
				</label>
			</td>
			<td> 
			<?php echo JHTML::calendar($this->appointment->app_date,'app_date','app_date','%Y-%m-%d'); ?>
			</td>	
			</tr>
		<tr>
			<td width="100" align="right" class="key">
				<label for="slot_id">
					Appointment Slot
				</label>
			</td>
			<td>
				<select name='slot_id' id='slot_id' >
				<option value='NULL' <?php if(!$this->appointment->appointment_id) echo "selected='selected'"; ?>  >Choose a slot</option>
		<?php foreach($this->objSlotList as $slot) {
			echo "<option value='".$slot->slot_id."' ";
			if ($this->appointment->slot_id == $slot->slot_id )
			echo "selected='selected' ";
			echo ">".$slot->slot_title."</option>\n";
			
		} ?>
		</select>
		</td></tr>
		<?php if ($this->appointment->req_staff_id) { ?>
		<tr>
		<td width="100" align="right" class="key">
				<label >
					Requested Staff
				</label>
			</td>
			<td>
			 <?php 
			 if(!isset($dbo))
			 $dbo =& JFactory::getDBO();
			 $dbo->setQuery('SELECT * FROM `#__cp_staff` WHERE `staff_id` = '.$this->appointment->req_staff_id);
			 $objReqStaff = $dbo->loadObject();
			 if($objReqStaff)
			 	echo $objReqStaff->firstname." ".$objReqStaff->lastname;
			 
			 ?>
			</td>
		</tr>
		<?php } ?>
		<tr>
			<td width="100" align="right" class="key">
				<label for="staff_id">
					Assign Staff
				</label>
			</td>
			<td>
				<select name='staff_id' id='staff_id' >
				<option value='NULL' <?php if(!$this->appointment->staff_id) echo "selected='selected'"; ?>  >Choose one</option>
		<?php foreach($this->objStaffList as $staff) {
			echo "<option value='".$staff->staff_id."' ";
			if ($this->appointment->staff_id == $staff->staff_id )
			echo "selected='selected' ";
			echo ">".$staff->firstname." ".$staff->lastname ."</option>\n";
			
		} ?>
		</select>
		</td></tr>
		
		<tr>
			<td width="100" align="right" class="key">
				<label for="notes">
					Notes
				</label>
			</td>
			<td>
			
				<textarea rows="4" cols="50" name="notes" id="notes" >
				<?php echo $this->appointment->notes;?>
			</textarea>
			</td>
		</tr>
	</table>
	</fieldset>
</div>
<div class="clr"></div>

<input type="hidden" name="option" value="com_clientpipe" />
<input type="hidden" name="appointment_id" value="<?php echo $this->appointment->appointment_id; ?>" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="controller" value="appointment" />
</form>
