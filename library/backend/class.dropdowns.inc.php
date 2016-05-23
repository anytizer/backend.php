<?php
namespace backend;

/**
 *
 */
class dropdowns
	extends \common\mysql
{
	private $table_name;
	private $pk_column;
	private $parent_column;
	private $name_column;

	private $depth = 5; # Avoid too much of recursion

	public function __construct(
		$table_name = 'links_categories',
		$pk_column = 'category_id',
		$parent_column = 'parent_id',
		$name_column = 'category_name'
	) {
		$this->table_name = $table_name;
		$this->pk_column = $pk_column;
		$this->parent_column = $parent_column;
		$this->name_column = $name_column;

		parent::__construct();
	}

	# Loads HTML
	private function load($parent_id = 0, $level = 0)
	{
		# Avoid too much recursion
		if($level > $this->depth)
		{
			return '';
		}

		$html = '';
		$parent_id = (int)$parent_id;
		$load_sql = "
SELECT
	c.`{$this->pk_column}` id,
	c.`{$this->name_column}` `name`
FROM  `{$this->table_name}` c
WHERE
	c.`{$this->parent_column}`={$parent_id}
	AND c.`{$this->pk_column}` != 0 # Urgent
	AND c.is_active='Y'
ORDER BY
	c.`{$this->name_column}`
;";
		#die($load_sql);
		if($parents = $this->arrays($load_sql))
		{
			$spacer = str_repeat('&nbsp; ', $level);
			foreach($parents as $p => $parent)
			{
				#echo $level;
				#print_r($parent);
				$html .= "<option value='{$parent['id']}'>{$spacer}{$parent['name']}</option>";

				# Recursively apply the children's htmls
				$html .= $this->load($parent['id'], $level + 1);
			}
		}

		return $html;
	}

	# Loads Array
	private function load_array($parent_id = 0, $level = 0)
	{
		# Avoid too much recursion
		if($level > $this->depth)
		{
			return null;
		} # array();

		$html = array();
		$parent_id = (int)$parent_id;
		$load_sql = "
SELECT
	c.`{$this->pk_column}` id,
	c.`{$this->name_column}` `name`
FROM  `{$this->table_name}` c
WHERE
	c.`{$this->parent_column}`={$parent_id}
	AND c.`{$this->pk_column}` != 0 # Urgent to avoid recursion
	AND c.is_active='Y'
ORDER BY
	c.`{$this->name_column}`
;";
		#die($load_sql);
		if($parents = $this->arrays($load_sql))
		{
			$spacer = str_repeat('- - - - ', $level);
			foreach($parents as $p => $parent)
			{
				#echo $level;
				#print_r($parent);
				$html[$parent['id']] = "{$spacer}{$parent['name']}";

				/*				# Recurse here
								$children = $this->load_array($parent['id'], $level+1);
								#print_r($children); die();
								if(count($children))
								{
									foreach($children as $c => $child)
									{
										$html[$child['id']] = "---{$spacer}{$child['name']}";
									}
								}
								#print_r($children);
								#die();*/

				# Recursively apply the children's htmls
				#$html = array_merge($html, $this->load_array($parent['id'], $level+1));
				$html = $html + $this->load_array($parent['id'], $level + 1);
			}
		}

		return $html;
	}

	# Builds HTML
	public function build($parent_id = 0, $depth = 3)
	{
		$this->depth = (int)$depth;

		$records = array();
		$html = $this->load($parent_id, 0);

		return $html;
	}

	# Builds Array
	public function build_array($parent_id = 0, $depth = 3)
	{
		$this->depth = (int)$depth;

		$records = array();
		$html = $this->load_array($parent_id, 0);

		return $html;
	}


	/**
	 * Generates a bradcrumb around a paret/category.
	 * Navigates to the parent from the child.
	 * Adds a link to index page
	 */
	public function breadcrumb($parent_id = 0)
	{
		$parent_id = (int)$parent_id;
		$parents = array();

		$depth = 0;
		$max_depth = 5;

		$category_sql = "
# List of parents in parent/child model
SELECT
	c.`{$this->parent_column}` `pi`,
	c.`{$this->pk_column}` id,
	c.`{$this->name_column}` `name`
FROM  `{$this->table_name}` c
WHERE
	c.`{$this->pk_column}`={$parent_id}
	AND c.is_active='Y'
;";
		#die($category_sql);
		$child = $this->row($category_sql);
		#print_r($child);
		$parents[] = $child;
		while(isset($child['pi']) && $child['pi'] != 0)
		{
			$category_sql = "
# List of children in parent/child model
SELECT
	c.`{$this->parent_column}` `pi`,
	c.`{$this->pk_column}` id,
	c.`{$this->name_column}` `name`
FROM  `{$this->table_name}` c
WHERE
	c.`{$this->pk_column}`={$child['pi']}
	AND c.is_active = 'Y'
;";
			$child = $this->row($category_sql);

			if(!$child)
			{
				break;
			}
			if(++$depth > $max_depth)
			{
				break;
			}
			$parents[] = $child;
		}

		# Finally, add a link to home
		$parents[] = array(
			'pi' => 0,
			'id' => 0,
			'name' => 'Home',
		);

		krsort($parents);

		return $parents;
	}
}

