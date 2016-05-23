8:59 PM 10/25/2014
http://code.jquery.com/jquery-1.11.1.min.js

Put your global javascript files here.
It ships with javascript validator file.

Now onwards, every time jQuery updates, the file: will be modified.
jQuery will be always in minified forms.
On linux, just make a symlink:
	cd js
	rm -f jquery-latest.js
	ln -s jquery-?.js jquery-latest.js

jQuery updates till now (jquery-latest.js):
4:46 AM 4/29/2010	jquery-1.4.2.min.js
1:57 AM 9/9/2012	http://code.jquery.com/jquery-latest.pack.js