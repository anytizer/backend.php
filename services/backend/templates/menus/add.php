<div id="place-holder-menus">
	<strong>Placeholder</strong>: &quot;Here you will see menus used under a context&quot;. Please click on the context word to load the menus.
</div>
<table cellpadding="5">
	<tr>
		<td height="266">
			<form id="menus-add-form" name="menus-add-form" method="post" action="menus-add.php">
				<table class="data">
					<tr>
						<td class="attribute">Context:</td>
						<td><p>
								<input type="text" class="input" name="menus[menu_context]" value=""/>
							</p>

							<p>New/Choose from list</p></td>
					</tr>
					<tr>
						<td class="attribute">Menu&nbsp;Text:</td>
						<td><p>
								<input type="text" class="input" name="menus[menu_text]" value=""/>
							</p>

							<p>Readable content </p></td>
					</tr>
					<tr>
						<td class="attribute">Links to:</td>
						<td><p>
								<input type="text" class="input" name="menus[menu_link]" value=""/>
							</p>

							<p>Relative/Absolute link</p></td>
					</tr>
					<tr>
						<td class="attribute">&nbsp;</td>
						<td><input type="hidden" name="add-action" value="Add menus"/> <input type="submit"
						                                                                      name="submit-button"
						                                                                      class="submit"
						                                                                      value="Add"/> or <a
								href="menus-list.php">Cancel</a></td>
					</tr>
				</table>
			</form>
			<p>If you added wrong context, <br/> your menu will show <strong>no-where</strong>.</p></td>
		<td>{include file='menus/inc.contexts.php'}</td>
	</tr>
</table>
{* Add validation *}
{js src='ajax.js' validator=true}
{js src='validator/gen_validatorv31.js'}
{js src='validators/menus/add.js'}