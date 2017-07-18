@include('layouts.header')
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Menampilkan No DIPA: {{$realisasi_anggaran_target_pjb->nama_dipa}} Triwulan @if($realisasi_anggaran_target_pjb->triwulan==1) I @elseif($realisasi_anggaran_target_pjb->triwulan==2) II @elseif($realisasi_anggaran_target_pjb->triwulan==3) III @else IV @endif                                
       </h1>
    </section>
    <section class="content">
        @include('error')
        @if(Session::has('message'))
           <p class="alert {{ Session::get('alert-class', 'alert-danger') }}">{{ Session::get('message') }}</p>
        @elseif(Session::has('message2'))
           <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message2') }}</p>
        @endif
        <div class="row">
            <div class="col-md-6">
                <div class="page-header">
                    <form action="{{ route('realisasi_anggaran_target_pjbs.destroy', $realisasi_anggaran_target_pjb->id) }}" method="POST" style="display: inline;" onsubmit="if(confirm('Delete? Are you sure?')) { return true } else {return false };">
                        <small>Realisasi Anggaran Triwulan (Rp) </small>
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="btn-group pull-right" role="group" aria-label="...">
                            @if($penyerapan_anggaran_target_pjb->user_id == Auth::user()->id && $realisasi_anggaran_target_pjb->status != 'FINAL')
                            <a class="btn btn-warning btn-group" role="group" href="{{ url('realisasi_triwulan_berjalan', $realisasi_anggaran_target_pjb->id) }}"><i class="glyphicon glyphicon-edit"></i> Ubah</a>
                            @endif
                        </div>
                    </form>
                </div>
                <form class="well well-sm" action="#">
                    <div class="form-group">
                        <div class="row">
                                <label class="col-xs-7" for="total_anggaran">TAHUN</label>
                                <p class="col-xs-5">{{ $realisasi_anggaran_target_pjb->tahun_anggaran }}</p>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                                <label class="col-xs-7" for="total_anggaran">TOTAL ANGGARAN BELANJA</label>
                                <p class="col-xs-5">Rp {{ number_format($realisasi_anggaran_triwulan_berjalan->total_anggaran,2) }}</p>
                        </div>
                    </div>
                        <div class="form-group">
                            <div class="row">
                                <label class="col-xs-7" for="tahun_anggaran">BELANJA BARANG</label>
                                <p class="col-xs-5">Rp {{number_format($realisasi_anggaran_triwulan_berjalan->belanja_barang, 2)}}</p>
                            </div>
                    </div>
                        <div class="form-group">
                        <div class="row">
                            <label class="col-xs-7" for="triwulan">BELANJA MODAL</label>
                            <p class="col-xs-5">Rp {{number_format($realisasi_anggaran_triwulan_berjalan->belanja_modal,2)}}</p>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-xs-7" for="triwulan">BELANJA LAINNYA (Pegawai/Hibah)</label>
                            <p class="col-xs-5">Rp {{number_format($realisasi_anggaran_triwulan_berjalan->belanja_lainnya,2)}}</p>
                        </div>
                    </div>

                </form>
            </div>
            <div class="col-md-6">
                <div class="page-header">
                    <form action="{{ route('realisasi_anggaran_target_pjbs.destroy', $realisasi_anggaran_target_pjb->id) }}" method="POST" style="display: inline;" onsubmit="if(confirm('Delete? Are you sure?')) { return true } else {return false };">
                        <small>Target Penyerapan Setahun (Rp) </small>
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="btn-group pull-right" role="group" aria-label="...">
                        </div>
                    </form>
                </div>
                <form class="well well-sm" action="#">
                    <div class="form-group">
                        <div class="row">
                                <label class="col-xs-7" for="total_anggaran">TAHUN</label>
                                <p class="col-xs-5">{{ $penyerapan_anggaran_target_pjb->tahun_anggaran }}</p>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                                <label class="col-xs-7" for="total_anggaran">TOTAL ANGGARAN BELANJA</label>
                                <p class="col-xs-5">Rp {{ number_format($penyerapan_anggaran->total_anggaran,2) }}</p>
                        </div>
                    </div>
                        <div class="form-group">
                            <div class="row">
                                <label class="col-xs-7" for="tahun_anggaran">BELANJA BARANG</label>
                                <p class="col-xs-5">Rp {{number_format($penyerapan_anggaran->belanja_barang, 2)}}</p>
                            </div>
                    </div>
                        <div class="form-group">
                        <div class="row">
                            <label class="col-xs-7" for="triwulan">BELANJA MODAL</label>
                            <p class="col-xs-5">Rp {{number_format($penyerapan_anggaran->belanja_modal,2)}}</p>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-xs-7" for="triwulan">BELANJA LAINNYA (Pegawai/Hibah)</label>
                            <p class="col-xs-5">Rp {{number_format($penyerapan_anggaran->belanja_lainnya,2)}}</p>
                        </div>
                    </div>

                </form>
            </div>

        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="page-header">
                    <form action="{{ route('realisasi_anggaran_target_pjbs.destroy', $realisasi_anggaran_target_pjb->id) }}" method="POST" style="display: inline;" onsubmit="if(confirm('Delete? Are you sure?')) { return true } else {return false };">
                        <small>Realisasi Anggaran s.d. Triwulan @if($month==1) I @elseif($month==2) II @elseif($month==3) III @else IV @endif</small><small>(Rp)</small>
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="btn-group pull-right" role="group" aria-label="...">
                        </div>
                    </form>
                </div>
                <form class="well well-sm" action="#">
                    <div class="form-group">
                        <div class="row">
                                <label class="col-xs-6" for="total_anggaran">TAHUN</label>
                                <p class="col-xs-6">{{ $realisasi_anggaran_target_pjb->tahun_anggaran }}</p>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                                <label class="col-xs-6" for="total_anggaran">TOTAL ANGGARAN BELANJA</label>
                                <p class="col-xs-6">Rp {{ number_format($realisasi_triwulan->total_anggaran,2) }} ({{ number_format($realisasi_triwulan->p_total_anggaran *100,2) }} %) </p>
                        </div>
                    </div>
                        <div class="form-group">
                            <div class="row">
                                <label class="col-xs-6" for="tahun_anggaran">BELANJA BARANG</label>
                                <p class="col-xs-6">Rp {{number_format($realisasi_triwulan->belanja_barang, 2)}} ({{ number_format($realisasi_triwulan->p_belanja_barang*100,2) }} %)</p>
                            </div>
                    </div>
                        <div class="form-group">
                        <div class="row">
                            <label class="col-xs-6" for="triwulan">BELANJA MODAL</label>
                            <p class="col-xs-6">Rp {{number_format($realisasi_triwulan->belanja_modal,2)}}  ({{number_format($realisasi_triwulan->p_belanja_modal*100,2)}} %) </p>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-xs-6" for="triwulan">BELANJA LAINNYA (Pegawai/Hibah)</label>
                            <p class="col-xs-6">Rp {{number_format($realisasi_triwulan->belanja_lainnya,2)}} ({{number_format($realisasi_triwulan->p_belanja_lainnya*100,2)}} %)</p>
                        </div>
                    </div>

                </form>
            </div>
            <div class="col-md-6">
                <div class="page-header">
                    <form action="{{ route('realisasi_anggaran_target_pjbs.destroy', $realisasi_anggaran_target_pjb->id) }}" method="POST" style="display: inline;" onsubmit="if(confirm('Delete? Are you sure?')) { return true } else {return false };">
                        <small>Rencana Penyerapan s.d. Triwulan @if($month==1) I @elseif($month==2) II @elseif($month==3) III @else IV @endif</small><small>(Rp)</small>
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="btn-group pull-right" role="group" aria-label="...">
                        </div>
                    </form>
                </div>
                <form class="well well-sm" action="#">
                    <div class="form-group">
                        <div class="row">
                                <label class="col-xs-7" for="total_anggaran">TAHUN</label>
                                <p class="col-xs-5">{{ 	$penyerapan_anggaran_target_pjb->tahun_anggaran }}</p>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                                <label class="col-xs-7" for="total_anggaran">TOTAL ANGGARAN BELANJA</label>
                                <p class="col-xs-5">Rp {{ number_format($rencana_triwulan->p_total_anggaran,2) }}</p>
                        </div>
                    </div>
                        <div class="form-group">
                            <div class="row">
                                <label class="col-xs-7" for="tahun_anggaran">BELANJA BARANG</label>
                                <p class="col-xs-5">Rp {{number_format($rencana_triwulan->p_belanja_barang, 2)}}</p>
                            </div>
                    </div>
                        <div class="form-group">
                        <div class="row">
                            <label class="col-xs-7" for="triwulan">BELANJA MODAL</label>
                            <p class="col-xs-5">Rp {{number_format($rencana_triwulan->p_belanja_modal,2)}}</p>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-xs-7" for="triwulan">BELANJA LAINNYA (Pegawai/Hibah)</label>
                            <p class="col-xs-5">Rp {{number_format($rencana_triwulan->p_belanja_lainnya,2)}}</p>
                        </div>
                    </div>

                </form>
            </div>

        </div>
        
        <div class="row">
            <div class="col-md-12">
                
                <div class="page-header">
                    <form style="display: inline;">
                        <small>Penyebab dan Rekomendasi Atas Permasalahan</small>
                        <div class="btn-group pull-right" role="group" aria-label="...">
                            @if($realisasi_anggaran_target_pjb->user_id == Auth::user()->id && $realisasi_anggaran_target_pjb->status != 'FINAL')
                            <a class="btn btn-warning btn-group" role="group" href="{{ url('realisasi_anggaran_target_pjbs/permasalahan', $realisasi_anggaran_target_pjb->id) }}"><i class="glyphicon glyphicon-edit"></i> Ubah</a>
                            @endif
                        </div>
                    </form>
                </div>
                
                <form class="well well-sm" action="#">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Penyebab</th>
                                <th>Rekomendasi</th>
                            </tr>
                        </thead>
                        <tbody>
                        @if(count($realisasi_anggaran_target_pjb->permasalahan) == 0)
                            <tr>
                                <td colspan="3">(Tidak ada data)</td>
                            </tr>
                        @else
                        @foreach($realisasi_anggaran_target_pjb->permasalahan as $i => $p)
                            <tr>
                                <td>
                                    {{ ++$i }}
                                </td>
                                <td>
                                    <strong>Penyebab pada tahap {{$p->kelompok}}</strong>:<br/>
                                    <p>{{$p->penyebab}}</p><br/>
                                    
                                    <strong>Penjelasan atas penyebab di atas</strong>:<br/>
                                    <p>{{$p->penyebab_penjelasan}}</p><br/>
                                </td>
                                <td>
                                    <strong>Rekomendasi pada tahap {{$p->kelompok}}</strong>:<br/>
                                    <p>{{$p->rekomendasi}}</p><br/>
                                    
                                    <strong>Penjelasan atas rekomendasi di atas</strong>:<br/>
                                    <p>{{$p->rekomendasi_penjelasan}}</p><br/>                                    
                                </td>
                            </tr>
                        @endforeach
                        @endif
                        </tbody>
                    </table>                    
                </form>
                
                
            </div>
        </div>

        </section>
    <!-- /.content -->
  </div>
  @include('layouts.footer') 
</body>
</html>
