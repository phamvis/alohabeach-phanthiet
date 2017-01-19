<?php
/**
 * @version		2.6.x
 * @package		K2
 * @author		JoomlaWorks http://www.joomlaworks.net
 * @copyright	Copyright (c) 2006 - 2014 JoomlaWorks Ltd. All rights reserved.
 * @license		GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 */

// no direct access
defined('_JEXEC') or die;

?>

<!-- Start K2 Category Layout -->
<div id="k2Container" class="at-blog itemListView<?php if($this->params->get('pageclass_sfx')) echo ' '.$this->params->get('pageclass_sfx'); ?>">

	<?php if($this->params->get('show_page_title')): ?>
	<!-- Page title -->
	<div class="componentheading<?php echo $this->params->get('pageclass_sfx')?>">
		<?php echo $this->escape($this->params->get('page_title')); ?>
	</div>
	<?php endif; ?>

	<?php if($this->params->get('catFeedIcon')): ?>
	<!-- RSS feed icon -->
	<div class="k2FeedIcon">
		<a href="<?php echo $this->feed; ?>" title="<?php echo JText::_('K2_SUBSCRIBE_TO_THIS_RSS_FEED'); ?>">
			<span><?php echo JText::_('K2_SUBSCRIBE_TO_THIS_RSS_FEED'); ?></span>
		</a>
		<div class="clr"></div>
	</div>
	<?php endif; ?>

	<?php if(isset($this->category) || ( $this->params->get('subCategories') && isset($this->subCategories) && count($this->subCategories) )): ?>
	<!-- Blocks for current category and subcategories -->
	<div class="itemListCategoriesBlock">

		<?php if(isset($this->category) && ( $this->params->get('catImage') || $this->params->get('catTitle') || $this->params->get('catDescription') || $this->category->event->K2CategoryDisplay )): ?>
		<!-- Category block -->
		<div class="itemListCategory">

			<?php if(isset($this->addLink)): ?>
			<!-- Item add link -->
			<span class="catItemAddLink">
				<a class="modal" rel="{handler:'iframe',size:{x:990,y:650}}" href="<?php echo $this->addLink; ?>">
					<?php echo JText::_('K2_ADD_A_NEW_ITEM_IN_THIS_CATEGORY'); ?>
				</a>
			</span>
			<?php endif; ?>

			<?php if($this->params->get('catTitle')): ?>
			<!-- Category title -->
			<div class="categoryTitle"><?php echo $this->category->name; ?><?php if($this->params->get('catTitleItemCounter')) echo ' ('.$this->pagination->total.')'; ?></div>
			<?php endif; ?>

			<!-- K2 Plugins: K2CategoryDisplay -->
			<?php echo $this->category->event->K2CategoryDisplay; ?>

			<div class="clr"></div>
		</div>
		<?php endif; ?>

		<?php if($this->params->get('subCategories') && isset($this->subCategories) && count($this->subCategories)): ?>
		<!-- Subcategories -->
		<div class="itemListSubCategories">
			<?php foreach($this->subCategories as $key=>$subCategory): ?>

			<div class="subCategoryContainer">
				<div class="at-subCategory">
					<?php if($this->params->get('subCatTitle')): ?>
					<!-- Subcategory title -->
						<a href="<?php echo $subCategory->link; ?>">
							<?php echo $subCategory->name; ?><?php if($this->params->get('subCatTitleItemCounter')) echo ' ('.$subCategory->numOfItems.')'; ?>
						</a>
					<?php endif; ?>
					<div class="clr"></div>
				</div>
			</div>
			<?php endforeach; ?>

			<div class="clr"></div>
		</div>
		<?php endif; ?>

	</div>
	<?php endif; ?>



	<?php if((isset($this->leading) || isset($this->primary) || isset($this->secondary) || isset($this->links)) && (count($this->leading) || count($this->primary) || count($this->secondary) || count($this->links))): ?>
	<!-- Item list -->
	<div class="itemList">

		<?php if(isset($this->leading) && count($this->leading)): ?>
		<!-- Leading items -->
		<div class="items-leading clearfix">
		<?php
		$leadingcount = (count($this->leading));
		$counter = 0;
		?>
		<?php foreach($this->leading as $key=>$item): ?>
			<?php $rowcount = ((int) $key % (int) $this->params->get('num_leading_columns')) + 1; ?>
			<?php if ($rowcount == 1) : ?>
				<?php $row = $counter / $this->params->get('num_leading_columns'); ?>
				<div class="items-row cols-<?php echo (int) $this->params->get('num_leading_columns'); ?> <?php echo 'row-' . $row; ?> row-fluid clearfix">
			<?php endif; ?>
					<div class="span<?php echo round((12 / $this->params->get('num_leading_columns'))); ?>">
						<div class="item column-<?php echo $rowcount; ?>" itemprop="blogPost" itemscope itemtype="http://schema.org/BlogPosting">
						<?php
						$this->item = $item;
						echo $this->loadTemplate('item');
						?>
						</div>
						<!-- end item -->
						<?php $counter++; ?>
					</div><!-- end span -->
			<?php if (($rowcount == $this->params->get('num_leading_columns')) or ($counter == $leadingcount)) : ?>
				</div><!-- end row -->
			<?php endif; ?>
		<?php endforeach; ?>
		</div><!-- end items-leading -->
		<?php endif; ?>

		<?php if(isset($this->primary) && count($this->primary)): ?>
		<!-- Primary items -->
		<div id="itemListPrimary">
		<?php
		$primarycount = (count($this->primary));
		$counter = 0;
		?>
		<?php foreach($this->primary as $key=>$item): ?>
			<?php $rowcount = ((int) $key % (int) $this->params->get('num_primary_columns')) + 1; ?>
			<?php if ($rowcount == 1) : ?>
				<?php $row = $counter / $this->params->get('num_primary_columns'); ?>
				<div class="items-row cols-<?php echo (int) $this->params->get('num_primary_columns'); ?> <?php echo 'row-' . $row; ?> row-fluid clearfix">
			<?php endif; ?>
					<div class="span<?php echo round((12 / $this->params->get('num_primary_columns'))); ?>">
						<div class="item column-<?php echo $rowcount; ?>" itemprop="blogPost" itemscope itemtype="http://schema.org/BlogPosting">
						<?php
						$this->item = $item;
						echo $this->loadTemplate('item');
						?>
						</div>
						<!-- end item -->
						<?php $counter++; ?>
					</div><!-- end span -->
			<?php if (($rowcount == $this->params->get('num_primary_columns')) or ($counter == $primarycount)) : ?>
				</div><!-- end row -->
			<?php endif; ?>
		<?php endforeach; ?>
		</div>
		<?php endif; ?>

		<?php if(isset($this->secondary) && count($this->secondary)): ?>
		<!-- Secondary items -->
		<div id="itemListSecondary">
		<?php
		$secondarycount = (count($this->secondary));
		$counter = 0;
		?>
		<?php foreach($this->secondary as $key=>$item): ?>
			<?php $rowcount = ((int) $key % (int) $this->params->get('num_secondary_columns')) + 1; ?>
			<?php if ($rowcount == 1) : ?>
				<?php $row = $counter / $this->params->get('num_secondary_columns'); ?>
				<div class="items-row cols-<?php echo (int) $this->params->get('num_secondary_columns'); ?> <?php echo 'row-' . $row; ?> row-fluid clearfix">
			<?php endif; ?>
					<div class="span<?php echo round((12 / $this->params->get('num_secondary_columns'))); ?>">
						<div class="item column-<?php echo $rowcount; ?>" itemprop="blogPost" itemscope itemtype="http://schema.org/BlogPosting">
						<?php
						$this->item = $item;
						echo $this->loadTemplate('item');
						?>
						</div>
						<!-- end item -->
						<?php $counter++; ?>
					</div><!-- end span -->
			<?php if (($rowcount == $this->params->get('num_secondary_columns')) or ($counter == $secondarycount)) : ?>
				</div><!-- end row -->
			<?php endif; ?>
		<?php endforeach; ?>
		</div>
		<?php endif; ?>

		<?php if(isset($this->links) && count($this->links)): ?>
		<!-- Link items -->
		<div id="at-itemListLinks">
			<h2><?php echo JText::_('K2_MORE'); ?></h2>
			<ul class="the-arrow">
			<?php foreach($this->links as $key=>$item): ?>

			<?php
			// Define a CSS class for the last container on each row
			if( (($key+1)%($this->params->get('num_links_columns'))==0) || count($this->links)<$this->params->get('num_links_columns') )
				$lastContainer= ' itemContainerLast';
			else
				$lastContainer='';
			?>

			<li class="at-itemContainer<?php echo $lastContainer; ?>"<?php echo (count($this->links)==1) ? '' : ' style="width:'.number_format(100/$this->params->get('num_links_columns'), 1).'%;"'; ?>>
				<?php
					// Load category_item_links.php by default
					$this->item=$item;
					echo $this->loadTemplate('item_links');
				?>
			</li>
			<?php if(($key+1)%($this->params->get('num_links_columns'))==0): ?>
			<div class="clr"></div>
			<?php endif; ?>
			<?php endforeach; ?>
			</ul>
			<div class="clr"></div>
		</div>
		<?php endif; ?>

	</div>

	<!-- Pagination -->
	<?php if($this->pagination->getPagesLinks()): ?>
	<div class="pagination">
		<p class="counter"><?php if($this->params->get('catPaginationResults')) echo $this->pagination->getPagesCounter(); ?></p>
		<?php if($this->params->get('catPagination')) echo $this->pagination->getPagesLinks(); ?>
		<div class="clr"></div>
	</div>
	<?php endif; ?>

	<?php endif; ?>
</div>
<!-- End K2 Category Layout -->
