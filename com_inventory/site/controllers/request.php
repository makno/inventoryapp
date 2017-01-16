<?php defined( '_JEXEC' ) or die( 'Restricted access' ); 

/**
 * @package     it+kapfenberg
 * @subpackage  com_inventory
 *
 * @copyright   Copyright (C) 2013 Mathias Knoll All rights reserved.
 * @license     GNU AFFERO GENERAL PUBLIC LICENSE Version 3; see LICENSE.txt
 */

class InventoryControllersBorrow extends JControllerBase
{
	public function execute()
	{
		$app      = JFactory::getApplication();

		$return = array("success"=>false);

		$model = new InventoryModelsWaitlist();

		if ( $model->store() )
		{
			$return['success'] = true;
			$return['msg'] = JText::_('COM_INVENTORY_DEVICE_REQUEST_SUCCESS');

		}else{
			$return['msg'] = JText::_('COM_INVENTORY_DEVICE_REQUEST_FAILURE');
		}

		echo json_encode($return);
	}

}