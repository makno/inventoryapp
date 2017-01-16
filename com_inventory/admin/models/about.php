<?php // no direct access

/**
 * @package     it+kapfenberg
 * @subpackage  com_inventory
 *
 * @copyright   Copyright (C) 2013 Mathias Knoll All rights reserved.
 * @license     GNU AFFERO GENERAL PUBLIC LICENSE Version 3; see LICENSE.txt
 */
 

defined( '_JEXEC' ) or die( 'Restricted access' ); 
 
class InventoryModelAbout extends JModelLegacy{
	public function getVersion(){
	
		$db = JFactory::getDBO();
	
		$query = 
			'SELECT manifest_cache'.
			' FROM #__extensions'.
			' WHERE element = "com_inventory"'.
			' LIMIT 1';
		
		$db->setQuery($query);
		$rows = $db->loadObjectList();
		$itemrow = $rows[0];
		
		$itmearray = json_decode($itemrow->manifest_cache);
			
		return $itmearray->version;
	}
}