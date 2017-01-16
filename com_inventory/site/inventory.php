<?php // No direct access

/**
 * @package     it+kapfenberg
 * @subpackage  com_inventory
 *
 * @copyright   Copyright (C) 2013 Mathias Knoll All rights reserved.
 * @license     GNU AFFERO GENERAL PUBLIC LICENSE Version 3; see LICENSE.txt
 */

defined( '_JEXEC' ) or die( 'Restricted access' );

//sessions
jimport( 'joomla.session.session' );

// QRCode Support
include_once(JPATH_COMPONENT_ADMINISTRATOR.'/libraries/phpqrcode.php');
include_once(JPATH_COMPONENT_ADMINISTRATOR.'/libraries/authcheck.php');
 
//load tables
JTable::addIncludePath(JPATH_COMPONENT.'/tables');

//load classes
JLoader::registerPrefix('Inventory', JPATH_COMPONENT);

//Load plugins
JPluginHelper::importPlugin('inventory');
 
//Load styles and javascripts
InventoryHelpersStyle::load();

//application
$app = JFactory::getApplication();
 
// Require specific controller if requested
$controller = $app->input->get('controller','default');

// Create the controller
$classname  = 'InventoryControllers'.ucwords($controller);
$controller = new $classname();
 
// Perform the Request task
$controller->execute();