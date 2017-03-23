/**
var editor = document.createElement("script");
editor.type = "text/javascript";
editor.src = "//cdn.tinymce.com/4/tinymce.min.js";
$("head").append(editor);
*/

tinymce.init({ selector:'textarea.editor' });

/**
 * Basic configurations for a standard editor to suit almost all kinds of deployment environment.
 *
 * http://tinymce.moxiecode.com/wiki.php/Configuration:mode
 * http://www.tinymce.com/wiki.php/Configuration:relative_urls
 * http://www.tinymce.com/wiki.php/Configuration:extended_valid_elements
 */
 /**
tinyMCE.init({
	relative_urls: false,

	mode: "specific_textareas",
	//editor_selector: "editor",
	editor_selector: /(editor|textarea)/,

	// content CSS
	//content_css : 'css/framework.css',

	theme: 'advanced',

	// Theme options
	theme_advanced_buttons1: 'bold,italic,underline,strikethrough,|,bullist,numlist,|,undo,redo,|,link,unlink,image,|,cleanup,code,',
	theme_advanced_buttons2: "",
	theme_advanced_buttons3: "",
	theme_advanced_buttons4: "",
	theme_advanced_toolbar_location: 'bottom',
	theme_advanced_toolbar_align: 'left',
	theme_advanced_statusbar_location: 'top',
	theme_advanced_resizing: false,

	extended_valid_elements: "a[href|rel|rev|target|title|type]," +
		"b[]," +
		"br[clear]," +
		"em[]," +
		"font[color|face|font-weight|point-size|size]," +
		"h1[align|class]," +
		"h2[align|class]," +
		"h3[align|class]," +
		"h4[align|class]," +
		"h5[align|class]," +
		"h6[align|class]," +
		"li[align|class|clear|type|value]," +
		"ol[align|class|start|type]," +
		"p[align|class|clear]," +
		"strike[]," +
		"strong[]," +
		"u[]," +
		"ul[align|class|type]"
});*/