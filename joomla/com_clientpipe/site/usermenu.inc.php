<?php $jsurl = JURI::Base() . "?option=com_clientpipe"; ?>

<div class="ncUsermenu">
<ul>
<li><a href="<?php echo $jsurl ?>">Show Calendar</a></li>
<li><a href="<?php echo $jsurl ?>&view=uagenda">Show My Appointments</a></li>
<?php if($_REQUEST['view'] == 'clientpipe') { ?>
<li><a href="<?php echo $jsurl ?>">Go to Today</a></li>
<?php } ?>
</ul>
</div>
<div class="clear">&nbsp;</div>