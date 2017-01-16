<?php defined( '_JEXEC' ) or die( 'Restricted access' );

/**
 * @package     it+kapfenberg
 * @subpackage  com_inventory
 *
 * @copyright   Copyright (C) 2014 Jürgen Kiendler, Mathias Knoll All rights reserved.
 */

class InventoryViewApi extends JViewLegacy{
	
	public function display($tpl = null){

		require_once JPATH_COMPONENT.'/helpers/inventory.php';
		InventoryHelper::addSubmenu('api');

		// Check for errors.
		if (count($errors = $this->get('Errors'))){
			JError::raiseError(500, implode("\n", $errors));
			return false;
		}

		$this->addToolbar();
		$this->sidebar = JHtmlSidebar::render();
		parent::display($tpl);
	}

	protected function addToolbar(){
		$state	= $this->get('State');
		$canDo	= JHelperContent::getActions('com_inventory');
		$user	= JFactory::getUser();

		// Get the toolbar object instance
		$bar = JToolBar::getInstance('toolbar');
		
		JToolbarHelper::title(JText::_('COM_INVENTORY_MANAGER_API'), 'shield api');
	
		if ($user->authorise('core.admin', 'com_inventory')){
			JToolbarHelper::preferences('com_inventory');
		}
		
		JToolbarHelper::help('JHELP_COMPONENTS_INVENTORY_API');

		JHtmlSidebar::setAction('index.php?option=com_inventory&view=api');
	
	}

}
