<?php defined( '_JEXEC' ) or die( 'Restricted access' );

/**
 * @package     it+kapfenberg
 * @subpackage  com_inventory
 *
 * @copyright   Copyright (C) 2013 Mathias Knoll All rights reserved.
 * @license     GNU AFFERO GENERAL PUBLIC LICENSE Version 3; see LICENSE.txt
 */

class InventoryViewsDeviceHtml extends JViewHtml
{
  function render()
  {
    $app = JFactory::getApplication();
    $layout = $this->getLayout();

    $this->params = JComponentHelper::getParams('com_inventory');

    //$model = new InventoryModelsDevice(); // Given already by Controller!
	
	$this->_editor = JFactory::getEditor();
	$this->_params = array( 
		'smilies'			=> '0' ,
		 'style'  			=> '1' ,  
		 'layer'  			=> '0' , 
		 'table'  			=> '0' ,
		 'clear_entities'	=>'0'
		 );
		 
    if($layout == 'list')
    {
		if($this->model->_selectionTag != null && $this->model->_selectionTag == "notag"){
			$this->devices = $this->model->listItemsWithNoTags();
		}else{
			$this->devices = $this->model->listItems();
		}
		$this->model->items_total = sizeof($this->devices);
		
		$this->_modalMessage = InventoryHelpersView::load('Device','_message','phtml');
		$this->_lendDeviceView = InventoryHelpersView::load('Device','_lend','phtml');
		$this->_addDeviceView = InventoryHelpersView::load('Device','_add','phtml');
        $this->_editDeviceView = InventoryHelpersView::load('Device','_edit','phtml');
        $this->_deviceListView = InventoryHelpersView::load('Device','_entry','phtml');		
		$this->_returnDeviceView = InventoryHelpersView::load('Device', '_return', 'phtml');
		
		$this->_addDeviceView->_editor = $this->_editor;
		$this->_addDeviceView->_params = $this->_params;
		$this->_editDeviceView->_editor = $this->_editor;
		$this->_editDeviceView->_params = $this->_params;
		
		$this->_deviceListView->_editor = $this->_editor;
		$this->_deviceListView->_params = $this->_params;
    }
	
	if($layout == 'profile' || $layout == 'device'){
        $this->device = $this->model->getItem();
		$this->_modalMessage = InventoryHelpersView::load('Profile','_message','phtml');
        $this->_lendDeviceView = InventoryHelpersView::load('Device', '_lend', 'phtml');
		$this->_returnDeviceView = InventoryHelpersView::load('Device', '_return', 'phtml');
        $this->_editDeviceView = InventoryHelpersView::load('Device','_edit','phtml');
        $this->_lendDeviceView->device = $this->device;
        $this->_returnDeviceView->device = $this->device;   
		
		$this->_editDeviceView->_editor = $this->_editor;
		$this->_editDeviceView->_params = $this->_params;
    }
	
    return parent::render();
  } 
}