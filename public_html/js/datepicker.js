// http://stackoverflow.com/questions/3913359/how-to-load-css-using-jquery
// https://msdn.microsoft.com/en-us/library/ms531194(VS.85).aspx
$('<link>')
	.appendTo('head')
	.attr({type : 'text/css', rel : 'stylesheet'})
	.attr('href', '//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css');

// https://api.jquery.com/jquery.getscript/
$.getScript("//code.jquery.com/ui/1.11.2/jquery-ui.js")
.done(function(script, textStatus){
	$("input[rel=date]").datepicker({
		dateFormat: "yy-mm-dd"
	});
})
.fail(function(jqxhr, settings, exception){
	console.log(textStatus);
});