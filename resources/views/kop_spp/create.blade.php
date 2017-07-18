@include('layouts.header')
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Membuat
        <small><i class="glyphicon glyphicon-edit"></i> KOP dan Surat Perintah Pembayaran (SPP)</small>
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
            <form action="{{ route('kop_spp.store') }}" method="POST">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="col-md-6">
                <div class="form-group @if($errors->has('id')) has-error @endif">
                     <div class="form-group @if($errors->has('id_anggaran')) has-error @endif">
                       <label for="id_anggaran-field">No DIPA</label>
                       <select class="form-control" id="id_anggaran-field" name="id_anggaran">                    
                        @foreach ($penyerapan_anggaran_target_pjbs as $dipa)
                            <option value="{{$dipa->id}}">{{$dipa->nama_dipa}} - (Rencana PJB Rp {{ number_format($dipa->total_anggaran,2)}})</option>
                        @endforeach
                        </select>
                       @if($errors->has("id_anggaran"))
                        <span class="help-block">{{ $errors->first("id_anggaran") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('jenis')) has-error @endif">
                       <label for="triwulan-field">Jenis</label>
                        <select class="form-control" id="jenis-field" name="jenis">                    
                            <option value="">Pilih Jenis</option>
                            <option value="m">Modal</option>
                            <option value="b">Barang</option>
                            <option value="l">Lainnya</option>
                        </select>                       
                       @if($errors->has("jenis"))
                        <span class="help-block">{{ $errors->first("jenis") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('satuan_kerja')) has-error @endif">
                       <label for="satuan_kerja-field">Satuan Kerja</label>
                        <input type="text" id="satuan_kerja-field" name="satuan_kerja" class="form-control" value="{{ $user->name }}" readonly>
                       @if($errors->has("satuan_kerja"))
                        <span class="help-block">{{ $errors->first("satuan_kerja") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('kategori_uraian')) has-error @endif">
                       <label for="kategori_uraian-field">Kategori Uraian</label>
                    <input type="text" id="kategori_uraian-field" name="kategori_uraian" class="form-control" value="{{ old("kategori_uraian") }}"/>
                       @if($errors->has("kategori_uraian"))
                        <span class="help-block">{{ $errors->first("kategori_uraian") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('no_kop')) has-error @endif">
                       <label for="no_kop-field">No KOP</label>
                    <input type="text" id="no_kop-field" name="no_kop" class="form-control" value="{{ old("no_kop") }}"/>
                       @if($errors->has("no_kop"))
                        <span class="help-block">{{ $errors->first("no_kop") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('uraian_kop')) has-error @endif">
                       <label for="uraian_kop-field">Uraian KOP</label>
                    <input type="text" id="uraian_kop-field" name="uraian_kop" class="form-control" value="{{ old("uraian_kop") }}"/>
                       @if($errors->has("uraian_kop"))
                        <span class="help-block">{{ $errors->first("uraian_kop") }}</span>
                       @endif
                    </div>

                    <div class="form-group @if($errors->has('tgl_kop')) has-error @endif">
                       <label for="tgl_kop-field">Tanggal KOP</label>
                       <input type="text" id="tgl_kop-field" name="tgl_kop" class="form-control date dpYears" value="{{ old("tgl_kop") }}" data-date-format="dd-mm-yyyy" data-date-viewmode="years">
                       @if($errors->has("tgl_kop"))
                        <span class="help-block">{{ $errors->first("tgl_kop") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('nilai_kop')) has-error @endif">
                       <label for="nilai_kop-field">Nilai Kop</label>
                    <input type="text" id="nilai_kop-field" name="nilai_kop"  class="form-control money"  value="{{ old("nilai_kop") }}"/>
                       @if($errors->has("nilai_kop"))
                        <span class="help-block">{{ $errors->first("nilai_kop") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('no_kontrak')) has-error @endif">
                       <label for="no_kontrak-field">No kontrak/SPK</label>
                    <input type="text" id="no_kontrak-field" name="no_kontrak" class="form-control" value="{{ old("no_kontrak") }}"/>
                       @if($errors->has("no_kontrak"))
                        <span class="help-block">{{ $errors->first("no_kontrak") }}</span>
                       @endif
                    </div>

                    <div class="form-group @if($errors->has('tgl_kontrak')) has-error @endif">
                       <label for="tgl_kontrak-field">Tanggal kontrak</label>
                       <input type="text" id="tgl_kontrak-field" name="tgl_kontrak" class="form-control date dpYears" value="{{ old("tgl_kontrak") }}" data-date-format="dd-mm-yyyy" data-date-viewmode="years">
                       @if($errors->has("tgl_kontrak"))
                        <span class="help-block">{{ $errors->first("tgl_kontrak") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('nilai_kontrak')) has-error @endif">
                       <label for="nilai_kontrak-field">Nilai Kontrak</label>
                    <input type="text" id="nilai_kontrak-field" name="nilai_kontrak"  class="form-control money"  value="{{ old("nilai_kontrak") }}"/>
                       @if($errors->has("nilai_kontrak"))
                        <span class="help-block">{{ $errors->first("nilai_kontrak") }}</span>
                       @endif
                    </div>
                </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group @if($errors->has('no_bap')) has-error @endif">
                       <label for="no_bap-field">NO Berita Acara Pemeriksaan (BAP)</label>
                    <input type="text" id="no_bap-field" name="no_bap" class="form-control" value="{{ old("no_bap") }}"/>
                       @if($errors->has("no_bap"))
                        <span class="help-block">{{ $errors->first("no_bap") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('tgl_bap')) has-error @endif">
                       <label for="tgl_bap-field">Tanggal Berita Acara Pemeriksaan (BAP)</label>
                       <input type="text" id="tgl_bap-field" name="tgl_bap" class="form-control date dpYears" value="{{ old("tgl_bap") }}" data-date-format="dd-mm-yyyy" data-date-viewmode="years">
                       @if($errors->has("tgl_bap"))
                        <span class="help-block">{{ $errors->first("tgl_bap") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('no_bast')) has-error @endif">
                       <label for="no_bast-field">No Berita Acara Serah Terima (BAST)</label>
                    <input type="text" id="no_bast-field" name="no_bast" class="form-control" value="{{ old("no_bast") }}"/>
                       @if($errors->has("no_bast"))
                        <span class="help-block">{{ $errors->first("no_bast") }}</span>
                       @endif
                    </div>

                    <div class="form-group @if($errors->has('tgl_bast')) has-error @endif">
                       <label for="tgl_bast-field">Tanggal Berita Acara Serah Terima (BAST)</label>
                       <input type="text" id="tgl_bast-field" name="tgl_bast" class="form-control date dpYears" value="{{ old("tgl_bast") }}" data-date-format="dd-mm-yyyy" data-date-viewmode="years">
                       @if($errors->has("tgl_bast"))
                        <span class="help-block">{{ $errors->first("tgl_bast") }}</span>
                       @endif
                    </div>

                    <div class="form-group @if($errors->has('no_spp')) has-error @endif">
                       <label for="no_spp-field">No Surat Perintah Pembayaran (SPP)</label>
                    <input type="text" id="no_spp-field" name="no_spp" class="form-control" value="{{ old("no_spp") }}"/>
                       @if($errors->has("no_spp"))
                        <span class="help-block">{{ $errors->first("no_spp") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('uraian_spp')) has-error @endif">
                       <label for="no_spp-field">Uraian Surat Perintah Pembayaran (SPP)</label>
                    <input type="text" id="uraian_spp-field" name="uraian_spp" class="form-control" value="{{ old("uraian_spp") }}"/>
                       @if($errors->has("uraian_spp"))
                        <span class="help-block">{{ $errors->first("uraian_spp") }}</span>
                       @endif
                    </div>

                    <div class="form-group @if($errors->has('tgl_spp')) has-error @endif">
                       <label for="tgl_spp-field">Tanggal Surat Perintah Pembayaran (SPP)</label>
                       <input type="text" id="tgl_spp-field" name="tgl_spp" class="form-control date dpYears" value="{{ old("tgl_spp") }}" data-date-format="dd-mm-yyyy" data-date-viewmode="years">
                       @if($errors->has("tgl_spp"))
                        <span class="help-block">{{ $errors->first("tgl_spp") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('nilai_spp')) has-error @endif">
                       <label for="nilai_spp-field">Nilai Surat Perintah Pembayaran (SPP)</label>
                    <input type="text" id="nilai_spp-field" name="nilai_spp"  class="form-control money"  value="{{ old("nilai_spp") }}"/>
                       @if($errors->has("nilai_spp"))
                        <span class="help-block">{{ $errors->first("nilai_spp") }}</span>
                       @endif
                    </div>
                <div class="well well-sm">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a class="btn btn-link pull-right" href="{{ route('penyerapan_anggaran_target_pjbs.index') }}"><i class="glyphicon glyphicon-backward"></i> Kembali</a>
                </div>
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
