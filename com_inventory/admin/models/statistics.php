<?php // no direct access

/**
 * @package     it+kapfenberg
 * @subpackage  com_inventory
 *
 * @copyright   Copyright (C) 2013 Mathias Knoll All rights reserved.
 * @license     GNU AFFERO GENERAL PUBLIC LICENSE Version 3; see LICENSE.txt
 */
 

defined( '_JEXEC' ) or die( 'Restricted access' ); 
 
class InventoryModelStatistics extends JModelLegacy{
 
 public function getStats(){
 	
    $db = JFactory::getDbo();

    $stats = array();

    //Retrieve Total Devices
    $query = $db->getQuery(true);
    $query->select('COUNT(*)')
          ->from('#__inventory_devices')
		  ->where('active = 1');
    $db->setQuery($query);
    $stats['total_devices'] = $db->loadResult();

    //Retrieve Total Lent
    $query = $db->getQuery(true);
    $query->select('COUNT(*)')
          ->from('#__inventory_devices')
          ->where('lent = 1')
		  ->where('active = 1');
    $db->setQuery($query);
    $stats['total_loaned'] = $db->loadResult();

    //Retrieve Total Available
    $query = $db->getQuery(true);
    $query->select('COUNT(*)')
          ->from('#__inventory_devices')
          ->where('lent <> 1')
		  ->where('active = 1');
    $db->setQuery($query);
    $stats['total_available'] = $db->loadResult();

	 //Retrieve Total Trash
    $query = $db->getQuery(true);
    $query->select('COUNT(*)')
          ->from('#__inventory_devices')
		  ->where('active <> 1');
    $db->setQuery($query);
    $stats['total_trashcan'] = $db->loadResult();
	
    return $stats;
 }

}