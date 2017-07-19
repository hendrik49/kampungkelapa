<div>
<!-- /.content-wrapper -->
  <footer class="main-footer">
    <div class="pull-right hidden-xs">
      <b>Versi</b> 2.3.6
    </div>
    <strong>Hak Cipta &copy; 2014-2016 <a href="http://almsaeedstudio.com">PT Primus Indonesia</a>.</strong> Dilindungi Undang-Undang.
  </footer>
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->
<!-- jQuery 2.2.3 -->
<script src="{{ asset('assets/plugins/jQuery/jquery-2.2.3.min.js') }}"></script>
<!-- jQuery 2.2.3 -->
<script src="{{ asset('assets/plugins/jQuery/jquery.mask.min.js') }}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{ asset('assets/dist/js/jquery-ui.min.js')}}"></script>
<!-- Morris.js charts -->
<script src="{{ asset('assets/dist/js/raphael-min.js')}}"></script>
<!-- daterangepicker -->
<script src="{{ asset('assets/dist/js/moment.min.js') }}"></script>

<!-- InputMask -->
<script src="{{ asset('assets/plugins/input-mask/jquery.inputmask.js')}}"></script>
<script src="{{ asset('assets/plugins/input-mask/jquery.inputmask.date.extensions.js')}}"></script>
<script src="{{ asset('assets//plugins/input-mask/jquery.inputmask.extensions.js')}}"></script>

<!-- date-range-picker 
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>
-->
<script src="{{ asset('assets/plugins/daterangepicker/daterangepicker.js')}}"></script>
<!-- bootstrap datepicker -->
<script src="{{ asset('assets/plugins/datepicker/bootstrap-datepicker.js')}}"></script>
<!-- bootstrap color picker -->
<script src="{{ asset('assets/plugins/colorpicker/bootstrap-colorpicker.min.js')}}"></script>
<!-- bootstrap time picker -->
<script src="{{ asset('assets/plugins/timepicker/bootstrap-timepicker.min.js')}}"></script>

<!-- Bootstrap 3.3.6 -->
<script src="{{ asset('assets/bootstrap/js/bootstrap.min.js') }}"></script>
<!-- FastClick -->
<script src="{{ asset('assets/plugins/fastclick/fastclick.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('assets/dist/js/app.min.js') }}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{ asset('assets/dist/js/demo.js') }}"></script>
<!-- FLOT CHARTS -->
<script src="{{ asset('assets/plugins/flot/jquery.flot.min.js') }}"></script>
<!-- FLOT RESIZE PLUGIN - allows the chart to redraw when the window is resized -->
<script src="{{ asset('assets/plugins/flot/jquery.flot.resize.min.js') }}"></script>
<!-- FLOT PIE PLUGIN - also used to draw donut charts -->
<script src="{{ asset('assets/plugins/flot/jquery.flot.pie.min.js') }}"></script>
<!-- FLOT CATEGORIES PLUGIN - Used to draw bar charts -->
<script src="{{ asset('assets/plugins/flot/jquery.flot.categories.min.js') }}"></script>
<!-- Select2 -->
<script src="{{ asset('assets/plugins/select2/select2.full.min.js') }}"></script>
<!-- ChartJS 1.0.1 -->
<script src="{{ asset('assets/plugins/chartjs/Chart.min.js') }}"></script>
<!-- DataTables -->
<script src="{{ asset('assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables/dataTables.bootstrap.min.js') }}"></script>
<!-- SlimScroll -->
<script src="{{ asset('assets/plugins/slimScroll/jquery.slimscroll.min.js') }}"></script>
<script>
  $(function () {
    //Initialize Select2 Elements
    $(".select2").select2();
    $('.dpYears').datepicker({
				format: 'dd-mm-yyyy'
    });
    $('.money').mask('000,000,000,000,000,000,000,000,000,000', {reverse: true});
    $('.money2').mask("#.##0,00", {reverse: true});
    $(".date-picker").datepicker({ dateFormat: 'mm/dd/yyyy' });
    //$(".date-picker").datepicker('setDate', new Date());    
    
    //Datemask dd/mm/yyyy
  });
</script>