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
</style>
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
    <div class="page-header clearfix">
        <h1>
            <i class="glyphicon glyphicon-align-justify"></i> Penyerapan Anggaran Dan Pengadaan Barang dan Jasa
            <a class="btn btn-success pull-right" href="{{ route('penyerapan_anggaran_target_pjbs.create') }}"><i class="glyphicon glyphicon-plus"></i> Tambah</a>
        </h1>

    </div>
    </section>
      <!-- Main content -->
    <section class="content">
        
    @include('error')
    @if(Session::has('message2'))
       <p class="alert {{ Session::get('alert-class', 'alert-danger') }}">{{ Session::get('message2') }}</p>
    @elseif(Session::has('message'))
       <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
    @endif        
        
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-body">                
                @if($penyerapan_anggaran_target_pjbs->count())
                    <table class="table table-condensed table-striped">
                        <thead>
                            <tr>
                            <th>ID</th>
                            <th>TAHUN</th>
                            <th>SATUAN KERJA</th>
                            <th>No DIPA</th>
                            <th>TANGGAL</th>
                            <th>JENIS</th>
                            <th>TOTAL ANGGARAN (Rp) </th>
                            <th>SURAT</th>
                            <th>STATUS</th>
                                <th class="text-right">AKSI</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($penyerapan_anggaran_target_pjbs as $penyerapan_anggaran_target_pjb)
                                <tr>
                                @if($penyerapan_anggaran_target_pjb->error == "DECRYPTION_ERROR")
                                    <td>{{$penyerapan_anggaran_target_pjb->id}}</td>
                                    <td>ERROR</td>
                                    <td>ERROR</td>
                                    <td>ERROR</td>
                                    <td>ERROR</td>
                                    <td>ERROR</td>
                                    <td align="right">ERROR</td>
                                    <td>ERROR</td>
                                    <td>ERROR</td>
                                @else
                                    <td>{{$penyerapan_anggaran_target_pjb->id}}</td>
                                    <td>{{$penyerapan_anggaran_target_pjb->tahun_anggaran}}</td>
                                    <td>{{$penyerapan_anggaran_target_pjb->satuan_kerja}}</td>
                                    <td>{{$penyerapan_anggaran_target_pjb->nama_dipa}}</td>
                                    <td>{{$penyerapan_anggaran_target_pjb->tanggal_dipa}}</td>
                                    <td>@if($penyerapan_anggaran_target_pjb->jenis=='p') Pusat @else Daerah @endif</td>
                                    <td align="right">{{ number_format($penyerapan_anggaran_target_pjb->total_anggaran)}}</td>
                                    <td>{{$penyerapan_anggaran_target_pjb->jenis_surat}}</td>
                                    <td class="status_{{$penyerapan_anggaran_target_pjb->status}}">{{$penyerapan_anggaran_target_pjb->status}}</td>
                                @endif     
                                    <td class="text-right">
                                        <a class="btn btn-xs btn-primary" href="{{ route('penyerapan_anggaran_target_pjbs.show', $penyerapan_anggaran_target_pjb->id) }}"><i class="glyphicon glyphicon-eye-open"></i> Tampilkan</a>
                                        @if($penyerapan_anggaran_target_pjb->user_id == Auth::user()->id && $penyerapan_anggaran_target_pjb->status != 'FINAL')
                                        <a class="btn btn-xs btn-warning" href="{{ route('penyerapan_anggaran_target_pjbs.edit', $penyerapan_anggaran_target_pjb->id) }}"><i class="glyphicon glyphicon-edit"></i> Ubah</a>
                                        <form action="{{ route('penyerapan_anggaran_target_pjbs.destroy', $penyerapan_anggaran_target_pjb->id) }}" method="POST" style="display: inline;" onsubmit="if(confirm('Hapus secara permanen data ini?')) { return true } else {return false };">
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
       }
     } );
  });
</script>
</body>
</html>

