$("input[name=borderColor]").minicolors({
	animationSpeed: 100,
	animationEasing: "swing",
	change: null,
	changeDelay: 0,
	control: "hue",
	defaultValue: "",
	hide: null,
	hideSpeed: 100,
	inline: false,
	letterCase: "uppercase",
	opacity: false,
	position: "default",
	show: null,
	showSpeed: 100,
	swatchPosition: "right",
	textfield: true,
	theme: "bootstrap"
});

$("#borderSizeSlider").noUiSlider({
	range: [0, 30],
	start: parseInt($("input[name=borderSize]").val()),
	handles: 1,
	step: 1,
	serialization: {
		to: [$("input[name=borderSize]")],
		resolution: 1
	}
});

$('input[type=checkbox]').each(function(index,obj){
	if ($(obj).attr('id')=='chk_clearImage') return;
	var togglerId = $(obj).attr('id')+'_toggler';
	$(obj).parent().append('<div class="toggle-light" id="'+togglerId+'"></div>');
	$('#'+togglerId).toggles({
		drag: false,
		width: 60,
		text: {
			on: text_ON,
			off: text_OFF
		},
		on: $(obj).is(':checked'),
		checkbox: $(obj)
	});
	$(obj).hide();
});
