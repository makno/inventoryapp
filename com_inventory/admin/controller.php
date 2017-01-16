<?php defined( '_JEXEC' ) or die( 'Restricted access' ); // No direct access

/**
 * @package     it+kapfenberg
 * @subpackage  com_inventory
 *
 * @copyright   Copyright (C) 2014 Klaus Gebeshuber, Mathias Knoll All rights reserved.
 */

class InventoryController extends JControllerLegacy{

	public function display($cachable = false, $urlparams = false){
		
		require_once JPATH_COMPONENT.'/helpers/inventory.php';

		$view   = $this->input->get('view', 'default');		
		$layout = $this->input->get('layout', 'default');
		$id     = $this->input->getInt('id');
		


		if ($view == 'device' && $layout == 'edit' && !$this->checkEditId('com_inventory.edit.device', $id)){
			$this->setError(JText::sprintf('JLIB_APPLICATION_ERROR_UNHELD_ID', $id));
			$this->setMessage($this->getError(), 'error');
			$this->setRedirect(JRoute::_('index.php?option=com_inventory&view=devices', false));
			return false;
		}
		
		if($view=='default'){
			$this->setRedirect(JRoute::_('index.php?option=com_inventory&view=statistics', false));
			return true;
		}
		
		parent::display();
	}
}
