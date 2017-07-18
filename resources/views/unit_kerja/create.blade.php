@include('layouts.header')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
    <div class="page-header">
        <h1><i class="glyphicon glyphicon-edit"></i> Pengguna / Membuat</h1>
    </div>
    </section>
      <!-- Main content -->
    <section class="content">
    @include('error')
    <div class="row">
        <div class="col-md-12">

            <form action="{{ route('unit_kerja.store') }}" method="POST">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="form-group @if($errors->has('id')) has-error @endif">
                    <div class="form-group @if($errors->has('name')) has-error @endif">
                       <label for="name-field">Nama</label>
                    <input type="text" id="name-field" name="name" class="form-control" />
                       @if($errors->has("name"))
                        <span class="help-block">{{ $errors->first("name") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('email')) has-error @endif">
                       <label for="click-field">Email</label>
                    <input type="text" id="email-field" name="email" class="form-control" />
                       @if($errors->has("email"))
                        <span class="help-block">{{ $errors->first("email") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('password')) has-error @endif">
                       <label for="view-field">Password</label>
                    <input type="password" id="view-field" name="password" class="form-control" />
                       @if($errors->has("password"))
                        <span class="help-block">{{ $errors->first("password") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('copassword')) has-error @endif">
                       <label for="view-field">Confirm Password</label>
                    <input type="password" id="view-field" name="copassword" class="form-control"/>
                       @if($errors->has("copassword"))
                        <span class="help-block">{{ $errors->first("copassword") }}</span>
                       @endif
                    </div>
                <div class="well well-sm">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a class="btn btn-link pull-right" href="{{ route('unit_kerja.index') }}"><i class="glyphicon glyphicon-backward"></i> Kembali</a>
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
