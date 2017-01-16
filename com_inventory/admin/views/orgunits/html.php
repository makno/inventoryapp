<?php defined( '_JEXEC' ) or die( 'Restricted access' ); 

/**
 * @package     it+kapfenberg
 * @subpackage  com_inventory
 *
 * @copyright   Copyright (C) 2013 Mathias Knoll All rights reserved.
 * @license     GNU AFFERO GENERAL PUBLIC LICENSE Version 3; see LICENSE.txt
 */
 
JLoader::register('InventoryAdminHelper', JPATH_COMPONENT.'/helpers/common.php');
 
class InventoryViewsOrgunitsHtml extends JViewHtml
{

	function render()
	{
		$app = JFactory::getApplication();
		$model = new InventoryModelsOrgunits();
		$this->items = $model->getList();
		InventoryAdminHelper::addSubmenu('orgunits');
		$this->sidebar = JHtmlSidebar::render();
		$this->addToolbar();
		return parent::render();
	} 

	protected function addToolbar()
	{
		$canDo  = InventoryHelpersInventory::getActions();
		$bar = JToolBar::getInstance('toolbar');
		JToolbarHelper::title(JText::_('COM_INVENTORY_ORGUNITS'));        
		JToolbarHelper::addNew('add');
		if ($canDo->get('core.admin'))
		{
			JToolbarHelper::preferences('com_inventory');
		}
		

	}
}