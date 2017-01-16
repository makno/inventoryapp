<?php defined( '_JEXEC' ) or die( 'Restricted access' ); 

/**
 * @package     it+kapfenberg
 * @subpackage  com_inventory
 *
 * @copyright   Copyright (C) 2013 Mathias Knoll All rights reserved.
 * @license     GNU AFFERO GENERAL PUBLIC LICENSE Version 3; see LICENSE.txt
 */

class InventoryControllersDevice extends JControllerBase
{
  public function execute()
  {
    $app = JFactory::getApplication();
  	$return = array("success"=>false);
	
	$__id = $app->input->get('id',null);
	    
  	$model = new InventoryModelsDevice();
	$model->_device_id = $__id;
	$device = $model->getItem();

	if($device){
		$return['success'] = true;
		$return['msg'] .= ',device found';
		$return['device'] = $device;
	}else{
		$return['msg'] .= ',device not found for id '.$__id;
	}
	
  	echo json_encode($return);

  }

}