
$(document).ready(function() {

	$("[data-mask]").inputmask();

	$('#menuPrincipal').simpleScrollFollow();

	$(".btVoltar").click(function() {
		history.back();
	});

	jQuery.validator.setDefaults({
		highlight : function(element, errorClass, validClass) {
			if (element.type === "radio") {
				this.findByName(element.name).addClass(errorClass).removeClass(validClass);
			} else {
				$(element).closest('.form-group').removeClass('has-success has-feedback').addClass('has-error has-feedback');
				$(element).closest('.form-group').find('span.glyphicon').remove();
				$(element).closest('.form-group').append('<span class="glyphicon glyphicon-remove form-control-feedback" aria-hidden="true"></span>');
			}
		},
		unhighlight : function(element, errorClass, validClass) {
			if (element.type === "radio") {
				this.findByName(element.name).removeClass(errorClass).addClass(validClass);
			} else {
				$(element).closest('.form-group').removeClass('has-error has-feedback').addClass('has-success has-feedback');
				$(element).closest('.form-group').find('span.glyphicon').remove();
				$(element).closest('.form-group').append('<span class="glyphicon glyphicon-ok form-control-feedback" aria-hidden="true"></span>');
			}
		},
		 ignore: [],
	});

	$('input[type="checkbox"].flat-blue, input[type="radio"].flat-blue').iCheck({
		checkboxClass : 'icheckbox_flat-blue',
		radioClass : 'iradio_flat-blue'
	});
});
