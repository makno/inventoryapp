<?php

/**
 * @package     it+kapfenberg
 * @subpackage  com_inventory
 *
 * @copyright   Copyright (C) 2013 Mathias Knoll All rights reserved.
 * @license     GNU AFFERO GENERAL PUBLIC LICENSE Version 3; see LICENSE.txt
 */
 
// no direct access
defined('_JEXEC') or die('Restricted access');

class InventoryHelpersStyle
{
	public static function load()
	{
		$document = JFactory::getDocument();

		//javascripts
		$document->addScript(JURI::root().'administrator/components/com_inventory/assets/js/apichecker.js');
		$document->addScript(JURI::root().'administrator/components/com_inventory/assets/js/orgunit.js');
	}
}