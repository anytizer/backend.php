<!--{*
Created on: 2011-02-10 00:27:11 536
*}-->
<!--{* This page may be used for public / admin layouts. *} admin details -->
<div class="information">
    <ul class="links">
        <li><a href="subdomains-add.php"><img src="{'add'|icon}" title="Add subdomains"
                                              alt="Add subdomains"/> Add subdomains</a></li>
        <li>| <a href="subdomains-list.php"><img src="{'table'|icon}" title="List subdomains"
                                                 alt="List subdomains"/> List subdomains</a></li>
        <li>| <a href="subdomains-change-id.php?id={$subdomains.subdomain_id}"><img src="{'edit'|icon}"
                                                                                    title="sub-domain ID"
                                                                                    alt="sub-domain ID"/> Change ID</a>
        </li>
        <li>| <a href="subdomains-clone.php?id={$subdomains.subdomain_id}"><img src="{'in'|icon}" title="Clone"
                                                                                alt="Clone"/> Clone</a></li>
        <li>| <a href="subdomains-merge.php?id={$subdomains.subdomain_id}"><img src="{'in'|icon}" title="Clone"
                                                                                alt="Clone"/> Merge</a></li>
        <li>| <a href="history-list.php?id={$subdomains.subdomain_id}">Development History</a></li>
    </ul>
</div>
<div class="clear"></div>
<!-- admmin details for subdomains -->
<div class="details">
    <div class="holder">
        <div class="title">sub-domain Port</div>
        <div class="content">{$subdomains.subdomain_port|default:'&nbsp;'}</div>
    </div>
    <div class="holder">
        <div class="title">DB Templates</div>
        <div class="content">{$subdomains.db_templates|default:'&nbsp;'}</div>
    </div>
    <div class="holder">
        <div class="title">Template File</div>
        <div class="content">{$subdomains.template_file|default:'&nbsp;'}</div>
    </div>
    <div class="holder">
        <div class="title">sub-domain Key</div>
        <div class="content">{$subdomains.subdomain_key|default:'&nbsp;'}</div>
    </div>
    <div class="holder">
        <div class="title">sub-domain Prefix</div>
        <div class="content">{$subdomains.subdomain_prefix|default:'&nbsp;'}</div>
    </div>
    <div class="holder">
        <div class="title">sub-domain Name</div>
        <div class="content">{$subdomains.subdomain_name|default:'&nbsp;'}</div>
    </div>
    <div class="holder">
        <div class="title">sub-domain Short</div>
        <div class="content">{$subdomains.subdomain_short|default:'&nbsp;'}</div>
    </div>
    <div class="holder">
        <div class="title">sub-domain Comments</div>
        <div class="content">{$subdomains.subdomain_comments|default:'&nbsp;'}</div>
    </div>
    <div class="holder">
        <div class="title">Dir Controllers</div>
        <div class="content">{$subdomains.dir_controllers|default:'&nbsp;'}</div>
    </div>
    <div class="holder">
        <div class="title">Dir Templates</div>
        <div class="content">{$subdomains.dir_templates|default:'&nbsp;'}</div>
    </div>
    <div class="holder">
        <div class="title">Dir Configs</div>
        <div class="content">{$subdomains.dir_configs|default:'&nbsp;'}</div>
    </div>
    <div class="holder">
        <div class="title">Dir Plugins</div>
        <div class="content">{$subdomains.dir_plugins|default:'&nbsp;'}</div>
    </div>
    <div class="holder">
        <div class="title">sub-domain URL</div>
        <div class="content"><a href="{$subdomains.subdomain_url}">{$subdomains.subdomain_url|default:'&nbsp;'}</a>
        </div>
    </div>
    <div class="holder">
        <div class="title">Pointed To</div>
        <div class="content">{$subdomains.pointed_to|default:'&nbsp;'}</div>
    </div>
    <div class="holder">
        <div class="title">FTP Host</div>
        <div class="content">{$subdomains.ftp_host|default:'&nbsp;'}</div>
    </div>
    <div class="holder">
        <div class="title">FTP Username</div>
        <div class="content">{$subdomains.ftp_username|default:'&nbsp;'}</div>
    </div>
    <div class="holder">
        <div class="title">FTP Password</div>
        <div class="content">{$subdomains.ftp_password|stars}</div>
    </div>
    <div class="holder">
        <div class="title">FTP Path</div>
        <div class="content">{$subdomains.ftp_path|default:'&nbsp;'}</div>
    </div>
    <div class="holder">
        <div class="title">Description</div>
        <div class="content">{$subdomains.subdomain_description|default:'&nbsp;'}</div>
    </div>
    <div class="holder">
        <div class="title">Developers?</div>
        <div class="content">
            Host: <strong>{$subdomains.ftp_host}</strong><br/> Username:
            <strong>{$subdomains.ftp_username}</strong><br/> Password: <strong>{$subdomains.ftp_password}</strong>
        </div>
    </div>
    <div class="clear"></div>
    <div class="information">
        <ul class="links admin-editor">
            <li><a href="subdomains-edit.php?id={$subdomains.subdomain_id}&amp;code={$subdomains.code}"><img
                        src="{'edit'|icon}" title="Edit subdomains" alt="Edit subdomains"/> Edit this record</a></li>
        </ul>
    </div>
    <div class="clear"></div>
    <!-- End of admin details of subdomains (sub-domain s) -->