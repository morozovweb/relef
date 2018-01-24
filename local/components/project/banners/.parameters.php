<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

use Bitrix\Highloadblock as HL;
use Bitrix\Main\Entity;
use \Bitrix\Main;
use \Bitrix\Main\Localization\Loc as Loc;

Loc::loadMessages(__FILE__); 

try
{
	if (!Main\Loader::includeModule('iblock'))
		throw new Main\LoaderException("iblock not found");

    if (!Main\Loader::includeModule('highloadblock'))
        throw new Main\LoaderException("iblock not found");

	$iblockTypes = \CIBlockParameters::GetIBlockTypes(Array("-" => " "));
	
	$iblocks = array(0 => " ");
	if (isset($arCurrentValues['IBLOCK_TYPE']) && strlen($arCurrentValues['IBLOCK_TYPE']))
	{
	    $filter = array(
	        'TYPE' => $arCurrentValues['IBLOCK_TYPE'],
	        'ACTIVE' => 'Y'
	    );
	    $rsIBlock = \CIBlock::GetList(array('SORT' => 'ASC'), $filter);
	    while ($arIBlock = $rsIBlock -> GetNext())
	    {
	        $iblocks[$arIBlock['ID']] = $arIBlock['NAME'];
	    }
    }

    $rsData = \Bitrix\Highloadblock\HighloadBlockTable::getList(
        array(
            'filter' => array()
        )
    );

    while ($ar = $rsData -> Fetch()){
        $iblocks[$ar['ID']] = $ar['NAME'];
    }

    $rsData = \Bitrix\Highloadblock\HighloadBlockTable::getList(
        array(
            'filter' => array()
        )
    );

    while ($ar = $rsData -> Fetch()){
        $hblocks[$ar['ID']] = $ar['NAME'];
    }

	$arComponentParameters = array(
		'GROUPS' => array(
		),
		'PARAMETERS' => array(
			'IBLOCK_TYPE' => Array(
				'PARENT' => 'BASE',
				'NAME' => Loc::getMessage('BANNERS_COMPONENT_PARAMETERS_IBLOCK_TYPE'),
				'TYPE' => 'LIST',
				'VALUES' => $iblockTypes,
				'DEFAULT' => '',
				'REFRESH' => 'Y'
			),
			'IBLOCK_ID' => array(
				'PARENT' => 'BASE',
				'NAME' => Loc::getMessage('BANNERS_COMPONENT_PARAMETERS_IBLOCK_ID'),
				'TYPE' => 'LIST',
				'VALUES' => $iblocks
			),
            'HB_TYPE' => array(
                'PARENT' => 'BASE',
                'NAME' => Loc::getMessage('BANNERS_COMPONENT_PARAMETERS_HB_TYPE'),
                'TYPE' => 'LIST',
                'VALUES' => $hblocks
            ),
            'HB_LIST' => array(
                'PARENT' => 'BASE',
                'NAME' => Loc::getMessage('BANNERS_COMPONENT_PARAMETERS_HB_LIST'),
                'TYPE' => 'LIST',
                'VALUES' => $hblocks
            ),
            'FILTER_NAME' => array(
                'PARENT' => 'BASE',
                'NAME' => Loc::getMessage('BANNERS_COMPONENT_PARAMETERS_FILTER_NAME'),
                'TYPE' => 'STRING',
                'VALUES' => "arFilter"
            ),
            "CACHE_TIME"  =>  Array("DEFAULT"=>36000000),
		)
	);
}
catch (Main\LoaderException $e)
{
	ShowError($e -> getMessage());
}
?>