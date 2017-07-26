@include('layouts.header')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
    <div class="page-header">
        <h1><i class="glyphicon glyphicon-edit"></i> Authorize Area / Membuat</h1>
    </div>
    </section>
      <!-- Main content -->
    <section class="content">
    @include('error')
    <div class="row">
        <div class="col-md-12">
            <form action="{{ route('unit_area.store') }}" method="POST">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="form-group @if($errors->has('user_id')) has-error @endif">
                       <label for="user_id-field">Pengguna</label>
                        <select class="form-control select2" id="user_id-field" name="user_id">                    
                        @foreach ($users as $u)
                            <option value="{{$u->user_id}}">{{ $u->full_name }}</option>
                        @endforeach
                        </select>                       
                       @if($errors->has("user_id"))
                        <span class="help-block">{{ $errors->first("user_id") }}</span>
                       @endif
                    </div>
                    <div class="form-group @if($errors->has('zone')) has-error @endif">
                       <label for="user_id-field">Zone</label>
                        <select class="form-control select2" id="zone-field" name="zone">                    
                            <option value="province">Provinsi</option>
                            <option value="regency">Kabupaten</option>
                            <option value="district">Kecamatan</option>
                        </select>                       
                       @if($errors->has("zona"))
                        <span class="help-block">{{ $errors->first("zona") }}</span>
                       @endif
                    </div>
    
                    <div id="provinsi" class="form-group @if($errors->has('zone_ids')) has-error @endif">
                       <label for="user_id-field">Provinsi</label>
                        <select class="form-control select2" id="zona_ids-field" name="zone_ids">                    
                        @foreach ($province as $u)
                            <option value="{{$u->id}}">{{ $u->name }}</option>
                        @endforeach
                        </select>                       
                       @if($errors->has("zone_ids"))
                        <span class="help-block">{{ $errors->first("zone_ids") }}</span>
                       @endif
                    </div>
                    <div id="kabupaten" class="form-group @if($errors->has('zone_ids')) has-error @endif">
                       <label for="user_id-field">Kabupaten</label>
                        <select class="form-control select2" id="zona_ids-field" name="zone_ids">                    
                        @foreach ($regency as $u)
                            <option value="{{$u->id}}">{{ $u->name }}</option>
                        @endforeach
                        </select>                       
                       @if($errors->has("zone_ids"))
                        <span class="help-block">{{ $errors->first("zone_ids") }}</span>
                       @endif
                    </div>
                    <div id="kecamatan" class="form-group @if($errors->has('zone_ids')) has-error @endif">
                       <label for="user_id-field">Kecamatan</label>
                        <select class="form-control select2" id="zona_ids-field" name="zone_ids">                    
                        @foreach ($district as $u)
                            <option value="{{$u->id}}">{{ $u->name }}</option>
                        @endforeach
                        </select>                       
                       @if($errors->has("zone_ids"))
                        <span class="help-block">{{ $errors->first("zone_ids") }}</span>
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
<script>
  $(function () {
            
            $("#provinsi").hide();
            $("#kabupaten").hide();
            $("#kecamatan").hide();

            var level;
            $("#zone-field").change(function (){
                level = $(this).val();
                if(level=="province"){
                    $("#provinsi").show();
                    $("#kabupaten").hide();
                    $("#kecamatan").hide();
                }
                else if(level=="regency"){
                    $("#provinsi").hide();
                    $("#kabupaten").show();
                    $("#kecamatan").hide();
                }else if(level=="district"){
                    $("#provinsi").hide();
                    $("#kabupaten").hide();
                    $("#kecamatan").show();
                }
 
            });

  });
</script>
</body>
</html>
