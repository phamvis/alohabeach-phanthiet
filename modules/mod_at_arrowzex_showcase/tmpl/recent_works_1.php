<?php
/**
 * @copyright	http://www.amazing-templates.com
 * @author		Tran Nam Chung
 * @link		http://www.amazing-templates.com
 * @license		License GNU General Public License version 2 or later
 * @package		Amazing-Templates Framework Template
 */

defined('_JEXEC') or die;
$itemcount = 0;
$counter = 0;
$flag_open = $flag_close =0;
?>
<div class="at-arrowzex-recent-works-1">
		<?php
		if( $contenSource == 'default') :
		foreach ($list as $key => &$item) :
				$articleImage = json_decode($item->images);
				$articleLinks = json_decode($item->urls);
				$link = NULL;
				switch ($linkTo) {
					case 'urltao':
						$link = JURI::base().'index.php?option=com_content&view=article&id='.$item->id;
						break;
					case 'urltal':
						$link = $item->link;
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
				
				if($itemcount < $primaryCount) :
					if($key == 0){$flag_open = 1;}
					if($key == $primaryCount-1 || $key == count($list)-1)$flag_close = 1;
					if($flag_open == 1){
						echo "<div class='at-primary-group'>";$flag_open = 0;
					}
					$key = $key + 1;
					$rowcount = (((int) $key - 1) % (int) $primaryColumns) + 1;
					$row = $itemcount / $primaryColumns;
					if ($rowcount == 1) : ?>
					
					<div class="items-row cols-<?php echo (int) $primaryColumns;?> <?php echo 'row-'.$row; ?> row-fluid">
					<?php endif; ?>
					
						<?php $articleImage = json_decode($item->images);?>
						<div class="at-intro-item-wrap span<?php echo round((12 / $primaryColumns));?>">
						    <div class="at-intro-item">
						    	<?php if($articleImage->image_intro): ?>
									<div class="at-item-image lazy" data-original="<?php echo JURI::base().htmlspecialchars($articleImage->image_intro); ?>" style="">
									</div>
								<?php endif;?>
								<div class="ch-info">
									<?php if($articleTitle == 'true'):?>   
										<<?php echo $item_heading; ?> class="at-item-title">
									   	<?php if ($linkTo !='unurl' && $link != null) : ?>
										<a href="<?php echo $link;?>" <?php echo $newTabText;?>>
												<?php echo $item->title;?></a>
								        <?php else :?>
								        <?php echo $item->title; ?>
								        <?php endif; ?>
								        </<?php echo $item_heading; ?>>
							        <?php endif;?>
									<div class="ch-info-content">
										<?php if($articleIntro == 'true') echo $item->introtext; ?>
										<?php if (isset($item->link) && $item->readmore != 0 && $readmoreBtn == 'true') :?>
											<div>
											<?php 
												echo '<a class="at_readmore" href="'.$link.'"';
												if($newTab=='true') echo " target='_blank'";
												echo ">";
												echo '<div class="at_readmore_text">'.$readmoreText.'</div>';
											?>
											</a>
											</div>
										<?php endif; ?>
									</div>
								</div>
							</div>
						<?php $counter++; ?>
						<?php $itemcount++; ?>
				        </div>		
						<?php if (($rowcount == $primaryColumns) or ($counter == $primaryCount) or $counter == count($list)) :?>
						</div>
						<?php endif; ?>
				<?php 
				if($flag_close == 1){
						echo "</div>";$flag_close = 0;$counter = 0;
					}
				?>
				<?php else :?>
				<?php
					if($key == $primaryCount){$flag_open = 1;}
					if($key == count($list)-1)$flag_close = 1;
					
					if($flag_open == 1){
						echo "<div class='at-secondary-group'>";$flag_open = 0;
					}
					
				 	$key = ($key - $primaryCount)+ 1;
					$rowcount = (((int) $key - 1) % (int) $secondaryColumns) + 1;
					$row = $counter / $secondaryColumns;
					if ($rowcount == 1) : ?>
					<div class="items-row cols-<?php echo (int) $secondaryColumns;?> <?php echo 'row-'.$row; ?> row-fluid">
					<?php endif; ?>
					
						<?php $articleImage = json_decode($item->images);?>
						<div class="at-intro-item-wrap span<?php echo round((12 / $secondaryColumns));?>">
						    <div class="at-intro-item">
						    	<?php if($articleImage->image_intro): ?>
									<div class="at-item-image lazy" data-original="<?php echo JURI::base().htmlspecialchars($articleImage->image_intro); ?>" style="">
									</div>
								<?php endif;?>
								<div class="at-item-more">
										<div>
											<div class="at-item-more-content">
												<?php if($imgLightboxIcon == 'true')
												{
													$id = uniqid();
													echo '<a class="at-image" href="#at-image-'.$id.'" data-toggle="modal"><div class="at-arrowzex-image-icon"></div></a>';
												}
												?>
												<?php if ($linkTo !='unurl' && $link != null && $readmoreBtn == 'true') :?>
												<?php 
													echo '<a class="at-readmore" href="'.$link.'"';
													if($newTab=='true') echo " target='_blank'";
													echo ">";
													echo '<div class="at-readmore-text"></div>';
												?>
												</a>
											<?php endif; ?>
											</div>
										</div>
								</div>
							</div>
							<div class="ch-info">
								<?php if($articleTitle == 'true'):?>   
									<<?php echo $item_heading; ?> class="at-item-title">
							        	<?php echo $item->title; ?>
							        </<?php echo $item_heading; ?>>
						        <?php endif;?>
							</div>
						<?php $counter++; ?>
						<?php $itemcount++; ?>
				        </div>
				        
				        <?php if ($articleImage->image_intro) : ?>
						<div id="at-image-<?php echo $id;?>" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
						  <div class="modal-body">
						    <img class="at-modal-image" src="<?php echo JURI::base().htmlspecialchars($articleImage->image_intro);?>">
						  </div>
						  <div class="modal-footer">
						    <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
						  </div>
						</div>
						<?php endif;?>
								
						<?php if (($rowcount == $secondaryColumns) or ($counter == count($list) - $primaryCount)) : ?>
						</div>
						<?php endif; ?>
					<?php 
					if($flag_close == 1){
						echo "</div>";$flag_close = 0;
						}
					?>	
				<?php endif;?>
			<?php endforeach;?>
		<?php
		elseif( $contenSource == 'k2') :
			foreach ($list as $key => &$item) :
				if($itemcount < $primaryCount) :
					if($key == 0){$flag_open = 1;}
					if($key == $primaryCount-1 || $key == count($list)-1)$flag_close = 1;
					if($flag_open == 1){
						echo "<div class='at-primary-group'>";$flag_open = 0;
					}
					$key = $key + 1;
					$rowcount = (((int) $key - 1) % (int) $primaryColumns) + 1;
					$row = $itemcount / $primaryColumns;
					if ($rowcount == 1) : ?>
					
					<div class="items-row cols-<?php echo (int) $primaryColumns;?> <?php echo 'row-'.$row; ?> row-fluid">
					<?php endif; ?>
						<div class="at-intro-item-wrap span<?php echo round((12 / $primaryColumns));?>">
						    <div class="at-intro-item">
						    	<?php if($item->image): ?>
									<div class="at-item-image lazy" data-original="<?php echo htmlspecialchars($item->image); ?>" style="">
									</div>
								<?php endif;?>
								<div class="ch-info">
									<?php if($articleTitle == 'true'):?>   
										<<?php echo $item_heading; ?> class="at-item-title">
									   	<?php if ($linkTo !='unurl' && $link != null) : ?>
											<a href="<?php echo $item->link;?>" <?php if($newTab=='true') echo " target='_blank'";?> >
											<?php echo $item->title;?></a>
								        <?php else :?>
								        <?php echo $item->title; ?>
								        <?php endif; ?>
								        </<?php echo $item_heading; ?>>
							        <?php endif;?>
									<div class="ch-info-content">
										<?php if($articleIntro == 'true') echo $item->introtext; ?>
										<?php if ($item->link != null && $readmoreBtn == 'true') :?>
											<div>
											<?php 
												echo '<a class="at_readmore" href="'.$item->link.'"';
												if($newTab=='true') echo " target='_blank'";
												echo ">";
												echo '<div class="at_readmore_text">'.$readmoreText.'</div>';
											?>
											</a>
											</div>
										<?php endif; ?>
									</div>
								</div>
							</div>
						<?php $counter++; ?>
						<?php $itemcount++; ?>
				        </div>		
						<?php if (($rowcount == $primaryColumns) or ($counter == $primaryCount) or $counter == count($list)) :?>
						</div>
						<?php endif; ?>
				<?php 
				if($flag_close == 1){
						echo "</div>";$flag_close = 0;$counter = 0;
					}
				?>
				<?php else :?>
				<?php
					if($key == $primaryCount){$flag_open = 1;}
					if($key == count($list)-1)$flag_close = 1;
					
					if($flag_open == 1){
						echo "<div class='at-secondary-group'>";$flag_open = 0;
					}
					
				 	$key = ($key - $primaryCount)+ 1;
					$rowcount = (((int) $key - 1) % (int) $secondaryColumns) + 1;
					$row = $counter / $secondaryColumns;
					if ($rowcount == 1) : ?>
					<div class="items-row cols-<?php echo (int) $secondaryColumns;?> <?php echo 'row-'.$row; ?> row-fluid">
					<?php endif; ?>
						<div class="at-intro-item-wrap span<?php echo round((12 / $secondaryColumns));?>">
						    <div class="at-intro-item">
						    	<?php if($item->image): ?>
									<div class="at-item-image lazy" data-original="<?php echo htmlspecialchars($item->image); ?>" style="">
									</div>
								<?php endif;?>
								<div class="at-item-more">
										<div>
											<div class="at-item-more-content">
												<?php if($imgLightboxIcon == 'true')
												{
													$id = uniqid();
													echo '<a class="at-image" href="#at-image-'.$id.'" data-toggle="modal"><div class="at-arrowzex-image-icon"></div></a>';
												}
												?>
												<?php if ($item->link != null && $readmoreBtn == 'true') :?>
												<?php 
													echo '<a class="at-readmore" href="'.$item->link.'"';
													if($newTab=='true') echo " target='_blank'";
													echo ">";
													echo '<div class="at-readmore-text"></div>';
												?>
												</a>
											<?php endif; ?>
											</div>
										</div>
								</div>
							</div>
							<div class="ch-info">
								<?php if($articleTitle == 'true'):?>   
									<<?php echo $item_heading; ?> class="at-item-title">
							        	<?php echo $item->title; ?>
							        </<?php echo $item_heading; ?>>
						        <?php endif;?>
							</div>
						<?php $counter++; ?>
						<?php $itemcount++; ?>
				        </div>
				        
				        <?php if ($item->image) : ?>
						<div id="at-image-<?php echo $id;?>" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
						  <div class="modal-body">
						    <img class="at-modal-image" src="<?php echo htmlspecialchars($item->image);?>">
						  </div>
						  <div class="modal-footer">
						    <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
						  </div>
						</div>
						<?php endif;?>
								
						<?php if (($rowcount == $secondaryColumns) or ($counter == count($list) - $primaryCount)) : ?>
						</div>
						<?php endif; ?>
					<?php 
					if($flag_close == 1){
						echo "</div>";$flag_close = 0;
						}
					?>	
				<?php endif;?>
			<?php endforeach;?>
		<?php endif;?>
</div>