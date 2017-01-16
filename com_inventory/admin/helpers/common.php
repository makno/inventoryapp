<?php defined('_JEXEC') or die;

/**
 * @package     it+kapfenberg
 * @subpackage  com_inventory
 *
 * @copyright   Copyright (C) 2013 Mathias Knoll All rights reserved.
 * @license     GNU AFFERO GENERAL PUBLIC LICENSE Version 3; see LICENSE.txt
 */
 
class InventoryAdminHelper
{
	public static function addSubmenu($vName)
	{
		JHtmlSidebar::addEntry(
			JText::_('COM_INVENTORY_STATISTICS'),
			'index.php?option=com_inventory',
			$vName == 'statistics'
		);

		JHtmlSidebar::addEntry(
			JText::_('COM_INVENTORY_ORGUNITS'),
			'index.php?option=com_inventory&view=orgunits',
			$vName == 'orgunits'
		);
		
		JHtmlSidebar::addEntry(
			JText::_('COM_INVENTORY_DEVICES'),
			'index.php?option=com_inventory&view=devices',
			$vName == 'devices'
		);
		
		JHtmlSidebar::addEntry(
			JText::_('COM_INVENTORY_API'),
			'index.php?option=com_inventory&view=api',
			$vName == 'api'
		);

		JHtmlSidebar::addEntry(
			JText::_('COM_INVENTORY_ABOUT'),
			'index.php?option=com_inventory&view=about',
			$vName == 'about'
		);

	}
}
