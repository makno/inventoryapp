<?php defined( '_JEXEC' ) or die( 'Restricted access' ); 

/**
 * @package     it+kapfenberg
 * @subpackage  com_inventory
 *
 * @copyright   Copyright (C) 2013 Mathias Knoll All rights reserved.
 * @license     GNU AFFERO GENERAL PUBLIC LICENSE Version 3; see LICENSE.txt
 */

class InventoryControllersQrcode extends JControllerBase
{
  public function execute()
  {
    $app = JFactory::getApplication();  
	$return   = array("hasCode"=>false, "hasSVG"=>false);
	
    $model = new InventoryModelsDevice();
    $this->_qrcode = $app->input->get('qrcode',null);
	$this->devices = $model->listItems();
	
	for($i=0, $n = count($this->devices);$i<$n;$i++) { 
		if($this->devices[$i]->qrcode == $this->_qrcode){
			$return['hasCode'] = true;
			$return['msg'] = 'QRCode already in use!';	
			$return['hasSVG'] = !empty($this->devices[$i]->qrcodesvg);
			if($return['hasSVG'] )
				$return['qrcode'] = $this->devices[$i]->qrcodesvg;
			break;
		}
	} 
	if(!$return['hasSVG']){
		$return['qrcode'] = QRcode::svg($this->_qrcode,false, QR_ECLEVEL_L, 3,1,false, 0xFFFFFF,0x000000);
		$return['hasSVG'] = !empty($return['qrcode']);
	}
	
	echo json_encode($return);
  }

}