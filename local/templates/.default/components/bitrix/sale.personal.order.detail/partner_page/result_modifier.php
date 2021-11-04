<?php
    $arResult['CNT'] = \CSaleOrder::GetList([],['USER_ID'=>$USER->GetID()])->SelectedRowsCount();