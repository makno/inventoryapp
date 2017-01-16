<?php defined( '_JEXEC' ) or die( 'Restricted access' );

/**
 * @package     it+kapfenberg
 * @subpackage  com_inventory
 *
 * @copyright   Copyright (C) 2014 Jürgen Kiendler, Mathias Knoll All rights reserved.
 */

class InventoryViewOrgunits extends JViewLegacy{
	
	protected $items;
	protected $pagination;
	protected $state;

	public function display($tpl = null){
		$this->items		= $this->get('Items');
		$this->pagination	= $this->get('Pagination');
		$this->state		= $this->get('State');

		require_once JPATH_COMPONENT.'/helpers/inventory.php';
		InventoryHelper::addSubmenu('orgunits');

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
		
		JToolbarHelper::title(JText::_('COM_INVENTORY_MANAGER_ORGUNITS_ENTRIES'), 'shield orgunits');

		// if ($canDo->get('core.add')){
			JToolbarHelper::addNew('orgunit.add');
		//}
		
		if ($canDo->get('core.edit')){
			JToolbarHelper::editList('orgunit.edit');
		}
		
		if ($canDo->get('core.delete')){
			JToolbarHelper::deleteList('ARE YOU SURE?','orgunits.delete');
		}
		
		if ($user->authorise('core.admin', 'com_inventory')){
			JToolbarHelper::preferences('com_inventory');
		}
		
		JToolbarHelper::help('JHELP_COMPONENTS_INVENTORY_ORGUNIT_ENTRIES');

		JHtmlSidebar::setAction('index.php?option=com_inventory&view=orgunits');
	
	}

	/**
	 * Returns an array of fields the table can be sorted by
	 *
	 * @return  array  Array containing the field name to sort by as the key and display text as value
	 *
	 * @since   3.0
	 */
	protected function getSortFields(){
		return array(
			'a.name' => JText::_('COM_INVENTORY_NAME'),
			'a.shortdescription' => JText::_('COM_INVENTORY_SHORTDESCRIPTION'),
			'a.orgunit_id' => JText::_('COM_INVENTORY_ID')
		);
	}
}
