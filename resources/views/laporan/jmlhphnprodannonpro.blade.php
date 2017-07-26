@include('layouts.header')
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
    <div class="page-header clearfix">
        <h1>
            <i class="glyphicon glyphicon-align-justify"></i> Jumlah Pohon Kelapa Produktif dan Non Produktif per Kecamatan
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
                            <th width="80%">KECAMATAN</th>
                            <th width="10%">PRODUKTIF</th>
                            <th width="10%">NON PRODUKTIF</th>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th width="80%">KECAMATAN</th>
                            <th width="10%">PRODUKTIF</th>
                            <th width="10%">NON PRODUKTIF</th>
                        </tr>
                        </tfoot>

                        <tbody>
                            @foreach($data as $master_datum)
                        <tr>
                        <td width="80%">{{$master_datum->name}}</td>
                        <td align="right" width="10%">{{$master_datum->produktif}}</td>
                        <td align="right" width="10%">{{$master_datum->nonproduktif}}</td>
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

