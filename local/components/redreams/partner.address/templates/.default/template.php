<?php
if($arResult):?>
    <ol class="my_addr">
        <?foreach ($arResult as $addr):?>
            <li><?=$addr['UF_ADRESS']?></li>
        <?endforeach;?>
    </ol>
<?endif;?>
