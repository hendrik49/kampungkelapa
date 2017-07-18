@include('layouts.header')
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Ubah Triwulan {{$realisasi->triwulan}}
        <small>Realisasi Triwulan Berjalan</small>
       </h1>
    </section>

    <section class="content">
    @include('error')
    <div class="row">
        <div class="col-md-6">
            <form action="{{ url('realisasi_triwulan_update', $realisasi_triwulan_berjalan->id) }}" method="POST">
                <input type="hidden" name="_method" value="POST">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="form-group @if($errors->has('tahun_anggaran')) has-error @endif">
                       <label for="tahun_anggaran-field">Tahun (Hanya baca)</label>
                       <input type="text" readom id="tahun_anggaran-field" name="tahun_anggaran" class="form-control" value="{{ is_null(old("tahun_anggaran")) ? $realisasi->tahun_anggaran : old("tahun_anggaran") }}"  readonly/>
                       @if($errors->has("tahun_anggaran"))
                        <span class="help-block">{{ $errors->first("tahun_anggaran") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('total_anggaran')) has-error @endif">
                       <label for="total_anggaran-field">Anggaran Total (Hanya baca)</label>
                       <input type="text" readom id="total_anggaran-field" name="total_anggaran" class="form-control" value="{{ is_null(old("total_anggaran")) ? number_format($realisasi_triwulan_berjalan->total_anggaran,2) : old("total_anggaran") }}"  readonly/>
                       @if($errors->has("total_anggaran"))
                        <span class="help-block">{{ $errors->first("total_anggaran") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('belanja_barang')) has-error @endif">
                       <label for="belanja_barang-field">Belanja Barang</label>
                    <input type="text" id="belanja_barang-field" name="realisasi_barang" class="form-control money" value="{{ is_null(old("belanja_barang")) ? $realisasi_triwulan_berjalan->belanja_barang : old("belanja_barang") }}"/>
                       @if($errors->has("belanja_barang"))
                        <span class="help-block">{{ $errors->first("belanja_barang") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('belanja_modal')) has-error @endif">
                       <label for="belanja_modal-field">Belanja Modal</label>
                    <input type="text" id="belanja_modal-field" name="realisasi_modal" class="form-control money" value="{{ is_null(old("belanja_modal")) ? $realisasi_triwulan_berjalan->belanja_modal : old("belanja_modal") }}" @if($pjb->jenis == 'd') title="DIPA daerah tidak bisa mengisi belanja modal" readonly @endif/>
                       @if($errors->has("belanja_modal"))
                        <span class="help-block">{{ $errors->first("belanja_modal") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('belanja_lainnya')) has-error @endif">
                       <label for="belanja_lainnya-field">Belanja Lainnya (Pegawai/Hibah)</label>
                    <input type="text" id="belanja_lainnya-field" name="realisasi_lainnya" class="form-control money" value="{{ is_null(old("belanja_lainnya")) ? $realisasi_triwulan_berjalan->belanja_lainnya : old("belanja_lainnya") }}"/>
                       @if($errors->has("belanja_lainnya"))
                        <span class="help-block">{{ $errors->first("belanja_lainnya") }}</span>
                       @endif
                    </div>

                <div class="well well-sm">
                    <a class="btn btn-link pull-right" href="{{ route('realisasi_anggaran_target_pjbs.index') }}"><i class="glyphicon glyphicon-backward"></i>  Kembali</a>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>

        </div>
                <div class="col-md-6">
            <form action="{{ url('realisasi_triwulan_update', $realisasi_triwulan_berjalan->id) }}" method="POST">
                <input type="hidden" name="_method" value="POST">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="form-group @if($errors->has('tahun_anggaran')) has-error @endif">
                       <label for="tahun_anggaran-field">No DIPA</label>
                       <input type="text" readom id="tahun_anggaran-field" name="tahun_anggaran" class="form-control" value="{{ $pjb->nama_dipa }}"  readonly/>
                       @if($errors->has("tahun_anggaran"))
                        <span class="help-block">{{ $errors->first("tahun_anggaran") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('total_anggaran')) has-error @endif">
                       <label for="total_anggaran-field">Anggaran Triwulan  {{$realisasi->triwulan}} (Hanya baca)</label>
                       <input type="text" readom id="total_anggaran-field" name="total_anggaran" class="form-control" value="{{ number_format($realisasi_triwulan->total_anggaran,2) }}"  readonly/>
                       @if($errors->has("total_anggaran"))
                        <span class="help-block">{{ $errors->first("total_anggaran") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('belanja_barang')) has-error @endif">
                       <label for="belanja_barang-field">Belanja Barang</label>
                    <input type="text" id="belanja_barang-field" name="realisasi_barang" class="form-control" value="{{ number_format($realisasi_triwulan->belanja_barang,2) }}" readonly/>
                       @if($errors->has("belanja_barang"))
                        <span class="help-block">{{ $errors->first("belanja_barang") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('belanja_modal')) has-error @endif">
                       <label for="belanja_modal-field"> Belanja Modal </label>
                    <input type="text" id="belanja_modal-field" name="realisasi_modal" class="form-control" value="{{ number_format($realisasi_triwulan->belanja_modal,2) }}" readonly>
                       @if($errors->has("belanja_modal"))
                        <span class="help-block">{{ $errors->first("belanja_modal") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('belanja_lainnya')) has-error @endif">
                       <label for="belanja_lainnya-field"> Belanja Lainnya (Pegawai/Hibah)</label>
                    <input type="text" id="belanja_lainnya-field" name="realisasi_lainnya" class="form-control" value="{{ number_format($realisasi_triwulan->belanja_lainnya,2) }}" readonly/>
                       @if($errors->has("belanja_lainnya"))
                        <span class="help-block">{{ $errors->first("belanja_lainnya") }}</span>
                       @endif
                    </div>

            </form>

        </div>

    </div>
 </div>
    </section>
    <!-- /.content -->
  </div>
@include('layouts.footer') 
</body>
</html>
