<?php

$properties = array();

$tmp = array(
	'tpl' => array(
		'type' => 'textfield'
		,'value' => ''
	)
	,'returnIds' => array(
		'type' => 'combo-boolean'
		,'value' => false
	)
	,'showLog' => array(
		'type' => 'combo-boolean'
		,'value' => false
	)
	,'fastMode' => array(
		'type' => 'combo-boolean'
		,'value' => false
	)
	,'sortby' => array(
		'type' => 'textfield'
		,'value' => 'publishedon'
	)
	,'sortdir' => array(
		'type' => 'list'
		,'options' => array(
			array('text' => 'ASC','value' => 'ASC')
			,array('text' => 'DESC','value' => 'DESC')
		)
		,'value' => 'DESC',
	)
	,'limit' => array(
		'type' => 'numberfield'
		,'value' => 10
	)
	,'offset' => array(
		'type' => 'numberfield'
		,'value' => 0
	)
	,'depth' => array(
		'type' => 'numberfield'
		,'value' => 10
	)
	,'outputSeparator' => array(
		'type' => 'textfield'
		,'value' => "\n"
	)
	,'toPlaceholder' => array(
		'type' => 'textfield'
		,'value' => ''
	)
	,'parents' => array(
		'type' => 'textfield'
		,'value' => ''
	)
	,'includeContent' => array(
		'type' => 'combo-boolean'
		,'value' => false
	)

	,'includeTVs' => array(
		'type' => 'textfield'
		,'value' => ''
	)
	,'prepareTVs' => array(
		'type' => 'textfield'
		,'value' => '1'
	)
	,'processTVs' => array(
		'type' => 'textfield'
		,'value' => ''
	)
	,'tvPrefix' => array(
		'type' => 'textfield'
		,'value' => 'tv.'
	)
	,'tvFilters' => array(
		'type' => 'textfield'
		,'value' => ''
	)
	,'tvFiltersAndDelimiter' => array(
		'type' => 'textfield'
		,'value' => ','
	)
	,'tvFiltersOrDelimiter' => array(
		'type' => 'textfield'
		,'value' => '||'
	)

	,'where' => array(
		'type' => 'textfield'
		,'value' => ''
	)
	,'showUnpublished' => array(
		'type' => 'combo-boolean'
		,'value' => false
	)
	,'showDeleted' => array(
		'type' => 'combo-boolean'
		,'value' => false
	)
	,'showHidden' => array(
		'type' => 'combo-boolean'
		,'value' => true
	)
	,'hideContainers' => array(
		'type' => 'combo-boolean'
		,'value' => false
	)
	,'context' => array(
		'type' => 'textfield'
		,'value' => ''
	)
	,'idx' => array(
		'type' => 'numberfield'
		,'value' => ''
	)

	,'first' => array(
		'type' => 'numberfield'
		,'value' => ''
	)
	,'last' => array(
		'type' => 'numberfield'
		,'value' => ''
	)
	,'tplFirst' => array(
		'type' => 'textfield'
		,'value' => ''
	)
	,'tplLast' => array(
		'type' => 'textfield'
		,'value' => ''
	)
	,'tplOdd' => array(
		'type' => 'textfield'
		,'value' => ''
	)
	,'tplWrapper' => array(
		'type' => 'textfield'
		,'value' => ''
	)
	,'wrapIfEmpty' => array(
		'type' => 'combo-boolean'
		,'value' => false
	)
	,'totalVar' => array(
		'type' => 'textfield'
		,'value' => 'total'
	)
	,'resources' => array(
		'type' => 'textfield'
		,'value' => ''
	)
	,'tplCondition' => array(
		'type' => 'textfield'
		,'value' => ''
	)
	,'tplOperator' => array(
		'type' => 'list'
		,'options' => array(
			array('text' => 'is equal to','value' => '=='),
			array('text' => 'is not equal to','value' => '!='),
			array('text' => 'less than','value' => '<'),
			array('text' => 'less than or equal to','value' => '<='),
			array('text' => 'greater than or equal to','value' => '>='),
			array('text' => 'is empty','value' => 'empty'),
			array('text' => 'is not empty','value' => '!empty'),
			array('text' => 'is null','value' => 'null'),
			array('text' => 'is in array','value' => 'inarray'),
			array('text' => 'is between','value' => 'between'),
		)
		,'value' => '=='
	)
	,'conditionalTpls' => array(
		'type' => 'textarea'
		,'value' => ''
	)
	,'select' => array(
		'type' => 'textarea'
		,'value' => ''
	)
	,'toSeparatePlaceholders' => array(
		'type' => 'textfield'
		,'value' => ''
	)
	,'loadModels' => array(
		'type' => 'textfield'
		,'value' => ''
	)

);

foreach ($tmp as $k => $v) {
	$properties[] = array_merge(array(
			'name' => $k
			,'desc' => 'pdotools_prop_'.$k
			,'lexicon' => 'pdotools:properties'
		), $v
	);
}

return $properties;