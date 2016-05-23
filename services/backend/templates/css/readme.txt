This is a /css directory of this subdomain (backend).
Anything here, will appear as if called from the parent.
Write your .css files uniquenly, not matching to the parent's /css/* files.

This uses a special URL rewriring to do so, in the parent framework.

ie.,
<backend>/css/* <= <subdomain>/library/services/<backend>/css/*

Notes:
You may copy these files int /css to speed up the operation.
File names here, should NOT match as that in parent's directory.