<?php defined( '_JEXEC' ) or die( 'Restricted access' ); // No direct access

/**
 * @package     it+kapfenberg
 * @subpackage  com_inventory
 *
 * @copyright   Copyright (C) 2013 Mathias Knoll All rights reserved.
 * @license     GNU AFFERO GENERAL PUBLIC LICENSE Version 3; see LICENSE.txt
 */

JHtml::_('behavior.tabstate');

JForm::addFormPath(JPATH_COMPONENT_ADMINISTRATOR . '/models/forms');
JForm::addFieldPath(JPATH_COMPONENT_ADMINISTRATOR . '/models/fields');


//InventoryHelpersStyle::load();

if (!JFactory::getUser()->authorise('core.manage', 'com_inventory')){
	return JError::raiseWarning(404, JText::_('JERROR_ALERTNOAUTHOR'));
}

$controller	= JControllerLegacy::getInstance('Inventory');
$controller->execute(JFactory::getApplication()->input->get('task'));
$controller->redirect();

?>

