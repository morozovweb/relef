<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Highloadblock as HL;
use Bitrix\Main\Entity;
use \Bitrix\Main;
use \Bitrix\Main\Localization\Loc as Loc;

class BannersComponent extends \CBitrixComponent{

	protected $modules = array('highloadblock');

	protected $filter = array();

	protected $cacheKeys = array();
	
	public function onIncludeComponentLang(){

		$this -> includeComponentLang(basename(__FILE__));
		Loc::loadMessages(__FILE__);
	}
	
    public function onPrepareComponentParams($params){

        $result = array(
            'IBLOCK_TYPE' => trim($params['IBLOCK_TYPE']),
            'IBLOCK_ID' => intval($params['IBLOCK_ID']),
            'HB_TYPE' => intval($params['HB_TYPE']),
            'HB_LIST' => intval($params['HB_LIST']),
            'FILTER_NAME' => trim($params['FILTER_NAME']),
        );

        return $result;

    }

	protected function readDataFromCache(){

		if ($this -> arParams['CACHE_TYPE'] == 'N')
			return false;

		return !($this -> StartResultCache(false, $this -> cacheAddon));

	}

	protected function putDataToCache(){

		if (is_array($this -> cacheKeys) && sizeof($this -> cacheKeys) > 0){
			$this -> SetResultCacheKeys($this -> cacheKeys);
		}

	}

	protected function abortDataCache(){
		$this -> AbortResultCache();
	}
	
	protected function checkModules(){

	    foreach ($this->modules as $module){

			if(!Main\Loader::includeModule($module)){
				throw new Main\LoaderException(Loc::getMessage("BASE_MODULE_NOT_INSTALLED", array("#MODULE#" => $module)));
			}

	    }

	}
	

	protected function checkParams(){

		if ($this -> arParams['IBLOCK_ID'] <= 0)
			throw new Main\ArgumentNullException('IBLOCK_ID');

	}

	protected function prepareFilter(){
						
        $this->filter['UF_ACTIVE'] = true;

        // Исключаемые элементы
        if (!empty($this->arParams['EXCLUDED_IDS'])){
            $this->filter['!ID'] = $this->arParams['EXCLUDED_IDS'];
        }

        $filterName = $this->arParams['FILTER_NAME'];

		if(!empty($filterName)){

            if (is_array($filterName)){

                foreach ($filterName as $key => $filter){

                    if (count($filter)){
						$res[$key] = $filter;
                        $this->filter = array_merge_recursive($res, $this->filter);
                    }

                }

            }elseif (!empty($GLOBALS[$filterName])){

                $this->filter = array_merge($GLOBALS[$this->arParams['FILTER_NAME']], $this->filter);
            }

			$this->cacheAddon[] = $this->filter;

		}

	}

	protected function getResult(){

        $result = array();

        $hlblock_requests=HL\HighloadBlockTable::getById($this -> arParams["HB_LIST"])->fetch();
        $entity_requests=HL\HighloadBlockTable::compileEntity($hlblock_requests);
        $entity_requests_data_class = $entity_requests->getDataClass();

        $main_query_requests = new Entity\Query($entity_requests_data_class);

        $main_query_requests->setSelect(
            array(
                '*'
            )
        );

        $main_query_requests->setFilter($this->filter);

        $result_requests = $main_query_requests->exec();
        $result_requests = new CDBResult($result_requests);



        while($row_requests = $result_requests->Fetch()) {

            $result[] = $row_requests;

        }

        return $result;

	}
	
	public function executeComponent(){

		try{

			$this -> checkModules();
			$this -> checkParams();
			$this->prepareFilter();

            if (!$this -> readDataFromCache()){

                $this -> arResult["ITEMS"] = $this -> getResult();
                $this -> putDataToCache();
                $this->includeComponentTemplate();

            }

		}catch (Exception $e){

			$this -> abortDataCache();
			ShowError($e -> getMessage());

		}

	}

}?>