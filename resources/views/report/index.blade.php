@include('layouts.header')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Unduh Laporan Anggaran
        </h1>
    </section>

    <section class="content">

        <div class="row">
            <div class="col-md-12">

                <form action="" method="POST">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                    <div class="form-group">
                        <label for="satker-field">Satuan Kerja</label>
                        <select class="form-control" id="satker-field" name="nama">
                            <option value="0" selected>Seluruh Satuan Kerja</option>
                            <optgroup label="Pilih">
                                @foreach ($satker as $u)
                                <option value="{{$u->id}}">{{$u->name}}</option>
                                @endforeach
                            </optgroup>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="triwu-field">Triwulan</label>
                        <select class="form-control" id="triwu-field" name="triwulan">                    
                            @foreach ($triwu as $s => $t)
                            <option value="{{$s}}" @if($s==$currTriwu) selected @endif>Triwulan {{$t}}</option> 
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="tahun_anggaran-field">Tahun Anggaran</label>
                        <input type="number" id="tahun_anggaran-field" name="tahun_anggaran" class="form-control" value="{{ date("Y") }}"/>
                    </div>

                    <div class="form-group">
                        <label for="encrypt-field">
                            <input type="checkbox" id="encrypt-field" name="encrypt" checked="checked"/>
                            Kunci file dengan password akun
                        </label>                        
                        
                    </div>                    
                    
                    <div class="well well-sm">
                        <button type="button" class="btn btn-primary" onclick="downloadReport('excel');">Unduh (Excel)</button>
                        <button type="button" class="btn btn-primary" onclick="downloadReport('pdf');">Unduh (PDF)</button>
                    </div>
                </form>

            </div>
        </div>
    </section>
    
    <script type="text/javascript">
    function downloadReport(format) {
        var satker = $('#satker-field').val();
        var tahun = $('#tahun_anggaran-field').val();
        var triwulan = $('#triwu-field').val();
        var encrypt = $('#encrypt-field').is(':checked');
        
        var route = "{{ url('/report') }}";
        var dl = route + '/' + format + '/' + satker + '/' + tahun + '/' + triwulan + '/' + encrypt;
        console.log("Navigate to " + dl);
        
        window.location = dl;
    }
    </script>
    <!-- /.content -->
</div>
@include('layouts.footer') 
</body>
</html>
