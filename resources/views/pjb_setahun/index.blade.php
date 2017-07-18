@include('layouts.header')
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
    <div class="page-header clearfix">
        <h1>
            <i class="glyphicon glyphicon-align-justify"></i> Paket dan Nilai Pengadaan Barang dan Jasa Setahun
            <a class="btn btn-success pull-right" href="{{ route('pjb_setahun.create') }}"><i class="glyphicon glyphicon-plus"></i> Tambah</a>
        </h1>

    </div>
    </section>
      <!-- Main content -->
    <section class="content">    
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-body">               
                @if($Penyerapan_anggaran_setahun_pjbs->count())
                    <table class="table table-condensed table-striped">
                        <thead>
                            <tr>
                            <th>ID</th>
                            <th>TAHUN</th>
                            <th>SATUAN KERJA</th>
                            <th>TANGGAL</th>
                            <th class="text-right">JUMLAH </th>
                            <th class="text-right">NILAI (Rp)</th>
                            <th class="text-center">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($Penyerapan_anggaran_setahun_pjbs as $master_datum)
                        <tr>
                        <td>{{$master_datum->id}}</td>
                        <td>{{$master_datum->tahun}}</td>
                        <td>{{$master_datum->user->name}}</td>
                        <td>{{$master_datum->created_at}}</td>
                        <td class="text-right">{{number_format($master_datum->target_paket_pjb)}}</td>
                        <td class="text-right">{{number_format($master_datum->nilai_paket_pjb)}}</td>
                        <td class="text-center">
                            <a class="btn btn-xs btn-warning" href="{{ route('pjb_setahun.edit', $master_datum->id) }}"><i class="glyphicon glyphicon-edit"></i> Ubah</a>
                            <form action="{{ route('pjb_setahun.destroy', $master_datum->id) }}" method="POST" style="display: inline;" onsubmit="if(confirm('Hapus? Apakah anda yakin?')) { return true } else {return false };">
                                <input type="hidden" name="_method" value="DELETE">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <button type="submit" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-trash"></i> Hapus</button>
                            </form>
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
       }
     } );
  });
</script>
</body>
</html>

