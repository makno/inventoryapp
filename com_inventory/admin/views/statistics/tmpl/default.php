<?php
/**
 * @package     it+kapfenberg
 * @subpackage  com_inventory
 *
 * @copyright   Copyright (C) 2013 Mathias Knoll All rights reserved.
 * @license     GNU AFFERO GENERAL PUBLIC LICENSE Version 3; see LICENSE.txt
 */
?>

<?php if (!empty( $this->sidebar)) : ?>
	<div id="j-sidebar-container" class="span2">
		<?php echo $this->sidebar; ?>
	</div>
	<div id="j-main-container" class="span10">
<?php else : ?>
	<div id="j-main-container">
<?php endif;?>

		<div class="span4 thumbnail" style="margin-bottom:5px;margin-left: 0px; margin-right:5px;">
			<h3>
				<span class="label label-info pull-right"><?php echo $this->stats['total_devices']; ?></span>
				<?php echo JText::_('COM_INVENTORY_STATISTICS_TOTAL_DEVICES'); ?>
			</h3>
			<div class="progress progress-info">
				<div class="bar" style="width: <?php echo $this->stats['total_devices'] > 100 ? $this->stats['total_devices'] / 100 : $this->stats['total_devices']; ?>%"></div>
			</div>
			<p><?php echo JText::_('COM_INVENTORY_STATISTICS_TOTAL_DEVICES_DESC'); ?></p>
		</div>
		
		<div class="span4 thumbnail" style="margin-bottom:5px;margin-left: 0px; margin-right:5px;">
			<h3>
				<span class="label label-success pull-right"><?php echo $this->stats['total_available']; ?></span>
				<?php echo JText::_('COM_INVENTORY_STATISTICS_TOTAL_AVAILABLE'); ?>
			</h3>
			<div class="progress progress-success">
				<div class="bar" style="width: <?php echo $this->stats['total_devices'] > 100 ? $this->stats['total_available'] / 100 : $this->stats['total_available']; ?>%"></div>
			</div>
			<p><?php echo JText::_('COM_INVENTORY_STATISTICS_TOTAL_AVAILABLE_DESC'); ?></p>
		</div>

		<div class="span4 thumbnail" style="margin-bottom:5px;margin-left: 0px; margin-right:5px;">
			<h3>
				<span class="label label-warning pull-right"><?php echo $this->stats['total_loaned']; ?></span>
				<?php echo JText::_('COM_INVENTORY_STATISTICS_TOTAL_LENT'); ?>
			</h3>
			<div class="progress progress-warning">
				<div class="bar" style="width: <?php echo $this->stats['total_devices'] > 100 ? $this->stats['total_loaned'] / 100 : $this->stats['total_loaned']; ?>%"></div>
			</div>
			<p><?php echo JText::_('COM_INVENTORY_STATISTICS_TOTAL_LENT_DESC'); ?></p>
		</div>

		<div class="span4 thumbnail" style="margin-bottom:5px;margin-left: 0px; margin-right:5px;">
			<h3>
				<span class="label label-warning pull-right"><?php echo $this->stats['total_loaned']; ?></span>
				<span class="label label-success pull-right"><?php echo $this->stats['total_available']; ?></span>
				<?php echo JText::_('COM_INVENTORY_STATISTICS_COMBINED'); ?>
			</h3>
			<div class="progress">
				<div class="bar bar-success" style="width: <?php echo $this->stats['total_devices'] > 100 ? $this->stats['total_available'] / 100 : $this->stats['total_available']; ?>%"></div>
				<div class="bar bar-warning" style="width: <?php echo $this->stats['total_devices'] > 100 ? $this->stats['total_loaned'] / 100 : $this->stats['total_loaned']; ?>%"></div>	
			</div>
			<p><?php echo JText::_('COM_INVENTORY_STATISTICS_COMBINED_DESC'); ?></p>
		</div>
		
		<div class="span4 thumbnail" style="margin-bottom:5px;margin-left: 0px; margin-right:5px;">
			<h3>
				<span class="label label-danger pull-right"><?php echo $this->stats['total_trashcan']; ?></span>
				<?php echo JText::_('COM_INVENTORY_STATISTICS_TOTAL_TRASH'); ?>
			</h3>
			<div class="progress progress-danger">
				<div class="bar" style="width: <?php echo $this->stats['total_trashcan'] / $this->stats['total_devices']; ?>%"></div>
			</div>
			<p><?php echo JText::_('COM_INVENTORY_STATISTICS_TOTAL_TRASH_DESC'); ?></p>
		</div>
	</div>