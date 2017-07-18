@include('layouts.header')

<style type="text/css">
    
    .status_BELUM {
        background-color: #FF5E5E;
        color: #FF5E5E;    
    }
    .status_DRAFT {
        background-color: #FFCB28;
        color: #FFCB28;        
    }
    .status_FINAL {
        background-color: #2EDE22;
        color: #2EDE22;        
    }
    .status_pengisian_table th {
        vertical-align: top !important;
        text-align: center;
        background-color: #666;
        color: #fff;
    }    

    
</style>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Status Pengisian Data per Satuan Kerja ({{$tahun}})
        </h1>
    </section>
    <!-- Main content -->
    <section class="content">            
        <div class="row">
            <div class="col-md-12">
                
                <div class="well">
                    <div class="row">
                        <div class="col-md-3">
                            <form action="" method="GET" id="form_status_tahun">
                                <div class="form-group">
                                    <label for="tahun_anggaran-field">Tahun</label>
                                    <select name="tahun" class="form-control" onchange="$('#form_status_tahun').submit()">
                                        <option value="{{$tahun_now  }}" @if($tahun==$tahun_now  ) selected @endif>{{$tahun_now  }}</option>
                                        <option value="{{$tahun_now-1}}" @if($tahun==$tahun_now-1) selected @endif>{{$tahun_now-1}}</option>
                                        <option value="{{$tahun_now-2}}" @if($tahun==$tahun_now-2) selected @endif>{{$tahun_now-2}}</option>
                                    </select>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-9">
                            <label for="">Keterangan</label> <br/>
                            <div class="status_BELUM" style="display: inline-block; width: 120px; height: 25px; text-align: center; color: #333 !important;">Belum mengisi</div>
                            <div class="status_DRAFT" style="display: inline-block; width: 120px; height: 25px; text-align: center; color: #333 !important;">Status draft</div>
                            <div class="status_FINAL" style="display: inline-block; width: 120px; height: 25px; text-align: center; color: #333 !important;">Status final</div>                            
                        </div>
                    </div>
                </div>
                                
                @if($users->count())
                <table class="table table-condensed table-striped table-bordered status_pengisian_table">
                    <thead>
                        <tr>
                            <th rowspan="2">ID</th>
                            <th rowspan="2">SATUAN KERJA</th>
                            <th rowspan="2">RENCANA</th>
                            <th colspan="4">REALISASI (Triwulan)</th>
                            <th colspan="4">PROGRES (Triwulan)</th>
                        </tr>
                        <tr>
                            <th>1</th>
                            <th>2</th>
                            <th>3</th>
                            <th>4</th>
                            <th>1</th>
                            <th>2</th>
                            <th>3</th>
                            <th>4</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($users as $u)
                        <tr>
                            <td>{{$u->id}}</td>
                            <td>{{$u->name}}</td>
                            <td class="status_{{$u->status['rencana']}}">{{$u->status['rencana']}}</td>
                            <td class="status_{{$u->status['realisasi'][1]}}">{{$u->status['realisasi'][1]}}</td>
                            <td class="status_{{$u->status['realisasi'][2]}}">{{$u->status['realisasi'][2]}}</td>
                            <td class="status_{{$u->status['realisasi'][3]}}">{{$u->status['realisasi'][3]}}</td>
                            <td class="status_{{$u->status['realisasi'][4]}}">{{$u->status['realisasi'][4]}}</td>
                            <td class="status_{{$u->status['progres'][1]}}">{{$u->status['progres'][1]}}</td>
                            <td class="status_{{$u->status['progres'][2]}}">{{$u->status['progres'][2]}}</td>
                            <td class="status_{{$u->status['progres'][3]}}">{{$u->status['progres'][3]}}</td>
                            <td class="status_{{$u->status['progres'][4]}}">{{$u->status['progres'][4]}}</td>
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
//        $(".table").DataTable({
//            "oLanguage": {
//                "sSearch": "Pencarian: ",
//                "sLengthMenu": "Tampilkan _MENU_ baris",
//                "sInfo": "Menampilkan total _TOTAL_ baris (_START_ s.d _END_)",
//                "oPaginate": {
//                    "sFirst": "Pertama",
//                    "sNext": "Selanjutnya",
//                    "sPrevious": "Sebelumnya"
//                }
//            }
//        });
    });
</script>
</body>
</html>

