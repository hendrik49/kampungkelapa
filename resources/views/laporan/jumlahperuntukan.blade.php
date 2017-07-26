@include('layouts.header')
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
    <div class="page-header clearfix">
        <h1>
            <i class="glyphicon glyphicon-align-justify"></i>Jumlah Peruntukan Kelapa per Kecamatan - Buah, Nira, Bibit
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
                            <th width="70%">KECAMATAN</th>
                            <th width="10%">BIBIT</th>
                            <th width="10%">NIRA</th>
                            <th width="10%">BUAH</th>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th width="70%">KECAMATAN</th>
                            <th width="10%">BIBIT</th>
                            <th width="10%">NIRA</th>
                            <th width="10%">BUAH</th>
                        </tr>
                        </tfoot>

                        <tbody>
                            @foreach($data as $master_datum)
                        <tr>
                        <td width="70%">{{$master_datum->name}}</td>
                        @if($master_datum->bibit!=null)
                            <td align="right" width="10%">{{$master_datum->bibit}}</td>
                        @else
                            <td align="right" width="10%">0</td>
                        @endif
                        
                        @if($master_datum->nira!=null)
                            <td align="right" width="10%">{{$master_datum->nira}}</td>
                        @else
                            <td align="right" width="10%">0</td>
                        @endif

                        @if($master_datum->buah!=null)
                            <td align="right" width="10%">{{$master_datum->buah}}</td>
                        @else
                            <td align="right" width="10%">0</td>
                        @endif

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

