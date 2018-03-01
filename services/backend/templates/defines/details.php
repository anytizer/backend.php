<!-- Created on: 2010-06-16 21:19:04 969 -->
<!--{* This page may be used for public / admin layouts. *} admin details -->
<div class="information">
    <ul>
        <li><a href="defines-add.php"><img src="{'add'|icon}"/> Add defines</a></li>
        <li><a href="defines-list.php"><img src="{'table'|icon}"/> List defines</a></li>
    </ul>
</div>
<!-- admmin details for defines -->
<div class="details">
    <div><strong>Define Id</strong>: {$defines.define_id}</div>
    <div><strong>sub-domain Id</strong>: {$defines.subdomain_id}</div>
    <div><strong>Is Active</strong>: {$defines.is_active}</div>
    <div><strong>Define Context</strong>: {$defines.define_context}</div>
    <div><strong>Define Name</strong>: {$defines.define_name}</div>
    <div><strong>Define Value</strong>: {$defines.define_value}</div>
    <div><strong>Define Sample</strong>: {$defines.define_sample}</div>
    <div><strong>Define Handler</strong>: {$defines.define_handler}</div>
    <div><strong>Define Comments</strong>: {$defines.define_comments}</div>
</div>
<!-- End of defines Details (Admin) -->