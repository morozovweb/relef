<? require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");?>

<?//Фильтр по секциям
/*$GLOBALS["arFilter"]["UF_SECTIONS"] = array(
	1
);

//Фильтр по страницам
$GLOBALS["arFilter"]["UF_PAGE"] = array(
	"/page/"
);*/?>

<?$APPLICATION->IncludeComponent(
	"project:banners",
	"",
	Array(
		"CACHE_TIME" => "36000000",
		"CACHE_TYPE" => "A",
		"FILTER_NAME" => "arFilter",
		"HB_LIST" => "37",
		"HB_TYPE" => "36",
		"IBLOCK_ID" => "10",
		"IBLOCK_TYPE" => "type_catalog"
	)
);?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>