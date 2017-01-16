<?php defined( '_JEXEC' ) or die( 'Restricted access' ); 

/**
 * @package     it+kapfenberg
 * @subpackage  com_inventory
 *
 * @copyright   Copyright (C) 2013 Mathias Knoll All rights reserved.
 * @license     GNU AFFERO GENERAL PUBLIC LICENSE Version 3; see LICENSE.txt
 */

class InventoryTableDevice extends JTable{                      

  function __construct( &$db ) {
    parent::__construct('#__inventory_devices', 'device_id', $db);
    
    JTableObserverContenthistory::createObserver($this, array('typeAlias' => 'com_inventory.device'));
    
  }
}