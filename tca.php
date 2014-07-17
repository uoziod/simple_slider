<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

$TCA['tx_simpleslider_items'] = array (
	'ctrl' => $TCA['tx_simpleslider_items']['ctrl'],
	'interface' => array (
		'showRecordFieldList' => 'hidden,header,subheader,image,link'
	),
	'feInterface' => $TCA['tx_simpleslider_items']['feInterface'],
	'columns' => array (
		'hidden' => array (		
			'exclude' => 1,
			'label'   => 'LLL:EXT:lang/locallang_general.xml:LGL.hidden',
			'config'  => array (
				'type'    => 'check',
				'default' => '0'
			)
		),
		'header' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:simple_slider/locallang_db.xml:tx_simpleslider_items.header',		
			'config' => array (
				'type' => 'input',	
				'size' => '30',	
				'eval' => 'required',
			)
		),
		'subheader' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:simple_slider/locallang_db.xml:tx_simpleslider_items.subheader',		
			'config' => array (
				'type' => 'text',
				'cols' => '30',	
				'rows' => '5',
			)
		),
		'image' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:simple_slider/locallang_db.xml:tx_simpleslider_items.image',		
			'config' => array (
				'type' => 'group',
				'internal_type' => 'file',
				'allowed' => $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext'],	
				'max_size' => $GLOBALS['TYPO3_CONF_VARS']['BE']['maxFileSize'],	
				'uploadfolder' => 'uploads/tx_simpleslider',
				'show_thumbs' => 1,	
				'size' => 1,	
				'minitems' => 0,
				'maxitems' => 1,
			)
		),
		'link' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:simple_slider/locallang_db.xml:tx_simpleslider_items.link',		
			'config' => array (
				'type'     => 'input',
				'size'     => '15',
				'max'      => '255',
				'checkbox' => '',
				'eval'     => 'trim',
				'wizards'  => array(
					'_PADDING' => 2,
					'link'     => array(
						'type'         => 'popup',
						'title'        => 'Link',
						'icon'         => 'link_popup.gif',
						'script'       => 'browse_links.php?mode=wizard',
						'JSopenParams' => 'height=300,width=500,status=0,menubar=0,scrollbars=1'
					)
				)
			)
		),
	),
	'types' => array (
		'0' => array('showitem' => 'hidden;;1;;1-1-1, header, subheader, image, link')
	),
	'palettes' => array (
		'1' => array('showitem' => '')
	)
);
?>