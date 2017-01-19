<?php
/**
 * @copyright	http://www.amazing-templates.com
 * @author		Tran Nam Chung
 * @link		http://www.amazing-templates.com
 * @license		License GNU General Public License version 2 or later
 * @package		Amazing-Templates Framework Template
 */

defined('_JEXEC') or die('Restricted index access');

jimport('joomla.form.formfield');
jimport('joomla.filesystem.folder');
require_once( dirname(__FILE__).DIRECTORY_SEPARATOR.'defined.php' );
class JFormFieldAvatarShowcaseSelector extends JFormField
{
	public $type = 'avatarshowcaseselector';

	protected function getInput()
	{
		$html 		= '';
		$options 	= array();
		$base 		= JPATH_ROOT.DIRECTORY_SEPARATOR.'modules'.DIRECTORY_SEPARATOR.AT_NAME.DIRECTORY_SEPARATOR.'tmpl';

		$attr 		= '';
		$attr 		.= $this->element['class'] ? ' class="'.(string) $this->element['class'].'"' : '';

		if ((string) $this->element['readonly'] == 'true' || (string) $this->element['disabled'] == 'true')
		{
			$attr .= ' disabled="disabled"';
		}

		$attr .= $this->element['size'] ? ' size="'.(int) $this->element['size'].'"' : '';
		$attr .= $this->multiple ? ' multiple="multiple"' : '';

		$attr .= $this->element['onchange'] ? ' onchange="'.(string) $this->element['onchange'].'"' : '';

		$options[] 	= JHTML::_('select.option', '', JText::_('AVATAR_SELECT_SHOWCASE'));
		$folders   	= JFolder::folders($base, '.', false, true);
		foreach ($folders as $folder)
		{
			$folder 	= str_replace($base, '', $folder);
			$value		= str_replace(DIRECTORY_SEPARATOR, '/', substr($folder, 1));
			$text	 	= str_replace(DIRECTORY_SEPARATOR, '/', $folder);
			$options[] 	= JHTML::_('select.option', $value, $text);
		}
		if (is_array($options))
		{
			sort($options);
		}

		$html = JHtml::_('select.genericlist', $options, $this->name, trim($attr), 'value', 'text', $this->value, $this->id);

		return $html;
	}

}