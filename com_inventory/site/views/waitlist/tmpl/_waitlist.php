<?php
/**
 * @package     it+kapfenberg
 * @subpackage  com_inventory
 *
 * @copyright   Copyright (C) 2013 Mathias Knoll All rights reserved.
 * @license     GNU AFFERO GENERAL PUBLIC LICENSE Version 3; see LICENSE.txt
 */
?>
<table cellpadding="0" cellspacing="0" width="100%" class="table table-striped">
	<tbody id="device-list">
		<?php for($i=0, $n = count($this->waitlist);$i<$n;$i++) { 
		        $this->_deviceListView->device = $this->waitlist[$i];
		        $this->_deviceListView->type = 'waitlist';
		        echo $this->_deviceListView->render();
		} ?>
	</tbody>
</table>