<?php
/**
 * @copyright	http://www.amazing-templates.com
 * @author		Tran Nam Chung
 * @link		http://www.amazing-templates.com
 * @license		License GNU General Public License version 2 or later
 * @package		Amazing-Templates Framework Template
 */

// No direct access
defined('_JEXEC') or die;

function modChrome_avatarmodule($module, &$params, &$attribs)
{
	if (!empty ($module->content)) : ?>
		<div class="avatar-module <?php echo htmlspecialchars($params->get('moduleclass_sfx')); ?>">
		<?php if ($module->showtitle != 0) : ?>
			<<?php echo $params->get('header_tag', 'h4');?> class="avatar-module-heading"><span></spam><span><?php echo $module->title; ?></span></span></<?php echo $params->get('header_tag', 'h4');?>>
		<?php endif; ?>
			<div class="avatar-module-content">
				<?php echo $module->content; ?>
			</div>
		</div>
	<?php endif;
}

