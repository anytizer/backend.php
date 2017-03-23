<h3><a></a>Professional Support (Paid Services)</h3>
<p><strong>For Professional Support and customization</strong>: This application is a framework only - and is very good
    for custom projects (that needed to be built from the scratch). So, you may think of supporting us by hiring there.
</p>
<p>Core Part of our framework is always in open source, while your project's main file will be never exposed out. You
    are working with trusted staff, and for reliable technical support.</p>
<h3><a></a>Tested Applications (Types) on this framework</h3>
<ul>
    <li>Non-Membership websites (Membership is not a part of core development)</li>
    <li>Finance/Budget Planning website</li>
    <li>E-Commerce back-end application (Data Editor)</li>
    <li>JavaScript based Syndication (Links Publisher)</li>
    <li>Email forwarding Applications</li>
    <li>Link directories</li>
    <li>Personal websites</li>
    <li>Music tagging and selling websites</li>
    <li>Crawlers</li>
    <li>Portfolio management sites</li>
    <li>Syndicated links distribution</li>
</ul>
<h3><a></a>Proof of Concept</h3>
<p>Now, you can write your own module, without affecting the core system we develop. Hence, it can increase your
    creativity.
    <a href="http://bimal.org.np/">See more in google codes</a>.</p>
<h3><a></a>Backend / Frontend</h3>
<p>We have almost lost the concepts of backend for our projects, and this framework supports making a frondend look like
    its backend. Here is a code sample on how to list out the database entities, like menus:</p>
<pre class="prettyprint">$menus = new \subdomain\menus();
$entries = $menus-&gt;list_entries(array());

$smarty-&gt;assignByRef('menuss', $entries);</pre>
<p>And, this handles the deletion:</p>
<pre class="prettyprint">if(($menus_id = $variable-&gt;get('id', 'integer', 0)) &amp;&amp; ($code = $variable-&gt;get('code', 'string', "")))
{
	$menus = new \subdomain\menus();
	if($menus-&gt;delete($menus_id, $code))
	{
		\common\stopper::url('menus-delete-successful.php');
	}
	else
	{
		\common\stopper::url('menus-delete-error.php');
	}
}
else
{
	\common\stopper::url('menus-direct-access-error.php');
}</pre>
<p>
    <strong>Forget the coding</strong>, you do not have to remember or rewrite it anymore. This framework allows you to
    bring the security, auto generated codes, and error/success messages.
</p>
<h3><a></a>We use Object Oriented MVC Pattern</h3>
<p>For an operation there are three different files: a model (the heart), a controller that interacts with user
    commands, and the view (Based on Smarty) to show up the results. In total there are 12 different files for
    add/delete actions, and all of them are automated, to speed up your work. Take an example:</p>
<pre class="prettyprint">entity-add.php : Helps to add an entity
entity-add-successful.php : The entity was successfully added.
enity-add-error.php : Error adding an entity (ID/FK failed, or code failed)
entity-details.php : Details a particular entity
entity-delete.php : Management: Removes an entity by inactivating it
entity-delete-successful.php : Entity is deleted successfully.
entity-delete-error.php : Error deleting an entity due to code/is_active column/non-existent entity)
enity-direct-access-error.php : Can not list, edit, details without sufficient parameters
entity-edit.php : Management: Gives a form to enter details of an entity
enity-edit-successful.php : Entity edited successfully.
enity-edit-error.php : Error editing an entity (Non existent, Code failed, or FK error)
entity-list.php : Lists out entities</pre>
<p><strong>Fully automated!</strong> Fully object oriented, and in MVC pattern with Smarty. What else would you expect?
</p>