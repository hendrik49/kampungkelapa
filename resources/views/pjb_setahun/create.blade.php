@include('layouts.header')
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Membuat
        <small><i class="glyphicon glyphicon-edit"></i> Paket dan Nilai Pengadaan Barang dan Jasa Setahun</small>
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
            <form action="{{ route('pjb_setahun.store') }}" method="POST">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="form-group @if($errors->has('id')) has-error @endif">
                    <div class="form-group @if($errors->has('tahun')) has-error @endif">
                       <label for="name-field">Tahun</label>
                    <input type="number" id="tahun-field" name="tahun" class="form-control" />
                       @if($errors->has("tahun"))
                        <span class="help-block">{{ $errors->first("tahun") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('jumlah_paket')) has-error @endif">
                       <label for="jumlah_paket-field">Jumlah</label>
                    <input type="number" id="jumlah_paket-field" name="jumlah_paket" class="form-control" />
                       @if($errors->has("jumlah_paket"))
                        <span class="help-block">{{ $errors->first("jumlah_paket") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('nilai_paket')) has-error @endif">
                       <label for="nilai_paket-field">Nilai</label>
                    <input type="text" id="nilai_paket-field" name="nilai_paket" class="form-control money" />
                       @if($errors->has("nilai_paket"))
                        <span class="help-block">{{ $errors->first("nilai_paket") }}</span>
                       @endif
                    </div>
                <div class="well well-sm">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a class="btn btn-link pull-right" href="{{ route('pjb_setahun.index') }}"><i class="glyphicon glyphicon-backward"></i> Kembali</a>
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
