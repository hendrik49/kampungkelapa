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
      <h1>
       </h1>
    <div class="page-header clearfix">
        <h1>
            <i class="glyphicon glyphicon-align-justify"></i> Progres Pengadaan Barang dan Jasa
            <a class="btn btn-success pull-right" href="{{ route('progres_pjbs.create') }}"><i class="glyphicon glyphicon-plus"></i> Tambah</a>
        </h1>

    </div>
    </section>
      <!-- Main content -->
    <section class="content">
        
    @if(Session::has('message'))
        <p class="alert alert-info">{{ Session::get('message') }}</p>
    @endif
        
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-body">               
                @if($progres_pjbs->count())
                    <table class="table table-condensed table-striped">
                        <thead>
                            <tr>
                            <th>ID</th>
                            <th>TAHUN</th>
                            <th>TRIWULAN</th>
                            <th>SATUAN KERJA</th>
                            <th>ID PJB SETAHUN</th>
                            <th>TANGGAL</th>
                            <th>STATUS</th>
                                <th class="text-right">AKSI</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($progres_pjbs as $progres_pjb)
                                <tr>
                                @if($progres_pjb->error == "DECRYPTION_ERROR")
                                    <td>{{$progres_pjb->id}}</td>
                                    <td>ERROR</td>
                                    <td>ERROR</td>
                                    <td>ERROR</td>
                                    <td>ERROR</td>
                                    <td align="right">ERROR</td>
                                    <td>ERROR</td>
                                @else
                                    <td>{{$progres_pjb->id}}</td>
                                    <td>{{$progres_pjb->tahun_anggaran}}</td>
                                    <td>
                                        @if($progres_pjb->triwulan==1) I 
                                        @elseif($progres_pjb->triwulan==2) II 
                                        @elseif($progres_pjb->triwulan==3) III 
                                        @else IV
                                        @endif                                                                                                
                                    </td>
                                    <td>{{$progres_pjb->satuan_kerja}}</td>
                                    <td>{{$progres_pjb->nama_dipa}}</td>
                                    <td>{{$progres_pjb->tanggal_dipa}}</td>
                                    <td class="status_{{$progres_pjb->status}}">{{$progres_pjb->status}}</td>
                                @endif     
                                    <td class="text-right">
                                        <a class="btn btn-xs btn-primary" href="{{ route('progres_pjbs.show', $progres_pjb->id) }}"><i class="glyphicon glyphicon-eye-open"></i> Tampilkan</a>
                                        @if($progres_pjb->user_id == Auth::user()->id && $progres_pjb->status != 'FINAL')
                                        <a class="btn btn-xs btn-warning" href="{{ route('progres_pjbs.edit', $progres_pjb->id) }}"><i class="glyphicon glyphicon-edit"></i> Ubah</a>
                                        <form action="{{ route('progres_pjbs.destroy', $progres_pjb->id) }}" method="POST" style="display: inline;" onsubmit="if(confirm('Hapus secara permanen data ini?')) { return true } else {return false };">
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

