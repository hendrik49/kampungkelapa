@include('layouts.header')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <i class="glyphicon glyphicon-edit"></i> Ubah Progres Pengadaan Barang dan Jasa
        </h1>
    </section>

    <section class="content">
        @include('error')
        @if(Session::has('message'))
           <p class="alert {{ Session::get('alert-class', 'alert-danger') }}">{{ Session::get('message') }}</p>
        @elseif(Session::has('message2'))
           <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message2') }}</p>
        @endif
        <form action="{{ route('progres_pjbs.update', $progres_pjb->id) }}" method="POST">
            <div class="row">
                <input type="hidden" name="_method" value="PUT">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="col-md-6">           
                    <div class="form-group @if($errors->has('nama_dipa')) has-error @endif">
                        <label for="tahun_anggaran-field">ID Pengadaan Barang dan Jasa Setahun</label>
                        <input type="text" id="nama_dipa-field" name="nama_dipa_view" class="form-control" value="{{ $penyerapan_anggaran_setahun_pjb->id }}" readonly>
                        <input type="hidden" id="nama_dipa-field" name="nama_dipa" class="form-control" value="{{ $progres_pjb->id_anggaran }}" readonly>
                        @if($errors->has("nama_dipa"))
                        <span class="help-block">{{ $errors->first("nama_dipa") }}</span>
                        @endif
                    </div>
                    <div class="form-group @if($errors->has('satuan_kerja')) has-error @endif">
                        <label for="satuan_kerja-field">Satuan Kerja</label>
                        <input type="text" id="satuan_kerja-field" name="satuan_kerja" class="form-control" value="{{ $user->name }}" readonly>
                        @if($errors->has("satuan_kerja"))
                        <span class="help-block">{{ $errors->first("satuan_kerja") }}</span>
                        @endif
                    </div>
                    <div class="form-group @if($errors->has('triwulan')) has-error @endif">
                        <label for="triwulan-field">Triwulan</label>
                        <select class="form-control" id="triwulan-field" name="triwulan">                    
                            <option value="">Pilih Triwulan</option>
                            <option value="1" @if($progres_pjb->triwulan == "1") selected @endif>Triwulan I</option>
                            <option value="2" @if($progres_pjb->triwulan == "2") selected @endif>Triwulan II</option>
                            <option value="3" @if($progres_pjb->triwulan == "3") selected @endif>Triwulan III</option>
                            <option value="4" @if($progres_pjb->triwulan == "4") selected @endif>Triwulan IV</option>
                        </select>                       

                        @if($errors->has("triwulan"))
                        <span class="help-block">{{ $errors->first("triwulan") }}</span>
                        @endif
                    </div>
                    <div class="form-group @if($errors->has('tanggal_dipa')) has-error @endif">
                        <label for="tanggal_dipa-field">Tanggal</label>
                        <input type="text" id="dpYears" name="tanggal_dipa" class="form-control date dpYears" value="{{ $progres_pjb->tanggal_dipa}}" data-date-format="dd-mm-yyyy" data-date-viewmode="years">
                        @if($errors->has("tanggal_dipa"))
                        <span class="help-block">{{ $errors->first("tanggal_dipa") }}</span>
                        @endif
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group @if($errors->has('jumlah_paket_belum_dilelang')) has-error @endif">
                                <label for="jumlah_paket-field">Belum dilelang (Jumlah Paket) </label>
                                <input type="text" id="jumlah_paket_belum_dilelang-field" name="jumlah_paket_belum_dilelang"  class="form-control money"  value="{{ $progres_pjb->jumlah_paket_belum_dilelang}}"/>
                                @if($errors->has("jumlah_paket_belum_dilelang"))
                                <span class="help-block">{{ $errors->first("jumlah_paket_belum_dilelang") }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">                
                            <div class="form-group @if($errors->has('nilai_pjb_belum_dilelang')) has-error @endif">
                                <label for="nilai_pjb-field">Nilai PBJ (Rp)</label>
                                <input type="text" id="nilai_pjb_dilelang-field" name="nilai_pjb_belum_dilelang" class="form-control money" value="{{ $progres_pjb->nilai_pjb_belum_dilelang}}"/>
                                @if($errors->has("nilai_pjb_belum_realisasi"))
                                <span class="help-block">{{ $errors->first("nilai_pjb_belum_dilelang") }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group @if($errors->has('jumlah_paket_pemenang')) has-error @endif">
                                <label for="jumlah_paket-field">Ada Pemenang (Jumlah Paket) </label>
                                <input type="text" id="jumlah_paket_pemenang-field" name="jumlah_paket_pemenang"  class="form-control money"  value="{{ $progres_pjb->jumlah_paket_pemenang}}"/>
                                @if($errors->has("jumlah_paket_pemenang"))
                                <span class="help-block">{{ $errors->first("jumlah_paket_pemenang") }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group @if($errors->has('nilai_pjb_pemenang')) has-error @endif">
                                <label for="nilai_pjb-field">Nilai PBJ (Rp)</label>
                                <input type="text" id="nilai_pjb_pemenang-field" name="nilai_pjb_pemenang" class="form-control money" value="{{ $progres_pjb->nilai_pjb_pemenang}}"/>
                                @if($errors->has("nilai_pjb_pemenang"))
                                <span class="help-block">{{ $errors->first("nilai_pjb_pemenang") }}</span>
                                @endif
                            </div>           
                        </div>
                    </div>         
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group @if($errors->has('jumlah_paket_belum_realisasi')) has-error @endif">
                                <label for="jumlah_paket-field">Belum Realisasi (Jumlah Paket) </label>
                                <input type="text" id="jumlah_paket_belum_realisasi-field" name="jumlah_paket_belum_realisasi"  class="form-control money"  value="{{ $progres_pjb->jumlah_paket_belum_realisasi}}"/>
                                @if($errors->has("jumlah_paket_belum_realisasi"))
                                <span class="help-block">{{ $errors->first("jumlah_paket_belum_realisasi") }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group @if($errors->has('nilai_pjb_belum_realisasi')) has-error @endif">
                                <label for="nilai_pjb-field">Nilai PBJ (Rp)</label>
                                <input type="text" id="nilai_pjb_belum_realisasi-field" name="nilai_pjb_belum_realisasi" class="form-control money" value="{{ $progres_pjb->nilai_pjb_belum_realisasi}}"/>
                                @if($errors->has("nilai_pjb_belum_realisasi"))
                                <span class="help-block">{{ $errors->first("nilai_pjb_belum_realisasi") }}</span>
                                @endif
                            </div>           
                        </div>
                    </div>
                    <div class="form-group @if($errors->has('status')) has-error @endif">
                       <label for="status-field">Status</label>
                       <select id="status-field" name="status" class="form-control">
                            <option value="DRAFT" @if($progres_pjb->status == 'DRAFT') selected @endif>DRAFT</option>
                            <option value="FINAL" @if($progres_pjb->status == 'FINAL') selected @endif>FINAL</option>
                       </select>
                       @if($errors->has("status"))
                        <span class="help-block">{{ $errors->first("status") }}</span>
                       @endif
                    </div>                                        
                </div>
                <div class="col-md-6">           
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group @if($errors->has('jumlah_paket_level1')) has-error @endif">
                                <label for="jumlah_paket-field">Realisasi 1 - 25% (Jumlah Paket) </label>
                                <input type="text" id="jumlah_paket_level1-field" name="jumlah_paket_level1"  class="form-control money"  value="{{ $progres_pjb->jumlah_paket_level1}}"/>
                                @if($errors->has("jumlah_paket"))
                                <span class="help-block">{{ $errors->first("jumlah_paket") }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group @if($errors->has('nilai_pjb_level1')) has-error @endif">
                                <label for="nilai_pjb-field">Nilai PBJ (Rp)</label>
                                <input type="text" id="nilai_pjb_level1-field" name="nilai_pjb_level1" class="form-control money" value="{{ $progres_pjb->nilai_pjb_level1}}"/>
                                @if($errors->has("nilai_pjb_level1"))
                                <span class="help-block">{{ $errors->first("nilai_pjb_level1") }}</span>
                                @endif
                            </div>           
                        </div>
                    </div>    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group @if($errors->has('jumlah_paket_level2')) has-error @endif">
                                <label for="jumlah_paket-field">Realisasi 26 - 50% (Jumlah Paket) </label>
                                <input type="text" id="jumlah_paket_level2-field" name="jumlah_paket_level2"  class="form-control money"  value="{{ $progres_pjb->jumlah_paket_level2}}"/>
                                @if($errors->has("jumlah_paket_level2"))
                                <span class="help-block">{{ $errors->first("jumlah_paket_level2") }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group @if($errors->has('nilai_pjb_level2')) has-error @endif">
                                <label for="nilai_pjb-field">Nilai PBJ (Rp)</label>
                                <input type="text" id="nilai_pjb_level2-field" name="nilai_pjb_level2" class="form-control money" value="{{ $progres_pjb->nilai_pjb_level2}}"/>
                                @if($errors->has("nilai_pjb_level2"))
                                <span class="help-block">{{ $errors->first("nilai_pjb_level2") }}</span>
                                @endif
                            </div>           
                        </div>
                    </div>              
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group @if($errors->has('jumlah_paket_level3')) has-error @endif">
                                <label for="jumlah_paket-field">Realisasi 51 - 75% (Jumlah Paket) </label>
                                <input type="text" id="jumlah_paket_level3-field" name="jumlah_paket_level3"  class="form-control money"  value="{{ $progres_pjb->jumlah_paket_level3}}"/>
                                @if($errors->has("jumlah_paket_level3"))
                                <span class="help-block">{{ $errors->first("jumlah_paket_level3") }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group @if($errors->has('nilai_pjb_level3')) has-error @endif">
                                <label for="nilai_pjb-field">Nilai PBJ (Rp)</label>
                                <input type="text" id="nilai_pjb-field" name="nilai_pjb_level3" class="form-control money" value="{{ $progres_pjb->nilai_pjb_level3}}"/>
                                @if($errors->has("nilai_pjb_level3"))
                                <span class="help-block">{{ $errors->first("nilai_pjb_level3") }}</span>
                                @endif
                            </div>           
                        </div>
                    </div>   
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group @if($errors->has('jumlah_paket_level4')) has-error @endif">
                                <label for="jumlah_paket-field">Realisasi 76 - 99% (Jumlah Paket) </label>
                                <input type="text" id="jumlah_paket_level4-field" name="jumlah_paket_level4"  class="form-control money"  value="{{ $progres_pjb->jumlah_paket_level4}}"/>
                                @if($errors->has("jumlah_paket_level4"))
                                <span class="help-block">{{ $errors->first("jumlah_paket_level4") }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group @if($errors->has('nilai_pjb_level4')) has-error @endif">
                                <label for="nilai_pjb-field">Nilai PBJ (Rp)</label>
                                <input type="text" id="nilai_pjb_level4-field" name="nilai_pjb_level4" class="form-control money" value="{{ $progres_pjb->nilai_pjb_level4}}"/>
                                @if($errors->has("nilai_pjb_level4"))
                                <span class="help-block">{{ $errors->first("nilai_pjb_level4") }}</span>
                                @endif
                            </div>           
                        </div>
                    </div>               
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group @if($errors->has('jumlah_paket_level5')) has-error @endif">
                                <label for="jumlah_paket-field">Realisasi 100% (Jumlah Paket) </label>
                                <input type="text" id="jumlah_paket_level5-field" name="jumlah_paket_level5"  class="form-control money"  value="{{ $progres_pjb->jumlah_paket_level5}}"/>
                                @if($errors->has("jumlah_paket_level5"))
                                <span class="help-block">{{ $errors->first("jumlah_paket_level5") }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group @if($errors->has('nilai_pjb_level5')) has-error @endif">
                                <label for="nilai_pjb-field">Nilai PBJ (Rp)</label>
                                <input type="text" id="nilai_pjb_level5-field" name="nilai_pjb_level5" class="form-control money" value="{{ $progres_pjb->nilai_pjb_level5}}"/>
                                @if($errors->has("nilai_pjb_level5"))
                                <span class="help-block">{{ $errors->first("nilai_pjb_level5") }}</span>
                                @endif
                            </div>           
                        </div>
                    </div>
                </div>
            </div>
            <div class="well well-sm">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a class="btn btn-link pull-right" href="{{ route('progres_pjbs.index') }}"><i class="glyphicon glyphicon-backward"></i> Kembali</a>
            </div>           
        </form>
    </section>
    <!-- /.content -->
</div>
@include('layouts.footer') 
</body>
</html>
