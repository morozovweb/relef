<? require_once($_SERVER['DOCUMENT_ROOT'] . "/bitrix/modules/main/include/prolog_before.php");

use Bitrix\Highloadblock as HL;
use Bitrix\Main\Entity;

if (!CModule::IncludeModule('highloadblock') and !CModule::IncludeModule('iblock')) {
    die();
}

$arBlocks = array(
    array(
        "TYPE" => "IB",
        "IBLOCK_TYPE" => array(
            'ID' => 'type_catalog',
            'SECTIONS' => 'Y',
            'SORT' => 100,
            'LANG' => Array(
                'ru' => Array(
                    'NAME' => 'Каталог',
                    'SECTION_NAME' => 'Секции',
                    'ELEMENT_NAME' => 'Элементы'
                ),
                'en' => Array(
                    'NAME' => 'Catalog',
                    'SECTION_NAME' => 'Sections',
                    'ELEMENT_NAME' => 'Products'
                )
            )
        ),
        "IBLOCK" => array(
            "ACTIVE" => "Y",
            "NAME" => "Каталог",
            "CODE" => "catalog",
            "IBLOCK_TYPE_ID" => "type_catalog",
            "SITE_ID" => Array("s1"),
            "SORT" => 100,
        )
    ),
    array(
        "TYPE" => "HB",
        "NAME" => "RcBannersTypes",
        "TABLE_NAME" => "rc_banners_types",
        "UF" => array(
            array(
                "FIELD_NAME" => "NAME",
                "USER_TYPE_ID" => "string",
                "MULTIPLE" => "N",
                "SIZE" => 100,
                "ROWS" => 1,
                "NAME_RU" => "Наименование",
                "NAME_EN" => "Name",
            ),
            array(
                "FIELD_NAME" => "CODE",
                "USER_TYPE_ID" => "string",
                "MULTIPLE" => "N",
                "SIZE" => 100,
                "ROWS" => 1,
                "NAME_RU" => "Код",
                "NAME_EN" => "Code",
            ),
            array(
                "FIELD_NAME" => "COUNT",
                "USER_TYPE_ID" => "string",
                "MULTIPLE" => "N",
                "SIZE" => 100,
                "ROWS" => 1,
                "NAME_RU" => "Количество",
                "NAME_EN" => "Count",
            )
        ),
    ),
    array(
        "TYPE" => "HB",
        "NAME" => "RcBannersList",
        "TABLE_NAME" => "rc_banners_list",
        "UF" => array(
            array(
                "FIELD_NAME" => "ACTIVE",
                "USER_TYPE_ID" => "boolean",
                "MULTIPLE" => "N",
                "SIZE" => "",
                "ROWS" => "",
                "NAME_RU" => "Активность",
                "NAME_EN" => "Active",
            ),
            array(
                "FIELD_NAME" => "DATE_ACTIVE",
                "USER_TYPE_ID" => "datetime",
                "MULTIPLE" => "N",
                "SIZE" => "",
                "ROWS" => "",
                "NAME_RU" => "Дата активности",
                "NAME_EN" => "Date active",
            ),
            array(
                "FIELD_NAME" => "TYPE",
                "USER_TYPE_ID" => "hlblock",
                "MULTIPLE" => "N",
                "SIZE" => 100,
                "ROWS" => 1,
                "NAME_RU" => "Тип баннера",
                "NAME_EN" => "Type of banner",
                "SETTINGS" => array(
                    "DISPLAY" => "LIST",
                    "LIST_HEIGHT" => "5",
                    "HLBLOCK_ID" => "RcBannersTypes",
                    "HLFIELD_ID" => 0,
                    "DEFAULT_VALUE" => 0
                )

            ),
            array(
                "FIELD_NAME" => "PICTURE",
                "USER_TYPE_ID" => "file",
                "MULTIPLE" => "N",
                "NAME_RU" => "Изображение",
                "NAME_EN" => "Picture",
            ),
            array(
                "FIELD_NAME" => "LINK",
                "USER_TYPE_ID" => "string",
                "MULTIPLE" => "N",
                "SIZE" => "",
                "ROWS" => "",
                "NAME_RU" => "Ссылка",
                "NAME_EN" => "Link",
            ),
            array(
                "FIELD_NAME" => "TARGET",
                "USER_TYPE_ID" => "enumeration",
                "MULTIPLE" => "N",
                "SIZE" => "",
                "ROWS" => "",
                "NAME_RU" => "Где открыть",
                "NAME_EN" => "Target",
                "SETTINGS" => array(
                    "DISPLAY" => "LIST",
                    "LIST_HEIGHT" => "5",

                ),
                "VALUES" => array(
                    "blank" => "В новом окне",
                    "self" => "В текущем окне"
                )
            ),
            array(
                "FIELD_NAME" => "TITLE",
                "USER_TYPE_ID" => "string",
                "MULTIPLE" => "N",
                "SIZE" => 100,
                "ROWS" => 1,
                "NAME_RU" => "Подсказка",
                "NAME_EN" => "Title",
            ),
            array(
                "FIELD_NAME" => "SHOW",
                "USER_TYPE_ID" => "string",
                "MULTIPLE" => "N",
                "SIZE" => 100,
                "ROWS" => 1,
                "NAME_RU" => "Количество показов баннера",
                "NAME_EN" => "Count",
            ),
            array(
                "FIELD_NAME" => "RATING",
                "USER_TYPE_ID" => "integer",
                "MULTIPLE" => "N",
                "SIZE" => 100,
                "ROWS" => 1,
                "NAME_RU" => "Рейтинг",
                "NAME_EN" => "Rating",
            ),
            array(
                "FIELD_NAME" => "SORT",
                "USER_TYPE_ID" => "integer",
                "MULTIPLE" => "N",
                "SIZE" => 100,
                "ROWS" => 1,
                "NAME_RU" => "Сортировка",
                "NAME_EN" => "Sort",
            ),
            array(
                "FIELD_NAME" => "FIX",
                "USER_TYPE_ID" => "boolean",
                "MULTIPLE" => "N",
                "SIZE" => 100,
                "ROWS" => 1,
                "NAME_RU" => "Сортировка",
                "NAME_EN" => "Sort",
            ),
            array(
                "FIELD_NAME" => "ALIGN",
                "USER_TYPE_ID" => "enumeration",
                "MULTIPLE" => "N",
                "SIZE" => "",
                "ROWS" => "",
                "NAME_RU" => "Выравнивание",
                "NAME_EN" => "Align",
                "SETTINGS" => array(
                    "DISPLAY" => "LIST",
                    "LIST_HEIGHT" => "5",

                ),
                "VALUES" => array(
                    "left" => "Лево",
                    "right" => "Право"
                )

            ),
            array(
                "FIELD_NAME" => "AUTH",
                "USER_TYPE_ID" => "boolean",
                "MULTIPLE" => "N",
                "SIZE" => 100,
                "ROWS" => 1,
                "NAME_RU" => "Признак авторизации",
                "NAME_EN" => "Auth",
            ),
            array(
                "FIELD_NAME" => "NODE",
                "USER_TYPE_ID" => "string",
                "MULTIPLE" => "N",
                "SIZE" => 100,
                "ROWS" => 1,
                "NAME_RU" => "Узел РЦ",
                "NAME_EN" => "Rc",
            ),
            array(
                "FIELD_NAME" => "SECTIONS",
                "USER_TYPE_ID" => "iblock_section",
                "MULTIPLE" => "Y",
                "SIZE" => 100,
                "ROWS" => 1,
                "NAME_RU" => "Разделы каталога",
                "NAME_EN" => "Sections",
                "SETTINGS" => array(
                    "DISPLAY" => "LIST",
                    "LIST_HEIGHT" => "5",
                    "IBLOCK_ID" => "catalog",
                )

            ),
            array(
                "FIELD_NAME" => "PAGE",
                "USER_TYPE_ID" => "string",
                "MULTIPLE" => "Y",
                "SIZE" => 100,
                "ROWS" => 1,
                "NAME_RU" => "Список страниц",
                "NAME_EN" => "List of page",
            ),
        ),
    ),

);

$obBlocktype = new CIBlockType;
$ib = new CIBlock;
$obEnum = new CUserFieldEnum();
$oUserTypeEntity = new CUserTypeEntity();

if($arBlocks){

    foreach ($arBlocks as $block){

        if($block["TYPE"] == "IB"){

            $rsIblockType = $obBlocktype->Add($block["IBLOCK_TYPE"]);

            if($rsIblockType){

                $res["BLOCK_IDS"][$block["IBLOCK"]["CODE"]] = $ib->Add($block["IBLOCK"]);

            }

        }elseif($block["TYPE"] == "HB"){

            $result = Bitrix\Highloadblock\HighloadBlockTable::add(

                array(
                    'NAME' => $block["NAME"],
                    'TABLE_NAME' => $block["TABLE_NAME"]
                )

            );

            if ($result->isSuccess()) {

                $res["BLOCK_IDS"][$block["NAME"]] = $result->getId();

                if($block["UF"]){

                    foreach ($block["UF"] as $uf){

                        if($uf["SETTINGS"]["IBLOCK_ID"]){
                            $uf["SETTINGS"]["IBLOCK_ID"] = $res["BLOCK_IDS"][$uf["SETTINGS"]["IBLOCK_ID"]];
                        }

                        if($uf["SETTINGS"]["HLBLOCK_ID"]){
                            $uf["SETTINGS"]["HLBLOCK_ID"] = $res["BLOCK_IDS"][$uf["SETTINGS"]["HLBLOCK_ID"]];
                        }

                        $defSettings = array(
                            'DEFAULT_VALUE' => '',
                            'SIZE' => '100',
                            'ROWS' => '1',
                            'MIN_LENGTH' => '0',
                            'MAX_LENGTH' => '0',
                            'REGEXP' => '',
                        );

                        $aUserFields = array(
                            'ENTITY_ID' => 'HLBLOCK_' . $res["BLOCK_IDS"][$block["NAME"]],
                            'FIELD_NAME' => 'UF_' . $uf["FIELD_NAME"],
                            'USER_TYPE_ID' => $uf["USER_TYPE_ID"],
                            'XML_ID' => 'XML_UF_' . $uf["FIELD_NAME"],
                            'SORT' => 500,
                            'MULTIPLE' => ($uf["MULTIPLE"]) ? $uf["MULTIPLE"] : "N",
                            'MANDATORY' => 'N',
                            'SHOW_FILTER' => 'I',
                            'SHOW_IN_LIST' => '',
                            'EDIT_IN_LIST' => '',
                            'IS_SEARCHABLE' => 'N',
                            'SETTINGS' => ($uf["SETTINGS"]) ? $uf["SETTINGS"] : $defSettings,
                            'EDIT_FORM_LABEL'   => array(
                                'ru' => $uf["NAME_RU"],
                                'en' => $uf["NAME_EN"],
                            ),
                            'LIST_COLUMN_LABEL' => array(
                                'ru' => $uf["NAME_RU"],
                                'en' => $uf["NAME_EN"],
                            ),
                            'LIST_FILTER_LABEL' => array(
                                'ru' => $uf["NAME_RU"],
                                'en' => $uf["NAME_EN"],
                            ),
                            'ERROR_MESSAGE'     => array(
                                'ru' => 'Ошибка',
                                'en' => 'Error',
                            ),
                            'HELP_MESSAGE'      => array(
                                'ru' => '',
                                'en' => '',
                            ),
                        );


                        $ufId = $oUserTypeEntity->Add($aUserFields);

                        if (!$ufId) {
                            $error[$uf["FIELD_NAME"]] = true;
                        }else{

                            if($uf["VALUES"]){

                                $i = 1;

                                foreach ($uf["VALUES"] as $key => $value){

                                    $i++;

                                    $arAddEnum = array();

                                    $arAddEnum['n'.$i] = array(
                                        'XML_ID' => $key,
                                        'VALUE' => $value,
                                        'DEF' => 'N',
                                        'SORT' => $i*10
                                    );

                                    $obEnum->SetEnumValues(
                                        $ufId,
                                        $arAddEnum
                                    );

                                }

                            }

                        }

                    }

                }

            }

        }

    }

}