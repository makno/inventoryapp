<?php defined( '_JEXEC' ) or die( 'Restricted access' ); 

/**
 * @package     it+kapfenberg
 * @subpackage  com_inventory
 *
 * @copyright   Copyright (C) 2013 Mathias Knoll All rights reserved.
 * @license     GNU AFFERO GENERAL PUBLIC LICENSE Version 3; see LICENSE.txt
 */

class InventoryModelsWaitlist extends InventoryModelsDefault
{

  //Define class level variables
  var $_waitlist_id   = null;
  var $_lent_user_id       = null;

  function __construct()
  {
    parent::__construct();      

    $app = JFactory::getApplication();
    $this->_waitlist_id = $app->input->get('waitlist_id',null);
    $this->_lent_user_id = $app->input->get('lent_user_id',JFactory::getUser()->id);
  }

 function getItem() 
  {
   
    $deviceModel = new InventoryModelsDevice();
    $deviceModel->set('_waitlist', TRUE);
    $deviceModel->set('_lent_user_id', $this->_lent_user_id);
    $waitlist = $deviceModel->listItems();

    return $waitlist;
  }

  /**
  * Delete a device from a waitlist
  * @param int      ID of the device to delete
  * @return boolean True if successfully deleted
  */
  public function delete($id = null)
  {
    $app  = JFactory::getApplication();
    $id   = $id ? $id : $app->input->get('waitlist_id');

    if (!$id)
    {
      if ($device_id = $app->input->get('device_id')) 
      {
        $db = JFactory::getDbo();
        $user = JFactory::getUser();
        $query = $db->getQuery(true);
        $query->delete()
            ->from('#__inventory_waitlists')
            ->where('lent_user_id = ' . $user->id)
            ->where('device_id = ' . $device_id);
        $db->setQuery($query);
        if($db->query()) {
          return true;
        }
      } 

    } else {
      $waitlist = JTable::getInstance('Waitlist','Table');
      $waitlist->load($id);

      if ($waitlist->delete()) 
      {
        return true;
      }      
    }

    return false;
  }

}
