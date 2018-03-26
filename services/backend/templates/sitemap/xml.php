<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    {section name='s' loop=$sitemap}
    <url>
        <loc>{$smarty.const.__URL__}/{$sitemap[s].n|htmlentities}</loc>
        <lastmod>{sitemap modification=random}</lastmod>
        <changefreq>{sitemap frequency=random}</changefreq>
        <priority>{sitemap priority=random}</priority>
    </url>
    {sectionelse}
    <url>
        <loc>{$smarty.const.__URL__}</loc>
        <lastmod>{sitemap modification=random}</lastmod>
        <changefreq>{sitemap frequency=random}</changefreq>
        <priority>{sitemap priority=random}</priority>
    </url>
    {/section}
</urlset>