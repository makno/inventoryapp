<?php defined( '_JEXEC' ) or die( 'Restricted access' );

/**
 * @package     it+kapfenberg
 * @subpackage  com_inventory
 *
 * @copyright   Copyright (C) 2013 Mathias Knoll All rights reserved.
 * @license     GNU AFFERO GENERAL PUBLIC LICENSE Version 3; see LICENSE.txt
 */

class InventoryControllersDefault extends JControllerBase
{
  public function execute()
  {

    // Get the application
    $app = $this->getApplication();

    $params = JComponentHelper::getParams('com_inventory');
    if ($params->get('required_account') == 1) 
    {
        $user = JFactory::getUser();
        if ($user->get('guest'))
        {
            $app->redirect('index.php',JText::_('COM_INVENTORY_ACCOUNT_REQUIRED_MSG'));
        }
    }
 
    // Get the document object.
    $document     = JFactory::getDocument();
 
    $viewName     = $app->input->getWord('view', 'device');
    $viewFormat   = $document->getType();
    $layoutName   = $app->input->getWord('layout', 'list');

    $app->input->set('view', $viewName);
 
    // Register the layout paths for the view
    $paths = new SplPriorityQueue;
    $paths->insert(JPATH_ROOT . '/templates/' . $app->getTemplate() .'/html/com_inventory/'.$viewName, 'normal');
     
    $overrideTmplPath = JPATH_COMPONENT . '/views/' . $viewName . '/tmpl';
    if (file_exists($overrideTmplPath))
        $paths->insert(JPATH_COMPONENT . '/views/' . $viewName . '/tmpl', 'normal');
 
    $viewClass  = 'InventoryViews' . ucfirst($viewName) . ucfirst($viewFormat);
    $modelClass = 'InventoryModels' . ucfirst($viewName);

    if (false === class_exists($modelClass))
    {
      $modelClass = 'InventoryModelsDefault';
    }
	
	$model = new $modelClass;
	$model->_status = JRequest::getVar('statusSelection', '');
	$model->_selectionTag = JRequest::getVar('tagSelection', '');
	$model->_selectionTags = $this->checkTags();
	
    $view = new $viewClass($model, $paths);

    $view->setLayout($layoutName);

    // Render our view.
    echo $view->render();
 
    return true;
  }
  
  private function checkTags(){
	$tagSelectionResult = array();
	$hasTag = false;
  	$tagSelection = JRequest::getVar('tagSelection', '', 'post','string',JREQUEST_NOTRIM);
	$tagSelectionAll = JRequest::getVar('tagSelectionAll', '', 'post','string',JREQUEST_NOTRIM);
	if(empty($tagSelection)&&empty($tagSelectionAll)){
		$tagSelectionArray = array();
		$tagSelectionAll = '';
	}else{				
		$tagSelectionArray =  preg_split('#,#',$tagSelectionAll);
		foreach ($tagSelectionArray as $tag){
			if ($tagSelection==$tag){
					$hasTag = true;
			}else{
				if(!empty($tag))
					array_push($tagSelectionResult,$tag);
			}
		}
		if(!$hasTag){
			array_push($tagSelectionResult,$tagSelection);
		}
	}
	asort($tagSelectionResult, SORT_STRING);	
	return $tagSelectionResult;
  }
  
}