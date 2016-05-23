Put global CSS files here, and access them from the templates.
If you plan carefully, you can reuse these css even if you use different templates.

It is upto your programming skills.

For subdomains, do not name the external css files as css/*.css that will match
in this directory. If the names are unique and reside in library/<subdomain>/templates/css/*,
the .htacess will rewrite them properly.

So, all of your css can be relative to your subdomain's templates only.