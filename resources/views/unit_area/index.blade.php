@include('layouts.header')
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
    <div class="page-header clearfix">
        <h1>
            <i class="glyphicon glyphicon-align-justify"></i> Area Authorize
            <a class="btn btn-success pull-right" href="{{ route('unit_area.create') }}"><i class="glyphicon glyphicon-plus"></i> Tambah</a>
        </h1>

    </div>
    </section>
      <!-- Main content -->
    <section class="content">    
    @include('error')
    @if(Session::has('message2'))
       <p class="alert {{ Session::get('alert-class', 'alert-danger') }}">{{ Session::get('message2') }}</p>
    @elseif(Session::has('message'))
       <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
    @endif        

    <div class="row">
        <div class="col-md-12">
            @if($users->count())
                <table class="table table-condensed table-striped">
                    <thead>
                        <tr>
                        <th>ID</th>
                        <th>FULL NAME</th>
                        <th>ZONA</th>
                        <th>ZONA IDS</th>
                        <th class="text-right">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($users as $master_datum)
                    <tr>
                    <td>{{$master_datum->id}}</td>
                    <td>{{$master_datum->user->full_name}}</td>
                    <td align="center">{{$master_datum->zone}}</td>
                    <td align="right">{{$master_datum->zone_ids}}</td>
                    <td class="text-right">
                        <a class="btn btn-xs btn-warning" href="{{ route('unit_area.edit', $master_datum->id) }}"><i class="glyphicon glyphicon-edit"></i> Ubah</a>
                        <form action="{{ route('unit_area.destroy', $master_datum->id) }}" method="POST" style="display: inline;" onsubmit="if(confirm('Delete? Are you sure?')) { return true } else {return false };">
                            <input type="hidden" name="_method" value="DELETE">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <button type="submit" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-trash"></i> Hapus</button>
                        </form>
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

