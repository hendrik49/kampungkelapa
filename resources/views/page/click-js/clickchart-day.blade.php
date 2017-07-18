<!-- FLOT CHARTS -->
<script src="{{ asset('assets/plugins/flot/jquery.flot.min.js') }}"></script>
<!-- FLOT RESIZE PLUGIN - allows the chart to redraw when the window is resized -->
<script src="{{ asset('assets/plugins/flot/jquery.flot.resize.min.js') }}"></script>
<!-- FLOT PIE PLUGIN - also used to draw donut charts -->
<script src="{{ asset('assets/plugins/flot/jquery.flot.pie.min.js') }}"></script>
<!-- FLOT CATEGORIES PLUGIN - Used to draw bar charts -->
<script src="{{ asset('assets/plugins/flot/jquery.flot.categories.min.js') }}"></script>
<!-- Page script -->
<script>
  $(function () {
    /*
     * LINE CHART
     * ----------
     */
    //LINE randomly generated data
    $.ajax({
      url: "{{ url('/getDataClickDay') }}",
      method: "GET",
      success: function(data) {
      console.log(data);
      var click_day = [], click = [], count_click = [];
      for(var i in data) {
        click_day.push(data[i].click_day);
        count_click.push(data[i].count_click);
        click.push(data[i].click);
      }
      
      var line_data1 = {
        label: click[0],
        data: count_click,
        color: "#3c8dbc"
      };
      var line_data2 = {
        label: click,
        data: count_click,
        color: "#00c0ef"
      };

      var line_data3 = {
        label: click,
        data: count_click,
        color: "#00c000"
      };

      $.plot("#line-chart", [line_data1, line_data2, line_data3], {
        grid: {
          hoverable: true,
          borderColor: "#f3f3f3",
          borderWidth: 1,
          tickColor: "#f3f3f3"
        },
        series: {
          shadowSize: 0,
          lines: {
            show: true
          },
          points: {
            show: true
          }
        },
        lines: {
          fill: false,
          color: ["#3c8dbc", "#f56954"]
        },
        yaxis: {
          show: true,
        },
        xaxis: {
          show: true
        }
      });

      //Initialize tooltip on hover
      $('<div class="tooltip-inner" id="line-chart-tooltip"></div>').css({
        position: "absolute",
        display: "none",
        opacity: 0.8
      }).appendTo("body");

      $("#line-chart").bind("plothover", function (event, pos, item) {

        if (item) {
          var x = item.datapoint[0].toFixed(2),
              y = item.datapoint[1].toFixed(2);

          $("#line-chart-tooltip").html(item.series.label + " <br/> Click at " + x + " = " + y)
              .css({top: item.pageY + 5, left: item.pageX + 5})
              .fadeIn(200);
        } else {
          $("#line-chart-tooltip").hide();
        }

      });
}
      
      /* END LINE CHART */
});
</script>