jQuery(document).ready(function () {
	const { __, _x, _n, sprintf } = wp.i18n;
	if ( jQuery('.ld-dashboard-instructor-earning-chart-wrapper').length ) {
		loadInstructorEarningChart('year');
	}
	if ( jQuery('.ld-dashboard-course-completion-report-wrapper').length ) {
		loadCourseCompletionChart('year');
	}
	if ( jQuery('.ld-dashboard-top-courses-report-wrapper').length ) {
		loadTopCoursesChart('year');
	}

	jQuery( 'li.ld-dashboard-instructor-earning-filters-link' ).on( 'click', function(){
		let filter = jQuery(this).data('filter');
		let chart = jQuery(this).parent().data('type');
		jQuery( 'li.ld-dashboard-instructor-earning-filters-link' ).each(function(){
			jQuery(this).removeClass('filter-selected');
		});
		jQuery(this).addClass('filter-selected');
		if ( 'earning_chart' === chart ) {
			loadInstructorEarningChart(filter);
		} else if ( 'course_completion_chart' === chart ) {
			loadCourseCompletionChart(filter);
		} else if ( 'top_courses_chart' === chart ) {
			loadTopCoursesChart(filter);
		}
	});
    
	

	function loadInstructorEarningChart( filter ) {
		let params = {
			action: "ld_dashboard_get_instructor_earning_chart_data",
			nonce: ld_dashboard_chart_object.ajax_nonce,
			filter: filter,
		};
		jQuery.ajax({
			url: ld_dashboard_chart_object.ajaxurl,
			type: "post",
			data: params,
			success: function (response) {
				let result = JSON.parse(response);
				var labels = result.keys;
				var values = result.values;
				var total = result.total;
				if ( jQuery('.ldd-dashboard-earning-amount-content').length ) {
					jQuery('.ldd-dashboard-earning-amount-content span.ldd-dashboard-earning-amount').html(total);
				}
				let chart_html = '<canvas id="ld-dashboard-instructor-earning-chart" class="ld-dashboard-chart-js"></canvas>';
				jQuery( '.ld-dashboard-instructor-earning-chart-wrapper' ).html(chart_html);
				var ctx = document.getElementById('ld-dashboard-instructor-earning-chart');
				let chartLabel = __( 'Earnings', 'ld-dashboard' );
				loadLineDesignChart( ctx, labels, values, chartLabel );
			},
		});
	}
    
	function loadCourseCompletionChart( filter ) {
		let params = {
			action: "ld_dashboard_get_course_completion_chart_data",
			nonce: ld_dashboard_chart_object.ajax_nonce,
			filter: filter,
		};
		jQuery.ajax({
			url: ld_dashboard_chart_object.ajaxurl,
			type: "post",
			data: params,
			success: function (response) {
				let result = JSON.parse(response);
				var labels = result.keys;
				var values = result.values;
				var total = result.total;
				let chart_html = '<canvas id="ld-dashboard-course-completion-chart" class="ld-dashboard-chart-js"></canvas>';
				jQuery( '.ld-dashboard-course-completion-report-wrapper' ).html(chart_html);
				var ctx = document.getElementById('ld-dashboard-course-completion-chart');
				let chartLabel = __( 'Total Completions', 'ld-dashboard' );
				loadLineDesignChart( ctx, labels, values, chartLabel )
			},
		});
	}

	function loadTopCoursesChart( filter ) {
		let params = {
			action: "ld_dashboard_get_top_courses_chart_data",
			nonce: ld_dashboard_chart_object.ajax_nonce,
			filter: filter,
		};
		jQuery.ajax({
			url: ld_dashboard_chart_object.ajaxurl,
			type: "post",
			data: params,
			success: function (response) {
				let result = JSON.parse(response);
				var labels = result.keys;
				var values = result.values;
				var total = result.total;
				let chart_html = '<canvas id="ld-dashboard-top-courses-chart" class="ld-dashboard-chart-js"></canvas>';
				jQuery( '.ld-dashboard-top-courses-report-wrapper' ).html(chart_html);
				var ctx = document.getElementById('ld-dashboard-top-courses-chart');
				let chartLabel = __( 'Total Completions', 'ld-dashboard' );
				loadBarDesignChart( ctx, labels, values, chartLabel )
			},
		});
	}

    function loadLineDesignChart( ctx, labels, values, chartLabel ){
        const data = {
            labels: labels,
            datasets: [{
                label: chartLabel,
                data: values,
                fill: true,
                backgroundColor: '#c4d7ed',
                borderColor: '#1d76da',
                tension: 0.1,
                pointStyle: 'circle',
                pointRadius: 3,
                pointBorderColor: '#1d76da',
                pointBorderWidth: 2,
                pointBackgroundColor: '#fff',
            }]
        };
        var widgetChart = new Chart(ctx, {
            type: 'line',
            data: data,
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    }

	function loadPieDesignChart( ctx, labels, values, chartLabel ){
		let colors = getRandomColorArray( labels.length );
        const data = {ctx,
            labels: labels,
            datasets: [{
                label: chartLabel,
                data: values,
                backgroundColor: colors,
				hoverOffset: 4
            }]
        };
        var widgetChart = new Chart(ctx, {
            type: 'pie',
            data: data,
        });
    }

	function loadBarDesignChart( ctx, labels, values, chartLabel ){
		const data = {
			labels: labels,
			datasets: [{
				label: chartLabel,
				data: values,
				backgroundColor: '#c4d7ed',
				borderColor: '#1d76da',
				borderWidth: 2,
			}]
		};
		var widgetChart = new Chart(ctx, {
			type: 'bar',
			data: data,
			options: {
				scales: {
					xAxes: [
						{
						  ticks: {
							fontSize: 12,
							callback: function (value) {
							  let stringlength = 9;
							  if(value.length > stringlength){
							  	return value.substr(0, stringlength) + ".."; //truncate
							  } else{
								return value;
							  }
							 },
						  },
						},
					  ],
					y: {
						beginAtZero: true
					}
				},
				tooltips: {
					enabled: true,
					mode: "label",
					callbacks: {
					  title: function (tooltipItems, data) {
						var idx = tooltipItems[0].index;
						return data.labels[idx];
					  },
					  label: function (tooltipItems, data) {
						var idx = tooltipItems.index;
						return data.labels[idx];
					  },
					},
				  },
			}
		});
	}

	function getRandomColor() {
		var letters = '0123456789ABCDEF';
		var color = '#';
		for (var i = 0; i < 6; i++) {
		  color += letters[Math.floor(Math.random() * 16)];
		}
		return color;
	}

	function getRandomColorArray( count ) {
		let colors = [];
		for (var i = 0; i < count; i++) {
			let color = getRandomColor();
			colors.push( color );
		}
		return colors;
	}

});