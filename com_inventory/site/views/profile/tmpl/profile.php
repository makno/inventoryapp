<?php
/**
 * @package     it+kapfenberg
 * @subpackage  com_inventory
 *
 * @copyright   Copyright (C) 2013 Mathias Knoll All rights reserved.
 * @license     GNU AFFERO GENERAL PUBLIC LICENSE Version 3; see LICENSE.txt
 */
?>
<a href="<?php echo JRoute::_('index.php?option=com_inventory&view=profile&layout=list'); ?>" class="btn pull-right"><i class="icon icon-chevron-left"></i> <?php echo JText::_('COM_INVENTORY_BACK'); ?></a>
<h2 class="page-header"><?php echo $this->profile->name; ?></h2>

<div class="row-fluid">
	<div class="span3">
		<strong><?php echo $this->profile->name; ?></strong><br />
		<?php echo $this->profile->email; ?>
	</div>
	<div class="span9 well well-small">
		<dl class="dl-horizontal">
			<dt><?php echo JText::_('COM_INVENTORY_PROFILE_NAME'); ?></dt>
			<dd><?php echo $this->profile->name; ?></dd>
			<dt><?php echo JText::_('COM_INVENTORY_PROFILE_JOIN'); ?></dt>
			<dd><?php echo JHtml::_('date', $this->profile->registerDate, JText::_('DATE_FORMAT_LC3')); ?></dd>
			<dd><?php if(isset($this->profile->details['aboutme'])) echo $this->profile->details['aboutme']; ?></dd>
		</dl>
	</div>
</div>

<?php echo $this->_modalMessage->render(); ?>