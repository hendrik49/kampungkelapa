@include('layouts.header')
<style type="text/css">
    .inlineform .form-control {
        margin-top: -4px;
    }
</style>
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Menampilkan No DIPA: {{$penyerapan_anggaran_target_pjb->nama_dipa}}
       </h1>
    </section>
    <section class="content inlineform">
        @include('error')
        @if(Session::has('message'))
           <p class="alert {{ Session::get('alert-class', 'alert-danger') }}">{{ Session::get('message') }}</p>
        @elseif(Session::has('message2'))
           <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message2') }}</p>
        @endif
        <div class="row">
            <div class="col-md-6">
                <div class="page-header">
                    <form action="{{ route('penyerapan_anggaran_target_pjbs.destroy', $penyerapan_anggaran_target_pjb->id) }}" method="POST" style="display: inline;" onsubmit="if(confirm('Delete? Are you sure?')) { return true } else {return false };">
                        <small>Rencana Penyerapan Anggaran </small>
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="btn-group pull-right" role="group" aria-label="...">
                            @if($penyerapan_anggaran_target_pjb->user_id == Auth::user()->id && $penyerapan_anggaran_target_pjb->status != 'FINAL')
                            <a class="btn btn-warning btn-group" role="group" href="#" onclick="return toggleForm('form_penyerapan_anggaran_perjenis', this);"><i class="glyphicon glyphicon-edit"></i> Ubah</a>                            
                            @endif
                        </div>
                    </form>
                </div>
                <form id="form_penyerapan_anggaran_perjenis" data-state="display" class="well well-sm" action="{{ route('penyerapan_anggaran_perjenis.update', $penyerapan_anggaran_perjenis_belanja->id_anggaran) }}" method="POST">                    
                    <input type="hidden" name="_method" value="PUT">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        
                    <div class="form-group">
                        <div class="row">
                            <label class="col-xs-7" for="total_anggaran">PAGU ANGGARAN DIPA</label>
                            <p class="col-xs-5">Rp {{ number_format($penyerapan_anggaran_perjenis_belanja->total_anggaran,2) }}</p>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-xs-7" for="tahun_anggaran">Belanja Barang</label>
                            <p class="col-xs-5">Rp {{number_format($penyerapan_anggaran_perjenis_belanja->belanja_barang, 2)}}</p>
                            <div class="col-xs-5" style="display: none">
                                <input type="text" id="belanja_barang-field" name="belanja_barang" class="form-control money" value="{{ is_null(old("belanja_barang")) ? $penyerapan_anggaran_perjenis_belanja->belanja_barang : old("belanja_barang") }}"/>
                                @if($errors->has("belanja_barang"))
                                <span class="help-block">{{ $errors->first("belanja_barang") }}</span>
                                @endif                                
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-xs-7" for="triwulan">Belanja Modal</label>
                            <p class="col-xs-5">Rp {{number_format($penyerapan_anggaran_perjenis_belanja->belanja_modal,2)}}</p>
                            <div class="col-xs-5" style="display: none">
                                <input type="text" id="belanja_modal-field" name="belanja_modal" class="form-control money" value="{{ is_null(old("belanja_modal")) ? $penyerapan_anggaran_perjenis_belanja->belanja_modal : old("belanja_modal") }}" @if($penyerapan_anggaran_target_pjb->jenis == 'd') title="DIPA daerah tidak bisa mengisi belanja modal" readonly @endif/>
                                @if($errors->has("belanja_modal"))
                                <span class="help-block">{{ $errors->first("belanja_modal") }}</span>
                                @endif                                
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-xs-7" for="triwulan">Belanja Lainnya (Pegawai/Hibah)</label>
                            <p class="col-xs-5">Rp {{number_format($penyerapan_anggaran_perjenis_belanja->belanja_lainnya,2)}}</p>
                            <div class="col-xs-5" style="display: none">
                                <input type="text" id="belanja_lainnya-field" name="belanja_lainnya" class="form-control money" value="{{ is_null(old("belanja_lainnya")) ? $penyerapan_anggaran_perjenis_belanja->belanja_lainnya : old("belanja_lainnya") }}"/>
                                @if($errors->has("belanja_lainnya"))
                                <span class="help-block">{{ $errors->first("belanja_lainnya") }}</span>
                                @endif                                
                            </div>
                        </div>
                    </div>
                    <div class="text-right" style="display: none">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>                    
                </form>
            </div>
        </div>
        <div class="row" @if($penyerapan_anggaran_target_pjb->jenis=="p") style="display: none;" @endif >
            <div class="col-md-6">
                <div class="page-header">
                    <form action="{{ route('penyerapan_anggaran_target_pjbs.destroy', $penyerapan_anggaran_target_pjb->id) }}" method="POST" style="display: inline;" onsubmit="if(confirm('Delete? Are you sure?')) { return true } else {return false };">
                        <small>Rencana Serap Belanja Barang </small>
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="btn-group pull-right" role="group" aria-label="...">
                            @if($penyerapan_anggaran_target_pjb->user_id == Auth::user()->id && $penyerapan_anggaran_target_pjb->status != 'FINAL')
                            <a class="btn btn-warning btn-group" role="group" href="" onclick="return toggleForm('form_penyerapan_anggaran_triwulan_barang', this);"><i class="glyphicon glyphicon-edit"></i> Ubah</a>
                            @endif
                        </div>
                    </form>
                </div>
                <form id="form_penyerapan_anggaran_triwulan_barang" data-state="display" class="well well-sm" action="{{ url('penyerapan_rencana_triwulan_barang', $penyerapan_anggaran_perjenis_belanja->id_anggaran) }}" method="POST">
                    <input type="hidden" name="_method" value="POST">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">                    
                    
                    <div class="form-group">
                        <div class="row">
                            <label class="col-xs-7" for="total_anggaran">PAGU ANGGARAN DIPA</label>
                            <p class="col-xs-5">Rp {{ number_format($penyerapan_anggaran_triwulan_barang->jumlah,2) }}</p>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-xs-7" for="tahun_anggaran">TRIWULAN I</label>
                            <p class=" col-xs-5">Rp {{number_format($penyerapan_anggaran_triwulan_barang->triwulan_1,2)}}</p>
                            <div class="col-xs-5" style="display: none">
                                <input type="text" id="barang_triwulan_1-field" name="barang_triwulan_1" class="form-control money" value="{{ is_null(old("barang_triwulan_1")) ? $penyerapan_anggaran_triwulan_barang->triwulan_1 : old("barang_triwulan_1") }}"/>
                                @if($errors->has("barang_triwulan_1"))
                                    <span class="help-block">{{ $errors->first("barang_triwulan_1") }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-xs-7" for="triwulan">TRIWULAN II</label>
                            <p class="col-xs-5">Rp {{number_format($penyerapan_anggaran_triwulan_barang->triwulan_2,2)}}</p>
                            <div class="col-xs-5" style="display: none">
                                <input type="text" id="barang_triwulan_2-field" name="barang_triwulan_2" class="form-control money" value="{{ is_null(old("barang_triwulan_2")) ? $penyerapan_anggaran_triwulan_barang->triwulan_2 : old("barang_triwulan_2") }}"/>
                                @if($errors->has("barang_triwulan_2"))
                                    <span class="help-block">{{ $errors->first("barang_triwulan_2") }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-xs-7" for="triwulan">TRIWULAN III</label>
                            <p class="col-xs-5">Rp {{number_format($penyerapan_anggaran_triwulan_barang->triwulan_3,2)}}</p>
                            <div class="col-xs-5" style="display: none">
                                <input type="text" id="barang_triwulan_3-field" name="barang_triwulan_3" class="form-control money" value="{{ is_null(old("barang_triwulan_3")) ? $penyerapan_anggaran_triwulan_barang->triwulan_3 : old("barang_triwulan_3") }}"/>
                                @if($errors->has("barang_triwulan_3"))
                                    <span class="help-block">{{ $errors->first("barang_triwulan_3") }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-xs-7" for="triwulan">TRIWULAN IV</label>
                            <p class="col-xs-5">Rp {{number_format($penyerapan_anggaran_triwulan_barang->triwulan_4,2)}}</p>
                            <div class="col-xs-5" style="display: none">
                                <input type="text" id="barang_triwulan_4-field" name="barang_triwulan_4" class="form-control money" value="{{ is_null(old("barang_triwulan_4")) ? $penyerapan_anggaran_triwulan_barang->triwulan_4 : old("barang_triwulan_4") }}"/>
                                @if($errors->has("barang_triwulan_4"))
                                    <span class="help-block">{{ $errors->first("barang_triwulan_4") }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="text-right" style="display: none">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>                                        
                </form>
            </div>
            <div class="col-md-6">
                <div class="page-header">
                    <form action="{{ route('penyerapan_anggaran_target_pjbs.destroy', $penyerapan_anggaran_target_pjb->id) }}" method="POST" style="display: inline;" onsubmit="if(confirm('Delete? Are you sure?')) { return true } else {return false };">
                        <small>Rencana Serap Belanja Modal </small>
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="btn-group pull-right" role="group" aria-label="...">
                            @if($penyerapan_anggaran_target_pjb->jenis == 'p')
                                @if($penyerapan_anggaran_target_pjb->user_id == Auth::user()->id && $penyerapan_anggaran_target_pjb->status != 'FINAL')
                                <a class="btn btn-warning btn-group" role="group" href="" onclick="return toggleForm('form_penyerapan_anggaran_triwulan_modal', this);"><i class="glyphicon glyphicon-edit"></i> Ubah</a>
                                @endif
                            @else
                                <a class="btn btn-default btn-group" disabled role="group" href="" onclick="return false;" title="DIPA daerah tidak bisa mengisi belanja modal"><i class="glyphicon glyphicon-edit"></i> Ubah</a>
                            @endif
                        </div>
                    </form>
                </div>
                <form id="form_penyerapan_anggaran_triwulan_modal" data-state="display" class="well well-sm" action="{{ url('penyerapan_rencana_triwulan_modal', $penyerapan_anggaran_perjenis_belanja->id_anggaran) }}" method="POST">
                    <input type="hidden" name="_method" value="POST">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">                                        
                    
                    <div class="form-group">
                        <div class="row">
                            <label class="col-xs-7" for="total_anggaran">PAGU ANGGARAN DIPA</label>
                            <p class="col-xs-5">Rp {{ number_format($penyerapan_anggaran_triwulan_modal->jumlah,2) }}</p>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-xs-7" for="tahun_anggaran">TRIWULAN I</label>
                            <p class=" col-xs-5">Rp {{number_format($penyerapan_anggaran_triwulan_modal->triwulan_1,2)}}</p>
                            <div class="col-xs-5" style="display: none">
                                <input type="text" id="modal_triwulan_1-field" name="modal_triwulan_1" class="form-control money" value="{{ is_null(old("modal_triwulan_1")) ? $penyerapan_anggaran_triwulan_modal->triwulan_1 : old("modal_triwulan_1") }}"/>
                                @if($errors->has("modal_triwulan_1"))
                                    <span class="help-block">{{ $errors->first("modal_triwulan_1") }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-xs-7" for="triwulan">TRIWULAN II</label>
                            <p class="col-xs-5">Rp {{number_format($penyerapan_anggaran_triwulan_modal->triwulan_2,2)}}</p>
                            <div class="col-xs-5" style="display: none">
                                <input type="text" id="modal_triwulan_2-field" name="modal_triwulan_2" class="form-control money" value="{{ is_null(old("modal_triwulan_2")) ? $penyerapan_anggaran_triwulan_modal->triwulan_2 : old("modal_triwulan_2") }}"/>
                                @if($errors->has("modal_triwulan_2"))
                                    <span class="help-block">{{ $errors->first("modal_triwulan_2") }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-xs-7" for="triwulan">TRIWULAN III</label>
                            <p class="col-xs-5">Rp {{number_format($penyerapan_anggaran_triwulan_modal->triwulan_3,2)}}</p>
                            <div class="col-xs-5" style="display: none">
                                <input type="text" id="modal_triwulan_3-field" name="modal_triwulan_3" class="form-control money" value="{{ is_null(old("modal_triwulan_3")) ? $penyerapan_anggaran_triwulan_modal->triwulan_3 : old("modal_triwulan_3") }}"/>
                                @if($errors->has("modal_triwulan_3"))
                                    <span class="help-block">{{ $errors->first("modal_triwulan_3") }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-xs-7" for="triwulan">TRIWULAN IV</label>
                            <p class="col-xs-5">Rp {{number_format($penyerapan_anggaran_triwulan_modal->triwulan_4,2)}}</p>
                            <div class="col-xs-5" style="display: none">
                                <input type="text" id="modal_triwulan_4-field" name="modal_triwulan_4" class="form-control money" value="{{ is_null(old("modal_triwulan_4")) ? $penyerapan_anggaran_triwulan_modal->triwulan_4 : old("modal_triwulan_4") }}"/>
                                @if($errors->has("modal_triwulan_4"))
                                    <span class="help-block">{{ $errors->first("modal_triwulan_4") }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="text-right" style="display: none">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>                                        
                </form>
            </div>
        </div>
        <div class="row" @if($penyerapan_anggaran_target_pjb->jenis=="p") style="display: none;" @endif>
            <div class="col-md-6">
                <div class="page-header">
                    <form action="{{ route('penyerapan_anggaran_target_pjbs.destroy', $penyerapan_anggaran_target_pjb->id) }}" method="POST" style="display: inline;" onsubmit="if(confirm('Delete? Are you sure?')) { return true } else {return false };">
                        <small>Rencana Serap Belanja Lainnya (Pegawai/Hibah) </small>
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="btn-group pull-right" role="group" aria-label="...">
                            @if($penyerapan_anggaran_target_pjb->user_id == Auth::user()->id && $penyerapan_anggaran_target_pjb->status != 'FINAL')
                            <a class="btn btn-warning btn-group" role="group" href="" onclick="return toggleForm('form_penyerapan_anggaran_triwulan_lainnya', this);"><i class="glyphicon glyphicon-edit"></i> Ubah</a>
                            @endif
                        </div>
                    </form>
                </div>
                <form id="form_penyerapan_anggaran_triwulan_lainnya" data-state="display" class="well well-sm" action="{{ url('penyerapan_rencana_triwulan_lainnya', $penyerapan_anggaran_perjenis_belanja->id_anggaran) }}" method="POST">
                    <input type="hidden" name="_method" value="POST">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">                                                            
                    
                    <div class="form-group">
                        <div class="row">
                            <label class="col-xs-7" for="total_anggaran">PAGU ANGGARAN DIPA</label>
                            <p class="col-xs-5">Rp {{number_format($penyerapan_anggaran_triwulan_lainnya->jumlah,2) }}</p>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-xs-7" for="tahun_anggaran">TRIWULAN I</label>
                            <p class=" col-xs-5">Rp {{number_format($penyerapan_anggaran_triwulan_lainnya->triwulan_1,2)}}</p>
                            <div class="col-xs-5" style="display: none">
                                <input type="text" id="lainnya_triwulan_1-field" name="lainnya_triwulan_1" class="form-control money" value="{{ is_null(old("lainnya_triwulan_1")) ? $penyerapan_anggaran_triwulan_lainnya->triwulan_1 : old("lainnya_triwulan_1") }}"/>
                                @if($errors->has("lainnya_triwulan_1"))
                                    <span class="help-block">{{ $errors->first("lainnya_triwulan_1") }}</span>
                                @endif                                
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-xs-7" for="triwulan">TRIWULAN II</label>
                            <p class="col-xs-5">Rp {{number_format($penyerapan_anggaran_triwulan_lainnya->triwulan_2,2)}}</p>
                            <div class="col-xs-5" style="display: none">
                                <input type="text" id="lainnya_triwulan_2-field" name="lainnya_triwulan_2" class="form-control money" value="{{ is_null(old("lainnya_triwulan_2")) ? $penyerapan_anggaran_triwulan_lainnya->triwulan_2 : old("lainnya_triwulan_2") }}"/>
                                @if($errors->has("lainnya_triwulan_2"))
                                    <span class="help-block">{{ $errors->first("lainnya_triwulan_2") }}</span>
                                @endif                                
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-xs-7" for="triwulan">TRIWULAN III</label>
                            <p class="col-xs-5">Rp {{number_format($penyerapan_anggaran_triwulan_lainnya->triwulan_3,2)}}</p>
                            <div class="col-xs-5" style="display: none">
                                <input type="text" id="lainnya_triwulan_3-field" name="lainnya_triwulan_3" class="form-control money" value="{{ is_null(old("lainnya_triwulan_3")) ? $penyerapan_anggaran_triwulan_lainnya->triwulan_3 : old("lainnya_triwulan_3") }}"/>
                                @if($errors->has("lainnya_triwulan_3"))
                                    <span class="help-block">{{ $errors->first("lainnya_triwulan_3") }}</span>
                                @endif                                
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-xs-7" for="triwulan">TRIWULAN IV</label>
                            <p class="col-xs-5">Rp {{number_format($penyerapan_anggaran_triwulan_lainnya->triwulan_4,2)}}</p>
                            <div class="col-xs-5" style="display: none">
                                <input type="text" id="lainnya_triwulan_4-field" name="lainnya_triwulan_4" class="form-control money" value="{{ is_null(old("lainnya_triwulan_4")) ? $penyerapan_anggaran_triwulan_lainnya->triwulan_4 : old("lainnya_triwulan_4") }}"/>
                                @if($errors->has("lainnya_triwulan_4"))
                                    <span class="help-block">{{ $errors->first("lainnya_triwulan_4") }}</span>
                                @endif                                
                            </div>
                        </div>
                    </div>
                    <div class="text-right" style="display: none">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>   
                </form>
                <a class="btn btn-link" href="{{ route('penyerapan_anggaran_target_pjbs.index') }}"><i class="glyphicon glyphicon-backward"></i>  Kembali</a>
            </div>    
              <div class="col-md-6">
                <div class="page-header">
                    <form action="{{ route('penyerapan_anggaran_target_pjbs.destroy', $penyerapan_anggaran_target_pjb->id) }}" method="POST" style="display: inline;" onsubmit="if(confirm('Delete? Are you sure?')) { return true } else {return false };">
                        <small>Rencana Penyerapan Per Triwulan </small>
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="btn-group pull-right" role="group" aria-label="...">
                        </div>
                    </form>
                </div>
                <form class="well well-sm" action="#">
                    <div class="form-group">
                        <div class="row">
                                <label class="col-xs-7" for="total_anggaran">PAGU ANGGARAN DIPA</label>
                                <p class="col-xs-5">Rp {{ number_format($penyerapan_anggaran_perjenis_belanja->total_anggaran,2) }}</p>
                        </div>
                    </div>
                        <div class="form-group">
                            <div class="row">
                                <label class="col-xs-7" for="tahun_anggaran">TRIWULAN I</label>
                                <p class=" col-xs-5">Rp {{number_format($penyerapan_anggaran_triwulan_lainnya->triwulan_1 + $penyerapan_anggaran_triwulan_barang->triwulan_1 + $penyerapan_anggaran_triwulan_modal->triwulan_1,2)}}</p>
                            </div>
                    </div>
                        <div class="form-group">
                        <div class="row">
                            <label class="col-xs-7" for="triwulan">TRIWULAN II</label>
                            <p class="col-xs-5">Rp {{number_format($penyerapan_anggaran_triwulan_lainnya->triwulan_2 + $penyerapan_anggaran_triwulan_barang->triwulan_2 + $penyerapan_anggaran_triwulan_modal->triwulan_2,2)}}</p>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-xs-7" for="triwulan">TRIWULAN III</label>
                            <p class="col-xs-5">Rp {{number_format($penyerapan_anggaran_triwulan_lainnya->triwulan_3 +$penyerapan_anggaran_triwulan_modal->triwulan_3+$penyerapan_anggaran_triwulan_barang->triwulan_3,2)}}</p>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-xs-7" for="triwulan">TRIWULAN IV</label>
                            <p class="col-xs-5">Rp {{number_format($penyerapan_anggaran_triwulan_lainnya->triwulan_4 + $penyerapan_anggaran_triwulan_modal->triwulan_4+ $penyerapan_anggaran_triwulan_barang->triwulan_4,2)}}</p>
                        </div>
                    </div>

                </form>
            </div>          
        </div>
        </section>
    
<script type="text/javascript">

var btnUbahHTML = '<i class="glyphicon glyphicon-edit"></i> Ubah';
var btnBatalHTML = '<i class="glyphicon glyphicon-remove"></i> Batal';

function toggleForm(id, btn) {
    
    var form = $('#' + id);
    var inputs = form.find("div:has(>input)");
    var displays = form.find("div:has(>input)").prev();
    var submitter = form.find("div:has(>button[type=submit])");
    var toggler = $(btn);
    
    if (form.data('state') == 'display') {
        displays.hide();
        inputs.show();
        submitter.show();
        toggler.html(btnBatalHTML).removeClass('btn-warning').addClass('btn-danger');
        form.data('state', 'edit');
    } else if (form.data('state') == 'edit') {
        displays.show();
        inputs.hide();
        submitter.hide();
        toggler.html(btnUbahHTML).removeClass('btn-danger').addClass('btn-warning');
        form.data('state', 'display');
    } 
    
    return false;
}

</script>
    
    <!-- /.content -->
  </div>
  @include('layouts.footer') 
</body>
</html>
