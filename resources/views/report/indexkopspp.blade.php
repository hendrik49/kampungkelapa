@include('layouts.header')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Unduh Laporan Kop & SPP
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
                            @foreach ($satker as $u)
                            <option value="{{$u->id}}">{{$u->name}}</option>
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
        var encrypt = $('#encrypt-field').is(':checked');
        
        var route;
        if (format == 'excel')
            route = "{{ url('/report_kop_spp_excel') }}";
        else if (format == 'pdf')
            route = "{{ url('/report_kop_spp_pdf') }}";
        
        var dl = route + '/' + satker + '/' + tahun + '/' + encrypt;
        console.log("Navigate to " + dl);
        
        window.location = dl;
    }
    </script>
    <!-- /.content -->
</div>
@include('layouts.footer') 
</body>
</html>
