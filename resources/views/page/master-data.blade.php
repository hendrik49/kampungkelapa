@include('layouts.header')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Data
        <small>Pengguna</small>
      </h1>
    </section>
      <!-- Main content -->
    <section class="content">
      
      <div class="row">
        <!-- /.col -->
        <div class="col-md-12">
          <!-- Install Table -->
          <div class="box">
            <div class="box-body">
            @if($master_datas->count())
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>Id</th>
                    <th>Nama</th>
                    <th>e-Mail</th>
                    <th>Waktu pembuatan</th>
                    <th>Waktu perbaharuan</th>
                  </tr>
                </thead>
                <tbody>
                @foreach($master_datas as $master_datum)
                    <tr>
                        <td>{{$master_datum->id}}</td>
                        <td>{{$master_datum->name}}</td>
                        <td>{{$master_datum->email}}</td>
                        <td>{{$master_datum->created_at}}</td>
                        <td>{{$master_datum->updated_at}}</td>
                        </td>
                    </tr>
                @endforeach
                </tbody>
              </table>
              {!! $master_datas->render() !!}
            @else
                <h3 class="text-center alert alert-info">Empty!</h3>
            @endif  
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
@include('layouts.footer') 
<script>
  $(function () {
    $("#example1").DataTable({
      "oLanguage": {
         "sSearch": "Pencarian: ",
          "sLengthMenu": "Tampilkan _MENU_ baris",
          "sInfo": "Menampilkan total _TOTAL_ baris (_START_ s.d _END_)",
          "oPaginate": {
          "sFirst": "Pertama",
          "sNext": "Selanjutnya",
          "sPrevious": "Sebelumnya"
          }        
       }   
    });
  });
</script>
</body>
</html>

