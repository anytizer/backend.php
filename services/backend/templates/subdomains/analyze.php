<table class="data">
	<thead>
	<tr>
		<th align="left">S. N.</th>
		<th align="left">Types of files</th>
		<th>Files Counter</th>
		<th>Files Size</th>
	</tr>
	</thead>
	<tbody>
	{assign var='total_files' value=0} {foreach name='analyzer' key='what' item='value' from=$sizes}
	<tr class="{cycle values='A,B'}">
		<td class="r">{counter name='index'}.</td>
		<td>{'/[^a-z]+/i'|preg_replace:' ':$what|strtoupper}</td>
		<td class="r">{$counters.$what} {'file'|plural:$counters.$what}</td>
		<td class="r">{$value|byte_format}</td>
	</tr>
	{assign var='total_files' value=$total_files+$counters.$what} {/foreach}
	<thead>
	<tr>
		<th>&nbsp;</th>
		<th>Total</th>
		<th>{$total_files} {'file'|plural:$total_files}</th>
		<th>{$total|byte_format}</th>
	</tr>
	</thead>
	</tbody>
</table>
<h3>Realtime report</h3>
<p>Total of <strong>{$total_files}</strong> {'file'|plural:$total_files}of size
	<strong>{$total|byte_format}</strong> in the subdomain:
	<strong>{$subdomain_id|table:'query_subdomains':'subdomain_name':'subdomain_id'}</strong>.</p>
