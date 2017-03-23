<!--{*
Created on: 2010-12-14 00:48:38 194
*}-->
<!--{* This page may be used for public / admin layouts. *} admin details -->
<div class="information">
    <ul class="links">
        <li><a href="downloads-add.php"><img src="{'add'|icon}" title="Add downloads"
                                             alt="Add downloads"/> Add downloads</a></li>
        <li><a href="downloads-list.php"><img src="{'table'|icon}" title="List downloads"
                                              alt="List downloads"/> List downloads</a></li>
    </ul>
</div>
<div class="clear"></div>
<!-- admmin details for downloads -->
<div class="details">
    <div class="holder">
        <div class="title">File Size</div>
        <div class="content">{$downloads.file_size}</div>
    </div>
    <div class="holder">
        <div class="title">Stats Comments</div>
        <div class="content">{$downloads.stats_comments}</div>
    </div>
    <div class="holder">
        <div class="title">Stats HTML</div>
        <div class="content">{$downloads.stats_html}</div>
    </div>
    <div class="holder">
        <div class="title">Stats Php</div>
        <div class="content">{$downloads.stats_php}</div>
    </div>
    <div class="holder">
        <div class="title">Stats Js</div>
        <div class="content">{$downloads.stats_js}</div>
    </div>
    <div class="holder">
        <div class="title">Stats Css</div>
        <div class="content">{$downloads.stats_css}</div>
    </div>
    <div class="holder">
        <div class="title">Stats Images</div>
        <div class="content">{$downloads.stats_images}</div>
    </div>
    <div class="holder">
        <div class="title">Stats Text</div>
        <div class="content">{$downloads.stats_text}</div>
    </div>
    <div class="holder">
        <div class="title">Stats Templates</div>
        <div class="content">{$downloads.stats_templates}</div>
    </div>
    <div class="holder">
        <div class="title">Stats Scripts</div>
        <div class="content">{$downloads.stats_scripts}</div>
    </div>
    <div class="holder">
        <div class="title">Show Links</div>
        <div class="content">{$downloads.show_links}</div>
    </div>
    <div class="holder">
        <div class="title">Show Samples</div>
        <div class="content">{$downloads.show_samples}</div>
    </div>
    <div class="holder">
        <div class="title">Distribution Link</div>
        <div class="content">{$downloads.distribution_link}</div>
    </div>
    <div class="holder">
        <div class="title">Distribution Title</div>
        <div class="content">{$downloads.distribution_title}</div>
    </div>
    <div class="holder">
        <div class="title">Distribution Text</div>
        <div class="content">{$downloads.distribution_text}</div>
    </div>
</div>
<div class="clear"></div>
<div class="information">
    <ul class="links admin-editor">
        <li><a href="downloads-edit.php?id={$downloads.distribution_id}&amp;code={$downloads.code}"><img
                    src="{'edit'|icon}" title="Edit downloads" alt="Edit downloads"/> Edit this record</a></li>
    </ul>
</div>
<div class="clear"></div>
<!-- End of downloads Details (Admin) -->