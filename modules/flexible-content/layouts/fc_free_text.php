<?php
/*
----------------------------------------------------
    ______                  ______          __
   / ____/_______  ___     /_  __/__  _  __/ /_
  / /_  / ___/ _ \/ _ \     / / / _ \| |/_/ __/
 / __/ / /  /  __/  __/    / / /  __/>  </ /_
/_/   /_/   \___/\___/    /_/  \___/_/|_|\__/

----------------------------------------------------
Free Text
*/

$max_width = '';
if(get_sub_field('max_width')) {
    $percentage = (get_sub_field('max_width') * 1200) / 100;
    $max_width = 'style="max-width:'.$percentage.'px; margin:0 auto;"';
}
?>

<div class="fc-free-text" <?php echo $max_width; ?>>
    <?php echo apply_filters('the_content', get_sub_field('free_text', false, false)); ?>
</div>

<?php
/* $current_user = wp_get_current_user();
if($current_user->ID == 1 ) {
	?>
	<style>
		#chart {
			max-width: 900px;
			margin: 0 auto;
		}

	</style>
	<script>
		jQuery(document).ready(function($) {
			// Initialize the slider
			$("#slider").slider({
				min: 1,
				max: 10,
				step: 1,
				value: 1,
				slide: function(event, ui) {
					updateChart(ui.value);
				}
			});

			// Initialize the chart
			var chart = new Chart($("#chart"), {
				type: "line",
				data: {
				labels: [],
				datasets: [{
					label: "Money",
					data: [],
					borderColor: "blue",
					fill: false
				}]
				},
				options: {
				scales: {
					x: {
					title: {
						display: true,
						text: "Years"
					}
					},
					y: {
					title: {
						display: true,
						text: "Money"
					}
					}
				}
				}
			});

			// Update the chart based on the slider value
			function updateChart(years) {
				var labels = [];
				var data = [];

				// Calculate the money for each year
				for (var i = 1; i <= years; i++) {
				labels.push("Year " + i);
				var money = calculateMoney(i);
				data.push(money);
				}

				// Update the chart data and labels
				chart.data.labels = labels;
				chart.data.datasets[0].data = data;

				// Update the chart
				chart.update();
			}

			// Calculate the money for a given year based on the interest rate
			function calculateMoney(year) {
				var principal = 1000; // Initial investment
				var interestRate = 3.45 / 100; // 3.45% interest rate
				var money = principal * Math.pow(1 + interestRate, year);
				return money.toFixed(2);
			}

			// Initial chart update
			updateChart(1);
		});

	</script>

	<div id="slider"></div>
	<canvas id="chart"></canvas>

	<?php
} */
?>
