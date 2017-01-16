<?php defined('_JEXEC') or die('Restricted access');

/**
 * @package     it+kapfenberg
 * @subpackage  com_inventory
 *
 * @copyright   Copyright (C) 2013 Mathias Knoll All rights reserved.
 * @license     GNU AFFERO GENERAL PUBLIC LICENSE Version 3; see LICENSE.txt
 */

class InventoryHelpersView
{
	public static function load($viewName, $layoutName='default', $viewFormat='html', $vars=null)
	{
		// Get the application
		$app = JFactory::getApplication();

		$app->input->set('view', $viewName);

        // Register the layout paths for the view
	    $paths = new SplPriorityQueue;
	    $paths->insert(JPATH_COMPONENT . '/views/' . strtolower($viewName) . '/tmpl', 'default');
	    
        // Template Override for Tiles Design --> strtolower !!!
	    // $overridePath = JPATH_ROOT . '/templates/' . $app->getTemplate() .'/html/com_inventory/'.strtolower($viewName);	    
    	// if (file_exists($overridePath))
        // 	$paths->insert($overridePath, 'normal'); 
	 
	    $viewClass  = 'InventoryViews' . ucfirst($viewName) . ucfirst($viewFormat);
	    $modelClass = 'InventoryModels' . ucfirst($viewName);

	    if (false === class_exists($modelClass))
	    {
	      $modelClass = 'InventoryModelsDefault';
	    }

	    $view = new $viewClass(new $modelClass, $paths);

	    $view->setLayout($layoutName);
	    
		if(isset($vars)) 
		{
			foreach($vars as $varName => $var) 
			{
				$view->$varName = $var;
			}
		}

		return $view;
	}

	public static function getHtml($view, $layout, $item, $data)
	{
		$objectView = InventoryHelpersView::load($view, $layout, 'phtml');
  		$objectView->$item = $data;

  		ob_start();
  		echo  $objectView->render();
  		$html = ob_get_contents();
  		ob_end_clean();

  		return $html;
	}
}
