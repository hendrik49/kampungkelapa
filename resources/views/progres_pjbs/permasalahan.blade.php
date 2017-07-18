@include('layouts.header')

<style type="text/css">
    
    ul.JSFORMLIST li {
        padding: 15px 0;
        border-top: 1px solid #DDD;
    }    
    
</style>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Permasalahan Pada Progres Pengadaan Barang dan Jasa Tahun {{ $progres_pjb->tahun_anggaran }} Triwulan {{ $progres_pjb->triwulan}}
        </h1>
    </section>
    <!-- Main content -->
    <section class="content">

        <div id="details">

            <ul class="collection JSFORMLIST" data-field="data.permasalahan" style="list-style: none; padding-left: 0;">
                <li>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-6">
                                    Kelompok: 
                                    <input name="permasalahan.kelompok" class="form-control"/> 
                                </div>
                                <div class="col-md-6">
                                    &nbsp;<br/>
                                    <button class="delete btn btn-danger btn-xs"><i class="glyphicon glyphicon-remove"></i> Hapus</button>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    Penyebab:<br/>
                                    <input name="permasalahan.penyebab" class="form-control"/>
                                </div>
                                <div class="col-md-6">
                                    Rekomendasi:<br/>
                                    <input name="permasalahan.rekomendasi" class="form-control"/>                                    
                                </div>
                            </div>           
                            <div class="row">
                                <div class="col-md-6">
                                    Penjelasan Penyebab:<br/>
                                    <textarea name="permasalahan.penyebab_penjelasan" class="form-control"></textarea>
                                </div>
                                <div class="col-md-6">
                                    Penjelasan Rekomendasi:<br/>
                                    <textarea name="permasalahan.rekomendasi_penjelasan" class="form-control"></textarea>
                                </div>
                            </div>                               
                        </div>
                    </div>
                </li>
            </ul>

            <form action="{{ url('progres_pjbs/permasalahan', $progres_pjb->id) }}" method="post" id="permasalahan_submit_form">
                
                <button type="button" class="add btn btn-success" data-field="data.permasalahan"><i class="glyphicon glyphicon-plus"></i> Tambah</button>
                
                <input type="hidden" name="_token" value="{{ csrf_token() }}">                
                <textarea id="POST_BODY" name="POST_BODY" style="display: none;"></textarea>
                <button type="submit" class="btn btn-primary">Simpan</button>
                
            </form>
            
            <a class="btn btn-link pull-right" href="{{ url('progres_pjbs', $progres_pjb->id) }}"><i class="glyphicon glyphicon-backward"></i>  Kembali</a>
            
        </div>
        
    </section>
    <!-- /.content -->
</div>

@include('layouts.footer') 

<script src="{{ asset('assets/dist/js/jquery.jsForm.js') }}"></script>

<script type="text/javascript">

var jsonData = {
    permasalahan: {!!$permasalahan!!}
};

$(document).ready(function() {
    $("#details").jsForm({
        data: jsonData
    }); 
});

$('#permasalahan_submit_form').submit(function (e) {
   
   $('#POST_BODY').val(JSON.stringify($("#details").jsForm("get")));
   $(this).submit();
   
});

</script>

</body>
</html>