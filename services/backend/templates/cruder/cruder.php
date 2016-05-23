<form autocomplete="off" id="cruder-form" name="cruder-form" method="post" action="?">
	<table class="data edit">
		<tr class="{cycle values='A,B'}" style="background-color:#FF0000;">
			<td class="attribute">Full Name:</td>
			<td><input type="text" name="entity[__ENTITY_FULLNAME__]" value="" class="input"/> <span
					style="color:#FFFFFF; font-weight:bold;">Readable name of this entity, eg. News</span></td>
		</tr>
		<tr class="{cycle values='A,B'}">
			<td class="attribute">Write to <em>sub</em>domain:</td>
			<td><select name="entity[subdomain_id]">
					<option value="">--Choose a subdomain--</option>
					<!-- system:services, system:subdomains_available, system:subdomains_available:visible -->    {html_options options='system:services'|dropdown}
				</select> For which subdomain?
			</td>
		</tr>
		<tr class="{cycle values='A,B'}">
			<td class="attribute">Entity Name (PHP Class):</td>
			<td><input type="text" name="entity[name]" value="" class="input" id="entity-name"/> eg.
				<strong>news </strong>(Plural, and without an underscore, lower-cased)
			</td>
		</tr>
		<tr class="{cycle values='A,B'}">
			<td class="attribute">Reversed Letters:</td>
			<td><input type="text" name="entity[reverse]" value="" class="input" id="reverse-captcha"/>
				<strong>swen</strong> - the reverse of <em>news</em> | As captcha
			</td>
		</tr>
		<tr class="{cycle values='A,B'}">
			<td class="attribute">Table Name:</td>
			<td><input type="text" name="entity[table_name]" value="" class="input"/> eg. <strong>prefix_news</strong>
			</td>
		</tr>
		<tr class="{cycle values='A,B'}">
			<td class="attribute">PK Name:</td>
			<td><input type="text" name="entity[pk_name]" value="" class="input"/> eg. <strong>news_id</strong></td>
		</tr>
		<tr class="{cycle values='A,B'}">
			<td class="attribute">Sort Data?</td>
			<td>
				<label><input name="sort" type="radio" value="N0" checked="checked"
				              class="radio"/> Sorting is not required.</label> <label><input name="sort" type="radio"
				                                                                             value="YES"
				                                                                             class="radio"/> Sorting is urgent.</label>
			</td>
		</tr>
		<tr class="{cycle values='A,B'}">
			<td class="attribute">Produce Physical Files?</td>
			<td>
				<label><input name="produce-files" type="radio" value="N0" checked="checked"
				              class="radio"/> No, just a preview.</label> <label><input name="produce-files"
				                                                                        type="radio" value="YES"
				                                                                        class="radio"/> Yes. Write the files.</label>
			</td>
		</tr>
		<tr class="{cycle values='A,B'}">
			<td class="attribute">&nbsp;</td>
			<td>
				<input type="submit" name="entity-add" value="CRUD Now!" class="submit"/> <strong
					style="color:#FF0000;">This is a permanent action! Be careful.</strong></td>
		</tr>
	</table>
</form>
<p>* This is the framework's ROOT, and not a real physical location. Base is always calculated per subdomain.</p>
<p>You MUST type the entity name correctly, and
	<strong>reverse type</strong> it for security reasons that - you are doing it purposefully. Upon successful completion, it will create some files and an .sql file to fire on the server. This file will register all of the CRUDed files. Dependencies of subdomain_id is solved automatically.
</p>
<script type="text/javascript" src="js/validator/gen_validatorv31.js"></script>
<script type="text/javascript" src="js/validators/cruder.js"></script>