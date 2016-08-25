var chart = $("#sparkline-pie");

chart.sparkline(chart.data('value'), {
	type: 'pie',
	width: '100%',
	height: '100%',
	offset: 10,
	borderWidth: 0,
	borderColor: '#000000 '
});