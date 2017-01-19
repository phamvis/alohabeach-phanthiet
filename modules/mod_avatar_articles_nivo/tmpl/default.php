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
?>
<div id="avatar_articles_nivo_<?php echo $id?>" class="slider-wrapper theme-<?php echo $theme;?>" style="width:<?php echo $sliderWidth;?>;height:auto;margin:auto;">
    <div id="slider_<?php echo $id;?>" class="nivoSlider">
        <?php foreach ($articles as $key=>$article):
				$articleImage = json_decode($article->images);
				$articleLinks = json_decode($article->urls);
				$link = NULL;
				switch ($linkTo) {
					case 'urlta':
						$link = $article->link;
						break;
					case 'urla':
						$link = $articleLinks->urla;
						break;	
					case 'urlb':
						$link = $articleLinks->urlb;
						break;
					case 'urlc':
						$link = $articleLinks->urlc;
						break;
					case 'unurl':
						$link = null;
						break;
				}	
		?>
		<?php if($link != null && $link!='') :?>
			<a <?php if($newTab == 'true') echo 'target="_blank"';?>
			href="<?php echo $link;?>" 
			title="<?php echo htmlspecialchars($article->title);?>">
		<?php endif;?>
			<img src="<?php if(strlen($articleImage->image_intro) == 0) echo JURI::base().'/modules/mod_avatar_articles_nivo/assets/images/blank.jpg'; 
							else echo $articleImage->image_intro;?>" 
			alt="<?php echo htmlspecialchars($article->title);?>" 
			title="<?php 
				if($articleTitle == 'true')
					echo htmlspecialchars('<div class="nivo-tittle"><h2>'.$article->title.'</h2></div>');
				if($articleIntro == 'true')
					echo htmlspecialchars('<div class="nivo-introtext">'.$article->introtext.'</div>');
					?>">
		<?php if($link != null && $link!='') :?>
			</a>
		<?php endif;?>
		<?php endforeach;?>
    </div>
</div>