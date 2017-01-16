<?php defined('_JEXEC') or die('Restricted access');

/**
 * @package     it+kapfenberg
 * @subpackage  com_inventory
 *
 * @copyright   Copyright (C) 2013 Mathias Knoll All rights reserved.
 * @license     GNU AFFERO GENERAL PUBLIC LICENSE Version 3; see LICENSE.txt
 */

class InventoryHelpersStyle
{
	public static function load()
	{
		$document = JFactory::getDocument();

		//stylesheets
		$document->addStylesheet(JURI::base().'components/com_inventory/assets/css/style.css');

		//javascripts
		$document->addScript(JURI::base().'components/com_inventory/assets/js/inventory.js');
		
	}
}