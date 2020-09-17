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
		theme_advanced_buttons1 : "bold,italic,underline,|,justifyleft,justifycenter,justifyright,justifyfull",
		theme_advanced_buttons2 : "",
		theme_advanced_buttons3 : "",
		theme_advanced_toolbar_location : "external",
		theme_advanced_toolbar_align : "left",
		theme_advanced_statusbar_location : "bottom",
		theme_advanced_resizing : false,
		extended_valid_elements : "",
		entity_encoding : "raw",
		use_native_selects : true,
		button_tile_map : true	
	});
