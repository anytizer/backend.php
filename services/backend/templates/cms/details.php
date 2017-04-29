<!--{*
Created on: 2011-02-09 23:32:47 349
*}-->
<!--{* This page may be used for public / admin layouts. *} admin details -->
<div class="information">
    <ul class="links">
        <li><a href="cms-add.php"><img src="{'add'|icon}" title="Add CMS" alt="Add CMS"/> Add CMS</a></li>
        <li><a href="cms-list.php"><img src="{'table'|icon}" title="List CMS" alt="List CMS"/> List CMS</a></li>
    </ul>
</div>
<div class="clear"></div>
<!-- admmin details for cms -->
<div class="details">
    <div class="holder">
        <div class="title">Page Name</div>
        <div class="content">{$cms.page_name|default:'&nbsp;'}</div>
    </div>
    <div class="holder">
        <div class="title">Page Title</div>
        <div class="content">{$cms.page_title|default:'&nbsp;'}</div>
    </div>
    <div class="holder">
        <div class="title">Include File</div>
        <div class="content">{$cms.include_file|default:'&nbsp;'}</div>
    </div>
    <div class="holder">
        <div class="title">Content Title</div>
        <div class="content">{$cms.content_title|default:'&nbsp;'}</div>
    </div>
    <div class="holder">
        <div class="title">Content Text</div>
        <div class="content">{$cms.content_text|default:'&nbsp;'}</div>
    </div>
    <div class="holder">
        <div class="title">Meta Keywords</div>
        <div class="content">{$cms.meta_keywords|default:'&nbsp;'}</div>
    </div>
    <div class="holder">
        <div class="title">Meta Description</div>
        <div class="content">{$cms.meta_description|default:'&nbsp;'}</div>
    </div>
    <div class="holder">
        <div class="title">Template File</div>
        <div class="content">{$cms.template_file|default:'&nbsp;'}</div>
    </div>
    <div class="holder">
        <div class="title">Page Comments</div>
        <div class="content">{$cms.page_comments|default:'&nbsp;'}</div>
    </div>
    <div class="holder">
        <div class="title">Page Extra</div>
        <div class="content">{$cms.page_extra|default:'&nbsp;'}</div>
    </div>
</div>
<div class="clear"></div>
<div class="information">
    <ul class="links admin-editor">
        <li><a href="cms-edit.php?id={$cms.page_id}&amp;code={$cms.code}"><img src="{'edit'|icon}" title="Edit cms"
                                                                               alt="Edit cms"/> Edit this record</a>
        </li>
    </ul>
</div>
<div class="clear"></div>
<!-- End of admin details of cms (CMS) -->