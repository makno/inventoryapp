<?php defined( '_JEXEC' ) or die( 'Restricted access' ); 

/**
 * @package     it+kapfenberg
 * @subpackage  com_inventory
 *
 * @copyright   Copyright (C) 2013 Mathias Knoll All rights reserved.
 * @license     GNU AFFERO GENERAL PUBLIC LICENSE Version 3; see LICENSE.txt
 */

class InventoryViewsDeviceJson extends JViewHtml
{
  function render()
  {
    $app = JFactory::getApplication();
    $layout = $this->getLayout();

    $this->params = JComponentHelper::getParams('com_inventory');

    //retrieve task list from model
    $model = new InventoryModelsDevice();

	// Get the document object.
	$document =& JFactory::getDocument();
 
	// Set the MIME type for JSON output.
	$document->setMimeEncoding('application/json');
 
	// Change the suggested filename.
	JResponse::setHeader('Content-Disposition','attachment;filename="'.$view->getName().'.json"');
	
    return parent::render();
  } 
}