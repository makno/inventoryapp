<?php defined( '_JEXEC' ) or die( 'Restricted access' ); 

/**
 * @package     it+kapfenberg
 * @subpackage  com_inventory
 *
 * @copyright   Copyright (C) 2013 Mathias Knoll All rights reserved.
 * @license     GNU AFFERO GENERAL PUBLIC LICENSE Version 3; see LICENSE.txt
*/

class InventoryControllersUploaddeviceimagefromportable extends JControllerBase
{
  public function execute()
  {
	jimport('joomla.filesystem.file');
  
    $app      = JFactory::getApplication();
	
    $return   = array("success"=>false);
	
	$params = JComponentHelper::getParams('com_inventory');
	$max_images = $params->get('maxAllowedDeviceImages', '5');
	$imagepath = $params->get('imagepath', '/images/devices');

	define("UPLOAD_DIR", JPATH_BASE . $imagepath . '/');
	
	$qrcode = $app->input->getString('deviceQR',null);
	error_log("current QR-Code= " . $qrcode);	
 
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

	// File-Upload Functionality starts here.

	$myFile = $app->input->files->get('myFile', false);
		
	if($myFile==false){
		error_log('ImageUpload failed, because there was no file found in the upload');
		$return['msg'] = 'file not found in upload';
		echo json_encode($return);
		return;
	}
	
	// ensure a safe filename
	$filename = JFile::makeSafe('img_' . $qrcode . ".JPG");	
	$src = $myFile['tmp_name'];
	$dest = UPLOAD_DIR . $qrcode . '/';
	
	if(!file_exists(UPLOAD_DIR . $qrcode)){
		error_log('directory created: ' . $dest . $filename);
		if(!mkdir(UPLOAD_DIR . $qrcode)){
			$return['msg'] = 'mkdir for deviceImage failed!';
			die('mkdir for deviceImage failed!'); //TODO replace "die" with return/error
		}
	}
	
	$filename = JFile::makeSafe('img_' . $qrcode . "-100.JPG");
	if (!file_exists($dest . $filename)){ //in case this is the first picture with the current QR-Code
		if ( JFile::upload($src, $dest . $filename) ){
			error_log('File uploaded! ' . $dest . $filename);
			$return['msg'] = 'file uploaded to ' . $dest . $filename;
			$return['success'] = true;
		}
		else{
			$return['msg'] = 'file not uploaded properly';
			echo json_encode($return);
			return;
		}	
	}else{ //in case this is not the first picture with the current QR-Code
		for ($i = 1; $i <=$max_images ; $i++){ // TODO set max_Imagecount as constant
			$filename = JFile::makeSafe('img_' . $qrcode . "-300-" . $i . ".JPG");
			if (!file_exists($dest . $filename)){
				if ( JFile::upload($src, $dest . $filename) ){
					$return['msg'] = 'file uploaded to ' . $dest . $filename;
					$return['success'] = true;
				}
				else{
					$return['msg'] = 'file not uploaded properly';
					echo json_encode($return);
					return;
				}
				break;
			}
		}
	}
	
	
	
	
	

	
/*	
	error_log("DEBUG Test-UPLOAD_DIR:  " . UPLOAD_DIR . $qrcode );
	if (!file_exists(UPLOAD_DIR .$qrcode )) {
		error_log("DEBUG mkdir: " . UPLOAD_DIR . $qrcode);	
			if(!mkdir(UPLOAD_DIR . $qrcode)){
				die('mkdir for deviceImage failed!'); //TODO replace "die" with return/error
				error_log("DEBUG: directory for >" . $qrcode . "< made");
			}
		}
		$mainImage = $qrcode . "-100.JPG";
		error_log("DEBUG mainImage= " . $mainImage);
		if (!file_exists(UPLOAD_DIR . $qrcode . "/" . $mainImage)){
			error_log("SAVE IMAGE HEEEERE!!");
			//preserver file from temporary directory
			$success = move_uploaded_file($myFile["tmp_name"],
				UPLOAD_DIR . $qrcode . "/" . $mainImage );
			if (!$success) {
				echo "<p>Unable to save file.</p>";
			exit;
		}
		}else{
			for ($i = 1; $i <=$max_images ; $i++){ // TODO set max_Imagecount as constant
				if (!file_exists(UPLOAD_DIR . $qrcode . "/" . $qrcode . "-300-" . $i)){
					move_uploaded_file($myFile["tmp_name"], UPLOAD_DIR . $qrcode . "/" . $qrcode . "-300-" . $i);
					break;
				}
			//while (file_exists(UPLOAD_DIR . $qrcode . "/" . $qrcode . "-300-" . $i)){
			//	$success = move_uploaded_file($myFile["tmp_name"], UPLOAD_DIR . $qrcode . "/" . $qrcode . "-300-" . $i);
			//	exit;
			//{
			}
		}
		
*/
		// don't overwrite an existing file
		// $i = 0;
		// $parts = pathinfo($name);
		// while (file_exists(UPLOAD_DIR . $name)) {
			// $i++;
			// $name = $parts["filename"] . "-" . $i . "." . $parts["extension"];
		// }
	
		// preserve file from temporary directory
		// $success = move_uploaded_file($myFile["tmp_name"],
				// UPLOAD_DIR . $name);
		// if (!$success) {
			// echo "<p>Unable to save file.</p>";
			// exit;
		// }
	
		// set proper permissions on the new file
		
		
		//chmod(UPLOAD_DIR . $name, 0644);

	
	//-----------
	
//       $modelName  = $app->input->get('model', 'device');
//     $view       = $app->input->get('view', 'device');
//     $layout     = $app->input->get('layout', '_entry');
//     $item       = $app->input->get('item', 'device');
	

//     $modelName  = 'InventoryModels'.ucwords($modelName);
// 	$model = new $modelName();
	
// 	$data = $app->input->getArray(array(
// 		'table' 			=> 'STRING',
// 		'type' 				=> 'STRING',
// 		'devicename' 		=> 'STRING',
// 		'imageurl' 			=> 'STRING',
// 		'snumber' 			=> 'STRING',
// 		'qrcode' 			=> 'STRING',
// 		'shortdescription' 	=> 'STRING',
// 		'description' 		=> 'HTML',
// 		'location' 			=> 'STRING',
// 		'orgunit_id' 		=> 'STRING',
// 		'tags' 				=> 'STRING'	
// 	));
	
// 	$file = $_FILES['image'];
	
	$desc = JRequest::getVar('description', 'no description', 'post','STRING',JREQUEST_ALLOWRAW);
	
	$data['description'] = $desc;
	
//    	if ( $row = $model->store($data) ){
// 		$return['success'] = true;
// 		$return['msg'] = JText::_('COM_INVENTORY_SAVE_SUCCESS');
// 		$return['html'] = InventoryHelpersView::getHtml($view, $layout, $item, $row);
// 	}else{
// 		$return['msg'] = JText::_('COM_INVENTORY_SAVE_FAILURE');
// 	}
	echo json_encode($return);
  }
}
?>
