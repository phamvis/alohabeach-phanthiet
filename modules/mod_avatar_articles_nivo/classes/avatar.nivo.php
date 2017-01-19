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
if(class_exists('avatar_nivo') != true)
{
	class avatar_nivo
	{
		public static function getslices($params){return $params->get('slices');}
		public static function getboxRows($params){return $params->get('boxRows');}
		public static function getanimSpeed($params){return $params->get('animSpeed');}
		public static function gettheme($params){return $params->get('theme');}
		public static function getcontrolNav($params){return $params->get('controlNav');}
		public static function getrandomStart($params){return $params->get('randomStart');}
		public static function gettitleColor($params){return $params->get('titleColor');}
		public static function getintroColor($params){return $params->get('introColor');}
		public static function getAutoPlay($params){return $params->get('autoPlay');}	
		public static function getSlideTime($params)
		{
				return $params->get('slideTime');
		}
		//get effect of transition
		public static function getTransition($params)
		{
				return $params->get('transition',array('fade'));
		}
	}
}
?>