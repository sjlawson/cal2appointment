<?php defined('_JEXEC') or die('Restricted access'); ?>
<form action="index.php" method="post" name="adminForm">
<div id="editcell">
<style type="text/css">
.ncMainMenu th {
	height: 33px;
	vertical-align: middle;
	width: 127px;
	text-align: center;
	background-image: url("/administrator/components/com_nucleocal/BlueBtn-alpha.png");
}
.ncMainMenu th a {
	color: white;
}
</style>
<table class="ncMainMenu">
<tr>
<th>
<?php $applink = JRoute::_( 'index.php?option=com_nucleocal&view=appointment'); ?>
<a href="<?php echo $applink ?>" >Appointments</a>
</th>
<th>
<?php $applink = JRoute::_( 'index.php?option=com_nucleocal&view=staff'); ?>
<a href="<?php echo $applink ?>" >Staff</a>
</th>
<th>
<?php $applink = JRoute::_( 'index.php?option=com_nucleocal&view=slot'); ?>
<a href="<?php echo $applink ?>" >Time Slots</a>
</th>
<th>
<?php $applink = JRoute::_( 'index.php?option=com_nucleocal&view=exception'); ?>
<a href="<?php echo $applink ?>" >Schedule Exceptions</a>
</th>
</tr>
</table>
	<table class="adminlist">
	<thead>
		<tr>
			<th width="5">Appointment
				<?php echo JText::_( 'ID' ); ?>
			</th>
			<th width="20">
				<input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count( $this->items ); ?>);" />
			</th>			
			<th>Name</th>
			<th>Email</th>
			<th>Phone</th>
			<th>Date</th>
			<th>Staff</th>
			<th>Slot ID</th>
			</tr>
	</thead>
	<?php
	$k = 0;
	for ($i=0, $n=count( $this->items ); $i < $n; $i++)	{
		$row = &$this->items[$i];
		$checked 	= JHTML::_('grid.id',   $i, $row->appointment_id );
		$link 		= JRoute::_( 'index.php?option=com_nucleocal&controller=appointment&task=edit&cid[]='. $row->appointment_id );
		?>
		<tr class="<?php echo "row$k"; ?>">
			<td>
				<?php echo $row->appointment_id; ?>
			</td>
			<td>
				<?php echo $checked; ?>
			</td>
			<td>
				<a href="<?php echo $link; ?>"><?php echo $row->firstname ." ".$row->lastname; ?></a>
			</td>
			<td>
				<?php echo $row->email; ?>
			</td>
			<td>
				<?php echo $row->phone; ?>
			</td>
			<td>
				<?php echo $row->app_date; ?>
			</td>
			<td>
				<?php 
				$objStaff = NucleocalModelAppointment::getStaff($row->staff_id);
				echo $objStaff->StaffName;
				//echo $row->staff_id; ?>
			</td>
			<td>
				<?php echo $row->slot_id; ?>
			</td>
		</tr>
		<?php
		$k = 1 - $k;
	}
	?>
	</table>
</div>

<input type="hidden" name="option" value="com_nucleocal" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="boxchecked" value="0" />
<input type="hidden" name="controller" value="appointment" />
</form>
