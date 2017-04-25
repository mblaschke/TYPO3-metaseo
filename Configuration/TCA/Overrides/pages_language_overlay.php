<?php
defined('TYPO3_MODE') || die();

$tempColumns = array(
    'tx_metaseo_pagetitle'        => array(
        'exclude' => 1,
        'label'   => 'LLL:EXT:metaseo/Resources/Private/Language/TCA/locallang.xlf:'
            . 'pages_language_overlay.tx_metaseo_pagetitle',
        'config'  => array(
            'type'     => 'input',
            'size'     => '30',
            'max'      => '255',
            'checkbox' => '',
            'eval'     => 'trim',
        )
    ),
    'tx_metaseo_pagetitle_rel'    => array(
        'exclude' => 1,
        'label'   => 'LLL:EXT:metaseo/Resources/Private/Language/TCA/locallang.xlf:'
            . 'pages_language_overlay.tx_metaseo_pagetitle_rel',
        'config'  => array(
            'type'     => 'input',
            'size'     => '30',
            'max'      => '255',
            'checkbox' => '',
            'eval'     => 'trim',
        )
    ),
    'tx_metaseo_pagetitle_prefix' => array(
        'label'   => 'LLL:EXT:metaseo/Resources/Private/Language/TCA/locallang.xlf:'
            . 'pages.tx_metaseo_pagetitle_prefix',
        'exclude' => 1,
        'config'  => array(
            'type'     => 'input',
            'size'     => '30',
            'max'      => '255',
            'checkbox' => '',
            'eval'     => 'trim',
        )
    ),
    'tx_metaseo_pagetitle_suffix' => array(
        'label'   => 'LLL:EXT:metaseo/Resources/Private/Language/TCA/locallang.xlf:'
            . 'pages.tx_metaseo_pagetitle_suffix',
        'exclude' => 1,
        'config'  => array(
            'type'     => 'input',
            'size'     => '30',
            'max'      => '255',
            'checkbox' => '',
            'eval'     => 'trim',
        )
    ),
    'tx_metaseo_canonicalurl'     => array(
        'label'   => 'LLL:EXT:metaseo/Resources/Private/Language/TCA/locallang.xlf:'
            . 'pages.tx_metaseo_canonicalurl',
        'exclude' => 1,
        'config'  => array(
            'type'     => 'input',
            'size'     => '30',
            'max'      => '255',
            'checkbox' => '',
            'eval'     => 'trim',
            'renderType' => 'inputLink',
            'fieldControl' => array(
                'linkPopup' => array(
                    'options' => array(
                        'blindLinkOptions' => 'mail',
                    ),
                ),
            ),
        )
    ),
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('pages_language_overlay', $tempColumns);

// TCA Palettes
$GLOBALS['TCA']['pages_language_overlay']['palettes']['tx_metaseo_pagetitle'] = array(
    'showitem'       => 'tx_metaseo_pagetitle,--linebreak--,tx_metaseo_pagetitle_prefix,tx_metaseo_pagetitle_suffix',
    'canNotCollapse' => 1
);

$GLOBALS['TCA']['pages_language_overlay']['palettes']['tx_metaseo_crawler'] = array(
    'showitem'       => 'tx_metaseo_canonicalurl',
    'canNotCollapse' => 1
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes(
    'pages_language_overlay',
    'tx_metaseo_pagetitle_rel',
    '',
    'after:title'
);

// Put it for standard page overlay
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes(
    'pages_language_overlay',
    '--div--;LLL:EXT:metaseo/Resources/Private/Language/TCA/locallang.xlf:pages.tab.seo;,--palette--;'
    . 'LLL:EXT:metaseo/Resources/Private/Language/TCA/locallang.xlf:pages.palette.pagetitle;tx_metaseo_pagetitle,'
    . '--palette--;LLL:EXT:metaseo/Resources/Private/Language/TCA/locallang.xlf:pages.palette.crawler;'
    . 'tx_metaseo_crawler',
    '',
    'after:author_email'
);
