<?php defined( '_JEXEC' ) or die( 'Restricted access' ); // No direct access

/**
 * @package     it+kapfenberg
 * @subpackage  com_inventory
 *
 * @copyright   Copyright (C) 2014 Jürgen Kiendler, Mathias Knoll All rights reserved.
 */

class InventoryControllerAbout extends JControllerAdmin{
	
	public function getModel($name = 'About', $prefix = 'InventoryModel', $config = array('ignore_request' => true)){
		$model = parent::getModel($name, $prefix, $config);
		return $model;
	}
	
	protected function postDeleteHook(JModelLegacy $model, $ids = null)
	{
		return;
	}
}
