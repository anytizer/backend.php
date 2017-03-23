<!-- Searches in the same form, as in the their own pages -->
<form autocomplete="off" id="search-form" name="search-form" method="post" action="?">
    <input type="text" name="search-query" class="input" value="{$search_query}"/> <input type="hidden"
                                                                                          name="search-action"
                                                                                          value="Search"/> <input
        type="image" name="search-image" src="{'zoom'|icon}"/> <a id="search-help-link" href="search-help.php"><img
            src="{'information'|icon}"/></a>
</form>
