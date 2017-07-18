@include('layouts.header')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Detail Progres Pengadaan Barang dan Jasa
        </h1>
    </section>

    <section class="content">
        @include('error')
        @if(Session::has('message'))
           <p class="alert {{ Session::get('alert-class', 'alert-danger') }}">{{ Session::get('message') }}</p>
        @elseif(Session::has('message2'))
           <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message2') }}</p>
        @endif
        
        <div class="row">
            <form action="" method="POST">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="col-md-6">           
                    <div class="form-group @if($errors->has('nama_dipa')) has-error @endif">
                        <label for="tahun_anggaran-field">ID PJB Setahun</label>
                        <input type="text" id="nama_dipa-field" name="nama_dipa" class="form-control" value="{{ $progres_pjb->nama_dipa }}" readonly>
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
                    <div class="form-group @if($errors->has('tahun_anggaran')) has-error @endif">
                        <label for="satuan_kerja-field">Tahun Anggaran</label>
                        <input type="text" id="tahun_anggaran-field" name="tahun_anggaran" class="form-control" value="{{ $progres_pjb->tahun_anggaran }}" readonly>
                        @if($errors->has("tahun_anggaran"))
                        <span class="help-block">{{ $errors->first("tahun_anggaran") }}</span>
                        @endif
                    </div>
                    <div class="form-group @if($errors->has('triwulan')) has-error @endif">
                        <label for="triwulan-field">Triwulan</label>
                        <input type="text" id="triwulan" name="triwulan" class="form-control" value="{{ $progres_pjb->triwulan}}" readonly>
                        @if($errors->has("triwulan"))
                        <span class="help-block">{{ $errors->first("triwulan") }}</span>
                        @endif
                    </div>
                    <div class="form-group @if($errors->has('tanggal_dipa')) has-error @endif">
                        <label for="tanggal_dipa-field">Tanggal</label>
                        <input type="text" id="tanggal_dipa" name="tanggal_dipa" class="form-control" value="{{ $progres_pjb->tanggal_dipa}}" readonly>
                        @if($errors->has("tanggal_dipa"))
                        <span class="help-block">{{ $errors->first("tanggal_dipa") }}</span>
                        @endif
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group @if($errors->has('target_paket')) has-error @endif">
                                <label for="target_paket-field">Target Paket Setahun</label>
                                <input type="text" id="jumlah_paket-field" name="target_paket"  class="form-control money"  value="{{ $progres_pjb->target_pjb}}" readonly>
                                @if($errors->has("target_paket"))
                                <span class="help-block">{{ $errors->first("target_paket") }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">                
                            <div class="form-group @if($errors->has('nilai_pjb')) has-error @endif">
                                <label for="nilai_pjb-field">Nilai PBJ Setahun (Rp)</label>
                                <input type="text" id="nilai_pjb_dilelang-field" name="nilai_pjb" class="form-control money" value="{{ $progres_pjb->nilai_pjb}}" readonly>
                                @if($errors->has("nilai_pjb"))
                                <span class="help-block">{{ $errors->first("nilai_pjb") }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group @if($errors->has('jumlah_paket_belum_dilelang')) has-error @endif">
                                <label for="jumlah_paket-field">Belum dilelang (Jumlah Paket) </label>
                                <input type="text" id="jumlah_paket_belum_dilelang-field" name="jumlah_paket_belum_dilelang"  class="form-control money"  value="{{ $progres_pjb->jumlah_paket_belum_dilelang}}" readonly>
                                @if($errors->has("jumlah_paket_belum_dilelang"))
                                <span class="help-block">{{ $errors->first("jumlah_paket_belum_dilelang") }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">                
                            <div class="form-group @if($errors->has('nilai_pjb_belum_dilelang')) has-error @endif">
                                <label for="nilai_pjb-field">Nilai PBJ (Rp)</label>
                                <input type="text" id="nilai_pjb_dilelang-field" name="nilai_pjb_belum_dilelang" class="form-control money" value="{{ $progres_pjb->nilai_pjb_belum_dilelang}}" readonly>
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
                                <input type="text" id="jumlah_paket_pemenang-field" name="jumlah_paket_pemenang"  class="form-control money"  value="{{ $progres_pjb->jumlah_paket_pemenang}}" readonly>
                                @if($errors->has("jumlah_paket_pemenang"))
                                <span class="help-block">{{ $errors->first("jumlah_paket_pemenang") }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group @if($errors->has('nilai_pjb_pemenang')) has-error @endif">
                                <label for="nilai_pjb-field">Nilai PBJ (Rp)</label>
                                <input type="text" id="nilai_pjb_pemenang-field" name="nilai_pjb_pemenang" class="form-control money" value="{{ $progres_pjb->nilai_pjb_pemenang}}" readonly>
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
                                <input type="text" id="jumlah_paket_belum_realisasi-field" name="jumlah_paket_belum_realisasi"  class="form-control money"  value="{{ $progres_pjb->jumlah_paket_belum_realisasi}}" readonly>
                                @if($errors->has("jumlah_paket_belum_realisasi"))
                                <span class="help-block">{{ $errors->first("jumlah_paket_belum_realisasi") }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group @if($errors->has('nilai_pjb_belum_realisasi')) has-error @endif">
                                <label for="nilai_pjb-field">Nilai PBJ (Rp)</label>
                                <input type="text" id="nilai_pjb_belum_realisasi-field" name="nilai_pjb_belum_realisasi" class="form-control money" value="{{ $progres_pjb->nilai_pjb_belum_realisasi}}" readonly>
                                @if($errors->has("nilai_pjb_belum_realisasi"))
                                <span class="help-block">{{ $errors->first("nilai_pjb_belum_realisasi") }}</span>
                                @endif
                            </div>           
                        </div>
                    </div>
                    <div class="form-group @if($errors->has('status')) has-error @endif">
                       <label for="status-field">Status</label>
                       <input type="text" class="form-control" value="{{$progres_pjb->status}}" readonly/>
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
                                <input type="text" id="jumlah_paket_level1-field" name="jumlah_paket_level1"  class="form-control money"  value="{{ $progres_pjb->jumlah_paket_level1}}" readonly>
                                @if($errors->has("jumlah_paket"))
                                <span class="help-block">{{ $errors->first("jumlah_paket") }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group @if($errors->has('nilai_pjb_level1')) has-error @endif">
                                <label for="nilai_pjb-field">Nilai PBJ (Rp)</label>
                                <input type="text" id="nilai_pjb_level1-field" name="nilai_pjb_level1" class="form-control money" value="{{ $progres_pjb->nilai_pjb_level1}}" readonly>
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
                                <input type="text" id="jumlah_paket_level2-field" name="jumlah_paket_level2"  class="form-control money"  value="{{ $progres_pjb->jumlah_paket_level2}}" readonly>
                                @if($errors->has("jumlah_paket_level2"))
                                <span class="help-block">{{ $errors->first("jumlah_paket_level2") }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group @if($errors->has('nilai_pjb_level2')) has-error @endif">
                                <label for="nilai_pjb-field">Nilai PBJ (Rp)</label>
                                <input type="text" id="nilai_pjb_level2-field" name="nilai_pjb_level2" class="form-control money" value="{{ $progres_pjb->nilai_pjb_level2}}" readonly>
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
                                <input type="text" id="jumlah_paket_level3-field" name="jumlah_paket_level3"  class="form-control money"  value="{{ $progres_pjb->jumlah_paket_level3}}" readonly>
                                @if($errors->has("jumlah_paket_level3"))
                                <span class="help-block">{{ $errors->first("jumlah_paket_level3") }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group @if($errors->has('nilai_pjb_level3')) has-error @endif">
                                <label for="nilai_pjb-field">Nilai PBJ (Rp)</label>
                                <input type="text" id="nilai_pjb-field" name="nilai_pjb_level3" class="form-control money" value="{{ $progres_pjb->nilai_pjb_level3}}" readonly>
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
                                <input type="text" id="jumlah_paket_level4-field" name="jumlah_paket_level4"  class="form-control money"  value="{{ $progres_pjb->jumlah_paket_level4}}" readonly>
                                @if($errors->has("jumlah_paket_level4"))
                                <span class="help-block">{{ $errors->first("jumlah_paket_level4") }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group @if($errors->has('nilai_pjb_level4')) has-error @endif">
                                <label for="nilai_pjb-field">Nilai PBJ (Rp)</label>
                                <input type="text" id="nilai_pjb_level4-field" name="nilai_pjb_level4" class="form-control money" value="{{ $progres_pjb->nilai_pjb_level4}}" readonly>
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
                                <input type="text" id="jumlah_paket_level5-field" name="jumlah_paket_level5"  class="form-control money"  value="{{ $progres_pjb->jumlah_paket_level5}}" readonly>
                                @if($errors->has("jumlah_paket_level5"))
                                <span class="help-block">{{ $errors->first("jumlah_paket_level5") }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group @if($errors->has('nilai_pjb_level5')) has-error @endif">
                                <label for="nilai_pjb-field">Nilai PBJ (Rp)</label>
                                <input type="text" id="nilai_pjb_level5-field" name="nilai_pjb_level5" class="form-control money" value="{{ $progres_pjb->nilai_pjb_level5}}" readonly>
                                @if($errors->has("nilai_pjb_level5"))
                                <span class="help-block">{{ $errors->first("nilai_pjb_level5") }}</span>
                                @endif
                            </div>           
                        </div>
                    </div>                  
                </div>
            </form>
        </div>

        <div class="row">
            <div class="col-md-12">
                
                <div class="page-header">
                    <form style="display: inline;">
                        <small>Penyebab dan Rekomendasi Atas Permasalahan</small>
                        <div class="btn-group pull-right" role="group" aria-label="...">
                            @if($progres_pjb->user_id == Auth::user()->id && $progres_pjb->status != 'FINAL')
                            <a class="btn btn-warning btn-group" role="group" href="{{ url('progres_pjbs/permasalahan', $progres_pjb->id) }}"><i class="glyphicon glyphicon-edit"></i> Ubah</a>
                            @endif
                        </div>
                    </form>
                </div>
                
                <form class="well well-sm" action="#">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Penyebab</th>
                                <th>Rekomendasi</th>
                            </tr>
                        </thead>
                        <tbody>
                        @if(count($progres_pjb->permasalahan) == 0)
                            <tr>
                                <td colspan="3">(Tidak ada data)</td>
                            </tr>
                        @else
                        @foreach($progres_pjb->permasalahan as $i => $p)
                            <tr>
                                <td>
                                    {{ ++$i }}
                                </td>
                                <td>
                                    <strong>Penyebab pada tahap {{$p->kelompok}}</strong>:<br/>
                                    <p>{{$p->penyebab}}</p><br/>
                                    
                                    <strong>Penjelasan atas penyebab di atas</strong>:<br/>
                                    <p>{{$p->penyebab_penjelasan}}</p><br/>
                                </td>
                                <td>
                                    <strong>Rekomendasi pada tahap {{$p->kelompok}}</strong>:<br/>
                                    <p>{{$p->rekomendasi}}</p><br/>
                                    
                                    <strong>Penjelasan atas rekomendasi di atas</strong>:<br/>
                                    <p>{{$p->rekomendasi_penjelasan}}</p><br/>                                    
                                </td>
                            </tr>
                        @endforeach
                        @endif
                        </tbody>
                    </table>                    
                </form>
                
                
            </div>
        </div>        
        
        
    </section>
    <!-- /.content -->
</div>
@include('layouts.footer') 
</body>
</html>
