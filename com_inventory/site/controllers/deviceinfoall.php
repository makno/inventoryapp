<?php defined( '_JEXEC' ) or die( 'Restricted access' ); 

/**
 * @package     it+kapfenberg
 * @subpackage  com_inventory
 *
 * @copyright   Copyright (C) 2013 Mathias Knoll All rights reserved.
 * @license     GNU AFFERO GENERAL PUBLIC LICENSE Version 3; see LICENSE.txt
 */

class InventoryControllersDeviceinfoall extends JControllerBase
{
  public function execute()
  {
    $app = JFactory::getApplication();
  	$return = array("success"=>false);
	$doc = JFactory::getDocument();

	$format = $app->input->get('format','raw');
	if($format=='json'){
		$doc->setMimeEncoding('application/json');
	}else{
		$doc->setMimeEncoding('text/plain');
	}
		
	$__status = $app->input->get('status',null);
	$__orgunit = $app->input->get('orgunit',null);
	$__username = $app->input->getString('username',null);
	$__password = $app->input->getString('password',null);
	
	$credentials = array("username"=>$__username, "password"=>$__password);
	
	$response = onAuthenticate( $credentials ); // JAuthenticationResponse
	
	if ($response->status === JAuthentication::STATUS_SUCCESS){
		$return['msg'] = 'user credentials valid';
	}else{
		$return['msg'] = $response->error_message;
		echo json_encode($return);
		return;
	}
	
	$return['userid'] = $credentials['id'];
	
  	$model = new InventoryModelsDevice();
	$model->_status = $__status;
	$model->_orgunit_id = $__orgunit;
	$this->devices = $model->listItemsSmall();

	if($this->devices){
		$return['success'] = true;
		$return['msg'] .= ','.sizeof($this->devices).' devices found';
		$return['devices'] = $this->devices;
	}else{
		$return['msg'] .= ',no  devices  found';
	}
	
  	echo json_encode($return);

  }

}