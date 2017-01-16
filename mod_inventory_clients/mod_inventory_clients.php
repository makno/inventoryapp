<?php

	/**
	 * @package     it+kapfenberg
	 * @subpackage  mod_inventory_clients
	 *
	 * @copyright   Copyright (C) 2013 Mathias Knoll All rights reserved.
	 * @license     GNU AFFERO GENERAL PUBLIC LICENSE Version 3; see LICENSE.txt
	 */
	 
	defined( '_JEXEC' ) or die( 'Restricted access' );
	
	require_once( dirname(__FILE__).'/helper.php' );
	
	// Is in inventory component already
	//require_once(dirname(__FILE__).'/phpqrcode.php');
	
	if(!file_exists( dirname(__FILE__).'/images/qrcode_android.svg')){
		QRcode::svg(JURI::root().'modules/mod_inventory_clients/downloads/iNventory.apk', dirname(__FILE__).'/images/qrcode_android.svg', QR_ECLEVEL_L, 3,1,false, 0xFFFFFF,0x000000); 
	}
	if(!file_exists( dirname(__FILE__).'/images/qrcode_ios.svg')){
		QRcode::svg("https://itunes.apple.com/at/app/kmu-goes-mobile-inventory/id686437533?mt=8", dirname(__FILE__).'/images/qrcode_ios.svg', QR_ECLEVEL_L, 3,1,false, 0xFFFFFF,0x000000); 
	}
	if(!file_exists( dirname(__FILE__).'/images/qrcode_html5.svg')){
		QRcode::svg(JURI::root().'inventory', dirname(__FILE__).'/images/qrcode_html5.svg', QR_ECLEVEL_L, 3,1,false, 0xFFFFFF,0x000000); 
	}
	
	require( JModuleHelper::getLayoutPath( 'mod_inventory_clients' ) );
	
?>