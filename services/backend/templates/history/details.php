<!--{*
Created on: 2010-12-27 11:38:12 391
*}-->
<!--{* This page may be used for public / admin layouts. *} admin details -->
<div class="information">
    <ul class="links">
        <li><a href="history-add.php"><img src="{'add'|icon}" title="Add history" alt="Add history"/> Add history</a>
        </li>
        <li><a href="history-list.php"><img src="{'table'|icon}" title="List history" alt="List history"/> List history</a>
        </li>
    </ul>
</div>
<div class="clear"></div>
<!-- admmin details for history -->
<div class="details">
    <div class="holder">
        <div class="title">History Title</div>
        <div class="content">{$history.history_title|default:'&nbsp;'}</div>
    </div>
    <div class="holder">
        <div class="title">History Text</div>
        <div class="content">{$history.history_text|default:'&nbsp;'}</div>
    </div>
</div>
<div class="clear"></div>
<div class="information">
    <ul class="links admin-editor">
        <li><a href="history-edit.php?id={$history.history_id}&amp;code={$history.code}"><img src="{'edit'|icon}"
                                                                                              title="Edit history"
                                                                                              alt="Edit history"/> Edit
                this record</a>
        </li>
    </ul>
</div>
<div class="clear"></div>
<!-- End of history Details (Admin) -->