<!--{*
Created on: 2011-03-18 13:20:47 198
*}-->
<!--{* This page may be used for public / admin layouts. *} admin details -->
<div class="information">
	<ul class="links">
		<li><a href="identifiers-add.php"><img src="{'add'|icon}" title="Add Identifiers"
		                                       alt="Add Identifiers"/> Add Identifiers</a></li>
		<li><a href="identifiers-list.php"><img src="{'table'|icon}" title="List Identifiers"
		                                        alt="List Identifiers"/> List Identifiers</a></li>
	</ul>
</div>
<div class="clear"></div>
<!-- admmin details for identifiers -->
<div class="details">
	<div class="holder">
		<div class="title">Context</div>
		<div class="content">{$identifiers.identifier_context|default:'&nbsp;'}</div>
	</div>
	<div class="holder">
		<div class="title">Checkboxes</div>
		<div class="content">
			<pre>{chr(123)}html_checkboxes name=&quot;objects&quot; options=&quot;{$identifiers.identifier_code|default:'&nbsp;'}&quot;<strong>|dropdown</strong> selected=&quot;&quot;{chr(125)}</pre>
		</div>
	</div>
	<div class="holder">
		<div class="title">Options Only</div>
		<div class="content">
			<pre>{chr(123)}html_options options=&quot;{$identifiers.identifier_code|default:'&nbsp;'}&quot;<strong>|dropdown</strong> selected=&quot;&quot;{chr(125)}</pre>
		</div>
	</div>
	<div class="holder">
		<div class="title">Select/Option HTML</div>
		<div class="content">
			<pre>&lt;select name=&quot;&quot;&gt;<br/>&lt;option value=&quot;0&quot;&gt;-- choose --&lt;/option&gt;<br/>{chr(123)}html_options options=&quot;{$identifiers.identifier_code|default:'&nbsp;'}&quot;<strong>|dropdown</strong> selected=&quot;&quot;{chr(125)}<br/>&lt;/select&gt;</pre>
		</div>
	</div>
	<!--{*
	  <div class="holder">
		<div class="title">Name</div>
		<div class="content">{$identifiers.identifier_name|default:'&nbsp;'}</div>
	  </div>
	*}-->
	<div class="holder">
		<div class="title">Identifier SQL</div>
		<div class="content">{$identifiers.identifier_sql|pre}</div>
	</div>
	<div class="holder">
		<div class="title">Identifier Comments</div>
		<div class="content">{$identifiers.identifier_comments|default:'&nbsp;'}</div>
	</div>
</div>
<div class="clear"></div>
<div class="information">
	<ul class="links admin-editor">
		<li><a href="identifiers-edit.php?id={$identifiers.identifier_id}&amp;code={$identifiers.code}"><img
					src="{'edit'|icon}" title="Edit identifiers" alt="Edit identifiers"/> Edit this record</a></li>
	</ul>
</div>
<div class="clear"></div>
<!-- End of admin details of identifiers (Identifiers) -->