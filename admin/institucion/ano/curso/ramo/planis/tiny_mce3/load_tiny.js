// JavaScript Document

	tinyMCE_GZ.init({
		plugins : 'safari,table,advimage,advlink,contextmenu,paste,fullscreen,nonbreaking',
		themes : 'advanced',
		languages : 'es',
		disk_cache : true,
		debug : false
	});

	tinyMCE.init({
		mode : "textareas",
		theme : "advanced",
		editor_selector : "mceAdvanced",
		editor_deselector : "mceNoEditor",
		language : "es",
		plugins : 'safari,table,advimage,advlink,contextmenu,paste,fullscreen,nonbreaking',
		theme_advanced_buttons1 : "bold,italic,underline,|,justifyleft,justifycenter,justifyright,justifyfull,|,formatselect,fontselect,fontsizeselect",
		theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,|,forecolor,backcolor",
		theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,|,sub,sup,|,fullscreen,pagebreak,|",
		theme_advanced_toolbar_location : "external",
		theme_advanced_toolbar_align : "left",
		theme_advanced_statusbar_location : "bottom",
		theme_advanced_resizing : true,
		extended_valid_elements : "a[name|href|target|title|onclick],img[class|src|border=0|alt|title|hspace|vspace|width|height|align|onmouseover|onmouseout|name],hr[class|width|size|noshade],font[face|size|color|style],span[class|align|style]",
		entity_encoding : "raw",
		use_native_selects : true,
		button_tile_map : true	
	});
