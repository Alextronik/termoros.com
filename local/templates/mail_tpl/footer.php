<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
	<!-- ***************** END CONTENT  ********************-->
	<!-- ***************** FOOTER  ********************-->
		</td>
	</tr>	
	
	<tr>
		<td colspan='5' style='text-align:center;padding:0;background:#ffffff; vertical-align:top;'>
			<img src='https://www.termoros.com/local/templates/mail_tpl/border.jpg' style='border:0;margin:0 auto 20px ;display:block;' alt='' />
		</td>
	</tr>

	<tr>
		<td colspan="2" style='text-align:left;padding:0 1rem;height:40px;vertical-align:middle;background:#e7e8ee;vertical-align:middle;'>
            <p style="display: inline-block;vertical-align:baseline;font-size: 12px;line-height: 14px;color: #6b6f7c;margin:0 0 0 0;padding:0;">© Группа компаний "Терморос" 1995-<?=date("Y")?></p>
		</td>
        <td colspan="2" style='text-align:left;padding:0;height:40px;background:#e7e8ee;vertical-align:middle;'>
            <a href="https://www.termoros.com/copy.php" style="display: inline-block;vertical-align:baseline;font-size: 12px;line-height: 14px;color: #6b6f7c;margin:0 1rem;padding:0;">Правовая информация</a>
            <a href='https://www.termoros.com/public_offer.php' style="display: inline-block;vertical-align:baseline;font-size: 12px;line-height: 14px;color: #6b6f7c;margin:0 0 0 0;padding:0;">Публичная оферта</a>
        </td>
        <td colspan="1" style='text-align:right;padding:0;height:40px;background:#e7e8ee;vertical-align:middle;'>
            <a href="https://www.facebook.com/Termoros/" target="_blank"><img style="max-height:64px;max-width:64px;margin:0.5rem" src="https://www.termoros.com/local/templates/mail_tpl/fb.png" alt="Facebook"></a>
            <a href="https://www.instagram.com/termoros_official/" target="_blank"><img style="max-height:64px;max-width:64px;margin:0.5rem" src="https://www.termoros.com/local/templates/mail_tpl/insta.png" alt="Instagram"></a>
            <a href="https://www.youtube.com/channel/UC5LKYB2gV18CeND-dInJrsQ" target="_blank"><img style="max-height:64px;max-width:64px;margin:0.5rem" src="https://www.termoros.com/local/templates/mail_tpl/utube.png" alt="Youtube"></a>
        </td>
	</tr>

</table>
<? if (\Bitrix\Main\Loader::includeModule('mail')) : ?>
<?=\Bitrix\Mail\Message::getQuoteEndMarker(true); ?>
<? endif; ?>
</body>
</html>
<!-- ***************** END FOOTER  ********************-->