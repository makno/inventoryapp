<?php defined( '_JEXEC' ) or die( 'Restricted access' );

/**
 * @package     it+kapfenberg
 * @subpackage  com_inventory
 *
 * @copyright   Copyright (C) 2013 Mathias Knoll All rights reserved.
 * @license     GNU AFFERO GENERAL PUBLIC LICENSE Version 3; see LICENSE.txt
 */

class InventoryControllersDelete extends JControllerBase
{
  public function execute()
  {
    $app = JFactory::getApplication();

	$params = JComponentHelper::getParams('com_inventory');
    if ($params->get('required_account') == 1) 
    {
        $user = JFactory::getUser();
        if ($user->get('guest'))
        {
            $app->redirect('index.php',JText::_('COM_INVENTORY_ACCOUNT_REQUIRED_MSG'));
        }
    }
	
  	$return = array("success"=>false);
 
    $model = new InventoryModelsDevice();

  	if ( $model->deactivate() )
  	{
  		$return['success'] = true;
  		$return['msg'] = JText::_('COM_INVENTORY_DEVICE_DELETE_SUCCESS');
  	}else{
  		$return['msg'] = JText::_('COM_INVENTORY_DEVICE_DELETE_FAILURE');
  	}

  	echo json_encode($return);

  }

}