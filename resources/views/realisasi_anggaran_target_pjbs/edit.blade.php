@include('layouts.header')
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Ubah No DIPA {{$realisasi_anggaran_target_pjb->nama_dipa}}
        <small><i class="glyphicon glyphicon-edit"></i> Realisasi Anggaran Pengadaan Barang dan Jasa</small>
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
        <div class="col-md-12">

            <form action="{{ route('realisasi_anggaran_target_pjbs.update', $realisasi_anggaran_target_pjb->id) }}" method="POST">
                <input type="hidden" name="_method" value="PUT">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="form-group @if($errors->has('triwulan')) has-error @endif">
                       <label for="triwulan-field">Triwulan</label>
                        <select class="form-control" id="triwulan-field" name="triwulan">                    
                            <option value="">Pilih Triwulan</option>
                            <option value="1" @if($realisasi_anggaran_target_pjb->triwulan == '1') selected @endif>I</option>
                            <option value="2" @if($realisasi_anggaran_target_pjb->triwulan == '2') selected @endif>II</option>
                            <option value="3" @if($realisasi_anggaran_target_pjb->triwulan == '3') selected @endif>III</option>
                            <option value="4" @if($realisasi_anggaran_target_pjb->triwulan == '4') selected @endif>IV</option>
                        </select>                       
                       @if($errors->has("triwulan"))
                        <span class="help-block">{{ $errors->first("triwulan") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('satuan_kerja')) has-error @endif">
                       <label for="satuan_kerja-field">Satuan Kerja</label>
                      <input type="text" id="satuan_kerja-field" name="satuan_kerja" class="form-control" value="{{ $user->name }}" readonly>
                       @if($errors->has("satuan_kerja"))
                        <span class="help-block">{{ $errors->first("satuan_kerja") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('nama_dipa')) has-error @endif">
                       <label for="nama_dipa-field">No Dipa</label>
                       <select class="form-control" id="nama_dipa-field" name="nama_dipa">                    
                        @foreach ($penyerapan_anggaran_target_pjbs as $dipa)
                            <option value="{{$dipa->id}}" @if($realisasi_anggaran_target_pjb->id_pjb == $dipa->id) selected @endif>{{$dipa->nama_dipa}} - (Rencana PJB Rp {{ number_format($dipa->total_anggaran,2)}})</option>
                        @endforeach
                        </select>
                       @if($errors->has("nama_dipa"))
                        <span class="help-block">{{ $errors->first("nama_dipa") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('tanggal_dipa')) has-error @endif">
                       <label for="tanggal_dipa-field">Tanggal</label>
                       <input type="text" id="dpYears" name="tanggal_dipa" class="form-control date dpYears" value="{{ $realisasi_anggaran_target_pjb->tanggal_dipa }}" data-date-format="dd-mm-yyyy" data-date-viewmode="years">
                       @if($errors->has("tanggal_dipa"))
                        <span class="help-block">{{ $errors->first("tanggal_dipa") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('total_anggaran')) has-error @endif">
                       <label for="total_anggaran-field">Total Anggaran </label>
                    <input type="text" id="total_anggaran-field" name="total_anggaran" class="form-control money" value="{{ is_null(old("total_anggaran")) ? number_format($realisasi_anggaran_target_pjb->total_anggaran) : old("total_anggaran") }}"/>
                       @if($errors->has("total_anggaran"))
                        <span class="help-block">{{ $errors->first("total_anggaran") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('status')) has-error @endif">
                       <label for="status-field">Status</label>
                       <select id="status-field" name="status" class="form-control">
                            <option value="DRAFT" @if($realisasi_anggaran_target_pjb->status == 'DRAFT') selected @endif>DRAFT</option>
                            <option value="FINAL" @if($realisasi_anggaran_target_pjb->status == 'FINAL') selected @endif>FINAL</option>
                       </select>
                       @if($errors->has("status"))
                        <span class="help-block">{{ $errors->first("status") }}</span>
                       @endif
                    </div>
                <div class="well well-sm">
                    <a class="btn btn-link pull-right" href="{{ route('realisasi_anggaran_target_pjbs.index') }}"><i class="glyphicon glyphicon-backward"></i>  Kembali</a>
                    <button type="submit" class="btn btn-primary">Simpan</button>
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
