<?php
use Bitrix\Main,
	Bitrix\Main\Loader,
	Bitrix\Main\Config\Option,
	Bitrix\Main\Web\Json,
	Bitrix\Main\Localization\Loc,
	Bitrix\Sale,
	Bitrix\Sale\Order,
	Bitrix\Sale\PersonType,
	Bitrix\Sale\Shipment,
	Bitrix\Sale\PaySystem,
	Bitrix\Sale\Payment,
	Bitrix\Sale\Delivery,
	Bitrix\Sale\Location,
	Bitrix\Sale\Location\LocationTable,
	Bitrix\Sale\Result,
	Bitrix\Sale\DiscountCouponsManager;

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

/**
 * @var $APPLICATION CMain
 * @var $USER CUser
 */

Loc::loadMessages(__FILE__);
Loader::includeModule('redreams.partners');
if (!Loader::includeModule("sale"))
{
	ShowError(Loc::getMessage("SOA_MODULE_NOT_INSTALL"));
	return;
}
CBitrixComponent::includeComponentClass("bitrix:sale.order.ajax");


class RedreamsSaleOrderAjax extends SaleOrderAjax
{
	/**
	 * Synchronization of modified fields with current order object.
	 *
	 * @param       $modifiedFields
	 * @param Order $order
	 * @throws Main\NotSupportedException
	 * @throws Main\ObjectNotFoundException
	 */
	protected function synchronizeOrder($modifiedFields, Order $order)
	{
		if (!empty($modifiedFields) && is_array($modifiedFields))
		{
			if($modifiedFields["PERSON_TYPE_ID"] > 0)
			{
				$order->setPersonTypeId($modifiedFields["PERSON_TYPE_ID"]);
			}
			$recalculatePayment = $modifiedFields['CALCULATE_PAYMENT'] === true;
			unset($modifiedFields['CALCULATE_PAYMENT']);
			$recalculateDelivery = false;
			$propertyCollection = $order->getPropertyCollection();

			foreach ($modifiedFields as $field => $value)
			{
				switch ($field)
				{
					case 'PAY_SYSTEM_ID':
						$recalculatePayment = true;
						break;
					case 'PAY_CURRENT_ACCOUNT':
						$recalculatePayment = true;
						break;
					case 'DELIVERY_ID':
						$recalculateDelivery = true;
						break;
					case 'ORDER_PROP':
						if (is_array($value))
						{
							/** @var Sale\PropertyValue $property */
							foreach ($propertyCollection as $property)
							{
								if (array_key_exists($property->getPropertyId(), $value))
								{
									$property->setValue($value[$property->getPropertyId()]);
									$arProperty = $property->getProperty();
									if ($arProperty['IS_LOCATION'] == 'Y' || $arProperty['IS_ZIP'] == 'Y')
										$recalculateDelivery = true;
								}
							}
						}
						break;
					case 'ORDER_DESCRIPTION':
						$order->setField("USER_DESCRIPTION", $value);
						break;
					case 'DELIVERY_LOCATION':
						$codeValue = CSaleLocation::getLocationCODEbyID($value);
						if ($property = $propertyCollection->getDeliveryLocation())
						{
							$property->setValue($codeValue);
							$this->arUserResult['ORDER_PROP'][$property->getPropertyId()] = $codeValue;
						}

						$recalculateDelivery = true;
						break;
					case 'DELIVERY_LOCATION_BCODE':
						if ($property = $propertyCollection->getDeliveryLocation())
						{
							$property->setValue($value);
							$this->arUserResult['ORDER_PROP'][$property->getPropertyId()] = $value;
						}

						$recalculateDelivery = true;
						break;
					case 'DELIVERY_LOCATION_ZIP':
						if ($property = $propertyCollection->getDeliveryLocationZip())
						{
							$property->setValue($value);
							$this->arUserResult['ORDER_PROP'][$property->getPropertyId()] = $value;
						}

						$recalculateDelivery = true;
						break;
					case 'TAX_LOCATION':
						$codeValue = CSaleLocation::getLocationCODEbyID($value);
						if ($property = $propertyCollection->getTaxLocation())
						{
							$property->setValue($codeValue);
							$this->arUserResult['ORDER_PROP'][$property->getPropertyId()] = $codeValue;
						}
						break;
					case 'TAX_LOCATION_BCODE':
						if ($property = $propertyCollection->getTaxLocation())
						{
							$property->setValue($value);
							$this->arUserResult['ORDER_PROP'][$property->getPropertyId()] = $value;
						}
						break;
					case 'PAYER_NAME':
						if ($property = $propertyCollection->getPayerName())
						{
							$property->setValue($value);
							$this->arUserResult['ORDER_PROP'][$property->getPropertyId()] = $value;
						}
						break;
					case 'USER_EMAIL':
						if ($property = $propertyCollection->getUserEmail())
						{
							$property->setValue($value);
							$this->arUserResult['ORDER_PROP'][$property->getPropertyId()] = $value;
						}
						break;
					case 'PROFILE_NAME':
						if ($property = $propertyCollection->getProfileName())
						{
							$property->setValue($value);
							$this->arUserResult['ORDER_PROP'][$property->getPropertyId()] = $value;
						}
						break;
				}

				$this->arUserResult[$field] = $value;
			}

			if ($recalculateDelivery)
			{
				if ($shipment = $this->getCurrentShipment($order))
				{
					$this->initDelivery($shipment);
					$recalculatePayment = true;
				}
			}

			if ($recalculatePayment)
				$this->recalculatePayment($order);
		}
	}
	protected function initUserProfiles(Order $order, $isPersonTypeChanged)
	{
		$arResult =& $this->arResult;



		$justAuthorized = $this->request->get('do_authorize') == 'Y' || $this->request->get('do_register') == 'Y';
		$bFirst = false;
		$dbUserProfiles = CSaleOrderUserProps::GetList(
			array("DATE_UPDATE" => "DESC"),
			array(
				"PERSON_TYPE_ID" => $order->getPersonTypeId(),
				"USER_ID" => $order->getUserId()
			)
		);
		while ($arUserProfiles = $dbUserProfiles->GetNext())
		{
			if(Redreams\Partners\partner::isPartner())
			{
				if (\Redreams\Partners\contractor::getCurentContractor() == $arUserProfiles["ID"] && (empty($this->arUserResult['PROFILE_CHANGE']) || $isPersonTypeChanged || $justAuthorized))
				{
					$this->arUserResult['PROFILE_ID'] = intval($arUserProfiles["ID"]);
				}

				if (intval($this->arUserResult['PROFILE_ID']) == intval($arUserProfiles["ID"]))
					$arUserProfiles["CHECKED"] = "Y";

				$arResult["ORDER_PROP"]["USER_PROFILES"][$arUserProfiles["ID"]] = $arUserProfiles;
			}
			elseif(Redreams\Partners\partner::isOperator())
			{
				/*
				$rsUser = CUser::GetByID($USER->GetID());
				$arUser = $rsUser->Fetch();

				if ($arUser["UF_OPERATOR_CONTRACTOR_XML_ID"][0])
				{
					$contractorID = $arUser["UF_OPERATOR_CONTRACTOR_XML_ID"][0];
					$this->arUserResult['PROFILE_ID'] = $contractorID;
				}
				*/
				
				/*
				if (\Redreams\Partners\contractor::getCurentContractor() == $arUserProfiles["ID"] && (empty($this->arUserResult['PROFILE_CHANGE']) || $isPersonTypeChanged || $justAuthorized))
				{
					$this->arUserResult['PROFILE_ID'] = intval($arUserProfiles["ID"]);
				}

				if (intval($this->arUserResult['PROFILE_ID']) == intval($arUserProfiles["ID"]))
					$arUserProfiles["CHECKED"] = "Y";

				$arResult["ORDER_PROP"]["USER_PROFILES"][$arUserProfiles["ID"]] = $arUserProfiles;
				*/
			}
			else
			{
				if (!$bFirst && (empty($this->arUserResult['PROFILE_CHANGE']) || $isPersonTypeChanged || $justAuthorized))
				{
					$bFirst = true;

					$this->arUserResult['PROFILE_ID'] = intval($arUserProfiles["ID"]);
				}

				if (intval($this->arUserResult['PROFILE_ID']) == intval($arUserProfiles["ID"]))
					$arUserProfiles["CHECKED"] = "Y";

				$arResult["ORDER_PROP"]["USER_PROFILES"][$arUserProfiles["ID"]] = $arUserProfiles;
			}



		}
	}


}