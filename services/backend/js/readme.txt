This is a /js directory of this sub-domain (backend).
Anything here, will appear as if called from the parent.
Write your .js files uniquenly, not matching to the parent's /js/* files.

This uses a special URL rewriring to do so, in the parent framework.

ie.,
<backend>/js/* <= <subdomain>/library/services/<backend>/js/*

Notes:
You may copy these files int /js to speed up the operation.
File names here, should NOT match as that in parent's directory.

Location of /js is within sub-domain package is different as that of /css and /images.
This is because, /js may NOT be a part of a theme and layout. It is required globally,
whatever theme you use.