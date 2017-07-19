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
    var barChartCanvas = $("#line-chart").get(0).getContext("2d");
    var barChartYesNo = new Chart(barChartCanvas);
     $.ajax({
      url: "{{ url('/getProduktifYesNo') }}",
      method: "GET",
      success: function(data) {
      console.log(data);
      var triwulan = [];
      var produktif = [];
      var nonproduktif = [];
      for (var i = 0; i < data.data.length; i++) {
        produktif.push(data.data[i].produktif);
        nonproduktif.push(data.data[i].nonproduktif);
        triwulan.push(data.data[i].name);
      }
      var barChartData = {
        labels: triwulan,
        datasets: [
          {
            label: "Produktif",
            fillColor: "rgba(110, 214, 222, 1)",
            strokeColor: "rgba(110, 214, 222, 1)",
            pointColor: "rgba(110, 214, 222, 1)",
            pointStrokeColor: "#c1c7d1",
            pointHighlightFill: "#fff",
            pointHighlightStroke: "rgba(220,220,220,1)",
            data: produktif
          },
          {
            label: "Non Produktif",
            fillColor: "rgba(110, 014, 222, 1)",
            strokeColor: "rgba(110, 014, 222, 1)",
            pointColor: "rgba(110, 014, 222, 1)",
            pointStrokeColor: "#c1c7d1",
            pointHighlightFill: "#fff",
            pointHighlightStroke: "rgba(220,220,220,1)",
            data: nonproduktif
          }
        ]
      };
      var barChartOptions = {
        //Boolean - Whether the scale should start at zero, or an order of magnitude down from the lowest value
        scaleBeginAtZero: true,
        //Boolean - Whether grid lines are shown across the chart
        scaleShowGridLines: true,
        //String - Colour of the grid lines
        scaleGridLineColor: "rgba(0,0,0,.05)",
        //Number - Width of the grid lines
        scaleGridLineWidth: 1,
        //Boolean - Whether to show horizontal lines (except X axis)
        scaleShowHorizontalLines: true,
        //Boolean - Whether to show vertical lines (except Y axis)
        scaleShowVerticalLines: true,
        //Boolean - If there is a stroke on each bar
        barShowStroke: true,
        //Number - Pixel width of the bar stroke
        barStrokeWidth: 2,
        //Number - Spacing between each of the X value sets
        barValueSpacing: 5,
        //Number - Spacing between data sets within X values
        barDatasetSpacing: 1,
        //String - A legend template
        legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].fillColor%>\"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>",
        //Boolean - whether to make the chart responsive
        responsive: true,
        maintainAspectRatio: true
      };
      barChartYesNo.Bar(barChartData, barChartOptions);
      }
     });    
/*
  $.ajax({
      url: "{{ url('/getProduktifYesNo') }}",
      method: "GET",
      success: function(data) {
      console.log(data);
      var sin = [], cos = [];
           for (var i = 0; i < data.data.length; i++) {
              sin.push([i,data.data[i].produktif]);
              cos.push([i,data.data[i].nonproduktif]);
            }
    var line_data1 = {
      label: "Produktif",
      data: cos,
      color: "blue"
    };
    var line_data2 = {
      label: "Non Produktif",
      data: sin,
      color: "green"
    };
    $.plot("#line-chart", [line_data2, line_data1], {
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
        },
        label: {
          show: true
        },
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
        $("#line-chart-tooltip").html(item.series.label + " <br/> triwulan " + x + " = Rp " + y)
            .css({top: item.pageY + 5, left: item.pageX + 5})
            .fadeIn(200);
      } else {
        $("#line-chart-tooltip").hide();
      }
    });
    */
    //-------------
    //- BAR CHART -
    //-------------/
    var barChartCanvas = $("#barChart").get(0).getContext("2d");
    var barChart = new Chart(barChartCanvas);
     $.ajax({
      url: "{{ url('/getProduktifJenis') }}",
      method: "GET",
      success: function(data) {
      console.log(data);
      var name = [];
      var buah = [];
      var nira = [];
      var bibit = [];
      for (var i = 0; i < data.data.length; i++) {
        buah.push(data.data[i].buah);
        nira.push(data.data[i].nira);
        bibit.push(data.data[i].bibit);
        name.push(data.data[i].name);
      }
      var barChartData = {
        labels: name,
        datasets: [
          {
            label: "Buah",
            fillColor: "rgba(110, 214, 222, 1)",
            strokeColor: "rgba(110, 214, 222, 1)",
            pointColor: "rgba(110, 214, 222, 1)",
            pointStrokeColor: "#c1c7d1",
            pointHighlightFill: "#fff",
            pointHighlightStroke: "rgba(220,220,220,1)",
            data: buah
          },
          {
            label: "Nira",
            fillColor: "rgba(110, 014, 222, 1)",
            strokeColor: "rgba(110, 014, 222, 1)",
            pointColor: "rgba(110, 014, 222, 1)",
            pointStrokeColor: "#c1c7d1",
            pointHighlightFill: "#fff",
            pointHighlightStroke: "rgba(220,220,220,1)",
            data: nira
          },
          {
            label: "Bibit",
            fillColor: "rgba(310, 014, 222, 1)",
            strokeColor: "rgba(210, 014, 222, 1)",
            pointColor: "rgba(210, 014, 222, 1)",
            pointStrokeColor: "#c1c7d1",
            pointHighlightFill: "#fff",
            pointHighlightStroke: "rgba(220,220,220,1)",
            data: bibit
          }
        ]
      };
      var barChartOptions = {
        //Boolean - Whether the scale should start at zero, or an order of magnitude down from the lowest value
        scaleBeginAtZero: true,
        //Boolean - Whether grid lines are shown across the chart
        scaleShowGridLines: true,
        //String - Colour of the grid lines
        scaleGridLineColor: "rgba(0,0,0,.05)",
        //Number - Width of the grid lines
        scaleGridLineWidth: 1,
        //Boolean - Whether to show horizontal lines (except X axis)
        scaleShowHorizontalLines: true,
        //Boolean - Whether to show vertical lines (except Y axis)
        scaleShowVerticalLines: true,
        //Boolean - If there is a stroke on each bar
        barShowStroke: true,
        //Number - Pixel width of the bar stroke
        barStrokeWidth: 2,
        //Number - Spacing between each of the X value sets
        barValueSpacing: 5,
        //Number - Spacing between data sets within X values
        barDatasetSpacing: 1,
        //String - A legend template
        legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].fillColor%>\"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>",
        //Boolean - whether to make the chart responsive
        responsive: true,
        maintainAspectRatio: true
      };
      barChart.Bar(barChartData, barChartOptions);
      }
     });    
$.ajax({
      url: "{{ url('/getDonutCommodity') }}",
      method: "GET",
      success: function(data) {
      console.log(data);
      var donutData = [];
      for (var i = 0; i < data.data.length; i++) {
        donutData.push({
            data: data.data[i].count,
            color: "#f56954",
            label: data.data[i].name
      });
      }
    $.plot("#donut-chart", donutData, {
      series: {
        pie: {
          show: true,
          radius: 1,
          innerRadius: 0.5,
          label: {
            show: true,
            radius: 2 / 3,
            formatter: labelFormatter,
            threshold: 0.1
          }
        }
      },
      legend: {
        show: true
      },
       grid: {
        hoverable: true
      },
      tooltip: true,
      tooltipOpts: {
          content: "%y.0, %s", // show percentages, rounding to 2 decimal places
          shifts: {
              x: 20,
              y: 0
          },
          defaultTheme: true
      }
    });
      function labelFormatter(label, series) {
        return '<div style="font-size:13px; text-align:center; padding:2px; color: #fff; font-weight: 600;">'
            + label
            + "<br>"
            + Math.round(series.percent) + "%</div>";
      }      
      }
   });
/*
  var pieChartCanvas = $("#donut-chart").get(0).getContext("2d");
  var pieChart = new Chart(pieChartCanvas);
 $.ajax({
      url: "{{ url('/getDonutRealisasiRencana') }}",
      method: "GET",
      success: function(data) {
      console.log(data);
    //- PIE CHART -
    //-------------
    // Get context with jQuery - using jQuery's .get() method.
    var PieData = [
      {
        value: data.data.sisa_realisasi,
        color: "#f56954",
        highlight: "#f56954",
        label: "Belum Realisasi"
      },
      {
        value: data.data.realisasi,
        color: "#d2d6de",
        highlight: "#d2d6de",
        label: "Realisasi"
      }
    ];
    var pieOptions = {
      //Boolean - Whether we should show a stroke on each segment
      segmentShowStroke: true,
      //String - The colour of each segment stroke
      segmentStrokeColor: "#fff",
      //Number - The width of each segment stroke
      segmentStrokeWidth: 2,
      //Number - The percentage of the chart that we cut out of the middle
      percentageInnerCutout: 50, // This is 0 for Pie charts
      //Number - Amount of animation steps
      animationSteps: 100,
      //String - Animation easing effect
      animationEasing: "easeOutBounce",
      //Boolean - Whether we animate the rotation of the Doughnut
      animateRotate: true,
      //Boolean - Whether we animate scaling the Doughnut from the centre
      animateScale: false,
      //Boolean - whether to make the chart responsive to window resizing
      responsive: true,
      // Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
      maintainAspectRatio: true,
      //String - A legend template
      legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<segments.length; i++){%><li><span style=\"background-color:<%=segments[i].fillColor%>\"></span><%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>"
    };
    //Create pie or douhnut chart
    // You can switch between pie and douhnut using the method below.
    pieChart.Doughnut(PieData, pieOptions);
    }
 });
*/
/*
  var pieChartCanvasSetahun = $("#donut-setahun").get(0).getContext("2d");
  var pieChartSetahun = new Chart(pieChartCanvasSetahun);
 $.ajax({
      url: "{{ url('/getDonutSetahunPaket') }}",
      method: "GET",
      success: function(data) {
      console.log(data);
      var PieDataSetahun = [
      {
        value: data.data.jumlah_paket_belum_dilelang,
        color: "#f56954",
        highlight: "#f56954",
        label: "Belum dilelang"
      },
      {
        value: data.data.jumlah_paket_pemenang,
        color: "#00d6de",
        highlight: "#d2d601",
        label: "Ada Pemenang"
      },
      {
        value: data.data.jumlah_paket_belum_realisasi,
        color: "#d200de",
        highlight: "#d2d610",
        label: "Belum realisasi"
      },
      {
        value: data.data.jumlah_paket_level1,
        color: "#11d6de",
        highlight: "#d2d2p0",
        label: "1-25%"
      },
      {
        value: data.data.jumlah_paket_level2,
        color: "#d220de",
        highlight: "#d2d612",
        label: "26-50%"
      },
      {
        value: data.data.jumlah_paket_level3,
        color: "#0066de",
        highlight: "#d2d34",
        label: "51-75%"
      },
      {
        value: data.data.jumlah_paket_level4,
        color: "#0244de",
        highlight: "#00d632",
        label: "76-99%"
      },
      {
        value: data.data.jumlah_paket_level5,
        color: "#0206ff",
        highlight: "#d200de",
        label: "100%"
      }
    ];
    var pieOptionsSetahun = {
      //Boolean - Whether we should show a stroke on each segment
      segmentShowStroke: true,
      //String - The colour of each segment stroke
      segmentStrokeColor: "#fff",
      //Number - The width of each segment stroke
      segmentStrokeWidth: 2,
      //Number - The percentage of the chart that we cut out of the middle
      percentageInnerCutout: 50, // This is 0 for Pie charts
      //Number - Amount of animation steps
      animationSteps: 100,
      //String - Animation easing effect
      animationEasing: "easeOutBounce",
      //Boolean - Whether we animate the rotation of the Doughnut
      animateRotate: true,
      //Boolean - Whether we animate scaling the Doughnut from the centre
      animateScale: false,
      //Boolean - whether to make the chart responsive to window resizing
      responsive: true,
      // Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
      maintainAspectRatio: true,
      //String - A legend template
      legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<segments.length; i++){%><li><span style=\"background-color:<%=segments[i].fillColor%>\"></span><%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>"
    };
    //Create pie or douhnut chart
    // You can switch between pie and douhnut using the method below.
    pieChartSetahun.Doughnut(PieDataSetahun, pieOptionsSetahun);
    }
 });
$.ajax({
      url: "{{ url('/getDonutSetahunPaket') }}",
      method: "GET",
      success: function(data) {
      console.log(data);
      var PieDataSetahun = [
      {
        data: data.data.jumlah_paket_belum_dilelang,
        color: "red",
        label: "Belum dilelang"
      },
      {
        data: data.data.jumlah_paket_pemenang,
        color: "purple",
        label: "Ada Pemenang"
      },
      {
        data: data.data.jumlah_paket_belum_realisasi,
        color: "green",
        label: "Belum realisasi"
      },
      {
        data: data.data.jumlah_paket_level1,
        color: "orange",
        label: "1-25%"
      },
      {
        data: data.data.jumlah_paket_level2,
        color: "pink",
        label: "26-50%"
      },
      {
        data: data.data.jumlah_paket_level3,
        color: "cyan",
        label: "51-75%"
      },
      {
        data: data.data.jumlah_paket_level4,
        color: "black",
        label: "76-99%"
      },
      {
        data: data.data.jumlah_paket_level5,
        color: "blue",
        label: "100%"
      }
    ];
  $.plot("#donut-setahun", PieDataSetahun, {
      series: {
        pie: {
          show: true,
          radius: 1,
          innerRadius: 0.5,
          label: {
            show: true,
            radius: 3 / 4,
            formatter: labelFormatter,
            threshold: 0.05
          }
        }
      },
      legend: {
        show: true
      }
    });
      }
   });
$.ajax({
      url: "{{ url('/getDonutSetahunNilai') }}",
      method: "GET",
      success: function(data) {
      console.log(data);
      var PieDataSetahunNilai = [
      {
        data: data.data.nilai_pjb_belum_dilelang,
        color: "#f56954",
        highlight: "#f56954",
        label: "Belum dilelang"
      },
      {
        data: data.data.nilai_pjb_pemenang,
        color: "#d2d623",
        highlight: "#d2d6de",
        label: "Ada Pemenang"
      },
      {
        data: data.data.nilai_pjb_belum_realisasi,
        color: "orange",
        highlight: "#d2d6de",
        label: "Belum realisasi"
      },
      {
        data: data.data.nilai_pjb_level1,
        color: "#d200de",
        highlight: "#d2d6de",
        label: "1-25%"
      },
      {
        data: data.data.nilai_pjb_level2,
        color: "#33d6de",
        highlight: "#d2d6de",
        label: "26-50%"
      },
      {
        data: data.data.nilai_pjb_level3,
        color: "#d299de",
        highlight: "#d2d6de",
        label: "51-75%"
      },
      {
        data: data.data.nilai_pjb_level4,
        color: "#0033ff",
        highlight: "#d2d6de",
        label: "76-99%"
      },
      {
        data: data.data.nilai_pjb_level5,
        color: "green",
        highlight: "#d2d6de",
        label: "100%"
      }
    ];
  $.plot("#donut-setahun-nilai", PieDataSetahunNilai, {
        series: {
        pie: {
          show: true,
          radius: 1,
          innerRadius: 0.5,
          label: {
            show: true,
            radius: 3 / 4,
            formatter: labelFormatter,
            threshold: 0.05
          }
        }
      },
      legend: {
        show: true
      }
    });
      }
   });
      function labelFormatter(label, series) {
        return '<div style="font-size:13px; text-align:center; padding:2px; color: #fff; font-weight: 600;">'
            + label
            + "<br>"
            + Math.round(series.percent) + "%</div>";
      }
      /*
  var pieChartCanvasSetahunNilai = $("#donut-setahun-nilai").get(0).getContext("2d");
  var pieChartSetahunNilai = new Chart(pieChartCanvasSetahunNilai);
 $.ajax({
      url: "{{ url('/getDonutSetahunNilai') }}",
      method: "GET",
      success: function(data) {
      console.log(data);
      var PieDataSetahunNilai = [
      {
        value: data.data.nilai_pjb_belum_dilelang,
        color: "#f56954",
        highlight: "#f56954",
        label: "Belum dilelang"
      },
      {
        value: data.data.nilai_pjb_pemenang,
        color: "#d2d623",
        highlight: "#d2d6de",
        label: "Ada Pemenang"
      },
      {
        value: data.data.nilai_pjb_belum_realisasi,
        color: "#d2d6de",
        highlight: "#d2d6de",
        label: "Belum realisasi"
      },
      {
        value: data.data.nilai_pjb_level1,
        color: "#d200de",
        highlight: "#d2d6de",
        label: "1-25%"
      },
      {
        value: data.data.nilai_pjb_level2,
        color: "#33d6de",
        highlight: "#d2d6de",
        label: "26-50%"
      },
      {
        value: data.data.nilai_pjb_level3,
        color: "#d299de",
        highlight: "#d2d6de",
        label: "51-75%"
      },
      {
        value: data.data.nilai_pjb_level4,
        color: "#d211de",
        highlight: "#d2d6de",
        label: "76-99%"
      },
      {
        value: data.data.nilai_pjb_level5,
        color: "#d2d6de",
        highlight: "#d2d6de",
        label: "100%"
      }
    ];
    var pieOptionsSetahunNilai = {
      //Boolean - Whether we should show a stroke on each segment
      segmentShowStroke: true,
      //String - The colour of each segment stroke
      segmentStrokeColor: "#fff",
      //Number - The width of each segment stroke
      segmentStrokeWidth: 2,
      //Number - The percentage of the chart that we cut out of the middle
      percentageInnerCutout: 50, // This is 0 for Pie charts
      //Number - Amount of animation steps
      animationSteps: 100,
      //String - Animation easing effect
      animationEasing: "easeOutBounce",
      //Boolean - Whether we animate the rotation of the Doughnut
      animateRotate: true,
      //Boolean - Whether we animate scaling the Doughnut from the centre
      animateScale: false,
      //Boolean - whether to make the chart responsive to window resizing
      responsive: true,
      // Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
      maintainAspectRatio: true,
      //String - A legend template
      legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<segments.length; i++){%><li><span style=\"background-color:<%=segments[i].fillColor%>\"></span><%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>"
    };
    //Create pie or douhnut chart
    // You can switch between pie and douhnut using the method below.
    pieChartSetahunNilai.Doughnut(PieDataSetahunNilai, pieOptionsSetahunNilai);
    }
 });
 $.ajax({
      url: "{{ url('/getRealisasiPerjenis') }}",
      method: "GET",
      success: function(data) {
      console.log(data);
      var PieDataperjenis = [
      {
        data: data.data.barang,
        color: "#f56954",
        highlight: "#f56954",
        label: "Barang"
      },
      {
        data: data.data.modal,
        color: "#d2d623",
        highlight: "#d2d6de",
        label: "Modal"
      },
      {
        data: data.data.lainnya,
        color: "#d2d6de",
        highlight: "#d2d6de",
        label: "Lainnya"
      }
    ];
  $.plot("#donut-perjenis", PieDataperjenis, {
      series: {
        pie: {
          show: true,
          radius: 1,
          innerRadius: 0.5,
          label: {
            show: true,
            radius: 2 / 3,
            formatter: labelFormatter,
            threshold: 0.05
          }
        }
      },
      legend: {
        show: true
      }
    });
      }
   });
   */
    var bar2ChartCanvas = $("#bar-ppl").get(0).getContext("2d");
    var bar2Chart = new Chart(bar2ChartCanvas);
     $.ajax({
      url: "{{ url('/getKinerjaPPL') }}",
      method: "GET",
      success: function(data) {
      console.log(data);
      
      var name = [];
      var presentase = [];
      for (var i = 0; i < data.data.length; i++) {
        name.push(data.data[i].district_loc);
        presentase.push(data.data[i].persentase_loc);
      }
      var bar2ChartData = {
        labels: name,
        datasets: [
          {
            label: "Persentase",
            fillColor: "rgba(110, 214, 222, 1)",
            strokeColor: "rgba(110, 214, 222, 1)",
            pointColor: "rgba(110, 214, 222, 1)",
            pointStrokeColor: "#c1c7d1",
            pointHighlightFill: "#fff",
            pointHighlightStroke: "rgba(220,220,220,1)",
            data: presentase
          }
        ]
      };
      var bar2ChartOptions = {
        //Boolean - Whether the scale should start at zero, or an order of magnitude down from the lowest value
        scaleBeginAtZero: true,
        //Boolean - Whether grid lines are shown across the chart
        scaleShowGridLines: true,
        //String - Colour of the grid lines
        scaleGridLineColor: "rgba(0,0,0,.05)",
        //Number - Width of the grid lines
        scaleGridLineWidth: 1,
        //Boolean - Whether to show horizontal lines (except X axis)
        scaleShowHorizontalLines: true,
        //Boolean - Whether to show vertical lines (except Y axis)
        scaleShowVerticalLines: true,
        //Boolean - If there is a stroke on each bar
        barShowStroke: true,
        //Number - Pixel width of the bar stroke
        barStrokeWidth: 2,
        //Number - Spacing between each of the X value sets
        barValueSpacing: 5,
        //Number - Spacing between data sets within X values
        barDatasetSpacing: 1,
        //String - A legend template
        legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].fillColor%>\"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>",
        //Boolean - whether to make the chart responsive
        responsive: true,
        maintainAspectRatio: true
      };
      bar2Chart.Bar(bar2ChartData, bar2ChartOptions);
      }
     });    
/*
  var pieChartCanvasperjenis = $("#donut-perjenis").get(0).getContext("2d");
  var pieChartperjenis = new Chart(pieChartCanvasperjenis);
 $.ajax({
      url: "{{ url('/getRealisasiPerjenis') }}",
      method: "GET",
      success: function(data) {
      console.log(data);
      var PieDataperjenis = [
      {
        value: data.data.barang,
        color: "#f56954",
        highlight: "#f56954",
        label: "Barang"
      },
      {
        value: data.data.modal,
        color: "#d2d623",
        highlight: "#d2d6de",
        label: "Modal"
      },
      {
        value: data.data.lainnya,
        color: "#d2d6de",
        highlight: "#d2d6de",
        label: "Lainnya"
      }
    ];
    var pieOptionsperjenis = {
      //Boolean - Whether we should show a stroke on each segment
      segmentShowStroke: true,
      //String - The colour of each segment stroke
      segmentStrokeColor: "#fff",
      //Number - The width of each segment stroke
      segmentStrokeWidth: 2,
      //Number - The percentage of the chart that we cut out of the middle
      percentageInnerCutout: 50, // This is 0 for Pie charts
      //Number - Amount of animation steps
      animationSteps: 100,
      //String - Animation easing effect
      animationEasing: "easeOutBounce",
      //Boolean - Whether we animate the rotation of the Doughnut
      animateRotate: true,
      //Boolean - Whether we animate scaling the Doughnut from the centre
      animateScale: false,
      //Boolean - whether to make the chart responsive to window resizing
      responsive: true,
      // Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
      maintainAspectRatio: true,
      //String - A legend template
      legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<segments.length; i++){%><li><span style=\"background-color:<%=segments[i].fillColor%>\"></span><%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>"
    };
    //Create pie or douhnut chart
    // You can switch between pie and douhnut using the method below.
    pieChartperjenis.Doughnut(PieDataperjenis, pieOptionsperjenis);
    }
    */
 });
</script>