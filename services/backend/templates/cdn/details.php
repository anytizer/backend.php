<!-- Created on: 2010-11-15 13:36:42 243 -->
<!--{* This page may be used for public / admin layouts. *} admin details -->
<div class="information">
    <ul class="links">
        <li><a href="cdn-add.php"><img src="{'add'|icon}" title="Add cdn" alt="Add cdn"/> Add CDN </a></li>
        <li><a href="cdn-list.php"><img src="{'table'|icon}" title="List cdn" alt="List cdn"/> List CDN </a></li>
    </ul>
</div>
<div class="clear"><!--{*  style="clear:both;" *}--></div>
<!-- admmin details for cdn -->
<div class="details">
    <div class="holder">
        <div class="title">Name</div>
        <div class="content">{$cdn.cdn_name}</div>
    </div>
    <div class="holder">
        <div class="title">Mime</div>
        <div class="content">{$cdn.cdn_mime}</div>
    </div>
    <div class="holder">
        <div class="title">Local Link</div>
        <div class="content">{$cdn.cdn_local_link}</div>
    </div>
    <div class="holder">
        <div class="title">&nbsp;</div>
        <div class="content"><a href="{$cdn.cdn_local_link}">Browse/Test local link</a></div>
    </div>
    <div class="holder">
        <div class="title">Remote Link</div>
        <div class="content">{$cdn.cdn_remote_link}</div>
    </div>
    <div class="holder">
        <div class="title">&nbsp;</div>
        <div class="content"><a href="{$cdn.cdn_remote_link}">Browse/Test remote link</a></div>
    </div>
    <div class="holder">
        <div class="title">Comments</div>
        <div class="content">{$cdn.cdn_comments}</div>
    </div>
    <div class="holder">
        <div class="title">CDN Version</div>
        <div class="content">{$cdn.cdn_version}</div>
    </div>
</div>
<!-- End of cdn Details (Admin) -->