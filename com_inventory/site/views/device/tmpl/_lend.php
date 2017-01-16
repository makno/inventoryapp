<?php
/**
 * @package     it+kapfenberg
 * @subpackage  com_inventory
 *
 * @copyright   Copyright (C) 2013 Mathias Knoll All rights reserved.
 * @license     GNU AFFERO GENERAL PUBLIC LICENSE Version 3; see LICENSE.txt
 */
?>
<div id="lendDeviceModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="lendDeviceModalLabel" aria-hidden="true">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
		<h3 id="myModalLabel"><?php echo JText::_('COM_INVENTORY_LEND_DEVICE'); ?></h3>
	</div>
	<div class="modal-body">
		<div class="row-fluid">
			<form id="lendForm">
				<div class="alert alert-info">
					<?php echo JText::_('COM_INVENTORY_LEND_DEVICE_TO'); ?> <?php echo JFactory::getUser()->username . '(' . JFactory::getUser()->id . ')'; ?>
				</div>
				<div id="device-modal-info" class="media"></div>
				<input type="hidden" name="device_id" id="deviceid" value="<?php echo $this->device->device_id; ?>" />
				<input type="hidden" name="table" value="Device" />
				<input type="hidden" name="lend" value="1" />
				<input type="hidden" name="lent_user_id" value="<?php echo JFactory::getUser()->id; ?>"  />
				<input class="span12" type="text" name="lent_description" placeholder="<?php echo JText::_('COM_INVENTORY_USERNAME_NOT_IN_DB'); ?>" /> 
			</form>
		</div>
	</div>
	<div class="modal-footer">
		<button class="btn" data-dismiss="modal" aria-hidden="true"><?php echo JText::_('COM_INVENTORY_CLOSE'); ?></button>
		<button class="btn btn-primary" onclick="lendDevice();"><?php echo JText::_('COM_INVENTORY_LEND'); ?></button>
	</div>
</div>