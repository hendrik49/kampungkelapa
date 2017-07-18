@include('layouts.header')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Click
        <small>Year</small>
      </h1>
    </section>
      <!-- Main content -->
    <section class="content">
      
      <div class="row">
        <div class="col-md-12">
          <!-- Bar chart -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <i class="fa fa-bar-chart-o"></i>

              <h3 class="box-title">Click and Impressions</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <div class="box-body">
              <div id="line-chart" style="height: 300px;"></div>
            </div>
            <!-- /.box-body-->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
        <div class="col-md-12">
          <!-- Install Table -->
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Data Table Install-Year</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
            @if($master_datas->count())
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>Id</th>
                    <th>IMEI</th>
                    <th>Created at</th>
                    <th>Updated at</th>
                    <th>Click</th>
                    <th>View</th>
                    <th>Type Device</th>
                    <th>Language</th>
                    <th>State</th>
                    <th>Regional</th>
                  </tr>
                </thead>
                <tbody>
                @foreach($master_datas as $master_datum)
                    <tr>
                        <td>{{$master_datum->id}}</td>
                        <td>{{$master_datum->imei}}</td>
                        <td>{{$master_datum->created_at}}</td>
                        <td>{{$master_datum->updated_at}}</td>
                        <td>{{$master_datum->click}}</td>
                        <td>{{$master_datum->view}}</td>
                        <td>{{$master_datum->type_device}}</td>
                        <td>{{$master_datum->language}}</td>
                        <td>{{$master_datum->state}}</td>
                        <td>{{$master_datum->regional}}</td>
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
    $("#example1").DataTable();
  });
</script>
@include('page.click-js.clickchart-year')
</body>
</html>

