@include('layouts.header')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="page-header clearfix">
            <h1>
                <i class="glyphicon glyphicon-align-justify"></i> Rencana Anggaran Pra-DIPA
            </h1>
        </div>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="alert alert-warning">
            <strong>Kesalahan: </strong><br/>
            {!!$message!!}
        </div>
    </section>
    <!-- /.content -->
</div>

@include('layouts.footer') 

</body>
</html>