<?php 

	/**
	 * @package     it+kapfenberg
	 * @subpackage  mod_inventory_clients
	 *
	 * @copyright   Copyright (C) 2013 Mathias Knoll All rights reserved.
	 * @license     GNU AFFERO GENERAL PUBLIC LICENSE Version 3; see LICENSE.txt
	 */

	defined( '_JEXEC' ) or die( 'Restricted access' ); 
?>

<div>
	<table width="100%">
	<tr><td width="50%">
	<a href="<?php echo JURI::root();?>modules/mod_inventory_clients/downloads/iNventory.apk" target="_self">
		<img src="<?php echo JURI::root();?>modules/mod_inventory_clients/images/android.svg" width="20%" style="vertical-align: middle;" />&nbsp;Android
		<img src="<?php echo JURI::root();?>modules/mod_inventory_clients/images/qrcode_android.svg" width="90%"/>
	</a>
	</td><td width="50%">
	<a href="https://itunes.apple.com/at/app/kmu-goes-mobile-inventory/id686437533?mt=8" target="_blank" >
		<img src="<?php echo JURI::root();?>modules/mod_inventory_clients/images/ios.svg" width="20%" style="vertical-align: middle;"/>&nbsp;iOS
		<img src="<?php echo JURI::root();?>modules/mod_inventory_clients/images/qrcode_ios.svg" width="90%"/>
	</a>
	</td></tr>
	<?php
		if(file_exists(JPATH_BASE.'/inventory')){
		?>	
			<tr><td width="50%">
				<a href="<?php echo JURI::root();?>inventory" target="_blank">
					<img src="<?php echo JURI::root();?>modules/mod_inventory_clients/images/html5.svg" width="20%" style="vertical-align: middle;" />&nbsp;HTML5
					<img src="<?php echo JURI::root();?>modules/mod_inventory_clients/images/qrcode_html5.svg" width="90%"/>
				</a>
			</td>
			</tr>
		<?php
		}
	?>
	</table>	
</div>