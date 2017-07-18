@include('layouts.header')
<style type="text/css">
    .status_DRAFT {
        color: #FFCB28;
        font-weight: bold;
    }
    .status_FINAL {
        color: #2EDE22;
        font-weight: bold;
    }
    table.kopspp {
        font-size: 13px;
    }
    tr.group,tr.group:hover {
    background-color: #ddd !important;
}
</style>
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
    <div class="page-header clearfix">
        <h1>
            <i class="glyphicon glyphicon-align-justify"></i> KOP dan Surat Perintah Pembayaran (SPP)
            <a class="btn btn-success pull-right" href="{{ route('kop_spp.create') }}"><i class="glyphicon glyphicon-plus"></i> Tambah</a>
        </h1>

    </div>
    </section>
      <!-- Main content -->
    <section class="content">
    <div class="row">
        <div class="col-md-12">
            @if($kop_spp->count())
                <table class="table table-condensed table-striped table.kopspp">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>NO DIPA</th>
                            <th>UNIT KERJA</th>
                            <th>BELANJA</th>
                            <th>KATEGORI</th>
                            <th>NO. KOP</th>
                            <th>TGL</th>
                            <th>URAIAN</th>
                            <th>NO. KONTRAK/SPK</th>                            
                            <th>NO. BAP</th>                            
                            <th>NO. BAST</th>                            
                            <th>NO. SPP</th>
                            <th>TGL</th>
                            <th>URAIAN</th>
                            <th>NILAI KOP (Rp) </th>
                            <th>NILAI KONTRAK (Rp) </th>
                            <th>NILAI SPP (Rp) </th>
                            <th>SISA (Rp)</th>
                            <th class="text-right">AKSI</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach($kop_spp as $kopspp)
                                <tr>
                                @if($kopspp->error == "DECRYPTION_ERROR")
                                    <td>{{$kopspp->id}}</td>
                                    <td>ERROR</td>
                                    <td>ERROR</td>
                                    <td>ERROR</td>
                                    <td>ERROR</td>
                                    <td>ERROR</td>
                                    <td>ERROR</td>
                                    <td>ERROR</td>
                                    <td>ERROR</td>
                                    <td>ERROR</td>
                                    <td>ERROR</td>
                                    <td>ERROR</td>
                                    <td>ERROR</td>
                                    <td>ERROR</td>
                                    <td>ERROR</td>
                                    <td>ERROR</td>
                                    <td>ERROR</td>
                                    <td align="right">ERROR</td>
                                    <td>ERROR</td>
                                @else
                                    <td>{{$kopspp->id}}</td>
                                    <td>{{$kopspp->dipa->nama_dipa}}</td>
                                    <td>{{$kopspp->user->name}}</td>
                                    <td> @if($kopspp->type_belanja == 'm') Modal @elseif($kopspp->type_belanja=="b") Barang @else Lainnya @endif</td>
                                    <td>{{$kopspp->kategori_uraian}}</td>
                                    <td>{{$kopspp->no_kop}}</td>
                                    <td>{{$kopspp->tgl_kop}}</td>
                                    <td>{{$kopspp->uraian_kop}}</td>
                                    <td>{{$kopspp->no_kontrak}}</td>
                                    <td>{{$kopspp->no_bap}}</td>
                                    <td>{{$kopspp->no_bast}}</td>
                                    <td>{{$kopspp->no_spp}}</td>
                                    <td>{{$kopspp->tgl_spp}}</td>
                                    <td>{{$kopspp->uraian_spp}}</td>
                                    <td align="right">{{ number_format($kopspp->nilai_kop)}}</</td>
                                    <td align="right">{{ number_format($kopspp->nilai_kontrak)}}</</td>
                                    <td align="right">{{ number_format($kopspp->nilai_spp)}}</</td>
                                    <td align="right">{{ number_format($kopspp->nilai_kop-$kopspp->nilai_spp)}}</td>
                                     @endif     
                                    <td class="text-right">
                                        <a class="btn btn-xs btn-primary" style="display:none;" href="{{ route('kop_spp.show', $kopspp->id) }}"><i class="glyphicon glyphicon-eye-open"></i> Tampilkan</a>
                                        @if($kopspp->user_id == Auth::user()->id && $kopspp->status != 'FINAL')
                                        <a class="btn btn-xs btn-warning" href="{{ route('kop_spp.edit', $kopspp->id) }}"><i class="glyphicon glyphicon-edit"></i> Ubah</a>
                                        <form action="{{ route('kop_spp.destroy', $kopspp->id) }}" method="POST" style="display: inline;" onsubmit="if(confirm('Hapus secara permanen data ini?')) { return true } else {return false };">
                                            <input type="hidden" name="_method" value="DELETE">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <button type="submit" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-trash"></i> Hapus</button>
                                        </form>
                                        @else
                                        <button type="button" class="btn btn-xs btn-default" disabled><i class="glyphicon glyphicon-edit"></i> Ubah</button>
                                        <button type="button" class="btn btn-xs btn-default" disabled><i class="glyphicon glyphicon-trash"></i> Hapus</button>
                                        @endif
                                    </td>

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
       },        
       "scrollX": true,
        "columnDefs": [
            { "visible": false, "targets": 4 }
        ],
        "order": [[ 4, 'asc' ]],
        "displayLength": 25,
       "drawCallback": function ( settings ) {
            var api = this.api();
            var rows = api.rows( {page:'current'} ).nodes();
            var last=null;
 
            api.column(4, {page:'current'} ).data().each( function ( group, i ) {
                if ( last !== group ) {
                    $(rows).eq( i ).before(
                        '<tr class="group"><td colspan="18">'+group+'</td></tr>'
                    );
 
                    last = group;
                }
            } );
        }
    } );
 
    // Order by the grouping
    $('.table tbody').on( 'click', 'tr.group', function () {
        var currentOrder = table.order()[0];
        if ( currentOrder[0] === 5 && currentOrder[1] === 'asc' ) {
            table.order( [ 5, 'desc' ] ).draw();
        }
        else {
            table.order( [ 5, 'asc' ] ).draw();
        }
    } );
  });
</script>
</body>
</html>

