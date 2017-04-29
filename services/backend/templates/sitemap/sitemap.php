<style type="text/css">
    .sitemap h1 {
        font-size: 16px;
        font-weight: bold;
        border: none;
        border-top: 1px solid #FFCC66;
        background-color: #FFFFFF;
        margin: 0px;
    }
</style>
<div class="sitemap">
    {section name='s' loop=$sitemap}
    <h1>{$smarty.section.s.index_next}. <a href="{$sitemap[s].n}">{$sitemap[s].t|ucwords}</a></h1>
    {/section}
</div>