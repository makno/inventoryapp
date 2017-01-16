
<?php
/**
 * @package     it+kapfenberg
 * @subpackage  com_inventory
 *
 * @copyright   Copyright (C) 2013 Mathias Knoll All rights reserved.
 * @license     GNU AFFERO GENERAL PUBLIC LICENSE Version 3; see LICENSE.txt
 */
?><div class="media well well-small span6">
<!--
	<a class="pull-left" href="<?php echo JRoute::_('index.php?option=com_inventory&view=profile&layout=profile&id='.$this->profile->id); ?>">
		<strong><?php echo $this->profile->name; ?></strong><br />
		<?php echo strtolower(trim($this->profile->email)); ?>
	</a>
-->
	<div class="media-body">
		<h4 class="media-heading"><a href="<?php echo JRoute::_('index.php?option=com_inventory&view=profile&layout=profile&profile_id='.$this->profile->id); ?>"><?php echo $this->profile->name; ?></a></h4>
		<p>
			<strong><?php echo JText::_('COM_INVENTORY_TOTAL_DEVICES'); ?></strong>: <?php echo $this->profile->totalDevices; ?>
		</p>
	</div>
</div>