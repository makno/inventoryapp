<?php defined( '_JEXEC' ) or die( 'Restricted access' ); 

/**
 * @package     it+kapfenberg
 * @subpackage  com_inventory
 *
 * @copyright   Copyright (C) 2013 Mathias Knoll All rights reserved.
 * @license     GNU AFFERO GENERAL PUBLIC LICENSE Version 3; see LICENSE.txt
 */

//Display partial views
class InventoryViewsWaitlistPhtml extends JViewHTML
{

    function render()
    {
    	$this->_deviceListView = InventoryHelpersView::load('Device','_entry','phtml');
    	return parent::render();
 	}
}