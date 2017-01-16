<?php

defined ( '_JEXEC' ) or die ( 'Restricted access' );

/**
 *
 * @package it+kapfenberg
 * @subpackage com_inventory
 *            
 * @copyright Copyright (C) 2014 Jürgen Kiendler, Mathias Knoll All rights reserved.
 */
class InventoryViewDevices extends JViewLegacy {
	protected $items;
	protected $pagination;
	protected $state;
	public function display($tpl = null) {
		
		$this->items = $this->get ( 'Items' );
		$this->pagination = $this->get ( 'Pagination' );
		$this->state = $this->get ( 'State' );
		
		require_once JPATH_COMPONENT . '/helpers/inventory.php';
		InventoryHelper::addSubmenu ( 'devices' );
		
		// Check for errors.
		if (count ( $errors = $this->get ( 'Errors' ) )) {
			JError::raiseError ( 500, implode ( "\n", $errors ) );
			return false;
		}
		
		$this->addToolbar ();
		$this->sidebar = JHtmlSidebar::render ();
		parent::display ( $tpl );
	}
	protected function addToolbar() {
		$state = $this->get ( 'State' );
		$canDo = JHelperContent::getActions ( 'com_inventory' );
		$user = JFactory::getUser ();
		
		// Get the toolbar object instance
		$bar = JToolBar::getInstance ( 'toolbar' );
		
		JToolbarHelper::title ( JText::_ ( 'COM_INVENTORY_MANAGER_DEVICES_ENTRIES' ), 'shield devices' );
		
		// if ($canDo->get('core.add')){
		JToolbarHelper::addNew ( 'device.add' );
		// }
		
		if ($canDo->get ( 'core.edit' )) {
			JToolbarHelper::editList ( 'device.edit' );
		}
		
		if ($canDo->get ( 'core.delete' )) {
			JToolbarHelper::deleteList ( 'ARE YOU SURE?', 'devices.delete' );
		}
		
		if ($user->authorise ( 'core.admin', 'com_inventory' )) {
			JToolbarHelper::preferences ( 'com_inventory' );
		}
		
		JToolbarHelper::help ( 'JHELP_COMPONENTS_INVENTORY_DEVICE_ENTRIES' );
		
		
		JHtmlSidebar::setAction ( 'index.php?option=com_inventory&view=devices' );
	}
	
	/**
	 * Returns an array of fields the table can be sorted by
	 *
	 * @return array Array containing the field name to sort by as the key and display text as value
	 *        
	 * @since 3.0
	 */
	protected function getSortFields() {
		return array(
			'a.devicename' => JText::_('COM_INVENTORY_NAME'),
			'a.snumber' => JText::_('COM_INVENTORY_SERIALNUMBER'),
			'o.name' => JText::_('COM_INVENTORY_ORGUNIT'),

		)
		;
	}
}
