@include('layouts.header')
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
    <div class="page-header clearfix">
        <h1>
            <i class="glyphicon glyphicon-align-justify"></i> Nilai Kinerja PPL
        </h1>

    </div>
    </section>
      <!-- Main content -->
    <section class="content">    
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-body">               
                @if($data)
                    <table class="table table-condensed table-striped">
                        <thead>
                        <tr>
                            <th algin="left" width="70%">KECAMATAN</th>
                            <th width="10%">PRESENTASE (%)</th>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th algin="left" width="70%">KECAMATAN</th>
                            <th width="10%">PRESENTASE (%)</th>
                        </tr>
                        </tfoot>

                        <tbody>
                            @foreach($data as $master_datum)
                        <tr>
                        <td algin="left" width="70%">{{$master_datum->district_loc}}</td>
                        <td align="right" width="30%">{{$master_datum->persentase_loc}}</td>
                        </tr>
                    @endforeach
                        </tbody>
                    </table>
                @else
                    <h3 class="text-center alert alert-info">Kosong!</h3>
                @endif
                </div>
            </div>

        </div>
    </div>
    </section>
    <!-- /.content -->
  </div>
@include('layouts.footer') 
<script>
  $(function () {
    $(".table").DataTable({
        dom: 'Bfrtip',
        buttons: [
            'excel', 'pdf'
        ],
       "oLanguage": {
         "sProcessing":   "Sedang memproses...",
        "sLengthMenu":   "Tampilkan _MENU_ entri",
        "sZeroRecords":  "Tidak ditemukan data yang sesuai",
        "sInfo":         "Menampilkan _START_ sampai _END_ dari _TOTAL_ entri",
        "sInfoEmpty":    "Menampilkan 0 sampai 0 dari 0 entri",
        "sInfoFiltered": "(disaring dari _MAX_ entri keseluruhan)",
        "sInfoPostFix":  "",
        "sSearch":       "Cari:",
        "sUrl":          "",
        "oPaginate": {
            "sFirst":    "Pertama",
            "sPrevious": "Sebelumnya",
            "sNext":     "Selanjutnya",
            "sLast":     "Terakhir"
        }
       }
     } );
  });
</script>
</body>
</html>

