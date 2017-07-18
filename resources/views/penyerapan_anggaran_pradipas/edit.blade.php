@include('layouts.header')
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Ubah No DIPA: {{$penyerapan_anggaran_pradipa->nama_dipa}}
        <small><i class="glyphicon glyphicon-edit"></i> Penyerapan Anggaran Pra-DIPA</small>
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

            <form action="{{ route('penyerapan_anggaran_pradipas.update', $penyerapan_anggaran_pradipa->id) }}" method="POST">
                <input type="hidden" name="_method" value="PUT">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                    <div class="form-group @if($errors->has('tahun_anggaran')) has-error @endif">
                       <label for="tahun_anggaran-field">Tahun Anggaran</label>
                    <input type="number" id="tahun_anggaran-field" name="tahun_anggaran" class="form-control" value="{{ is_null(old("tahun_anggaran")) ? $penyerapan_anggaran_pradipa->tahun_anggaran : old("tahun_anggaran") }}"/>
                       @if($errors->has("tahun_anggaran"))
                        <span class="help-block">{{ $errors->first("tahun_anggaran") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('jenis')) has-error @endif">
                       <label for="triwulan-field">Jenis</label>
                        <select class="form-control" id="jenis-field" name="jenis">                    
                            <option value="">Pilih Jenis</option>
                            <option value="p" @if($penyerapan_anggaran_pradipa->jenis == 'p') selected @endif>Pusat</option>
                            <option value="d" @if($penyerapan_anggaran_pradipa->jenis == 'd') selected @endif>Daerah</option>
                        </select>                       
                       @if($errors->has("pusat"))
                        <span class="help-block">{{ $errors->first("pusat") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('satuan_kerja')) has-error @endif">
                       <label for="satuan_kerja-field">Satuan Kerja</label>
                       <input type="text" id="satuan_kerja-field" name="satuan_kerja" class="form-control" value="{{$penyerapan_anggaran_pradipa->satuan_kerja}}" readonly>
                        <!--
                        <select class="form-control select2" id="satuankerja-field" name="satuan_kerja" style="width: 100%;">                    
                            <option value="">Pilih Satuan Kerja</option>
                            <option value="Kasum TNI">Kasum TNI</option>
                            <option value="Itjen TNI">Itjen TNI</option>
                            <option value="Sahli Panglima TNI">Sahli Panglima TNI</option>
                            <option value="Pom TNI">Pom TNI</option>
                            <option value="Srenum TNI">Srenum TNI</option>
                            <option value="Sintel TNI">Sintel TNI</option>
                            <option value="Sops TNI">Sops TNI</option>
                            <option value="Spers TNI">Spers TNI</option>
                            <option value="Slog TNI">Slog TNI</option>
                            <option value="Skomlek TNI">Skomlek TNI</option>
                            <option value="Ster TNI">Ster TNI</option>
                            <option value="Satkomlek TNI">Satkomlek TNI</option>
                            <option value="Setum TNI">Setum TNI</option>
                            <option value="Denma Mabes TNI">Denma Mabes TNI</option>
                            <option value="Kohanudnas TNI">Kohanudnas TNI</option>
                            <option value="Sesko TNI">Sesko TNI</option>
                            <option value="Kodiklat TNI">Kodiklat TNI</option>
                            <option value="Mako Akademi TNI">Mako Akademi TNI</option>
                            <option value="Basis TNI">Basis TNI</option>
                            <option value="Paspampres">Pom TNI</option>
                            <option value="Babinkum TNI">Babinkum TNI</option>
                            <option value="Puspen TNI">Puspen TNI</option>
                            <option value="Babek TNI">Babek TNI</option>
                            <option value="Pusbintal TNI">Pusbintal TNI</option>
                            <option value="Pusku TNI">Pusku TNI</option>
                            <option value="Pusjarah TNI">Pusjarah TNI</option>
                            <option value="Pusinfolahta TNI">Pusinfolahta TNI</option>
                            <option value="Puskersin TNI">Puskersin TNI</option>
                            <option value="Pusjiantra TNI">Pusjiantra TNI</option>
                            <option value="Kogartaf I/Jkt">Kogartaf I/Jkt</option>
                            <option value="Kogartaf II/Bdg">Kogartaf II/Bdg</option>
                            <option value="Kogartaf III/Sby">Kogartaf III/Sby</option>
                            <option value="Pusjaspermildas">Pusjaspermildas</option>
                        </select>                       
                        -->
                       @if($errors->has("satuan_kerja"))
                        <span class="help-block">{{ $errors->first("satuan_kerja") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('nama_dipa')) has-error @endif">
                       <label for="nama_dipa-field">No Dipa</label>
                    <input type="text" id="nama_dipa-field" name="nama_dipa" class="form-control" value="{{ is_null(old("nama_dipa")) ? $penyerapan_anggaran_pradipa->nama_dipa : old("nama_dipa") }}"/>
                       @if($errors->has("nama_dipa"))
                        <span class="help-block">{{ $errors->first("nama_dipa") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('tanggal_dipa')) has-error @endif">
                       <label for="tanggal_dipa-field">Tanggal Dipa</label>
                       <input type="text" id="dpYears" name="tanggal_dipa" class="form-control date dpYears" value="{{ Carbon\Carbon::parse($penyerapan_anggaran_pradipa->tanggal_dipa)->format('d-m-Y') }}" data-date-format="dd-mm-yyyy" data-date-viewmode="years">
                       @if($errors->has("tanggal_dipa"))
                        <span class="help-block">{{ $errors->first("tanggal_dipa") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('total_anggaran')) has-error @endif">
                       <label for="total_anggaran-field">Total Anggaran</label>
                    <input type="text" id="total_anggaran-field" name="total_anggaran" class="form-control money" value="{{ is_null(old("total_anggaran")) ? number_format($penyerapan_anggaran_pradipa->total_anggaran) : old("total_anggaran") }}"/>
                       @if($errors->has("total_anggaran"))
                        <span class="help-block">{{ $errors->first("total_anggaran") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('status')) has-error @endif">
                       <label for="status-field">Status</label>
                       <select id="status-field" name="status" class="form-control">
                            <option value="DRAFT" @if($penyerapan_anggaran_pradipa->status == 'DRAFT') selected @endif>DRAFT</option>
                            <option value="FINAL" @if($penyerapan_anggaran_pradipa->status == 'FINAL') selected @endif>FINAL</option>
                       </select>
                       @if($errors->has("status"))
                        <span class="help-block">{{ $errors->first("status") }}</span>
                       @endif
                    </div>
                <div class="well well-sm">
                    <a class="btn btn-link pull-right" href="{{ route('penyerapan_anggaran_pradipas.index') }}"><i class="glyphicon glyphicon-backward"></i>  Kembali</a>
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
