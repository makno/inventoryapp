<?php

/**
 * @package     it+kapfenberg
 * @subpackage  com_inventory
 *
 * @copyright   Copyright (C) 2013 Mathias Knoll All rights reserved.
 * @license     GNU AFFERO GENERAL PUBLIC LICENSE Version 3; see LICENSE.txt
 */
 
defined('_JEXEC') or die;


class InventoryHelper{
	
	public static $extension = 'com_inventory';
	
	public static function addSubmenu($vName){
				
		JHtmlSidebar::addEntry(
		JText::_('COM_INVENTORY_SIDEBAR_STATISTICS'),
		'index.php?option=com_inventory&view=statistics',
		$vName == 'statistics'
				);
		
		JHtmlSidebar::addEntry(
		JText::_('COM_INVENTORY_SIDEBAR_ORGUNIT_ENTRIES'),
		'index.php?option=com_inventory&view=orgunits',
		$vName == 'orgunits'
				);
				
		JHtmlSidebar::addEntry(
		JText::_('COM_INVENTORY_SIDEBAR_DEVICE_ENTRIES'),
		'index.php?option=com_inventory&view=devices',
		$vName == 'devices'
				);
				
		JHtmlSidebar::addEntry(
		JText::_('COM_INVENTORY_SIDEBAR_API'),
		'index.php?option=com_inventory&view=api',
		$vName == 'api'
				);
				
		JHtmlSidebar::addEntry(
		JText::_('COM_INVENTORY_SIDEBAR_ABOUT'),
		'index.php?option=com_inventory&view=about',
		$vName == 'scanstatuss'
				);
	
	}

	public static function getActions(){
		
		$user	= JFactory::getUser();
		$result	= new JObject;

		$assetName = 'com_inventory';
		$level = 'component';

		$actions = JAccess::getActions('com_inventory', $level);

		foreach ($actions as $action)
		{
			$result->set($action->name,	$user->authorise($action->name, $assetName));
		}

		return $result;
	}
}