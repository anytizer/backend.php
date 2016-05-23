<?php
namespace common;

/**
 * Multi Level Categorisation
 */
class category
	extends \common\mysql
{
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Generates a breadcrumb around a category.
	 */
	public function breadcrumb($category_id = 0)
	{
		$parents = array();
		$category_id += 0;

		$depth = 0;
		$max_depth = 10;

		$category_sql = "
# List of parents in parent/child model
SELECT
	c.category_id ci,
	c.parent_id `pi`,
	c.category_name cn,
	'Y' node
FROM shop_categories c
WHERE
	c.category_id={$category_id}
	AND c.is_active = 'Y'
;";
		$category = $this->row($category_sql);
		#\common\stopper::debug($category, false);
		$parents[] = $category;
		while($category['pi'] != 0)
		{
			$category_sql = "
# List of children in parent/child model
SELECT
	c.category_id ci,
	c.parent_id `pi`,
	c.category_name cn,
	'N' node
FROM shop_categories c
WHERE
	c.category_id={$category['pi']}
	# AND c.is_active = 'Y'
;";
			$category = $this->row($category_sql);

			#\common\stopper::debug($category, false);
			#flush();

			if(!$category)
			{
				break;
			}
			if(++$depth > $max_depth)
			{
				break;
			}
			$parents[] = $category;
		}

		/*		# Add the link to home
				$parents[] = array(
					'ci' => 0,
					'pi' => 0,
					'cn' => 'Home',
					'node' => 'N',
				);*/

		#\common\stopper::debug($category, false);
		#$parents =
		#echo('-----------+++++++++++++++++----------------');
		#\common\stopper::debug($parents, false);
		krsort($parents);
		#\common\stopper::debug($parents, false);


		$links = array_map(array(&$this, 'html_links'), $parents);
		#\common\stopper::debug($links, false);

		# Link to home page
		echo "<a href='index.php'>Home</a> &raquo; ";

		# Links to ther pages
		echo(implode(' &raquo; ', $links));
	}

	/**
	 * Particularly used to make a link around a category name.
	 */
	private function html_links($category = array())
	{
		if($category['node'] != 'Y')
		{
			$link = "<a href='category.php?ci={$category['ci']}'>{$category['cn']}</a>";
		}
		else
		{
			# No Links in the node
			$link = $category['cn'];
		}

		return $link;
	}

	function drop_down($category_id = 0)
	{
		$category_id += 0;
		$category_sql = "
# List of parents in parent/child model
SELECT
	c.category_id ci,
	c.parent_id `pi`,
	c.category_name cn,
	'Y' node
FROM shop_categories c
WHERE
	c.category_id={$category_id}
	AND c.is_active = 'Y'
;";
		$category = $this->row($category_sql);
	}

	function list_count()
	{
		$sql = "
SELECT
	c.cat_id,
	c.cat_name cn, c.cat_description cd,
	COUNT(i.image_id) total
FROM images i
INNER JOIN __categories c ON
	c.cat_id = i.cat_id
GROUP BY
	c.cat_id
;";
		$this->query($sql);

		return $this->to_array();
	}
}

