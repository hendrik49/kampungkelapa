<!DOCTYPE html>
<html>
@include('layouts.header')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Dasbor
        <small>Panel kendali (Tahun {{ date('Y')}})</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Beranda</a></li>
        <li class="active">Dasbor</li>
      </ol>
    </section>
      <!-- Main content -->
    <section class="content">                
      <div class="row">
          <div class="col-md-6">
            <!-- Line chart -->
            <div class="box box-primary">
              <div class="box-header with-border">
                <i class="fa fa-bar-chart-o"></i>

                <h3 class="box-title">Pohon Kelapa Produktif dan Non Produktif</h3>

                <div class="box-tools pull-right">
                  <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                </div>
              </div>
              <div class="box-body">
                <canvas id="line-chart" style="min-height: 300px;"></canvas>
              </div>
              <!-- /.box-body-->
            </div>
            <!-- /.box -->
            <!-- Bar chart -->
            <div class="box box-primary">
              <div class="box-header with-border">
                <i class="fa fa-bar-chart-o"></i>

                <h3 class="box-title">Peruntukan Kelapa - Buah, Nira, Bibit</h3>

                <div class="box-tools pull-right">
                  <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                </div>
              </div>
              <div class="box-body">
                <div class="chart">
                  <canvas id="barChart" style="min-height:300px"></canvas>
                </div>
              </div>
              <!-- /.box-body-->
            </div>
            
            <!-- /.box -->
         </div>      
          <div class="col-md-6">
            <!-- Line chart -->
            <div class="box box-primary">
              <div class="box-header with-border">
                <i class="fa fa-bar-chart-o"></i>

                <h3 class="box-title">Pohon Per Kecamatan</h3>

                <div class="box-tools pull-right">
                  <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                </div>
              </div>
              <div class="box-body">
                <div id="donut-chart" style="min-height: 300px;"></div>
              </div>
              <!-- /.box-body-->
            </div>
            <!-- /.box -->
            <!-- Bar chart -->
            <div class="box box-primary">
              <div class="box-header with-border">
                <i class="fa fa-bar-chart-o"></i>

                <h3 class="box-title">Kinerja PPL Per Kecamatan</h3>

                <div class="box-tools pull-right">
                  <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                </div>
              </div>
              <div class="box-body">
                <div class="chart">
                  <div canvas="donut-setahun-nilai" style="min-height:300px"></canvas>
                </div>
              </div>
              <!-- /.box-body-->
            </div>
            <!-- /.box -->
         </div>      

      </div>
      </div>
      <!--
      <div class="row">
        <div class="col-md-6">
            <div class="box box-primary">
              <div class="box-header with-border">
                <i class="fa fa-bar-chart-o"></i>

                <h3 class="box-title">Realisasi dan Rencana Per Jenis Belanja</h3>

                <div class="box-tools pull-right">
                  <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                </div>
              </div>
              <div class="box-body">
                <canvas id="donut-perjenis" style="height: 300px;"></div>
              </div>
            </div>
          <div class="col-md-6">
            <div class="box box-primary">
              <div class="box-header with-border">
                <i class="fa fa-bar-chart-o"></i>

                <h3 class="box-title">Realisasi vs Rencana</h3>

                <div class="box-tools pull-right">
                  <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                </div>
              </div>
              <div class="box-body">
                <div id="donut-setahun" style="height: 300px;"></div>
              </div>
            </div>
            -->
        </div>      
      </div>
        <!-- /.col -->
    </section>
    <!-- /.content -->
  </div>
@include('layouts.footer') 
@include('layouts.chartdashboard')
</body>
</html>

