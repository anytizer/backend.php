This is a /images directory of this subdomain (backend).
Anything here, will appear as if called from the parent.
Write your .images files uniquenly, not matching to the parent's /images/* files.

This uses a special URL rewriring to do so, in the parent framework.

ie.,
<backend>/images/* <= <subdomain>/library/services/<backend>/images/*

Notes:
You may copy these files int /images to speed up the operation.
File names here, should NOT match as that in parent's directory.