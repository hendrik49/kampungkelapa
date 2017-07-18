@include('layouts.header')
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Membuat
        <small><i class="glyphicon glyphicon-edit"></i> Penyerapan Anggaran dan Pengadaan Barang dan Jasa</small>
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

            <form action="{{ route('penyerapan_anggaran_target_pjbs.store') }}" method="POST">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                <div class="form-group @if($errors->has('id')) has-error @endif">
                    <div class="form-group @if($errors->has('tahun_anggaran')) has-error @endif">
                       <label for="tahun_anggaran-field">Tahun Anggaran</label>
                    <input type="number" id="tahun_anggaran-field" name="tahun_anggaran" class="form-control" value="{{ old("tahun_anggaran") }}"/>
                       @if($errors->has("tahun_anggaran"))
                        <span class="help-block">{{ $errors->first("tahun_anggaran") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('jenis')) has-error @endif">
                       <label for="triwulan-field">Jenis</label>
                        <select class="form-control" id="jenis-field" name="jenis">                    
                            <option value="">Pilih Jenis</option>
                            <option value="p">Pusat</option>
                            <option value="d">Daerah</option>
                        </select>                       
                       @if($errors->has("pusat"))
                        <span class="help-block">{{ $errors->first("pusat") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('satuan_kerja')) has-error @endif">
                       <label for="satuan_kerja-field">Satuan Kerja</label>
                        <input type="text" id="satuan_kerja-field" name="satuan_kerja" class="form-control" value="{{ $user->name }}" readonly>
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
                       <label for="nama_dipa-field">No DIPA</label>
                    <input type="text" id="nama_dipa-field" name="nama_dipa" class="form-control" value="{{ old("nama_dipa") }}"/>
                       @if($errors->has("nama_dipa"))
                        <span class="help-block">{{ $errors->first("nama_dipa") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('tanggal_dipa')) has-error @endif">
                       <label for="tanggal_dipa-field">Tanggal DIPA</label>
                       <input type="text" id="dpYears" name="tanggal_dipa" class="form-control date dpYears" value="{{ old("tanggal_dipa") }}" data-date-format="dd-mm-yyyy" data-date-viewmode="years">
                       @if($errors->has("tanggal_dipa"))
                        <span class="help-block">{{ $errors->first("tanggal_dipa") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('total_anggaran')) has-error @endif">
                       <label for="total_anggaran-field">Total Anggaran</label>
                    <input type="text" id="total_anggaran-field" name="total_anggaran"  class="form-control money"  value="{{ old("total_anggaran") }}"/>
                       @if($errors->has("total_anggaran"))
                        <span class="help-block">{{ $errors->first("total_anggaran") }}</span>
                       @endif
                    </div>
                <div class="well well-sm">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a class="btn btn-link pull-right" href="{{ route('penyerapan_anggaran_target_pjbs.index') }}"><i class="glyphicon glyphicon-backward"></i> Kembali</a>
                </div>
            </form>

        </div>
    </div>
</section>
    <!-- /.content -->
  </div>
@include('layouts.footer') 
</body>
</html>
