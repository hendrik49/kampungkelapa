@include('layouts.header')

<div class="content-wrapper">

    <section class="content-header">
        <div class="page-header">
            <h1><i class="glyphicon glyphicon-plus"></i> Tambahkan Data Tenggat Waktu </h1>
        </div>
    </section>

    <section class="content">

        <div class="row">
            <div class="col-md-12">

                <form action="{{ route('deadlines.store') }}" method="POST">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                    <div class="form-group @if($errors->has('tahun_anggaran')) has-error @endif">
                        <label for="tahun_anggaran-field">Tahun</label>
                        <input type="text" id="tahun_anggaran-field" name="tahun_anggaran" class="form-control" value="{{ $tahun }}" readonly/>
                        @if($errors->has("tahun_anggaran"))
                        <span class="help-block">{{ $errors->first("tahun_anggaran") }}</span>
                        @endif
                    </div>
                    <div class="form-group @if($errors->has('triwulan_1')) has-error @endif">
                        <label for="triwulan_1-field">Tenggat Waktu Triwulan I</label>
                        <input type="text" id="triwulan_1-field" name="triwulan_1" class="form-control date-picker" value="{{ old("triwulan_1") }}" data-date-format="dd-mm-yyyy" data-date-viewmode="years"/>
                        @if($errors->has("triwulan_1"))
                        <span class="help-block">{{ $errors->first("triwulan_1") }}</span>
                        @endif
                    </div>
                    <div class="form-group @if($errors->has('triwulan_2')) has-error @endif">
                        <label for="triwulan_2-field">Tenggat Waktu Triwulan II</label>
                        <input type="text" id="triwulan_2-field" name="triwulan_2" class="form-control date-picker" value="{{ old("triwulan_2") }}" data-date-format="dd-mm-yyyy" data-date-viewmode="years"/>
                        @if($errors->has("triwulan_2"))
                        <span class="help-block">{{ $errors->first("triwulan_2") }}</span>
                        @endif
                    </div>
                    <div class="form-group @if($errors->has('triwulan_3')) has-error @endif">
                        <label for="triwulan_3-field">Tenggat Waktu Triwulan III</label>
                        <input type="text" id="triwulan_3-field" name="triwulan_3" class="form-control date-picker" value="{{ old("triwulan_3") }}" data-date-format="dd-mm-yyyy" data-date-viewmode="years"/>
                        @if($errors->has("triwulan_3"))
                        <span class="help-block">{{ $errors->first("triwulan_3") }}</span>
                        @endif
                    </div>
                    <div class="form-group @if($errors->has('triwulan_4')) has-error @endif">
                        <label for="triwulan_4-field">Tenggat Waktu Triwulan IV</label>
                        <input type="text" id="triwulan_4-field" name="triwulan_4" class="form-control date-picker" value="{{ old("triwulan_4") }}" data-date-format="dd-mm-yyyy" data-date-viewmode="years"/>
                        @if($errors->has("triwulan_4"))
                        <span class="help-block">{{ $errors->first("triwulan_4") }}</span>
                        @endif
                    </div>
                    <div class="well well-sm">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <a class="btn btn-link pull-right" href="{{ route('deadlines.index') }}"><i class="glyphicon glyphicon-backward"></i> Kembali</a>
                    </div>
                </form>

            </div>
        </div>
    </section>

</div>    

@include('layouts.footer') 

</body>
</html>
