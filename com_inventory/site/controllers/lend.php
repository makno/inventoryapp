<?php defined( '_JEXEC' ) or die( 'Restricted access' ); 

/**
 * @package     it+kapfenberg
 * @subpackage  com_inventory
 *
 * @copyright   Copyright (C) 2013 Mathias Knoll All rights reserved.
 * @license     GNU AFFERO GENERAL PUBLIC LICENSE Version 3; see LICENSE.txt
 */

class InventoryControllersLend extends JControllerBase
{
	public function execute()
	{
		$app      = JFactory::getApplication();
		
		$return = array("success"=>false);
		
		$params = JComponentHelper::getParams('com_inventory');
		if ($params->get('required_account') == 1) 
		{
			$user = JFactory::getUser();
			if ($user->get('guest'))
			{
				$app->redirect('index.php',JText::_('COM_INVENTORY_ACCOUNT_REQUIRED_MSG'));
			}
		}

		$model = new InventoryModelsDevice();
		
		$view       = $app->input->get('view', 'device');
		$layout     = $app->input->get('layout', '_entry');
		$item       = $app->input->get('item', 'device');

		if ( $row = $model->lend() )
		{
			$return['success'] = true;
			$return['msg'] = JText::_('COM_INVENTORY_DEVICE_LEND_SUCCESS');
			$model->_device_id = $row->device_id;
			$device = $model->getItem();
			$return['html'] = InventoryHelpersView::getHtml($view, $layout, $item, $device);
		}else{
			$return['msg'] = JText::_('COM_INVENTORY_DEVICE_LEND_FAILURE');
		}

		echo json_encode($return);
	}
}