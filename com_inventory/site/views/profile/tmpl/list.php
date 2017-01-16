<?php
/**
 * @package     it+kapfenberg
 * @subpackage  com_inventory
 *
 * @copyright   Copyright (C) 2013 Mathias Knoll All rights reserved.
 * @license     GNU AFFERO GENERAL PUBLIC LICENSE Version 3; see LICENSE.txt
 */
?>
<h2 class="page-header"><?php echo JText::_('COM_INVENTORY_PROFILES'); ?></h2>
<div class="row-fluid">
	<?php for($i=0, $n = count($this->profiles);$i<$n;$i++) { 
	        $this->_profileListView->profile = $this->profiles[$i];
	        echo $this->_profileListView->render();
	} ?>
</div>