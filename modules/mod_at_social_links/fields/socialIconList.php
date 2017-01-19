<?php
/**
 * @copyright	http://www.amazing-templates.com
 * @author		Tran Nam Chung
 * @link		http://www.amazing-templates.com
 * @license		License GNU General Public License version 2 or later
 * @package		Amazing-Templates Framework Template
 */

defined('JPATH_PLATFORM') or die;
jimport( 'cms.version.version' );
$version = New JVersion;
/**
 * Form Field class for the Joomla CMS.
 * Provides a modal media selector including upload mechanism
 *
 * @package     Joomla.Libraries
 * @subpackage  Form
 * @since       1.6
 */
if($version->RELEASE == '3.3' || $version->RELEASE == '3.0' || $version->RELEASE == '3.1' || $version->RELEASE == '3.2')
{	
	class JFormFieldsocialIconList extends JFormField
	{
		/**
		 * The form field type.
		 *
		 * @var    string
		 * @since  1.6
		 */
		protected $type = 'socialIconList';
	
		/**
		 * The initialised state of the document object.
		 *
		 * @var    boolean
		 * @since  1.6
		 */
		protected static $initialised = false;
	
		/**
		 * The authorField.
		 *
		 * @var    string
		 * @since  3.2
		 */
		protected $authorField;
	
		/**
		 * The asset.
		 *
		 * @var    string
		 * @since  3.2
		 */
		protected $asset;
	
		/**
		 * The link.
		 *
		 * @var    string
		 * @since  3.2
		 */
		protected $link;
	
		/**
		 * The authorField.
		 *
		 * @var    string
		 * @since  3.2
		 */
		protected $preview;
	
		/**
		 * The preview.
		 *
		 * @var    string
		 * @since  3.2
		 */
		protected $directory;
	
		/**
		 * The previewWidth.
		 *
		 * @var    int
		 * @since  3.2
		 */
		protected $previewWidth;
	
		/**
		 * The previewHeight.
		 *
		 * @var    int
		 * @since  3.2
		 */
		protected $previewHeight;
	
		/**
		 * Method to get certain otherwise inaccessible properties from the form field object.
		 *
		 * @param   string  $name  The property name for which to the the value.
		 *
		 * @return  mixed  The property value or null.
		 *
		 * @since   3.2
		 */
		public function __get($name)
		{
			switch ($name)
			{
				case 'authorField':
				case 'asset':
				case 'link':
				case 'preview':
				case 'directory':
				case 'previewWidth':
				case 'previewHeight':
					return $this->$name;
			}
	
			return parent::__get($name);
		}
	
		/**
		 * Method to set certain otherwise inaccessible properties of the form field object.
		 *
		 * @param   string  $name   The property name for which to the the value.
		 * @param   mixed   $value  The value of the property.
		 *
		 * @return  void
		 *
		 * @since   3.2
		 */
		public function __set($name, $value)
		{
			switch ($name)
			{
				case 'authorField':
				case 'asset':
				case 'link':
				case 'preview':
				case 'directory':
					$this->$name = (string) $value;
					break;
	
				case 'previewWidth':
				case 'previewHeight':
					$this->$name = (int) $value;
					break;
	
				default:
					parent::__set($name, $value);
			}
		}
	
		/**
		 * Method to attach a JForm object to the field.
		 *
		 * @param   SimpleXMLElement  $element  The SimpleXMLElement object representing the <field /> tag for the form field object.
		 * @param   mixed             $value    The form field value to validate.
		 * @param   string            $group    The field name group control value. This acts as as an array container for the field.
		 *                                      For example if the field has name="foo" and the group value is set to "bar" then the
		 *                                      full field name would end up being "bar[foo]".
		 *
		 * @return  boolean  True on success.
		 *
		 * @see 	JFormField::setup()
		 * @since   3.2
		 */
		public function setup(SimpleXMLElement $element, $value, $group = null)
		{
			$result = parent::setup($element, $value, $group);
	
			if ($result == true)
			{
				$assetField = $this->element['asset_field'] ? (string) $this->element['asset_field'] : 'asset_id';
	
				$this->authorField   = $this->element['created_by_field'] ? (string) $this->element['created_by_field'] : 'created_by';
				$this->asset         = $this->form->getValue($assetField) ? $this->form->getValue($assetField) : (string) $this->element['asset_id'];
				$this->link          = (string) $this->element['link'];
				$this->preview       = (string) $this->element['preview'];
				$this->directory     = (string) $this->element['directory'];
				$this->previewWidth  = isset($this->element['preview_width']) ? (int) $this->element['preview_width'] : 300;
				$this->previewHeight = isset($this->element['preview_height']) ? (int) $this->element['preview_height'] : 200;
			}
	
			return $result;
		}
	
		/**
		 * Method to get the field input markup for a media selector.
		 * Use attributes to identify specific created_by and asset_id fields
		 *
		 * @return  string  The field input markup.
		 *
		 * @since   1.6
		 */
		protected function getInput()
		{
			$asset = $this->asset;
	
			if ($asset == '')
			{
				$asset = JFactory::getApplication()->input->get('option');
			}
	
			if (!self::$initialised)
			{
				// Load the modal behavior script.
				JHtml::_('behavior.modal');
	
				// Build the script.
				$script = array();
				$script[] = '	function jInsertFieldValue(value, id) {';
				$script[] = '		var old_value = document.id(id).value;';
				$script[] = '		if (old_value != value) {';
				$script[] = '			var elem = document.id(id);';
				$script[] = '			elem.value = value;';
				$script[] = '			elem.fireEvent("change");';
				$script[] = '			if (typeof(elem.onchange) === "function") {';
				$script[] = '				elem.onchange();';
				$script[] = '			}';
				$script[] = '			jMediaRefreshPreview(id);';
				$script[] = '		}';
				$script[] = '	}';
	
				$script[] = '	function jMediaRefreshPreview(id) {';
				$script[] = '		var value = document.id(id).value;';
				$script[] = '		var img = document.id(id + "_preview");';
				$script[] = '		if (img) {';
				$script[] = '			if (value) {';
				$script[] = '				img.src = "' . JUri::root() . '" + value;';
				$script[] = '				document.id(id + "_preview_empty").setStyle("display", "none");';
				$script[] = '				document.id(id + "_preview_img").setStyle("display", "");';
				$script[] = '			} else { ';
				$script[] = '				img.src = ""';
				$script[] = '				document.id(id + "_preview_empty").setStyle("display", "");';
				$script[] = '				document.id(id + "_preview_img").setStyle("display", "none");';
				$script[] = '			} ';
				$script[] = '		} ';
				$script[] = '	}';
	
				$script[] = '	function jMediaRefreshPreviewTip(tip)';
				$script[] = '	{';
				$script[] = '		var img = tip.getElement("img.media-preview");';
				$script[] = '		tip.getElement("div.tip").setStyle("max-width", "none");';
				$script[] = '		var id = img.getProperty("id");';
				$script[] = '		id = id.substring(0, id.length - "_preview".length);';
				$script[] = '		jMediaRefreshPreview(id);';
				$script[] = '		tip.setStyle("display", "block");';
				$script[] = '	}';
	
				// Add the script to the document head.
				JFactory::getDocument()->addScriptDeclaration(implode("\n", $script));
	
				self::$initialised = true;
			}
	
			$html = array();
			$attr = '';
	
			// Initialize some field attributes.
			$attr .= !empty($this->class) ? ' class="input-small ' . $this->class . '"' : ' class="input-small"';
			$attr .= !empty($this->size) ? ' size="' . $this->size . '"' : '';
	
			// Initialize JavaScript field attributes.
			$attr .= !empty($this->onchange) ? ' onchange="' . $this->onchange . '"' : '';
	
			// The text field.
			$html[] = '<div class="input-prepend input-append">';
	
			// The Preview.
			$showPreview = true;
			$showAsTooltip = false;
	
			switch ($this->preview)
			{
				case 'no': // Deprecated parameter value
				case 'false':
				case 'none':
					$showPreview = false;
					break;
	
				case 'yes': // Deprecated parameter value
				case 'true':
				case 'show':
					break;
	
				case 'tooltip':
				default:
					$showAsTooltip = true;
					$options = array(
						'onShow' => 'jMediaRefreshPreviewTip',
					);
					JHtml::_('behavior.tooltip', '.hasTipPreview', $options);
					break;
			}
	
			if ($showPreview)
			{
				if ($this->value && file_exists(JPATH_ROOT . '/' . $this->value))
				{
					$src = JUri::root() . $this->value;
				}
				else
				{
					$src = '';
				}
	
				$width = $this->previewWidth;
				$height = $this->previewHeight;
				$style = '';
				$style .= ($width > 0) ? 'max-width:' . $width . 'px;' : '';
				$style .= ($height > 0) ? 'max-height:' . $height . 'px;' : '';
	
				$imgattr = array(
					'id' => $this->id . '_preview',
					'class' => 'media-preview',
					'style' => $style,
				);
	
				$img = JHtml::image($src, JText::_('JLIB_FORM_MEDIA_PREVIEW_ALT'), $imgattr);
				$previewImg = '<div id="' . $this->id . '_preview_img"' . ($src ? '' : ' style="display:none"') . '>' . $img . '</div>';
				$previewImgEmpty = '<div id="' . $this->id . '_preview_empty"' . ($src ? ' style="display:none"' : '') . '>'
					. JText::_('JLIB_FORM_MEDIA_PREVIEW_EMPTY') . '</div>';
	
				if ($showAsTooltip)
				{
					$html[] = '<div class="media-preview add-on">';
					$tooltip = $previewImgEmpty . $previewImg;
					$options = array(
						'title' => JText::_('JLIB_FORM_MEDIA_PREVIEW_SELECTED_IMAGE'),
						'text' => '<i class="icon-eye"></i>',
						'class' => 'hasTipPreview'
					);
	
					$html[] = JHtml::tooltip($tooltip, $options);
					$html[] = '</div>';
				}
				else
				{
					$html[] = '<div class="media-preview add-on" style="height:auto">';
					$html[] = ' ' . $previewImgEmpty;
					$html[] = ' ' . $previewImg;
					$html[] = '</div>';
				}
			}
	
			$html[] = '	<input type="text" name="' . $this->name . '" id="' . $this->id . '" value="'
				. htmlspecialchars($this->value, ENT_COMPAT, 'UTF-8') . '" readonly="readonly"' . $attr . ' />';
	
			if ($this->value && file_exists(JPATH_ROOT . '/' . $this->value))
			{
				$folder = explode('/', $this->value);
				$folder = array_diff_assoc($folder, explode('/', JComponentHelper::getParams('com_media')->get('image_path', 'images')));
				array_pop($folder);
				$folder = implode('/', $folder);
			}
			elseif (file_exists(JPATH_ROOT . '/' . JComponentHelper::getParams('com_media')->get('image_path', 'images') . '/at_social_icons' . $this->directory))
			{
				$folder = 'at_social_icons' . $this->directory;
			}
			else
			{
				$folder = '';
			}
	
			// The button.
			if ($this->disabled != true)
			{
				//JHtml::_('bootstrap.tooltip');
	
				$html[] = '<a class="modal btn" title="' . JText::_('JLIB_FORM_BUTTON_SELECT') . '" href="'
					. ($this->readonly ? ''
					: ($this->link ? $this->link
						: 'index.php?option=com_media&amp;view=images&amp;tmpl=component&amp;asset=' . $asset . '&amp;author='
						. $this->form->getValue($this->authorField)) . '&amp;fieldid=' . $this->id . '&amp;folder=' . $folder) . '"'
					. ' rel="{handler: \'iframe\', size: {x: 800, y: 500}}">';
				$html[] = JText::_('JLIB_FORM_BUTTON_SELECT') . '</a><a class="btn hasTooltip" title="' . JText::_('JLIB_FORM_BUTTON_CLEAR') . '" href="#" onclick="';
				$html[] = 'jInsertFieldValue(\'\', \'' . $this->id . '\');';
				$html[] = 'return false;';
				$html[] = '">';
				$html[] = '<i class="icon-remove"></i></a>';
			}
	
			$html[] = '</div>';
	
			return implode("\n", $html);
		}
	}
}
elseif ($version->RELEASE == '2.5') {
	class JFormFieldsocialIconList extends JFormField
	{
		/**
		 * The form field type.
		 *
		 * @var    string
		 * @since  11.1
		 */
		protected $type = 'socialIconList';
	
		/**
		 * The initialised state of the document object.
		 *
		 * @var    boolean
		 * @since  11.1
		 */
		protected static $initialised = false;
	
		/**
		 * Method to get the field input markup for a media selector.
		 * Use attributes to identify specific created_by and asset_id fields
		 *
		 * @return  string  The field input markup.
		 *
		 * @since   11.1
		 */
		protected function getInput()
		{
			$assetField = $this->element['asset_field'] ? (string) $this->element['asset_field'] : 'asset_id';
			$authorField = $this->element['created_by_field'] ? (string) $this->element['created_by_field'] : 'created_by';
			$asset = $this->form->getValue($assetField) ? $this->form->getValue($assetField) : (string) $this->element['asset_id'];
			if ($asset == '')
			{
				$asset = JRequest::getCmd('option');
			}
	
			$link = (string) $this->element['link'];
			if (!self::$initialised)
			{
	
				// Load the modal behavior script.
				JHtml::_('behavior.modal');
	
				// Build the script.
				$script = array();
				$script[] = '	function jInsertFieldValue(value, id) {';
				$script[] = '		var old_value = document.id(id).value;';
				$script[] = '		if (old_value != value) {';
				$script[] = '			var elem = document.id(id);';
				$script[] = '			elem.value = value;';
				$script[] = '			elem.fireEvent("change");';
				$script[] = '			if (typeof(elem.onchange) === "function") {';
				$script[] = '				elem.onchange();';
				$script[] = '			}';
				$script[] = '			jMediaRefreshPreview(id);';
				$script[] = '		}';
				$script[] = '	}';
	
				$script[] = '	function jMediaRefreshPreview(id) {';
				$script[] = '		var value = document.id(id).value;';
				$script[] = '		var img = document.id(id + "_preview");';
				$script[] = '		if (img) {';
				$script[] = '			if (value) {';
				$script[] = '				img.src = "' . JURI::root() . '" + value;';
				$script[] = '				document.id(id + "_preview_empty").setStyle("display", "none");';
				$script[] = '				document.id(id + "_preview_img").setStyle("display", "");';
				$script[] = '			} else { ';
				$script[] = '				img.src = ""';
				$script[] = '				document.id(id + "_preview_empty").setStyle("display", "");';
				$script[] = '				document.id(id + "_preview_img").setStyle("display", "none");';
				$script[] = '			} ';
				$script[] = '		} ';
				$script[] = '	}';
	
				$script[] = '	function jMediaRefreshPreviewTip(tip)';
				$script[] = '	{';
				$script[] = '		tip.setStyle("display", "block");';
				$script[] = '		var img = tip.getElement("img.media-preview");';
				$script[] = '		var id = img.getProperty("id");';
				$script[] = '		id = id.substring(0, id.length - "_preview".length);';
				$script[] = '		jMediaRefreshPreview(id);';
				$script[] = '	}';
	
				// Add the script to the document head.
				JFactory::getDocument()->addScriptDeclaration(implode("\n", $script));
	
				self::$initialised = true;
			}
	
			// Initialize variables.
			$html = array();
			$attr = '';
	
			// Initialize some field attributes.
			$attr .= $this->element['class'] ? ' class="' . (string) $this->element['class'] . '"' : '';
			$attr .= $this->element['size'] ? ' size="' . (int) $this->element['size'] . '"' : '';
	
			// Initialize JavaScript field attributes.
			$attr .= $this->element['onchange'] ? ' onchange="' . (string) $this->element['onchange'] . '"' : '';
	
			// The text field.
			$html[] = '<div class="fltlft">';
			$html[] = '	<input type="text" name="' . $this->name . '" id="' . $this->id . '"' . ' value="'
				. htmlspecialchars($this->value, ENT_COMPAT, 'UTF-8') . '"' . ' readonly="readonly"' . $attr . ' />';
			$html[] = '</div>';
	
			$directory = (string) $this->element['directory'];
			if ($this->value && file_exists(JPATH_ROOT . '/' . $this->value))
			{
				$folder = explode('/', $this->value);
				array_shift($folder);
				array_pop($folder);
				$folder = implode('/', $folder);
			}
			elseif (file_exists(JPATH_ROOT . '/' . JComponentHelper::getParams('com_media')->get('image_path', 'images') . '/at_social_icons' . $this->directory))
			{
				$folder = 'at_social_icons' . $this->directory;
			}
			else
			{
				$folder = '';
			}
			// The button.
			$html[] = '<div class="button2-left">';
			$html[] = '	<div class="blank">';
			$html[] = '		<a class="modal" title="' . JText::_('JLIB_FORM_BUTTON_SELECT') . '"' . ' href="'
				. ($this->element['readonly'] ? ''
				: ($link ? $link
					: 'index.php?option=com_media&amp;view=images&amp;tmpl=component&amp;asset=' . $asset . '&amp;author='
					. $this->form->getValue($authorField)) . '&amp;fieldid=' . $this->id . '&amp;folder=' . $folder) . '"'
				. ' rel="{handler: \'iframe\', size: {x: 800, y: 500}}">';
			$html[] = JText::_('JLIB_FORM_BUTTON_SELECT') . '</a>';
			$html[] = '	</div>';
			$html[] = '</div>';
	
			$html[] = '<div class="button2-left">';
			$html[] = '	<div class="blank">';
			$html[] = '		<a title="' . JText::_('JLIB_FORM_BUTTON_CLEAR') . '"' . ' href="#" onclick="';
			$html[] = 'jInsertFieldValue(\'\', \'' . $this->id . '\');';
			$html[] = 'return false;';
			$html[] = '">';
			$html[] = JText::_('JLIB_FORM_BUTTON_CLEAR') . '</a>';
			$html[] = '	</div>';
			$html[] = '</div>';
	
			// The Preview.
			$preview = (string) $this->element['preview'];
			$showPreview = true;
			$showAsTooltip = false;
			switch ($preview)
			{
				case 'false':
				case 'none':
					$showPreview = false;
					break;
				case 'true':
				case 'show':
					break;
				case 'tooltip':
				default:
					$showAsTooltip = true;
					$options = array(
						'onShow' => 'jMediaRefreshPreviewTip',
					);
					JHtml::_('behavior.tooltip', '.hasTipPreview', $options);
					break;
			}
	
			if ($showPreview)
			{
				if ($this->value && file_exists(JPATH_ROOT . '/' . $this->value))
				{
					$src = JURI::root() . $this->value;
				}
				else
				{
					$src = '';
				}
	
				$attr = array(
					'id' => $this->id . '_preview',
					'class' => 'media-preview',
					'style' => 'max-width:160px; max-height:100px;'
				);
				$img = JHtml::image($src, JText::_('JLIB_FORM_MEDIA_PREVIEW_ALT'), $attr);
				$previewImg = '<div id="' . $this->id . '_preview_img"' . ($src ? '' : ' style="display:none"') . '>' . $img . '</div>';
				$previewImgEmpty = '<div id="' . $this->id . '_preview_empty"' . ($src ? ' style="display:none"' : '') . '>'
					. JText::_('JLIB_FORM_MEDIA_PREVIEW_EMPTY') . '</div>';
	
				$html[] = '<div class="media-preview fltlft">';
				if ($showAsTooltip)
				{
					$tooltip = $previewImgEmpty . $previewImg;
					$options = array(
						'title' => JText::_('JLIB_FORM_MEDIA_PREVIEW_SELECTED_IMAGE'),
						'text' => JText::_('JLIB_FORM_MEDIA_PREVIEW_TIP_TITLE'),
						'class' => 'hasTipPreview'
					);
					$html[] = JHtml::tooltip($tooltip, $options);
				}
				else
				{
					$html[] = ' ' . $previewImgEmpty;
					$html[] = ' ' . $previewImg;
				}
				$html[] = '</div>';
			}
	
			return implode("\n", $html);
		}
	}	
}