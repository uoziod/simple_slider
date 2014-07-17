<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

$TCA['tt_content']['types']['list']['subtypes_addlist'][$_EXTKEY.'_pi1']='pi_flexform';

t3lib_div::loadTCA('tt_content');
$TCA['tt_content']['types']['list']['subtypes_excludelist'][$_EXTKEY.'_pi1']='layout,select_key,pages';


t3lib_extMgm::addPlugin(array(
	'LLL:EXT:simple_slider/locallang_db.xml:tt_content.list_type_pi1',
	$_EXTKEY . '_pi1',
	t3lib_extMgm::extRelPath($_EXTKEY) . 'ext_icon.gif'
),'list_type');


if (TYPO3_MODE == 'BE') {
	$TBE_MODULES_EXT['xMOD_db_new_content_el']['addElClasses']['tx_simpleslider_pi1_wizicon'] = t3lib_extMgm::extPath($_EXTKEY).'pi1/class.tx_simpleslider_pi1_wizicon.php';
}


t3lib_extMgm::allowTableOnStandardPages('tx_simpleslider_items');

$TCA['tx_simpleslider_items'] = array (
	'ctrl' => array (
		'title'     => 'LLL:EXT:simple_slider/locallang_db.xml:tx_simpleslider_items',		
		'label'     => 'header',	
		'tstamp'    => 'tstamp',
		'crdate'    => 'crdate',
		'cruser_id' => 'cruser_id',
		'sortby' => 'sorting',	
		'delete' => 'deleted',	
		'enablecolumns' => array (		
			'disabled' => 'hidden',
		),
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY).'tca.php',
		'iconfile'          => t3lib_extMgm::extRelPath($_EXTKEY).'icon_tx_simpleslider_items.gif',
		'typeicons' => array (
			'1' => t3lib_extMgm::extRelPath($_EXTKEY).'icon_tx_simpleslider_items.gif',
		),
	),
);

t3lib_extMgm::addPiFlexFormValue($_EXTKEY.'_pi1', 'FILE:EXT:'.$_EXTKEY.'/flexform_ds.xml');

?>