<?php
/**
 * @package     it+kapfenberg
 * @subpackage  com_inventory
 *
 * @copyright   Copyright (C) 2013 Mathias Knoll All rights reserved.
 * @license     GNU AFFERO GENERAL PUBLIC LICENSE Version 3; see LICENSE.txt
 */
?>
<div id="borrowDeviceModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="borrowDeviceModalLabel" aria-hidden="true">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
		<h3 id="myModalLabel"><?php echo JText::_('COM_INVENTORY_BORROW_DEVICE'); ?></h3>
	</div>
	<div class="modal-body">
		<div class="row-fluid">
			<form id="borrowForm">
				<div class="alert alert-info">
					<?php echo JText::_('COM_INVENTORY_REQUEST_DEVICE'); ?>
				</div>
				<div id="device-modal-info" class="media"></div>
					<input type="hidden" name="device_id" id="device-id" value="" />
					<input type="hidden" name="lent_user_id" value="<?php echo JFactory::getUser()->id; ?>" />
					<input type="hidden" name="table" value="waitlist" />
			</form>
		</div>
	</div>
	<div class="modal-footer">
		<button class="btn" data-dismiss="modal" aria-hidden="true"><?php echo JText::_('COM_INVENTORY_CLOSE'); ?></button>
		<button class="btn btn-primary" onclick="borrowDevice();"><?php echo JText::_('COM_INVENTORY_BORROW'); ?></button>
	</div>
</div>