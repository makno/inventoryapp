<?php defined( '_JEXEC' ) or die( 'Restricted access' ); 

/**
 * @package     it+kapfenberg
 * @subpackage  com_inventory
 *
 * @copyright   Copyright (C) 2013 Mathias Knoll All rights reserved.
 * @license     GNU AFFERO GENERAL PUBLIC LICENSE Version 3; see LICENSE.txt
 */

class InventoryControllersLenddevicebyqrcode extends JControllerBase
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
		
	$__qrcode = $app->input->getString('qrcode',null);
	$__lent_description = $app->input->getString('lent_description',null);
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
	
	$device = $model->getItemByQrcode($__qrcode);
	if($device){
		$model->_device_id = $device->device_id;
	}
	
	if(!$device){
		$return['msg'] .= ', no device for qrcode ' . $__qrcode . ' found.';
		echo json_encode($return);
		return;
	}
	
	if($device->lent == 1){
		$return['msg'] .= ', device already lent to user with id ' . $device->lent_user_id;
		if(!empty($device->lent_description)){
		 	$return['msg'] .= ' and lent_description '. $device->lent_description;
		}
		echo json_encode($return);
		return;
	}
	
	$data = array();
	$data['lend'] = 1;
	$data['lent_description'] = $__lent_description;
	$data['table'] = 'device';
	$data['device_id'] = $device->device_id;
	$data['lent_user_id'] = $credentials['id'];
  
	if(empty($data['lent_user_id'])){
		$return['msg'] .= ', no user id present.';
		echo json_encode($return);
		return;
	}
	
	if($row = $model->lend($data)){
		$return['success'] = true;
		$return['msg'] .= ', device lent';
		$return['result'] = $row;
		echo json_encode($return);
		return;
	}

	$return['msg'] .= ', device not lent due unknown reason';
  	echo json_encode($return);

  }

}