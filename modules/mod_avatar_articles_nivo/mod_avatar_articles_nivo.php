<?php
/**
 * @copyright	amazing-templates.com
 * @author		Tran Nam Chung
 * @mail		chungtn2910@gmail.com
 * @link		http://www.amazing-templates.com
 * @license		License GNU General Public License version 2 or later
 */
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
// Include the syndicate functions only once
$language = JFactory::getLanguage();
require_once( dirname(__FILE__).DIRECTORY_SEPARATOR.'helper.php' );
require_once( dirname(__FILE__).DIRECTORY_SEPARATOR.'classes'.DIRECTORY_SEPARATOR.'avatar.helper.php' );
require_once( dirname(__FILE__).DIRECTORY_SEPARATOR.'classes'.DIRECTORY_SEPARATOR.'avatar.articles.php' );
require_once( dirname(__FILE__).DIRECTORY_SEPARATOR.'classes'.DIRECTORY_SEPARATOR.'avatar.nivo.php' );

$articles = avatar_articles::getList($params);
//var_dump(json_decode($articles[0]->urls));
if (count($articles)<1)return;
$linkTo = avatar_articles::getarticleLink($params);
$newTab = avatar_articles::getnewTab($params);
$articleTitle = avatar_articles::getarticleTitle($params);
$articleIntro = avatar_articles::getarticleIntro($params);

$sliderWidth = AMSize::getWidth($params);
$cr = AMSize::getCopyRight($params);
$jquery = AMJquery::getJqueryVer($params);

$slices = avatar_nivo::getslices($params);
$boxRows = avatar_nivo::getboxRows($params);
$boxCols = $boxRows*2;
$animSpeed = avatar_nivo::getanimSpeed($params);
$effect = avatar_nivo::getTransition($params);
$pauseTime = avatar_nivo::getSlideTime($params);
$theme = avatar_nivo::gettheme($params);
$controlNav = avatar_nivo::getcontrolNav($params);
$randomStart = avatar_nivo::getrandomStart($params);
$titleColor = avatar_nivo::gettitleColor($params);
$introColor = avatar_nivo::getintroColor($params);
$autoPlay = avatar_nivo::getAutoPlay($params);

$id=uniqid();
$document = JFactory::getDocument();
switch ($jquery) {
	case 'unload':	
		break;
	case 'latest':
		$document->addScript('http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js');
		$document->addScriptDeclaration('jQuery.noConflict();');
		break;
	default:
		$document->addScript('http://ajax.googleapis.com/ajax/libs/jquery/'.$jquery.'/jquery.min.js');
		$document->addScriptDeclaration('jQuery.noConflict();');
		break;
}
$document->addStyleSheet("modules/mod_avatar_articles_nivo/assets/css/".$theme.".css");
$document->addStyleSheet("modules/mod_avatar_articles_nivo/assets/css/nivo-slider.css");
$document->addScript("modules/mod_avatar_articles_nivo/assets/js/jquery.nivo.slider.pack.js");

require( JModuleHelper::getLayoutPath( 'mod_avatar_articles_nivo' ) );

?>
<script type="text/javascript">
jQuery.noConflict();
(function($) 
{ 
	$(function() 
	{
		$(document).ready( function()
		{					
			$('#slider_<?php echo $id;?>').nivoSlider({
				effect			:'<?php if(sizeof($effect) > 0)
								{
									for($n = 0; $n < sizeof($effect)-1; $n++)
										{echo ($effect[$n]);echo ",";}
									echo ($effect[$n]);
								}
								else echo $effect;?>',
				slices			:<?php echo $slices;?>,
				boxRows			:<?php echo $boxRows;?>,
				boxCols			:<?php echo $boxCols;?>,
				animSpeed		:<?php echo $animSpeed;?>,
				pauseTime		:<?php echo $pauseTime;?>,
				controlNav		:<?php echo $controlNav;?>,
				randomStart		:<?php echo $randomStart;?>,
				manualAdvance	:<?php echo $autoPlay;?>
			});
			$('#slider_<?php echo $id;?> .nivo-caption .nivo-title h2').css("color","<?php echo $titleColor;?>");
			$('#slider_<?php echo $id;?> .nivo-caption .nivo-introtext p').css("color","<?php echo $introColor;?>");
		});
	})
})(jQuery);
</script>
<?php if (strtolower($cr) == 'false'):?>
<div class="avatar-copyright" style="width:100%;margin: 5px;text-align: center;font-size: 10px;display:none;">
&copy; Amazing-Templates.com
	<a target="_blank" href="http://www.amazing-templates.com" title="Joomla Template &amp; Extension">Joomla Extension</a>-
	<a target="_blank" href="http://www.amazing-templates.com" title="Joomla Template &amp; Extension">Joomla Template</a>
</div>
<?php endif;?>