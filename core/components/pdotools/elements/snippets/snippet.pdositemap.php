<?php
/* @var array $scriptProperties */
/* @var pdoFetch $pdoFetch */
if (!$modx->getService('pdoFetch')) {return false;}
$pdoFetch = new pdoFetch($modx, $scriptProperties);
$pdoFetch->addTime('pdoTools loaded');

// Default variables
if (empty($tpl)) {$tpl = "@INLINE \n<url>\n\t<loc>[[+url]]</loc>\n\t<lastmod>[[+date]]</lastmod>\n\t<changefreq>[[+update]]</changefreq>\n\t<priority>[[+priority]]</priority>\n</url>";}
if (empty($tplWrapper)) {$tplWrapper = "@INLINE <?xml version=\"1.0\" encoding=\"[[++modx_charset]]\"?>\n<urlset xmlns=\"[[+schema]]\">\n[[+output]]\n</urlset>";}
if (empty($sitemapSchema)) {$sitemapSchema = 'http://www.sitemaps.org/schemas/sitemap/0.9';}
if (empty($outputSeparator)) {$outputSeparator = "\n";}

// Convert parameters from GoogleSiteMap if exists
if (!empty($itemTpl)) {$tpl = $itemTpl;}
if (!empty($containerTpl)) {$tplWrapper = $containerTpl;}
if (!empty($allowedtemplates)) {$scriptProperties['templates'] = $allowedtemplates;}
if (!empty($maxDepth)) {$scriptProperties['depth'] = $maxDepth;}
if (isset($hideDeleted)) {$scriptProperties['showDeleted'] = !$hideDeleted;}
if (isset($published)) {$scriptProperties['showUnpublished'] = !$published;}
if (isset($searchable)) {$scriptProperties['showUnsearchable'] = !$searchable;}
if (!empty($googleSchema)) {$sitemapSchema = $googleSchema;}
if (!empty($excludeResources)) {
	$tmp = array_map('trim', explode(',', $excludeResources));
	foreach ($tmp as $v) {
		if (!empty($scriptProperties['resources'])) {
			$scriptProperties['resources'] .= ',-'.$v;
		}
		else {
			$scriptProperties['resources'] = '-'.$v;
		}
	}
}
if (!empty($excludeChildrenOf)) {
	$tmp = array_map('trim', explode(',', $excludeChildrenOf));
	foreach ($tmp as $v) {
		if (!empty($scriptProperties['parents'])) {
			$scriptProperties['parents'] .= ',-'.$v;
		}
		else {
			$scriptProperties['parents'] = '-'.$v;
		}
	}
}
if (!empty($startId)) {
	if (!empty($scriptProperties['parents'])) {
		$scriptProperties['parents'] .= ','.$startId;
	}
	else {
		$scriptProperties['parents'] = $startId;
	}
}
if (!empty($sortBy)) {$scriptProperties['sortby'] = $sortBy;}
if (!empty($sortDir)) {$scriptProperties['sortdir'] = $sortDir;}
if (!empty($priorityTV)) {
	if (!empty($scriptProperties['includeTVs'])) {
		$scriptProperties['includeTVs'] .= ','.$priorityTV;
	}
	else {
		$scriptProperties['includeTVs'] = $priorityTV;
	}
}
if (!empty($itemSeparator)) {$outputSeparator = $itemSeparator;}
//---


$class = 'modResource';
$where = array();
if (empty($showHidden)) {
	$where[] = array(
		$class.'.hidemenu' => 0,
		'OR:'.$class.'.class_key:IN' => array('Ticket','Article')
	);
}
if (empty($context)) {
	$scriptProperties['context'] = $modx->context->key;
}

$select = array($class => 'id,editedon,createdon');
// Add custom parameters
foreach (array('where','select') as $v) {
	if (!empty($scriptProperties[$v])) {
		$tmp = $modx->fromJSON($scriptProperties[$v]);
		if (is_array($tmp)) {
			$$v = array_merge($$v, $tmp);
		}
	}
	unset($scriptProperties[$v]);
}
$pdoFetch->addTime('Conditions prepared');

// Default parameters
$default = array(
	'class' => $class,
	'where' => $modx->toJSON($where),
	'select' => $modx->toJSON($select),
	'sortby' => $class.'.menuindex',
	'sortdir' => 'ASC',
	'return' => 'data',
	'limit' => 0,
	//'checkPermissions' => 'load',
	'fastMode' => true
);

// Merge all properties and run!
$pdoFetch->addTime('Query parameters ready');
$pdoFetch->setConfig(array_merge($default, $scriptProperties), false);
$rows = $pdoFetch->run();

$now = time();
$output = array();
foreach ($rows as $row) {
	$url = $modx->makeUrl($row['id'], '', '', 'full');

	$time = !empty($row['editedon'])
		? $row['editedon']
		: $row['createdon'];
	$date = date('Y-m-d', $time);

	$datediff = floor(($now - $time) / 86400);
	if ($datediff <= 1) {
		$priority = '1.0';
		$update = 'daily';
	} elseif (($datediff > 1) && ($datediff <= 7)) {
		$priority = '0.75';
		$update = 'weekly';
	} elseif (($datediff > 7) && ($datediff <= 30)) {
		$priority = '0.50';
		$update = 'weekly';
	} else {
		$priority = '0.25';
		$update = 'monthly';
	}

	if (!empty($priorityTV) && !empty($row[$priorityTV])) {
		$row['priority'] = $row[$priorityTV];
	}
	/* add item to output */
	$output[] = $pdoFetch->parseChunk($tpl,
		array(
			'url' => $url,
			'date' => $date,
			'update' => $update,
			'priority' => $priority,
		)
	);
}
$pdoFetch->addTime('Rows processed');

$output = implode($outputSeparator, $output);
$output = $pdoFetch->getChunk($tplWrapper, array(
	'schema' => $sitemapSchema,
	'output' => $output,
	'items' => $output
));
$pdoFetch->addTime('Rows wrapped');

if ($modx->user->hasSessionContext('mgr') && !empty($showLog)) {
	$output .= '<pre class="pdoSitemapLog">' . print_r($pdoFetch->getTime(), 1) . '</pre>';
}

if (!empty($forceXML)) {
	header("Content-Type:text/xml");
	echo $output;
	exit();
}
else {
	return $output;
}