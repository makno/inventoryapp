<?php defined( '_JEXEC' ) or die( 'Restricted access' ); 

/**
 * @package     it+kapfenberg
 * @subpackage  com_inventory
 *
 * @copyright   Copyright (C) 2013 Mathias Knoll All rights reserved.
 * @license     GNU AFFERO GENERAL PUBLIC LICENSE Version 3; see LICENSE.txt
 */

class InventoryControllersDevicepictures extends JControllerBase
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
	
	$__qrcode = $app->input->get('qrcode',null);
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
		$pictures = array();
		$pictures = $this->getPictures($__qrcode);
		$return['success'] = true;
		$return['msg'] = 'device found, '.sizeof($pictures).' pictures found';
		$return['pictures'] = $pictures;
	}else{
		$return['msg'] = 'device not found for qrcode '.$__qrcode;
	}
	
  	echo json_encode($return);

  }
  
  private function getPictures($qrcode)
  {
		$pics = array();
		$exts = array('jpg','png','gif','jpeg');
		$dir = JPATH_BASE.'/images/devices/'.$qrcode;
		if ($handle = @opendir($dir)) {
			while (false !== ($entry = readdir($handle))) {
				$fileInfo = pathinfo($dir.'/'.$entry);
				if(in_array(strtolower($fileInfo['extension']),$exts)){
					$pics[] = JURI::base().'images/devices/'.$qrcode.'/'.$entry;
				}
			}
			closedir($handle);
		}
		return $pics;
  }
}