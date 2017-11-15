require('jquery');
require('sweetalert');
require('bootstrap-select');
require('./bootstrap');

// For optional modules.
require('moment');
require('./datepicker/bootstrap-datetimepicker.min');

$('.selectpicker').selectpicker({
	size: 4
});

$('.datepicker').datetimepicker({ format: 'Y-MM-DD' });