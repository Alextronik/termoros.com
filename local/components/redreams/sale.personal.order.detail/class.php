<?php

/**
 * Bitrix Framework
 * @package bitrix
 * @subpackage sale
 * @copyright 2001-2014 Bitrix
 */

use Bitrix\Main;
use Bitrix\Main\Config;
use Bitrix\Main\Localization;
use Bitrix\Highloadblock as HL;
use Bitrix\Main\Loader;
use Bitrix\Main\Data;
use Bitrix\Sale\Location;

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

class CBitrixPersonalOrderDetailComponent extends CBitrixComponent
{
	const E_SALE_MODULE_NOT_INSTALLED 		= 10000;
	const E_ORDER_NOT_FOUND 				= 10001;
	const E_CATALOG_MODULE_NOT_INSTALLED 	= 10003;
	const E_NOT_AUTHORIZED					= 10004;

	/**
	 * Fatal error list. Any fatal error makes useless further execution of a component code.
	 * In most cases, there will be only one error in a list according to the scheme "one shot - one dead body"
	 *
	 * @var string[] Array of fatal errors.
	 */
	protected $errorsFatal = array();

	/**
	 * Non-fatal error list. Some non-fatal errors may occur during component execution, so certain functions of the component
	 * may became defunct. Still, user should stay informed.
	 * There may be several non-fatal errors in a list.
	 *
	 * @var string[] Array of non-fatal errors.
	 */
	protected $errorsNonFatal = array();

	/**
	 * Contains some valuable info from $_REQUEST
	 *
	 * @var object request info
	 */
	protected $requestData = array();

	/**
	 * Gathered options that are required
	 *
	 * @var string[] options
	 */
	protected $options = array();

	/**
	 * Variable remains true if there is 'catalog' module installed
	 *
	 * @var bool flag
	 */
	protected $useCatalog = true;

	/**
	 * Variable remains true if there is 'highloadiblocks' module installed
	 *
	 * @var bool flag
	 */
	protected $useHL = true;

	/**
	 * Variable remains true if there is 'iblock' module installed
	 *
	 * @var bool flag
	 */
	protected $useIBlock = true;

	protected $currentCache = null;

	protected $dbResult = array();

	/**
	 * A convert map for method self::formatDate()
	 *
	 * @var string[] keys
	 */
	protected $orderDateFields2Convert = array(
		'DATE_INSERT',
		'DATE_STATUS',
		'PAY_VOUCHER_DATE',
		'DATE_DEDUCTED',
		'DATE_UPDATE',
		'PS_RESPONSE_DATE',
		'DATE_PAY_BEFORE',
		'DATE_BILL',
		'DATE_CANCELED',
		'DATE_PAYED'
	);

	protected $compatibilityPaymentFields = array(
		'DATE_PAID' => 'DATE_PAYED',
		'PAY_SYSTEM_ID',
		'EMP_PAID_ID' => 'EMP_PAYED_ID',
		'PAY_VOUCHER_NUM',
		'PAY_VOUCHER_DATE',
		'PS_STATUS',
		'PS_STATUS_CODE',
		'PS_STATUS_DESCRIPTION',
		'PS_STATUS_MESSAGE',
		'PS_SUM',
		'PS_CURRENCY',
		'PS_RESPONSE_DATE',
		'DATE_PAY_BEFORE',
		'DATE_BILL',
	);

	protected $compatibilityShipmentFields = array(
		'DELIVERY_ID',
		'TRACKING_NUMBER',
		'ALLOW_DELIVERY',
		'DATE_ALLOW_DELIVERY',
		'EMP_ALLOW_DELIVERY_ID',
		'DEDUCTED',
		'DATE_DEDUCTED',
		'EMP_DEDUCTED_ID',
		'REASON_UNDO_DEDUCTED',
		'RESERVED',
		'DELIVERY_DOC_NUM',
		'DELIVERY_DOC_DATE',
		'DELIVERY_DATE_REQUEST',
		'STORE_ID',
	);

	protected $compatibilityUserFields = array(
		'LOGIN',
		'NAME',
		'LAST_NAME',
		'EMAIL',
	);

	public function __construct($component = null)
	{
		parent::__construct($component);

		Localization\Loc::loadMessages(__FILE__);
	}

	/**
	 * Function checks if required modules installed. If not, throws an exception
	 * @throws Main\SystemException
	 * @return void
	 */
	protected function checkRequiredModules()
	{
		if (!Loader::includeModule('sale'))
			throw new Main\SystemException(Localization\Loc::getMessage("SPOD_SALE_MODULE_NOT_INSTALL"), self::E_SALE_MODULE_NOT_INSTALLED);

		$this->useCatalog = Loader::includeModule('catalog');
		$this->useHL = Loader::includeModule('highloadblock');
		$this->useIBlock = Loader::includeModule('iblock');
	}

	/**
	 * Function checks if user is authorized or not. If not, auth form will be shown.
	 * @return void
	 */
	protected function checkAuthorized()
	{
		global $USER, $APPLICATION;

		if (!$USER->IsAuthorized())
		{
			$msg = Localization\Loc::getMessage("SPOD_ACCESS_DENIED");

			// for compatibility reasons: by default AuthForm() is shown in class.php, as it used to be.
			// BUT the better way is to show it in template.php, as it required by MVC paradigm
			if(!$this->arParams['AUTH_FORM_IN_TEMPLATE'])
			{
				$APPLICATION->AuthForm($msg, false, false, 'N', false);
			}

			throw new Main\SystemException($msg, self::E_NOT_AUTHORIZED);
		}
	}

	/**
	 * Function checks and prepares all the parameters passed. Everything about $arParam modification is here.
	 * @param mixed[] $arParams List of unchecked parameters
	 * @return mixed[] Checked and valid parameters
	 */
	public function onPrepareComponentParams($arParams)
	{
		global $APPLICATION;

		$this->tryParseInt($arParams["CACHE_TIME"], 3600, true);

		$arParams['CACHE_GROUPS'] = (isset($arParams['CACHE_GROUPS']) && $arParams['CACHE_GROUPS'] == 'N' ? 'N' : 'Y');

		$this->tryParseString($arParams["PATH_TO_LIST"], $APPLICATION->GetCurPage());
		$this->tryParseString($arParams["PATH_TO_PAYMENT"], "payment.php");

		$this->tryParseString($arParams["PATH_TO_CANCEL"], $APPLICATION->GetCurPage()."?"."ID=#ID#");
		$arParams["PATH_TO_CANCEL"] .= (strpos($arParams["PATH_TO_CANCEL"], "?") === false ? "?" : "&");

		$this->tryParseString($arParams["ACTIVE_DATE_FORMAT"], "d.m.Y");

		// fields & props to select from IBlock
		if(!is_array($arParams["CUSTOM_SELECT_PROPS"]))
			$arParams["CUSTOM_SELECT_PROPS"] = array();
		else
			$this->tryParseArray($arParams["CUSTOM_SELECT_PROPS"]);

		// resample sizes
		$this->tryParseInt($arParams["PICTURE_WIDTH"], 110);
		$this->tryParseInt($arParams["PICTURE_HEIGHT"], 110);

		// resample type for images
		if(!in_array($arParams['RESAMPLE_TYPE'], array(BX_RESIZE_IMAGE_EXACT, BX_RESIZE_IMAGE_PROPORTIONAL, BX_RESIZE_IMAGE_PROPORTIONAL_ALT)))
			$arParams['RESAMPLE_TYPE'] = BX_RESIZE_IMAGE_PROPORTIONAL;

		$this->tryParseBoolean($arParams['AUTH_FORM_IN_TEMPLATE']);

		return $arParams;
	}

	/**
	 * Function parses an array: strip empty values, duplicate ones
	 * @param mixed[] $fld Field value
	 * @return int Parsed value
	 */
	public static function tryParseArray(&$fld)
	{
		foreach($fld as $k => &$item)
		{
			$item = trim($item);
			if(!strlen($item))
				unset($fld[$k]);
		}

		$fld = array_unique($fld);

		return $fld;
	}

	/**
	 * Function reduces input value to integer type, and, if gets null, passes the default value.
	 *
	 * @param int &$fld					Field value.
	 * @param int $default				Default value.
	 * @param bool $allowZero			Allows zero-value of the parameter
	 * @return int
	 */
	public static function tryParseInt(&$fld, $default, $allowZero = false)
	{
		$fld = (int)$fld;
		if (!$allowZero && !$fld && isset($default))
			$fld = $default;

		return $fld;
	}

	/**
	 * Function processes string value and, if gets null, passes the default value to it
	 * @param mixed &$fld Field value
	 * @param string $default Default value
	 * @return string Parsed value
	 */
	public static function tryParseString(&$fld, $default)
	{
		$fld = trim((string)$fld);
		if(!strlen($fld) && isset($default))
			$fld = htmlspecialcharsbx($default);

		return $fld;
	}

	/**
	 * Function forces 'Y'/'N' value to boolean
	 * @param mixed $fld Field value
	 * @param string $default Default value
	 * @return string parsed value
	 */
	public static function tryParseBoolean(&$fld)
	{
		$fld = $fld == 'Y';
		return $fld;
	}

	/**
	 * Function sets page title, if required
	 * @return void
	 */
	protected function setTitle()
	{
		global $APPLICATION;

		if ($this->arParams["SET_TITLE"] == 'Y')
			$APPLICATION->SetTitle(str_replace("#ID#", $this->dbResult["ACCOUNT_NUMBER"], Localization\Loc::getMessage("SPOD_TITLE")));
	}

	/**
	 * Function gets all options required for component
	 * @return void
	 */
	protected function loadOptions()
	{
		$this->options['USE_ACCOUNT_NUMBER'] = Config\Option::get("sale", "account_number_template", "") !== "";
		$this->options['WEIGHT_UNIT'] = Config\Option::get("sale", "weight_unit", "", SITE_ID);
		$this->options['WEIGHT_K'] = Config\Option::get("sale", "weight_koef", 1, SITE_ID);
	}

	/**
	 * Function could describe what to do when order ID not set. By default, component will redirect to list page.
	 * @return void
	 */
	protected function doCaseOrderIdNotSet()
	{
		global $APPLICATION;

		if ($this->arParams["PATH_TO_LIST"] != htmlspecialcharsbx($APPLICATION->GetCurPage()))
			LocalRedirect($this->arParams["PATH_TO_LIST"]);
	}

	/**
	 * Function processes and corrects $_REQUEST. Everyting about $_REQUEST lies here.
	 * @return void
	 */
	protected function processRequest()
	{
		$this->requestData["ID"] = urldecode(urldecode($this->arParams["ID"]));

		if (!strlen($this->requestData["ID"]))
			$this->doCaseOrderIdNotSet();
	}

	// obtain names for properties passed in $arParams['CUSTOM_SELECT_PROPS']
	protected function obtainPropertyNames(&$cached)
	{
		if($this->useIBlock && !empty($this->arParams['CUSTOM_SELECT_PROPS']))
		{
			$props = array();

			foreach($this->arParams['CUSTOM_SELECT_PROPS'] as $prop)
				if(strpos($prop, 'PROPERTY_') !== false)
				{
					$propId = str_replace('PROPERTY_', '', $prop);

					if($propId == (string)intval($propId)) // obviously its an id
						$filter = array('ID' => intval($propId));
					else // its a code
						$filter = array('CODE' => $propId);

					$res = CIBlockProperty::GetList(false, $filter);
					if($res = $res->Fetch())
						$props[$res['IBLOCK_ID']][$prop] = $res;
				}

			$cached["PROPERTY_DESCRIPTION"] = $props;
		}
	}

	/**
	 * Return order tax list
	 *
	 * @param array &$cached		Cached data.
	 * @return void
	 */
	protected function obtainTaxes(&$cached)
	{
		$cached['TAX'] = array();
		if (!empty($this->dbResult['ID']))
		{
			$taxIterator = CSaleOrderTax::GetList(array('APPLY_ORDER' => 'ASC'), array('ORDER_ID' => $this->dbResult['ID']));
			while ($tax = $taxIterator->Fetch())
				$cached['TAX'][] = $tax;
			unset($tax, $taxIterator);
		}
		$cached['TAX_LIST'] = $cached['TAX'];
	}

	/**
	 * Function fetches information about stores in the system, depending on the delivery system.
	 * This method should should be called only after obtainDataCachedStatic().
	 * @param mixed[] $cached Cached data taken from obtainDataCachedStructure()
	 * @return void
	 */
	protected function obtainDeliveryStore(&$cached)
	{
		if (empty($this->dbResult["ID"]))
			return;
		foreach ($this->dbResult['SHIPMENT'] as $shipment)
		{
			if (!empty($shipment["DELIVERY"]) && count($shipment["DELIVERY"]["STORE"]) > 0 && $this->useCatalog)
			{
				$stores = $shipment["DELIVERY"]["STORE"];
				$dbStores = CCatalogStore::GetList(
					array("SORT" => "DESC", "ID" => "DESC"),
					array("ACTIVE" => "Y", "ID" => $stores, "ISSUING_CENTER" => "Y", "+SITE_ID" => SITE_ID),
					false,
					false,
					array("ID", "TITLE", "ADDRESS", "DESCRIPTION", "IMAGE_ID", "PHONE", "SCHEDULE", "GPS_N", "GPS_S", "ISSUING_CENTER", "SITE_ID", "EMAIL")
				);
				while ($item = $dbStores->Fetch())
					$cached["DELIVERY_STORE_LIST"][$item['ID']] = $item;
			}
		}
	}

	/**
	 * Function gets order basket info from the database
	 * @param mixed[] Cached data taken from obtainDataCachedStructure()
	 * @return void
	 */
	protected function obtainBasket(&$cached)
	{
		if (empty($this->dbResult["ID"]))
			return;

		$basket = array();
		$arSetParentWeight = array();

		$dbBasket = CSaleBasket::GetList(
			array("NAME" => "ASC"),
			array("ORDER_ID" => $this->dbResult["ID"]),
			false,
			false,
			array("ID", "DETAIL_PAGE_URL", "NAME", "NOTES", "QUANTITY", "PRICE",
				"CURRENCY", "PRODUCT_ID", "DISCOUNT_PRICE", "WEIGHT", "CATALOG_XML_ID",
				"VAT_RATE", "PRODUCT_XML_ID", "TYPE", "SET_PARENT_ID", "MEASURE_CODE", "MEASURE_NAME", "MODULE"
			)
		);
		while ($arItem = $dbBasket->Fetch())
		{
			if (CSaleBasketHelper::isSetItem($arItem))
				continue;

			if($this->useCatalog && $this->cameFromCatalog($arItem))
			{
				$arParent = CCatalogSku::GetProductInfo($arItem["PRODUCT_ID"]);
				if(!empty($arParent))
					$arItem['PARENT'] = $arParent;
			}

			// adjust some sale params
			$arItem["PRICE_VAT_VALUE"] = (($arItem["PRICE"] / ($arItem["VAT_RATE"] +1)) * $arItem["VAT_RATE"]);
			$arItem["WEIGHT"] = doubleval($arItem["WEIGHT"]);

			// weight manipulation for product that has type "SET" (nabor)
			if (CSaleBasketHelper::isSetItem($arItem))
				$arSetParentWeight[$arItem["SET_PARENT_ID"]] += $arItem["WEIGHT"] * $arItem["QUANTITY"];

			if (CSaleBasketHelper::isSetParent($arItem))
				$arItem["WEIGHT"] = $arSetParentWeight[$arItem["ID"]] / $arItem["QUANTITY"];

			$basket[$arItem['ID']] = $arItem;
		}

		// fetching all properties
		$this->obtainBasketProps($basket);

		$cached["BASKET"] = $basket;
	}

	/*
	 * Function fills all required data about basket item properties
	 *
	 * @param mixed[] $arBasketItems List of basket items
	 * @return mixed[] Basket items
	 */
	public function obtainBasketProps(&$arBasketItems)
	{
		// prepare some indexes
		$arElementIds = array(); // a collection of PRODUCT_IDs and parent PRODUCT_IDs
		$arSku2Parent = array(); // a mapping SKU PRODUCT_IDs to PARENT PRODUCT_IDs
		$arParents = array(); // also
		$arSkuProps = array();

		if(self::isNonemptyArray($arBasketItems))
		{
			foreach($arBasketItems as &$arItem)
			{
				// get sale properties: which was added with CSaleBasket::Add(array('PROP' => array(...)))
				$arItem["PROPS"] = array();

				$dbProp = CSaleBasket::GetPropsList(
					array("SORT" => "ASC", "ID" => "ASC"),
					array("BASKET_ID" => $arItem["ID"], "!CODE" => array("CATALOG.XML_ID", "PRODUCT.XML_ID"))
				);
				while ($arProp = $dbProp->GetNext())
					$arItem["PROPS"][] = $arProp;

				// catalog-specific logic farther: iblocks, catalogs and other friends
				if(!$this->cameFromCatalog($arItem))
					continue;

				$arElementIds[] = $arItem["PRODUCT_ID"];

				if($arItem['PARENT'])
				{
					$arElementIds[] = $arItem['PARENT']["ID"];
					$arSku2Parent[$arItem["PRODUCT_ID"]] = $arItem['PARENT']["ID"];

					$arParents[$arItem["PRODUCT_ID"]]["PRODUCT_ID"] = $arItem['PARENT']["ID"];
					$arParents[$arItem["PRODUCT_ID"]]["IBLOCK_ID"] = $arItem['PARENT']["IBLOCK_ID"];
				}

				if(self::isNonemptyArray($arItem['PROPS']))
					foreach($arItem['PROPS'] as $prop)
							$arSkuProps[$prop['CODE']] = 1;
			}
			$arSkuProps = array_keys($arSkuProps);

			// fetching iblock props
			$this->obtainBasketPropsElement($arBasketItems, $arElementIds, $arSku2Parent);

			// fetching sku props, if any
			$this->obtainBasketPropsSKU($arBasketItems, $arSkuProps, $arParents);
		}

		return $arBasketItems;
	}

	/*
	 * For each basket items it fills information about properties stored in
	 *
	 * @param mixed[] $arBasketItems List of basket items
	 * @param mixed[] $arElementIds Array of element id
	 * @param mixed[] $arSku2Parent Mapping between sku ids and their parent ids
	 * @return void
	 */
	public function obtainBasketPropsElement(&$arBasketItems, $arElementIds, $arSku2Parent)
	{
		$arImgFields = array("PREVIEW_PICTURE", "DETAIL_PICTURE");

		// get BASKET product properties data (from iblocks): id, pictures and some any PROPERTY_*
		$arProductData = $this->obtainProductProps($arElementIds, array_merge(array("ID"), $arImgFields, $this->arParams['CUSTOM_SELECT_PROPS']));

		if(self::isNonemptyArray($arBasketItems))
		{
			foreach ($arBasketItems as &$arItem)
			{
				// catalog-specific logic farther
				if(!$this->cameFromCatalog($arItem))
					continue;

				// merge items with properties we obtained by calling $this->obtainProductProps(): pictures and PROPERTY_*
				if (array_key_exists($arItem["PRODUCT_ID"], $arProductData) && is_array($arProductData[$arItem["PRODUCT_ID"]]))
				{
					foreach ($arProductData[$arItem["PRODUCT_ID"]] as $key => $value)
					{
						if (strpos($key, "PROPERTY_") !== false || in_array($key, $arImgFields))
							$arItem[$key] = $value;
					}
				}

				// if we have SKU product with parent...
				if (array_key_exists($arItem["PRODUCT_ID"], $arSku2Parent)) // if sku element doesn't have value of some property - we'll show parent element value instead
				{
					$arFieldsToFill = array_merge($this->arParams['CUSTOM_SELECT_PROPS'], $arImgFields); // fields to be filled with parents' values if empty
					foreach ($arFieldsToFill as $field)
					{
						if(!strlen($field)) continue;

						$fieldVal = (in_array($field, $arImgFields)) ? $field : $field."_VALUE";
						$parentId = $arSku2Parent[$arItem["PRODUCT_ID"]];

						if ((!isset($arItem[$fieldVal]) || (isset($arItem[$fieldVal]) && strlen($arItem[$fieldVal]) == 0))
							&& (isset($arProductData[$parentId][$fieldVal]) && !empty($arProductData[$parentId][$fieldVal]))) // can be array or string
						{
							$arItem[$fieldVal] = $arProductData[$parentId][$fieldVal];
						}
					}
				}

				/*
				// in $this->arIblockProps there should be the result of CIBlockProperty::GetList() called on props we want to see in product list
				// consider this to be excess functionality
				foreach ($arItem as $key => $value) // format properties' values
				{
					if ((strpos($key, "PROPERTY_", 0) === 0) && (strrpos($key, "_VALUE") == strlen($key) - 6))
					{
						$code = str_replace(array("PROPERTY_", "_VALUE"), "", $key);
						$propData = $this->arIblockProps[$code];
						$arItem[$key] = CSaleHelper::getIblockPropInfo($value, $propData);
					}
				}
				*/

				// resampling picture
				$pict = false;
				if(intval($arItem["DETAIL_PICTURE"]))
					$pict = $arItem["DETAIL_PICTURE"];
				else
					$pict = $arItem["PREVIEW_PICTURE"];

				if($pict)
				{
					$arImage = CFile::GetFileArray($pict);
					if ($arImage && ($this->arParams['PICTURE_WIDTH'] || $this->arParams['PICTURE_HEIGHT']))
					{
						$arFileTmp = CFile::ResizeImageGet(
							$arImage,
							array("width" => $this->arParams['PICTURE_WIDTH'], "height" => $this->arParams['PICTURE_HEIGHT']),
							$this->arParams['PICTURE_RESAMPLE_TYPE'],
							true
						);

						$arItem["PICTURE"] = array_change_key_case($arFileTmp, CASE_UPPER);
					}
					else
						$arItem["PICTURE"] = $arImage;
				}
			}
		}
	}

	/*
	 * Creates an array of iblock properties for the elements with certain IDs
	 *
	 * @param mixed[] $arElementIds Array of element id
	 * @param mixed[] $arSelect Fields to select
	 * @return mixed[] Array of properties' values in the form of array("ELEMENT_ID" => array of props)
	 */
	public function obtainProductProps($arElementIds, $arSelect)
	{
		if (!$this->useIBlock)
			return array();

		if (empty($arElementIds))
			return array();

		$arProductData = array();
		$arElementData = array();
		// obtain list of iblocks we have to deal with
		$res = CIBlockElement::GetList(
			array(),
			array("=ID" => array_unique($arElementIds)),
			false,
			false,
			array("ID", "IBLOCK_ID")
		);
		while ($arElement = $res->GetNext())
			$arElementData[$arElement["IBLOCK_ID"]][] = $arElement["ID"]; // two getlists are used to support 1 and 2 type of iblock properties

		// for each iblock get properties for each element of it
		foreach ($arElementData as $iblockId => $arElemId) // todo: possible performance bottleneck
		{
			$res = CIBlockElement::GetList(
				array(),
				array("IBLOCK_ID" => $iblockId, "=ID" => array_unique($arElemId)),
				false,
				false,
				$arSelect
			);
			while ($arElement = $res->GetNext())
			{
				$id = $arElement["ID"];
				foreach ($arElement as $key => $value)
				{
					if (is_array($arProductData[$id])
						&& array_key_exists($key, $arProductData[$id])
						&& !is_array($arProductData[$id][$key])
						&& !in_array($value, explode(", ", $arProductData[$id][$key]))
					) // if we have multiple property value
					{
						$arProductData[$id][$key] .= ", ".$value;
					}
					elseif (empty($arProductData[$id][$key]))
					{
						$arProductData[$id][$key] = $value;
					}
				}
			}
		}

		return $arProductData;
	}

	/*
	 * For each basket items it fills information about SKU properties stored in
	 *
	 * @param mixed[] $arBasketItems List of basket items
	 * @param mixed[] $arSkuProps Sku properties to search for
	 * @param mixed[] $arParents Specially formed array, see code below
	 * @return void
	 */
	public function obtainBasketPropsSKU(&$arBasketItems, $arSkuProps, $arParents)
	{
		$arRes = array();
		$arSkuIblockID = array();

		if (self::isNonemptyArray($arBasketItems) && self::isNonemptyArray($arParents))
		{
			foreach ($arBasketItems as &$arItem)
			{
				// catalog-specific logic farther
				if(!$this->cameFromCatalog($arItem))
					continue;

				if (array_key_exists($arItem["PRODUCT_ID"], $arParents))
				{
					$arSKU = CCatalogSKU::GetInfoByProductIBlock($arParents[$arItem["PRODUCT_ID"]]["IBLOCK_ID"]);

					if (!array_key_exists($arSKU["IBLOCK_ID"], $arSkuIblockID))
						$arSkuIblockID[$arSKU["IBLOCK_ID"]] = $arSKU;

					$arItem["IBLOCK_ID"] = $arSKU["IBLOCK_ID"];
					$arItem["SKU_PROPERTY_ID"] = $arSKU["SKU_PROPERTY_ID"];
				}
			}
			unset($arItem);

			if($this->useIBlock)
			{
				if(!self::isNonemptyArray($arSkuProps))
					$arSkuProps = array();

				foreach ($arSkuIblockID as $skuIblockID => $arSKU)
				{
					// possible props values
					$rsProps = CIBlockProperty::GetList(
						array('SORT' => 'ASC', 'ID' => 'ASC'),
						array('IBLOCK_ID' => $skuIblockID, 'ACTIVE' => 'Y')
					);

					while ($arProp = $rsProps->Fetch())
					{
						if ($arProp['PROPERTY_TYPE'] == 'L' || $arProp['PROPERTY_TYPE'] == 'E' || ($arProp['PROPERTY_TYPE'] == 'S' && $arProp['USER_TYPE'] == 'directory'))
						{
							if ($arProp['XML_ID'] == 'CML2_LINK')
								continue;

							if (!in_array($arProp['CODE'], $arSkuProps))
								continue;

							$arRes[$skuIblockID][$arProp['ID']] = array(
								'ID' => $arProp['ID'],
								'CODE' => $arProp['CODE'],
								'NAME' => $arProp['NAME'],
								'TYPE' => $arProp['PROPERTY_TYPE'],
								'VALUES' => array()
							);

							if ($arProp['PROPERTY_TYPE'] == 'L')
							{
								$arValues = array();
								$rsPropEnums = CIBlockProperty::GetPropertyEnum($arProp['ID']);
								while ($arEnum = $rsPropEnums->Fetch())
								{
									$arValues[$arEnum['ID']] = array(
										'ID' => $arEnum['ID'],
										'NAME' => $arEnum['VALUE'],
										'PICT' => false
									);
								}

								$arRes[$skuIblockID][$arProp['ID']]['VALUES'] = $arValues;
							}
							elseif ($arProp['PROPERTY_TYPE'] == 'E')
							{
								$arValues = array();
								$rsPropEnums = CIBlockElement::GetList(
									array('SORT' => 'ASC'),
									array('IBLOCK_ID' => $arProp['LINK_IBLOCK_ID'], 'ACTIVE' => 'Y'),
									false,
									false,
									array('ID', 'NAME', 'PREVIEW_PICTURE')
								);
								while ($arEnum = $rsPropEnums->Fetch())
								{
									$arEnum['PREVIEW_PICTURE'] = CFile::GetFileArray($arEnum['PREVIEW_PICTURE']);

									if (!is_array($arEnum['PREVIEW_PICTURE']))
										continue;

									$productImg = CFile::ResizeImageGet($arEnum['PREVIEW_PICTURE'], array('width'=>80, 'height'=>80), BX_RESIZE_IMAGE_PROPORTIONAL, false, false);

									$arEnum['PREVIEW_PICTURE']['SRC'] = $productImg['src'];

									$arValues[$arEnum['ID']] = array(
										'ID' => $arEnum['ID'],
										'NAME' => $arEnum['NAME'],
										'SORT' => $arEnum['SORT'],
										'PICT' => $arEnum['PREVIEW_PICTURE']
									);
								}

								$arRes[$skuIblockID][$arProp['ID']]['VALUES'] = $arValues;
							}
							elseif ($arProp['PROPERTY_TYPE'] == 'S' && $arProp['USER_TYPE'] == 'directory')
							{
								$arValues = array();
								if ($this->useHL)
								{
									$hlblock = HL\HighloadBlockTable::getList(array("filter" => array("TABLE_NAME" => $arProp["USER_TYPE_SETTINGS"]["TABLE_NAME"])))->fetch();
									if ($hlblock)
									{
										$entity = HL\HighloadBlockTable::compileEntity($hlblock);
										$entity_data_class = $entity->getDataClass();
										$rsData = $entity_data_class::getList();

										while ($arData = $rsData->fetch())
										{
											$arValues[$arData['ID']] = array(
												'ID' => $arData['ID'],
												'NAME' => $arData['UF_NAME'],
												'SORT' => $arData['UF_SORT'],
												'FILE' => $arData['UF_FILE'],
												'PICT' => '',
												'XML_ID' => $arData['UF_XML_ID']
											);
										}

										$arRes[$skuIblockID][$arProp['ID']]['VALUES'] = $arValues;
									}
								}
							}
						}
					}
				}

				foreach ($arBasketItems as &$arItem) // for each item in the basket
				{
					// catalog-specific logic farther: iblocks, catalogs and other friends
					if(!$this->cameFromCatalog($arItem))
						continue;

					$arSelectSkuProps = array();

					foreach ($arSkuProps as $prop)
						$arSelectSkuProps[] = "PROPERTY_".$prop;

					if (isset($arItem["IBLOCK_ID"]) && intval($arItem["IBLOCK_ID"]) > 0 && array_key_exists($arItem["IBLOCK_ID"], $arRes))
					{
						$arItem["SKU_DATA"] = $arRes[$arItem["IBLOCK_ID"]];

						$arUsedValues = array();
						$arTmpRes = array();

						$arOfFilter = array(
							"IBLOCK_ID" => $arItem["IBLOCK_ID"],
							"PROPERTY_".$arSkuIblockID[$arItem["IBLOCK_ID"]]["SKU_PROPERTY_ID"] => $arParents[$arItem["PRODUCT_ID"]]["PRODUCT_ID"]
						);

						$rsOffers = CIBlockElement::GetList(
							array(),
							$arOfFilter,
							false,
							false,
							array_merge(array("ID"), $arSelectSkuProps)
						);
						while ($arOffer = $rsOffers->GetNext())
						{
							foreach ($arSkuProps as $prop)
							{
								if (!empty($arOffer["PROPERTY_".$prop."_VALUE"]) &&
									(!is_array($arUsedValues[$arItem["PRODUCT_ID"]][$prop]) || !in_array($arOffer["PROPERTY_".$prop."_VALUE"], $arUsedValues[$arItem["PRODUCT_ID"]][$prop])))
									$arUsedValues[$arItem["PRODUCT_ID"]][$prop][] = $arOffer["PROPERTY_".$prop."_VALUE"];
							}
						}

						if (!empty($arUsedValues))
						{
							// add only used values to the item SKU_DATA
							foreach ($arRes[$arItem["IBLOCK_ID"]] as $propId => $arProp)
							{
								if (!array_key_exists($arProp["CODE"], $arUsedValues[$arItem["PRODUCT_ID"]]))
									continue;

								$propValues = array();
								$skuType = '';
								foreach ($arProp["VALUES"] as $valId => $arValue)
								{
									// properties of various type have different values in the used values data
									if (($arProp["TYPE"] == "L" && in_array($arValue["NAME"], $arUsedValues[$arItem["PRODUCT_ID"]][$arProp["CODE"]]))
										|| ($arProp["TYPE"] == "E" && in_array($arValue["ID"], $arUsedValues[$arItem["PRODUCT_ID"]][$arProp["CODE"]]))
										|| ($arProp["TYPE"] == "S" && in_array($arValue["XML_ID"], $arUsedValues[$arItem["PRODUCT_ID"]][$arProp["CODE"]]))
									)
									{
										if ($arProp["TYPE"] == "S")
										{
											$arTmpFile = CFile::GetFileArray($arValue["FILE"]);
											$tmpImg = CFile::ResizeImageGet($arTmpFile, array('width'=>30, 'height'=>30), BX_RESIZE_IMAGE_PROPORTIONAL, true);
											$arValue['PICT'] = array_change_key_case($tmpImg, CASE_UPPER);

											$skuType = 'image';
										}
										else
											$skuType = 'link';

										$propValues[$valId] = $arValue;
									}
								}

								$arTmpRes['n'.$propId] = array(
									'CODE' => $arProp["CODE"],
									'NAME' => $arProp["NAME"],
									'SKU_TYPE' => $skuType,
									'VALUES' => $propValues
								);
							}
						}

						$arItem["SKU_DATA"] = $arTmpRes;
					}

					if(self::isNonemptyArray($arItem['PROPS']))
					{
						foreach($arItem['PROPS'] as $v => $prop) // for each property of basket item
						{
							// search for sku property that matches current one
							// establishing match based on codes even if the code may not set
							$code = $prop['CODE'];

							if(self::isNonemptyArray($arItem['SKU_DATA']))
								foreach($arItem['SKU_DATA'] as $spIndex => $skuProp)
								{
									if($skuProp['CODE'] == $code) // if match found
									{
										$arItem['PROPS'][$v]['SKU_PROP'] = $spIndex;
										$arItem['PROPS'][$v]['SKU_TYPE'] = $skuProp['SKU_TYPE'];

										if(self::isNonemptyArray($skuProp['VALUES']))
											foreach($skuProp['VALUES'] as $spValue) // search for a particular value of our property
											{
												if ($skuProp['SKU_TYPE'] == 'image')
													$match = $prop["VALUE"] == $spValue["NAME"] || $prop["VALUE"] == $spValue["XML_ID"]; // for "image" prop we got one condition
												else
													$match = $prop["VALUE"] == $spValue["NAME"]; // otherwise - the other

												if($match)
												{
													$arItem['PROPS'][$v]['SKU_VALUE'] = $spValue;
													break;
												}
											}
									}
								}
						}
					}
				}
			}
		}
	}

	/**
	 * Function gets order properties from database
	 * @param mixed[] $cached Cached data taken from obtainDataCachedStructure()
	 * @return void
	 */
	protected function obtainProps(&$cached)
	{
		if (empty($this->dbResult["ID"]))
			return;

		$props = array();

		$dbOrderProps = CSaleOrderPropsValue::GetOrderProps($this->dbResult["ID"]);
		$iGroup = -1;
		while ($arOrderProps = $dbOrderProps->GetNext())
		{
			if (empty($this->arParams["PROP_".$this->dbResult["PERSON_TYPE_ID"]]) || !in_array($arOrderProps["ORDER_PROPS_ID"], $this->arParams["PROP_".$this->dbResult["PERSON_TYPE_ID"]]))
			{
				if ($arOrderProps["ACTIVE"] == "Y" && $arOrderProps["UTIL"] == "N")
				{
					$arOrderPropsTmp = $arOrderProps;

					if ($iGroup != intval($arOrderProps["PROPS_GROUP_ID"]))
					{
						$arOrderPropsTmp["SHOW_GROUP_NAME"] = "Y";
						$iGroup = intval($arOrderProps["PROPS_GROUP_ID"]);
					}
					if ($arOrderProps["TYPE"] == "SELECT" || $arOrderProps["TYPE"] == "RADIO")
					{
						$arVal = CSaleOrderPropsVariant::GetByValue($arOrderProps["ORDER_PROPS_ID"], $arOrderProps["VALUE"]);
						$arOrderPropsTmp["VALUE"] = htmlspecialcharsEx($arVal["NAME"]);
					}
					elseif ($arOrderProps["TYPE"] == "MULTISELECT")
					{
						$arOrderPropsTmp["VALUE"] = "";
						$curVal = explode(",", $arOrderProps["VALUE"]);
						for ($i = 0, $intCount = count($curVal); $i < $intCount; $i++)
						{
							$arVal = CSaleOrderPropsVariant::GetByValue($arOrderProps["ORDER_PROPS_ID"], $curVal[$i]);
							if ($i > 0)
								$arOrderPropsTmp["VALUE"] .= ", ";

							$arOrderPropsTmp["VALUE"] .= htmlspecialcharsEx($arVal["NAME"]);
						}
					}
					elseif ($arOrderProps["TYPE"] == "LOCATION")
					{
						$locationName = "";
						if(CSaleLocation::isLocationProMigrated())
						{
							$locationName = Location\Admin\LocationHelper::getLocationStringById($arOrderProps["VALUE"]);
						}
						else
						{
							$arVal = CSaleLocation::GetByID($arOrderProps["VALUE"], LANGUAGE_ID);

							$locationName .= (!strlen($arVal["COUNTRY_NAME"]) ? "" : $arVal["COUNTRY_NAME"]);

							if (strlen($arVal["COUNTRY_NAME"]) && strlen($arVal["REGION_NAME"]))
								$locationName .= " - ".$arVal["REGION_NAME"];
							elseif (strlen($arVal["REGION_NAME"]))
								$locationName .= $arVal["REGION_NAME"];

							if (strlen($arVal["COUNTRY_NAME"]) || strlen($arVal["REGION_NAME"]))
								$locationName .= " - ".$arVal["CITY_NAME"];
							elseif (strlen($arVal["CITY_NAME"]))
								$locationName .= $arVal["CITY_NAME"];
						}

						$arOrderPropsTmp["VALUE"] = $locationName;
					}
					elseif ($arOrderProps["TYPE"] == "FILE")
					{
						if (strpos($arOrderProps["VALUE"], ",") !== false)
						{
							$fileValue = "";
							$values = explode(",", $arOrderProps["VALUE"]);

							if(self::isNonemptyArray($values))
								foreach ($values as $fileId)
									$fileValue .= CFile::ShowFile(trim($fileId), 0, 90, 90, true)."<br/>";

							$arOrderPropsTmp["VALUE"] = $fileValue;
						}
						else
						{
							$arOrderPropsTmp["VALUE"] = CFile::ShowFile($arOrderProps["VALUE"], 0, 90, 90, true);
						}
					}

					$props[] = $arOrderPropsTmp;
				}
			}
		}

		$cached["ORDER_PROPS"] = $props;
	}

	/**
	 * Perform reading main data from database, no cache is used for it
	 * @throws Main\SystemException
	 * @return void
	 */
	protected function obtainDataOrder()
	{
		global $USER;

		$select = array(
			'ID',
			'LID',
			'PERSON_TYPE_ID',

			'PAYED',
			'DATE_PAYED',
			'EMP_PAYED_ID',

			'CANCELED',
			'DATE_CANCELED',
			'EMP_CANCELED_ID',
			'REASON_CANCELED',

			'MARKED',
			'DATE_MARKED',
			'EMP_MARKED_ID',
			'REASON_MARKED',

			'STATUS_ID',
			'DATE_STATUS',

			'EMP_STATUS_ID',

			'PRICE_DELIVERY',

			'PRICE',
			'CURRENCY',
			'DISCOUNT_VALUE',

			'USER_ID',

			'DATE_INSERT',
			'DATE_INSERT_FORMAT',
			'DATE_UPDATE',

			'USER_DESCRIPTION',
			'ADDITIONAL_INFO',

			'COMMENTS',

			'TAX_VALUE',
			'STAT_GID',
			'RECURRING_ID',
			'RECOUNT_FLAG',

			'ORDER_TOPIC',

			'ACCOUNT_NUMBER',
			'XML_ID',
			'ID_1C'
		);
		$sort = array("ID" => "ASC");
		$filter = array(
			"USER_ID" => $USER->GetID(),
			"ACCOUNT_NUMBER" => $this->requestData["ID"],
		);

		$arOrder = false;
		if ($this->options['USE_ACCOUNT_NUMBER']) // supporting order ACCOUNT_NUMBER or ID in the URL
		{

			$res = \Bitrix\Sale\OrderTable::getList(array(
				'filter' => $filter,
				'select' => $select
			 ));

			if ($arOrder = $res->fetch())
			{
				$this->requestData["ID"] = $arOrder["ID"];
			}
		}

		if (!$arOrder)
		{
			$filter = array(
				"USER_ID" => $USER->GetID(),
				"ID" => $this->requestData["ID"],
			);

			$res = \Bitrix\Sale\OrderTable::getList(array(
														'filter' => $filter,
														'select' => $select
													));

			$arOrder = $res->fetch();
		}

		if (empty($arOrder))
		{
			throw new Main\SystemException(
				str_replace("#ID#", $this->requestData["ID"], Localization\Loc::getMessage("SPOD_NO_ORDER")),
				self::E_ORDER_NOT_FOUND
			);
		}


		$arOShipment = array();
		$dbShipment = \Bitrix\Sale\Internals\ShipmentTable::getList(array(
			'select' => array(
				'DELIVERY_NAME',
				'DEDUCTED',
				'DATE_DEDUCTED',
				'EMP_DEDUCTED_ID',
				'REASON_UNDO_DEDUCTED',
				'SYSTEM',
				'ID',
				'DELIVERY_ID',
				'TRACKING_NUMBER',
				'TRACKING_STATUS',
				'TRACKING_DESCRIPTION',
				'ALLOW_DELIVERY',
				'DATE_ALLOW_DELIVERY',
				'EMP_ALLOW_DELIVERY_ID',
				'RESERVED',
				'DELIVERY_DOC_NUM',
				'DELIVERY_DOC_DATE',
				),
			'filter' => array('ORDER_ID' => $arOrder['ID'])
		));

		while ($arShipment = $dbShipment->fetch())
		{
			if ($arShipment['SYSTEM'] == 'Y')
				continue;

			$dbShipmentItem = \Bitrix\Sale\Internals\ShipmentItemTable::getList(array(
				'select' => array('BASKET_ID', 'QUANTITY'),
				'filter' => array('ORDER_DELIVERY_ID' => $arShipment['ID'])
			));

			$shipmentItems = array();
			while ($shipmentItem = $dbShipmentItem->fetch())
			{
				$shipmentItems[$shipmentItem['BASKET_ID']] = $shipmentItem;
			}

			$arShipment['ITEMS'] = $shipmentItems;
			$arShipment['TRACKING_STATUS'] = \Bitrix\Sale\Delivery\Tracking\Manager::getStatusName(
				$arShipment['TRACKING_STATUS']
			);

			$arOShipment[] = $arShipment;
		}
		$arOrder['SHIPMENT'] = $arOShipment;

		// for compatibility

		if (!empty($this->compatibilityShipmentFields) && is_array($this->compatibilityShipmentFields))
		{
			foreach ($this->compatibilityShipmentFields as $shipmentField)
			{
				if (isset($arOShipment[0][$shipmentField]))
				{
					$setFieldValue = $arOShipment[0][$shipmentField];

					if ($setFieldValue instanceof Main\Type\Date
						|| $setFieldValue instanceof Main\Type\DateTime)
					{
						$setFieldValue = $setFieldValue->toString();
					}

					$arOrder[$shipmentField] = $setFieldValue;
				}
			}
		}

//		$arOrder['DELIVERY_ID'] = $arOShipment[0]['DELIVERY_ID'];
//		$arOrder['TRACKING_NUMBER'] = $arOShipment[0]['TRACKING_NUMBER'];

		$dbPayment = \Bitrix\Sale\Internals\PaymentTable::getList(array(
			'select' => array(
				'PAY_SYSTEM_NAME',
				'PAID',
				'ID',
				'DATE_PAID',
				'PAY_SYSTEM_ID',
				'SUM',
				'PAY_VOUCHER_NUM',
				'PAY_VOUCHER_DATE',
				'PS_STATUS',
				'PS_STATUS_CODE',
				'PS_STATUS_DESCRIPTION',
				'PS_STATUS_MESSAGE',
				'PS_SUM',
				'PS_CURRENCY',
				'PS_RESPONSE_DATE',
				'DATE_PAY_BEFORE',
				'DATE_BILL'
				),
			'filter' => array('ORDER_ID' => $arOrder['ID'])
		));

		$arOPayment = array();
		while ($arPayment = $dbPayment->fetch())
		{
			$arPayment['PAY_SYSTEM_NAME'] = htmlspecialcharsbx($arPayment['PAY_SYSTEM_NAME']);
			$arOPayment[] = $arPayment;
		}

		$arOrder['PAYMENT'] = $arOPayment;

		// for compatibility
//		$arOrder['PAY_SYSTEM_ID'] = $arOPayment[0]['PAY_SYSTEM_ID'];
//		$arOrder['PAY_VOUCHER_NUM'] = $arOPayment[0]['PAY_VOUCHER_NUM'];

		if (!empty($this->compatibilityPaymentFields) && is_array($this->compatibilityPaymentFields))
		{
			foreach ($this->compatibilityPaymentFields as $paymentName => $paymentField)
			{
				$findPaymentField = $paymentField;
				if (intval($paymentName) !== $paymentName)
				{
					$findPaymentField = $paymentName;
				}

				if (isset($arOPayment[0][$findPaymentField]))
				{
					$setFieldValue = $arOPayment[0][$findPaymentField];

					if ($setFieldValue instanceof Main\Type\Date
						|| $setFieldValue instanceof Main\Type\DateTime)
					{
						$setFieldValue = $setFieldValue->toString();
					}

					$arOrder[$paymentField] = $setFieldValue;
				}
			}
		}

		$this->dbResult = $arOrder;
	}

	/**
	 * Function gets user info from database, no cache is used for it
	 * @return void
	 */
	protected function obtainDataUser()
	{
		$dbUser = CUser::GetByID($this->dbResult["USER_ID"]);
		if ($arUser = $dbUser->GetNext())
		{
			$this->dbResult["USER"] = $arUser;


			if (!empty($this->compatibilityUserFields) && is_array($this->compatibilityUserFields))
			{
				foreach ($this->compatibilityUserFields as $userField)
				{
					if (isset($arUser[0][$userField]))
					{

						$setFieldValue = $arUser[0][$userField];

						if ($setFieldValue instanceof Main\Type\Date
							|| $setFieldValue instanceof Main\Type\DateTime)
						{
							$setFieldValue = $setFieldValue->toString();
						}

						$arOrder['USER_'.$userField] = $setFieldValue;
					}
				}
			}

		}
	}

	/**
	 * Function accuires all required fine-cacheable information to form $arResult.
	 * To pick up some additional data to the cached part of $arResult, make another method that modifies $cachedData and call it here.
	 * This method should be called only after obtainDataCachedStatic()
	 *
	 * @param mixed[] $cachedData Cached data taken from getDataCached()
	 * @return void
	 */
	protected function obtainDataCachedStructure(&$cachedData)
	{
		$this->obtainProps($cachedData);
		$this->obtainBasket($cachedData);
		$this->obtainDeliveryStore($cachedData);
		$this->obtainPropertyNames($cachedData);
		$this->obtainTaxes($cachedData);

		// smth else ...
	}

	/**
	 * Function gets pay system info from database, no cache is used here
	 * @return void
	 */
	protected function obtainDataPaySystem()
	{
		if (empty($this->dbResult["ID"]))
			return;
		foreach ($this->dbResult['PAYMENT'] as &$payment)
		{
			if (intval($payment["PAY_SYSTEM_ID"]))
			{
				$payment["PAY_SYSTEM"] = CSalePaySystem::GetByID($payment["PAY_SYSTEM_ID"], $this->dbResult["PERSON_TYPE_ID"]);
				$payment["PAY_SYSTEM"]['NAME'] = htmlspecialcharsbx($payment["PAY_SYSTEM"]['NAME']);
			}
			if ($payment["PAID"] != "Y" && $this->dbResult["CANCELED"] != "Y")
			{
				if (intval($payment["PAY_SYSTEM_ID"]))
				{
					$dbPaySysAction = CSalePaySystemAction::GetList(
						array(),
						array(
							"PAY_SYSTEM_ID" => $payment["PAY_SYSTEM_ID"],
							"PERSON_TYPE_ID" => $this->dbResult["PERSON_TYPE_ID"]
						),
						false,
						false,
						array("NAME", "ACTION_FILE", "NEW_WINDOW", "PARAMS", "ENCODING")
					);
					if ($arPaySysAction = $dbPaySysAction->Fetch())
					{
						if (strlen($arPaySysAction["ACTION_FILE"]))
						{
							$payment["CAN_REPAY"] = "Y";
							if ($arPaySysAction["NEW_WINDOW"] == "Y")
							{
								$payment["PAY_SYSTEM"]["PSA_ACTION_FILE"] = htmlspecialcharsbx($this->arParams["PATH_TO_PAYMENT"]).'?ORDER_ID='.urlencode(urlencode($this->dbResult["ACCOUNT_NUMBER"])).'&PAYMENT_ID='.$payment['ID'];
							}
							else
							{
								CSalePaySystemAction::InitParamArrays($this->dbResult, $this->requestData["ID"], $arPaySysAction["PARAMS"], array(), $payment);
								$pathToAction = $_SERVER["DOCUMENT_ROOT"].$arPaySysAction["ACTION_FILE"];
								$pathToAction = str_replace("\\", "/", $pathToAction);
								while (substr($pathToAction, strlen($pathToAction) - 1, 1) == "/")
									$pathToAction = substr($pathToAction, 0, strlen($pathToAction) - 1);
								if (file_exists($pathToAction))
								{
									if (is_dir($pathToAction) && file_exists($pathToAction."/payment.php"))
										$pathToAction .= "/payment.php";
									$payment["PAY_SYSTEM"]["PSA_ACTION_FILE"] = $pathToAction;
								}
								if (strlen($arPaySysAction["ENCODING"]))
								{
									define("BX_SALE_ENCODING", $arPaySysAction["ENCODING"]);
									AddEventHandler("main", "OnEndBufferContent", array($this, "changeBodyEncoding"));
								}
							}
						}
					}
				}
			}
		}
		unset($payment);

		// for compatibility
		$this->dbResult['PAY_SYSTEM'] = $this->dbResult['PAYMENT'][0]['PAY_SYSTEM'];
		$this->dbResult['CAN_REPAY'] = $this->dbResult['PAYMENT'][0]['CAN_REPAY'];
	}

	/**
	 * Function performs a conversion between a shared cache and the particular structure of our $arResult
	 * @param mixed[] $cached Cached data taken from obtainDataReferences()
	 * @return mixed[] Data structure that is appropriate for our $arResult
	 */
	protected function adaptCachedReferences($cached)
	{
		$formed = array();

		// form person type
		$formed["PERSON_TYPE"] = $cached['PERSON_TYPE'][$this->dbResult["PERSON_TYPE_ID"]];

		// form status
		$formed['STATUS'] = $cached['STATUS'][$this->dbResult["STATUS_ID"]];

		// form delivery
		foreach ($this->dbResult['SHIPMENT'] as $shipment)
		{
			$shipment['DELIVERY'] = $cached['DELIVERY'][$shipment["DELIVERY_ID"]];
			$shipment['DELIVERY']['STORE'] = \Bitrix\Sale\Delivery\ExtraServices\Manager::getStoresList($shipment["DELIVERY_ID"]);
			$formed['SHIPMENT'][] = $shipment;
		}
		$formed['DELIVERY'] = $formed['SHIPMENT'][0]['DELIVERY'];

		return $formed;
	}

	/**
	 * Function returns reference data as shared cache between this component and sale.personal.order.list.
	 *
	 * @throws Exception
	 * @return void
	 */
	protected function obtainDataReferences()
	{
		if ($this->startCache(array('spo-shared')))
		{
			try
			{
				$cachedData = array();

				/////////////////////
				/////////////////////

				// Person type
				$dbPType = CSalePersonType::GetList(array("SORT"=>"ASC"));
				while ($arPType = $dbPType->Fetch())
					$cachedData['PERSON_TYPE'][$arPType["ID"]] = $arPType;

				// Save statuses for Filter form
				$dbStatus = CSaleStatus::GetList(array("SORT"=>"ASC"), array("LID"=>LANGUAGE_ID));
				while ($arStatus = $dbStatus->Fetch())
					$cachedData['STATUS'][$arStatus["ID"]] = $arStatus;

				$dbPaySystem = CSalePaySystem::GetList(array("SORT"=>"ASC"));
				while ($arPaySystem = $dbPaySystem->Fetch())
				{
					$arPaySystem['NAME'] = htmlspecialcharsbx($arPaySystem['NAME']);
					$cachedData['PAYSYS'][$arPaySystem["ID"]] = $arPaySystem;
				}

				$cachedData['DELIVERY'] = array();

				$shipmentIds = array();
				foreach ($this->dbResult['SHIPMENT'] as $shipment)
					$shipmentIds[] = $shipment['DELIVERY_ID'];

				$dbDelivery = \Bitrix\Sale\Delivery\Services\Table::getList(array(
					'select' => array(
						'ID',
						'NAME',
						'PARENT_NAME' => 'PARENT.NAME',
						'PARENT_CLASS_NAME' => 'PARENT.CLASS_NAME'
					),
					'filter' => array('ID' => $shipmentIds)
				));

				$deliveryService = array();
				while ($delivery = $dbDelivery->fetch())
					$deliveryService[$delivery['ID']] = $delivery;

				foreach ($deliveryService as $delivery)
				{
					$cachedData['DELIVERY'][$delivery["ID"]] = array();

					if ($delivery['PARENT_NAME'])
						$cachedData['DELIVERY'][$delivery["ID"]]['NAME'] = htmlspecialcharsbx($delivery['PARENT_NAME'].':'.$delivery['NAME']);
					else
						$cachedData['DELIVERY'][$delivery["ID"]]['NAME'] = htmlspecialcharsbx($delivery['NAME']);
				}

				/////////////////////
				/////////////////////

			}
			catch (Exception $e)
			{
				$this->abortCache();
				throw $e;
			}

			$this->endCache($cachedData);

		}
		else
			$cachedData = $this->getCacheData();

		$this->dbResult = array_merge($this->dbResult, $this->adaptCachedReferences($cachedData));
	}

	/**
	 * Function contains a mechanism for cacheing data in the component
	 *
	 * @throws Exception
	 * @return void
	 */
	protected function obtainDataCached()
	{
		global $USER;
		global $APPLICATION;

		if ($this->startCache(array(
			$APPLICATION->GetCurPage(),
			$this->dbResult["ID"],
			$this->dbResult["PERSON_TYPE_ID"],
			$this->useCatalog,
			$this->arParams["CACHE_GROUPS"] === "N" ? false : $USER->GetGroups()
		)))
		{
			try
			{
				// so we got an array, which is stored in a cache. After all we merge $this->dbResult with $cachedData
				$cachedData = array();
				$this->obtainDataCachedStructure($cachedData);
			}
			catch (Exception $e)
			{
				$this->abortCache();
				throw $e;
			}

			$this->endCache($cachedData);
		}
		else
			$cachedData = $this->getCacheData();

		$this->dbResult = array_merge($this->dbResult, $cachedData);
	}

	/**
	 * Fetches all required data from database. Everyting that connected with data obtaining lies here
	 * @return void
	 */

	protected function obtainDataShipmentBasket()
	{
		$basket = $this->dbResult['BASKET'];
		foreach ($this->dbResult['SHIPMENT'] as &$shipment)
		{
			foreach ($shipment['ITEMS'] as $i => &$item)
			{
				if (isset($basket[$item['BASKET_ID']]))
				{
					$item['NAME'] = $basket[$item['BASKET_ID']]['NAME'];
					$item['MEASURE_NAME'] = $basket[$item['BASKET_ID']]['MEASURE_NAME'];
				}
				else
				{
					unset($shipment['ITEMS'][$i]);
				}
			}
			unset($item);
		}
		unset($shipment);
	}

	protected function obtainData()
	{
		// Do not reorder calls without a strong need.
		// Data obtain order is important and calls depend on each other.

		$this->obtainDataOrder();
		$this->obtainDataUser();

		// everything that can be well-cached is taken from the following calls:
		$this->obtainDataReferences(); // references
		$this->obtainDataCached(); // the rest of the important data

		// it depends on data taken from obtainDataCached(), so do not relocate
		$this->obtainDataPaySystem();
		$this->obtainDataShipmentBasket();

		$arResult =& $this->dbResult;

		$arResult["WEIGHT_UNIT"] = $this->options['WEIGHT_UNIT'];
		$arResult["WEIGHT_KOEF"] = $this->options['WEIGHT_K'];

		if(self::isNonemptyArray($arResult['BASKET']))
			foreach($arResult['BASKET'] as &$arItem)
			{
				$arItem["QUANTITY"] = doubleval($arItem["QUANTITY"]);
				$arResult["ORDER_WEIGHT"] += $arItem["WEIGHT"] * $arItem["QUANTITY"];
			}
	}

	/**
	 * Function formats price info in arResult
	 * @return void
	 */
	protected function formatResultPrices()
	{
		$arResult =& $this->arResult;

		$arResult["PRICE_FORMATED"] = SaleFormatCurrency($arResult["PRICE"], $arResult["CURRENCY"]);
		$arResult["PRICE_DELIVERY_FORMATED"] = SaleFormatCurrency($arResult['PRICE_DELIVERY'], $arResult["CURRENCY"]);
		foreach ($arResult['PAYMENT'] as &$payment)
			$payment["PRICE_FORMATED"] = SaleFormatCurrency($payment['SUM'], $arResult["CURRENCY"]);
		unset($payment);

		foreach ($arResult['SHIPMENT'] as &$shipment)
			$shipment["PRICE_DELIVERY_FORMATED"] = SaleFormatCurrency($shipment['PRICE_DELIVERY'], $arResult["CURRENCY"]);
		unset($shipment);

		if (doubleval($arResult["DISCOUNT_VALUE"]))
			$arResult["DISCOUNT_VALUE_FORMATED"] = SaleFormatCurrency($arResult["DISCOUNT_VALUE"], $arResult["CURRENCY"]);
		$arResult["CAN_CANCEL"] = (($arResult["CANCELED"]!="Y" && $arResult["STATUS_ID"]!="F" && $arResult["PAYED"]!="Y") ? "Y" : "N");

		if ($arResult["CAN_CANCEL"] == "Y")
			$arResult["URL_TO_CANCEL"] = CComponentEngine::MakePathFromTemplate($this->arParams["PATH_TO_CANCEL"], array("ID" => urlencode(urlencode($arResult["ACCOUNT_NUMBER"])))).'CANCEL=Y';

		$arResult["URL_TO_LIST"] = $this->arParams["PATH_TO_LIST"];
		$arResult["SITE_ID"] = $arResult["LID"];
	}

	/**
	 * Function formats status info in arResult
	 * @return void
	 */
	protected function formatResultStatus()
	{
		$arResult =& $this->arResult;

		if (!empty($arResult["STATUS"]))
		{
			$arResult["STATUS"]["NAME"] = htmlspecialcharsEx($arResult["STATUS"]["NAME"]);
			if (doubleval($arResult["SUM_PAID"]))
				$arResult["SUM_PAID_FORMATED"] = SaleFormatCurrency($arResult["SUM_PAID"], $arResult["CURRENCY"]);
		}
	}

	/**
	 * Function formats user info in arResult
	 * @return void
	 */
	protected function formatResultUser()
	{
		$arResult =& $this->arResult;

		if (!empty($arResult["NAME"]))
			$arResult["USER_NAME"] = CUser::FormatName(CSite::GetNameFormat(false), $arResult["NAME"], true, false);
	}

	/**
	 * Function formats customer info in arResult
	 * @return void
	 */
	protected function formatResultPerson()
	{
		$arResult =& $this->arResult;

		if (!empty($arResult["PERSON_TYPE"]))
			$arResult["PERSON_TYPE"]["NAME"] = htmlspecialcharsEx($arResult["PERSON_TYPE"]["NAME"]);
	}

	/**
	 * Function formats pay system info in arResult
	 * @return void
	 */
	protected function formatResultPaySystem()
	{
		$arResult =& $this->arResult;

		if (!empty($arResult["PAY_SYSTEM"]))
			$arResult["PAY_SYSTEM"]["NAME"] = htmlspecialcharsEx($arResult["PAY_SYSTEM"]["NAME"]);
	}

	/**
	 * Function formats delivery system info in arResult
	 * @return void
	 */
	protected function formatResultDeliverySystem()
	{
		$arResult =& $this->arResult;

		foreach ($arResult['SHIPMENT'] as &$shipment)
		{
			if (!empty($shipment["DELIVERY_ID"]))
				$shipment["DELIVERY"]["NAME"] = htmlspecialcharsEx($shipment["DELIVERY"]["NAME"]);

			$res = \Bitrix\Sale\Delivery\ExtraServices\Table::getList(array(
				'filter' => array(
					"=DELIVERY_ID" => $shipment['DELIVERY_ID'],
					"=CLASS_NAME" => '\Bitrix\Sale\Delivery\ExtraServices\Store',
					"=CODE" => 'BITRIX_STORE_PICKUP'
				)
			));

			$store = $res->fetch();
			if($store)
			{
				$dbRes = \Bitrix\Sale\Internals\ShipmentExtraServiceTable::getList(array(
					'filter' => array(
						'=SHIPMENT_ID' => $shipment['ID'],
						'=EXTRA_SERVICE_ID' => $store['ID']
					)
				));
				if ($row = $dbRes->fetch())
					$shipment['STORE_ID'] = $row["VALUE"];
			}
		}
		unset($shipment);

		if (!empty($arResult["DELIVERY"]))
		{
			if(!empty($arResult['DELIVERY_STORE_LIST']))
			{
				$arResult["DELIVERY"]['STORE_LIST'] = $arResult['DELIVERY_STORE_LIST'];
				unset($arResult['DELIVERY_STORE_LIST']);
			}

		}
	}

	/**
	 * Function formats order basket info in arResult
	 * @return void
	 */
	protected function formatResultBasket()
	{
		$arResult =& $this->arResult;

		if(self::isNonemptyArray($arResult['BASKET']))
			foreach ($arResult["BASKET"] as $k => $arBasket)
			{
				$arBasket["WEIGHT_FORMATED"] = roundEx(doubleval($arBasket["WEIGHT"]/$arResult["WEIGHT_KOEF"]), SALE_WEIGHT_PRECISION)." ".$arResult["WEIGHT_UNIT"];
				$arBasket["PRICE_FORMATED"] = SaleFormatCurrency($arBasket["PRICE"], $arBasket["CURRENCY"]);

				if (doubleval($arBasket["DISCOUNT_PRICE"]))
				{
					$arBasket["DISCOUNT_PRICE_PERCENT"] = $arBasket["DISCOUNT_PRICE"]*100 / ($arBasket["DISCOUNT_PRICE"] + $arBasket["PRICE"]);
					$arBasket["DISCOUNT_PRICE_PERCENT_FORMATED"] = roundEx($arBasket["DISCOUNT_PRICE_PERCENT"], SALE_VALUE_PRECISION)."%";
				}

				// backward compatibility
				$arBasket['MEASURE_TEXT'] = $arBasket['MEASURE_NAME'];

				$arResult["BASKET"][$k] = $arBasket;
			}
	}

	/**
	 * Function formats taxes info in arResult
	 * @return void
	 */
	protected function formatResultTaxes()
	{
		$arResult =& $this->arResult;

		if(self::isNonemptyArray($arResult['TAX_LIST']))
			foreach ($arResult["TAX_LIST"] as $k => $tax)
			{
				$tax =& $arResult["TAX_LIST"][$k];

				if ($tax["IS_IN_PRICE"]=="Y")
					$tax["VALUE_FORMATED"] = " (".(($tax["IS_PERCENT"]=="Y") ? "".doubleval($tax["VALUE"])."%, " : "").Localization\Loc::getMessage("SPOD_SALE_TAX_INPRICE").")";
				else
					$tax["VALUE_FORMATED"] = " (".(($tax["IS_PERCENT"]=="Y") ? "".doubleval($tax["VALUE"])."%" : "").")";
				if (doubleval($tax["VALUE_MONEY"]))
					$tax["VALUE_MONEY_FORMATED"] = SaleFormatCurrency($tax["VALUE_MONEY"], $arResult["CURRENCY"]);
			}
		else
			$arResult["TAX_LIST"] = array();

		$arResult["TAX_VALUE_FORMATED"] = SaleFormatCurrency($arResult["TAX_VALUE"], $arResult["CURRENCY"]);
	}

	/**
	 * Function formats weight info in arResult
	 * @return void
	 */
	protected function formatResultWeight()
	{
		$arResult =& $this->arResult;

		$arResult["ORDER_WEIGHT_FORMATED"] = roundEx(
			doubleval($arResult["ORDER_WEIGHT"] / $arResult["WEIGHT_KOEF"]),
			SALE_WEIGHT_PRECISION)." ".$arResult["WEIGHT_UNIT"];
	}

	/**
	 * Move data read from database to a specially formatted $arResult
	 * @return void
	 */
	protected function formatResult()
	{
		$this->arResult = $this->dbResult;

		$this->formatDate($this->arResult);

		$this->formatResultPrices();
		$this->formatResultStatus();
		$this->formatResultUser();
		$this->formatResultPerson();
		$this->formatResultPaySystem();
		$this->formatResultDeliverySystem();
		$this->formatResultWeight();
		$this->formatResultBasket();
		$this->formatResultTaxes();
	}

	/**
	 * Move all errors to $arResult, if there were any
	 * @return void
	 */
	protected function formatResultErrors()
	{
		$errors = array();
		if (!empty($this->errorsFatal))
			$errors['FATAL'] = $this->errorsFatal;
		if (!empty($this->errorsNonFatal))
			$errors['NONFATAL'] = $this->errorsNonFatal;

		if (!empty($errors))
			$this->arResult['ERRORS'] = $errors;

		// backward compatiblity
		$error = each($this->errorsFatal);
		if (!empty($error))
			$this->arResult['ERROR_MESSAGE'] = $error['value'];
	}

	/**
	 * Function implements all the life cycle of the component
	 * @return void
	 */
	public function executeComponent()
	{
		try
		{
			$this->checkRequiredModules();

			$this->checkAuthorized();
			$this->loadOptions();
			$this->processRequest();

			$this->obtainData();
			$this->formatResult();

			$this->setTitle();
		}
		catch(Exception $e)
		{
			$this->errorsFatal[htmlspecialcharsEx($e->getCode())] = htmlspecialcharsEx($e->getMessage());
		}

		$this->formatResultErrors();

		$this->includeComponentTemplate();
	}

	/**
	 * Convert dates if date template set
	 * @param mixed[] array that date conversion performs in
	 * @return void
	 */
	protected function formatDate(&$arr)
	{
		if (strlen($this->arParams['ACTIVE_DATE_FORMAT']))
		{
			foreach ($this->orderDateFields2Convert as $fld)
			{
				if (!empty($arr[$fld]))
					$arr[$fld."_FORMATED"] = CIBlockFormatProperties::DateFormat($this->arParams['ACTIVE_DATE_FORMAT'], MakeTimeStamp($arr[$fld]));
			}
		}
	}

	/**
	 * Function checks whether a certain item came from 'catalog' module or not
	 * @param mixed[] $item An item from basket
	 * @return boolean
	 */
	public static function cameFromCatalog($item)
	{
		return $item['MODULE'] == 'catalog';
	}

	/**
	 * The callback that changes body encoding when nescessary. Feature doesn`t work here and in the previous version of the component. Left for backward compatibility.
	 * @param string $content page content
	 * @return void
	 */
	public static function changeBodyEncoding($content)
	{
		global $APPLICATION;

		header("Content-Type: text/html; charset=".BX_SALE_ENCODING);
		$content = $APPLICATION->ConvertCharset($content, SITE_CHARSET, BX_SALE_ENCODING);
		$content = str_replace("charset=".SITE_CHARSET, "charset=".BX_SALE_ENCODING, $content);
	}

	/**
	 * Function checks if it`s argument is a legal array for foreach() construction
	 * @param mixed $arr data to check
	 * @return boolean
	 */
	protected static function isNonemptyArray($arr)
	{
		return !empty($arr) && is_array($arr);
	}

	////////////////////////
	// Cache functions
	////////////////////////

	/**
	 * Function checks if cacheing is enabled in component parameters
	 * @return boolean
	 */
	final protected function getCacheNeed()
	{
		return	intval($this->arParams['CACHE_TIME']) > 0 &&
				$this->arParams['CACHE_TYPE'] != 'N' &&
				Config\Option::get("main", "component_cache_on", "Y") == "Y";
	}

	/**
	 * Function perform start of cache process, if needed
	 * @param mixed[]|string $cacheId An optional addition for cache key
	 * @return boolean True, if cache content needs to be generated, false if cache is valid and can be read
	 */
	final protected function startCache($cacheId = array())
	{
		if(!$this->getCacheNeed())
			return true;

		$this->currentCache = Data\Cache::createInstance();

		return $this->currentCache->startDataCache(intval($this->arParams['CACHE_TIME']), $this->getCacheKey($cacheId));
	}

	/**
	 * Function perform start of cache process, if needed
	 * @throws Main\SystemException
	 * @param mixed[] $data Data to be stored in the cache
	 * @return void
	 */
	final protected function endCache($data = false)
	{
		if(!$this->getCacheNeed())
			return;

		if($this->currentCache == 'null')
			throw new Main\SystemException('Cache were not started');

		$this->currentCache->endDataCache($data);
		$this->currentCache = null;
	}

	/**
	 * Function discard cache generation
	 * @throws Main\SystemException
	 * @return void
	 */
	final protected function abortCache()
	{
		if(!$this->getCacheNeed())
			return;

		if($this->currentCache == 'null')
			throw new Main\SystemException('Cache were not started');

		$this->currentCache->abortDataCache();
		$this->currentCache = null;
	}

	/**
	 * Function return data stored in cache
	 * @throws Main\SystemException
	 * @return void|mixed[] Data from cache
	 */
	final protected function getCacheData()
	{
		if(!$this->getCacheNeed())
			return;

		if($this->currentCache == 'null')
			throw new Main\SystemException('Cache were not started');

		return $this->currentCache->getVars();
	}

	/**
	 * Function leaves the ability to modify cache key in future.
	 * @return string Cache key to be used in CPHPCache()
	 */
	final protected function getCacheKey($cacheId = array())
	{
		if(!is_array($cacheId))
			$cacheId = array((string) $cacheId);

		$cacheId['SITE_ID'] = SITE_ID;
		$cacheId['LANGUAGE_ID'] = LANGUAGE_ID;
		// if there are two or more caches with the same id, but with different cache_time, make them separate
		$cacheId['CACHE_TIME'] = intval($this->arResult['CACHE_TIME']);

		if(defined("SITE_TEMPLATE_ID"))
			$cacheId['SITE_TEMPLATE_ID'] = SITE_TEMPLATE_ID;

		return implode('|', $cacheId);
	}
}