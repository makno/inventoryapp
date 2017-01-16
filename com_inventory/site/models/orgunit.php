<?php defined( '_JEXEC' ) or die( 'Restricted access' ); 

/**
 * @package     it+kapfenberg
 * @subpackage  com_inventory
 *
 * @copyright   Copyright (C) 2013 Mathias Knoll All rights reserved.
 * @license     GNU AFFERO GENERAL PUBLIC LICENSE Version 3; see LICENSE.txt
 */

class InventoryModelsOrgunit extends InventoryModelsDefault{

	var $_orgunitlist   	= array();
	

	function __construct(){
		$this->_orgunitlist			= $this->getOrgUnitList();
		parent::__construct();       
	}
	
	public function getOrgUnitList(){
		$db = JFactory::getDBO();
		$query = $db->getQuery(TRUE);
		$query->select('o.orgunit_id, o.name, o.shortdescription');
		$query->from('#__inventory_orgunits as o');
		$query->order('o.name ASC');
		$db->setQuery($query);
		return $db->loadObjectList();
	}

}

