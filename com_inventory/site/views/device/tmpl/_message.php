<?php
/**
 * @package     it+kapfenberg
 * @subpackage  com_inventory
 *
 * @copyright   Copyright (C) 2013 Mathias Knoll All rights reserved.
 * @license     GNU AFFERO GENERAL PUBLIC LICENSE Version 3; see LICENSE.txt
 */
?>
<div id="messageModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="messageModalLabel" aria-hidden="true">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
		<h3 id="myModalLabel"><?php echo JText::_('COM_INVENTORY_MESSAGE'); ?></h3>
	</div>
	<div class="modal-body">
		<div class="row-fluid">
			<div class="alert alert-info" id="message">
				<?php echo JText::_('COM_INVENTORY_MESSAGE'); ?>
			</div>
		</div>
	</div>
	<div class="modal-footer">
		<button class="btn btn-primary" data-dismiss="modal" aria-hidden="true"><?php echo JText::_('COM_INVENTORY_CLOSE'); ?></button>
	</div>
</div>