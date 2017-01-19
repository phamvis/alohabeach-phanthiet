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
			<h3 class="avatar-module-heading"><span></spam><span><?php echo $module->title; ?></span></span></h3>
		<?php endif; ?>
			<div>
				<?php echo $module->content; ?>
			</div>
		</div>
	<?php endif;
}

