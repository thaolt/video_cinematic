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

$("#toggler").toggles({
	drag: false,
	width: 60,
	text: {
		on: "YES",
		off: "NO"
	},
	on: $("input[name=displayLogo]").is(':checked'),
	checkbox: $("input[name=displayLogo]")
});