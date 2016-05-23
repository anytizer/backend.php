<?php
#namespace plugins;

/**
 * Put an icon for various use.
 * Use <img> tags as well, when necessary.
 */
function smarty_function_icon($params = array(), &$smarty)
{
	# What icon to show as default icon?
	# Replace with valid HTML/IMG tags.
	$icon = 'X';

	$params['name'] = isset($params['name']) ? preg_replace('/[^a-z]+/', '', $params['name']) : 'list';

	# Additional XHTML parameters useful in user interaction
	$params['alt'] = htmlentities(isset($params['alt']) ? $params['alt'] : $params['name']);
	$params['title'] = htmlentities(isset($params['title']) ? $params['title'] : ucwords($params['name']));
	# Think of case when alt/title should not be used anymore in the XHTML Output.
	# Send blank alt/title here, to make it blank.

	# Thoughts:
	# Every case block has a full XHTML, because: each block can be separate: icon, or text link.
	# Dimensions of images are not used here. Rather control them from CSS.

	switch(strtolower($params['name']))
	{
		case 'a':
		case 'add': # A
			$src = 'images/selected-icons/add.png';
			break;
		case 'e':
		case 'edit': # E
			$src = 'images/selected-icons/edit.png';
			break;
		case 'd':
		case 'x':
		case 'delete': # X
			$src = 'images/selected-icons/delete.png';
			break;
		case 'l':
		case 'list': # L
			$src = 'images/selected-icons/table.png';
			break;
		case 's':
		case 'system': # S
			# Is this entry a system icon?
			$src = 'images/selected-icons/system.png';
			break;
		case 'u':
		case 'up': # Move upwards
			$src = 'images/arrows/up.png';
			break;
		case 'd':
		case 'down': # Move downwards
			$src = 'images/arrows/down.png';
			break;
		case 'tick':
		case 'right':
		case 'yes':
			$src = 'images/selected-icons/tick.png';
			break;
		case 'cross':
		case 'wrong':
		case 'no':
			$src = 'images/selected-icons/cross.png';
			break;
		default:
			# Try to find if the image exists
			$img_src = __APP_PATH__ . "/images/selected-icons/{$params['name']}.png";
			if(file_exists($img_src))
			{
				$src = "images/selected-icons/{$params['name']}.png";
			}
			else
			{
				# Use the default icon. Possibly, a WHAT icon or HELP.
				$src = 'images/selected-icons/help.png';
			}
	}

	$icon = "<img src=\"{$src}\" alt=\"{$params['alt']}\" title=\"{$params['title']}\" class=\"icon-{$params['name']}\" />";

	return $icon;
}
