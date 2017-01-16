<?php defined( '_JEXEC' ) or die( 'Restricted access' ); 

/**
 * @package     it+kapfenberg
 * @subpackage  com_inventory
 *
 * @copyright   Copyright (C) 2013 Mathias Knoll All rights reserved.
 * @license     GNU AFFERO GENERAL PUBLIC LICENSE Version 3; see LICENSE.txt
 */

class InventoryModelsProfile extends InventoryModelsDefault
{

  var $_lent_user_id     = null;

  function __construct()
  {
    $app = JFactory::getApplication();
	$this->_lent_user_id = $app->input->get('profile_id', JFactory::getUser()->id);
    parent::__construct();       
  }
 
  protected function _buildQuery()
  {
    $db = JFactory::getDBO();
    $query = $db->getQuery(TRUE);
    $query->select("u.id, u.username, u.name, u.email, u.registerDate");
    $query->from("#__users as u");
    $query->select("COUNT(DISTINCT(b.device_id)) as totalDevices");
    $query->leftjoin("#__inventory_devices as b on b.lent_user_id = u.id");
    return $query;
  }

  protected function _buildWhere($query)
  {
    $query->group("u.id");
    return $query;
  }

}