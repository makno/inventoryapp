// @package     it+kapfenberg
// @subpackage  com_inventory

// @copyright   Copyright (C) 2013 Mathias Knoll All rights reserved.
// @license     GNU AFFERO GENERAL PUBLIC LICENSE Version 3; see LICENSE.txt
	 
function checkForm(domain, elementname){
	retVal = jQuery("#"+elementname).serialize();
	jQuery("#"+elementname+"code").html("<b>"+domain+"</b>index.php?option=com_inventory&"+retVal);
}

function checkOutput(domain, elementname){
	retVal = jQuery("#"+elementname).serialize();
	jQuery.ajax({
		url:domain+'index.php?option=com_inventory',
		type:'POST',
		data:retVal,
		dataType:'JSON',
		success:function(data)
		{
			if ( data.success ){
				jQuery("#"+elementname+"output").html(JSON.stringify(data, null, 2));
			}else{
				jQuery("#"+elementname+"output").html(JSON.stringify(data, null, 2));
			}
		},
		error:function(data)
		{
			jQuery("#"+elementname+"output").html(JSON.stringify(data, null, 2));
		}
	});
}

function clearOutput(elementname){
	jQuery("#"+elementname+"output").html("Output ...");
}

