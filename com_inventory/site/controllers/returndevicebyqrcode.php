<?php defined( '_JEXEC' ) or die( 'Restricted access' );

/**
 * @package     it+kapfenberg
 * @subpackage  com_inventory
 *
 * @copyright   Copyright (C) 2013 Mathias Knoll All rights reserved.
 * @license     GNU AFFERO GENERAL PUBLIC LICENSE Version 3; see LICENSE.txt
 */ 
 
class InventoryControllersReturndevicebyqrcode extends JControllerBase
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
	$__name = $app->input->getString('name',null);
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
	
	if($device->lent == 0){
		$return['msg'] .= ', device already returned to user with id ' . $device->lent_user_id;
		if(!empty($device->lent_description)){
		 	$return['msg'] .= ' and lent_description '. $device->lent_description;
		}
		echo json_encode($return);
		return;
	}
	
	if($device->lent_user_id != $credentials['id']){
		$return['msg'] .= ', user '.$credentials['username']. ' with id '.$credentials['id'] . ' is not allowed to return device. user '.$device->lent_user_name.' with id '.$device->lent_user_id.' needed!';
		echo json_encode($return);
		return;
	}
	
	$data = array();
	$data['lend'] = 0;
	$data['lent_description'] = '';
	$data['table'] = 'device';
	$data['device_id'] = $device->device_id;
	$data['lent_date'] = $device->lent_date;
	$data['lent_user_id'] = $device->lent_user_id;
	
	if($row = $model->lend($data)){
		$return['success'] = true;
		$return['msg'] .= ', device returned';
		$return['result'] = $row;
		echo json_encode($return);
		return;
	}

	$return['msg'] .= ', device not returned due to unknown reason';
  	echo json_encode($return);

  }

}