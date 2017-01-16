<?php defined( '_JEXEC' ) or die( 'Restricted access' ); 

/**
 * @package     it+kapfenberg
 * @subpackage  com_inventory
 *
 * @copyright   Copyright (C) 2013 Mathias Knoll All rights reserved.
 * @license     GNU AFFERO GENERAL PUBLIC LICENSE Version 3; see LICENSE.txt
 */

class InventoryControllersAdddevicefromportable extends JControllerBase
{
  public function execute()
  {
    $app      = JFactory::getApplication();
	
    $return   = array("success"=>false);
	
	$params = JComponentHelper::getParams('com_inventory');
//     if ($params->get('required_account') == 1) 
//     {
//         $user = JFactory::getUser();
//         if ($user->get('guest'))
//         {
//             $app->redirect('index.php',JText::_('COM_INVENTORY_ACCOUNT_REQUIRED_MSG'));
//         }
//     }

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
	
	
    $modelName  = $app->input->get('model', 'device');
    $view       = $app->input->get('view', 'device');
    $layout     = $app->input->get('layout', '_entry');
    $item       = $app->input->get('item', 'device');
	

    $modelName  = 'InventoryModels'.ucwords($modelName);
	$model = new $modelName();
	
	$data = $app->input->getArray(array(
		'table' 			=> 'STRING',
		'type' 				=> 'STRING',
		'devicename' 		=> 'STRING',
		'imageurl' 			=> 'STRING',
		'snumber' 			=> 'STRING',
		'qrcode' 			=> 'STRING',
		'shortdescription' 	=> 'STRING',
		'description' 		=> 'HTML',
		'location' 			=> 'STRING',
		'orgunit_id' 		=> 'STRING',
		'tags' 				=> 'STRING'	
	));
	
	$desc = JRequest::getVar('description', 'no description', 'post','STRING',JREQUEST_ALLOWRAW);
	
	$data['description'] = $desc;
	
   	if ( $row = $model->store($data) ){
		$return['success'] = true;
		$return['msg'] = JText::_('COM_INVENTORY_SAVE_SUCCESS');
//		$return['html'] = InventoryHelpersView::getHtml($view, $layout, $item, $row);
	}else{
		$return['msg'] = JText::_('COM_INVENTORY_SAVE_FAILURE');
	}
	echo json_encode($return);
  }
}
?>
