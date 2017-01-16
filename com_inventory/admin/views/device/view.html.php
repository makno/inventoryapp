<?php defined( '_JEXEC' ) or die( 'Restricted access' ); // No direct access

/**
 * @package     it+kapfenberg
 * @subpackage  com_inventory
 *
 * @copyright   Copyright (C) 2014 Jürgen Kiendler, Mathias Knoll All rights reserved.
 */

class InventoryViewDevice extends JViewLegacy{

	protected $item;

	protected $form;

	protected $state;

	public function display($tpl = null){

		$this->state	= $this->get('State');
		$this->item		= $this->get('Item');
		$this->form		= $this->get('Form');

		// Check for errors.
		if (count($errors = $this->get('Errors'))){
			JError::raiseError(500, implode("\n", $errors));
			return false;
		}
		
		$this->addToolbar();
		parent::display($tpl);
	}

	protected function addToolbar(){
		
		JFactory::getApplication()->input->set('hidemainmenu', true);

		$user		= JFactory::getUser();
		
		if(isset($this->item->device_id))
			$isNew		= ($this->item->device_id == 0);
		else
			$isNew 		= true;
		
		$canDo		= JHelperContent::getActions('com_inventory');
		
		JToolbarHelper::title(JText::_('COM_INVENTORY_MANAGER_DEVICE'), 'list devices');

		if (($canDo->get('core.edit') || count($user->getAuthorisedCategories('com_inventory', 'core.create')) > 0)){
			JToolbarHelper::apply('device.apply');
			JToolbarHelper::save('device.save');
		}

		JToolbarHelper::cancel('device.cancel');
		
	}
}
