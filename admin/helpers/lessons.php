<?php
/**
 * @package     Courses
 * @subpackage  com_courses
 *
 * @author      Bruno Batista <bruno@atomtech.com.br>
 * @copyright   Copyright (C) 2014 AtomTech, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access.
defined('_JEXEC') or die;

/**
 * Lessons helper.
 *
 * @package     Courses
 * @subpackage  com_courses
 * @author      Bruno Batista <bruno@atomtech.com.br>
 * @since       3.2
 */
class LessonsHelper
{
	/**
	 * Gets a list of the actions that can be performed.
	 *
	 * @param   integer  $id         The item ID.
	 * @param   string   $assetName  The asset name.
	 *
	 * @return  JObject  A JObject containing the allowed actions.
	 *
	 * @since   3.2
	 */
	public static function getActions($id = 0, $assetName = '')
	{
		// Initialiase variables.
		$user   = JFactory::getUser();
		$result = new JObject;
		$path   = JPATH_ADMINISTRATOR . '/components/' . $assetName . '/access.xml';

		if (empty($id))
		{
			$section = 'component';
		}
		else
		{
			$section = 'lesson';
			$assetName .= '.lesson.' . (int) $id;
		}

		$actions = JAccess::getActionsFromFile($path, "/access/section[@name='" . $section . "']/");

		foreach ($actions as $action)
		{
			$result->set($action->name, $user->authorise($action->name, $assetName));
		}

		return $result;
	}
}
