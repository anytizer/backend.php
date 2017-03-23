<?php


# Sanitized name of the CRUDed entity. (Though Not Necessary)
$entity = $variable->post('entity', 'array', array()); # User input - Full Details

# Reverse typed name
$entity_reverse = \common\tools::sanitize($variable->read($entity, 'reverse', 'string', ""));

# Clean ENTITY Name
#$entity_name = \common\tools::sanitize($variable->read($entity, 'name', 'string', ""));
# Warning: Do not accept underscores! It might interfere with Smarty variable creation.
$entity_name = preg_replace('/[^a-z0-9]+/i', "", $variable->read($entity, 'name', 'string', ""));
$subdomain_id = \common\tools::sanitize($variable->read($entity, 'subdomain_id', 'integer', 0));

# Boolean decision: to produce files or not
$produce_files = ('YES' == $variable->post('produce-files', 'string', 'N'));


$cruder = new \subdomain\cruder();

# Matched reverse print makes sure that it is a purposeful request.
if($variable->post('entity-add', 'string', "") && $entity_name == strrev($entity_reverse) && $entity_name != "")
{
	/**
	 * Do not allow to write these entities.
	 */
	$protected_names = array(
		'config',
		'configs',
		'class',
		#'classes',
		'css',
		'developers',
		'directory',
		'framework',
		'js',
		'images',
		'index',
		'login',
		'logout',
		'management',
		'new',
		'null',
		'plugins',
		'sqls',
		'templates',
		'validators',

		# Also from PHP keywords list
		# http://php.net/manual/en/reserved.keywords.php
		'abstract',
		'and',
		'array',
		'as',
		'break',
		'case',
		'catch',
		'cfunction',
		'class',
		'clone',
		'const',
		'continue',
		'declare',
		'default',
		'do',
		'else',
		'elseif',
		'enddeclare',
		'endfor',
		'endforeach',
		'endif',
		'endswitch',
		'endwhile',
		'extends',
		'final',
		'for',
		'foreach',
		'function',
		'global',
		'goto',
		'if',
		'implements',
		'interface',
		'instanceof',
		'namespace',
		'new',
		'old_function',
		'or',
		'private',
		'protected',
		'public',
		'static',
		'switch',
		'throw',
		'try',
		'use',
		'var',
		'while',
		'xor',
	);
	# also, add the ones in query_crded table

	if(in_array(strtolower($entity_name), $protected_names))
	{
		\common\stopper::message('Your entity name is protected. Choose a different name.');
	}

	# Check that the entity class does not exist by default.
	# Do not check it now at the moment. Reason: It will hit the auto include SPL and fail.
	#if(class_exists($entity_name))
	{
		#\common\stopper::message('The entity name you are trying to create probably exists already.');
	}

	/**
	 * Check the existance of a table name first. Do not allow to CRUD on non existing tables.
	 */
	$table_name = !empty($_POST['entity']['table_name']) ? $_POST['entity']['table_name'] : "";
	if(!$table_name)
	{
		\common\stopper::message('Table name is missing.');
	}
	$table_existance_sql = "SHOW TABLES LIKE '{$table_name}';";
	$existing = $cruder->row($table_existance_sql);
	if(count($existing) != 1)
	{
		\common\stopper::message("Table name does not exist: <strong>{$table_name}</strong>");
	}

	/**
	 * @todo check if the primary key is valid in the table name.
	 */

	$cruder->read_file('header.html');

	# False: Does NOT write a file
	# True: Writes a file

	# Force the entity's full name. If not use the short code as the name.
	$__ENTITY_FULLNAME__ = !empty($_POST['entity']['__ENTITY_FULLNAME__']) ? $_POST['entity']['__ENTITY_FULLNAME__'] : $entity_name;

	if($cruder->generate_codes($subdomain_id, $entity_name, $__ENTITY_FULLNAME__, $produce_files))
	{
		$cruder->save_records($entity);
		#\common\stopper::url('cruder-successful.php');
	}
	else
	{
		#\common\stopper::url('cruder-failed.php');
	}

	$cruder->read_file('footer.html');

	# Controller should NOT go beyond here.
	\common\stopper::message(' <!-- Completed writing a CRUDer --> ', false);
}
