<style>

    body {
        font-family: 'sans-serif';
        font-size: 12px;
    }
    table thead td {
        text-align: center;
    }
    table {
        font-size: 11px;
        border-collapse: collapse;        
    }
    table.bordered td, table.bordered th {
        border: 1px solid #595959;
    }
    td, th {
        padding: 3px;
    }
    th {
        background: #dddddd;
        font-weight: normal;
    }    

    h1 {
        text-align: center;
        font-size: 18px;
    }

    h2 {
        font-size: 14px;
    }

</style>

<h1>
    LAPORAN HASIL REVIU PENYERAPAN ANGGARAN<br/>
    DAN PENGADAAN BARANG/JASA<br/>
    PADA MARKAS BESAR TNI<br/>
    TRIWULAN {{$tw_roman}} TAHUN {{$tahun}}
</h1>

<p>Satuan Kerja: {{$satker->name}}</p>

<h2>Anggaran Belanja dan Target Lelang Pengadaan Barang/Jasa Tahun {{$tahun}}</h2>


<table style="min-width: 50%">
    <tr>
        <td>1.</td>
        <td>Nomor DIPA</td>
        <td>:</td>
        <td>{{implode(', ', $nama_dipa)}}</td>
    </tr>
    <tr>
        <td>2.</td>
        <td>Tanggal DIPA</td>
        <td>:</td>
        <td>{{implode(', ', $tanggal_dipa)}}</td>
    </tr>
    <tr>
        <td>3.</td>
        <td>Anggaran Belanja:</td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td></td>
        <td>a. Belanja Barang</td>
        <td>: Rp</td>
        <td style="text-align: right;">{{number_format($pagu['barang'])}}</td>
    </tr>
    <tr>
        <td></td>
        <td>b. Belanja Modal</td>
        <td>: Rp</td>
        <td style="text-align: right;">{{number_format($pagu['modal'])}}</td>
    </tr>
    <tr>
        <td></td>
        <td>c. Belanja Lainnya</td>
        <td>: Rp</td>
        <td style="text-align: right;">{{number_format($pagu['lainnya'])}}</td>
    </tr>
    <tr>
        <td></td>
        <td>Jumlah</td>
        <td>: Rp</td>
        <td style="text-align: right;">{{number_format($pagu['barang'] + $pagu['modal'] + $pagu['lainnya'])}}</td>
    </tr>
    <tr>
        <td>4.</td>
        <td colspan="3">Rencana Penyerapan Anggaran</td>
    </tr>
</table>

<table class="bordered" style="width: 100%">
    <thead>
        <tr>
            <th rowspan="2">No.</th>
            <th rowspan="2">Triwulan</th>
            <th colspan="4">Anggaran Belanja (Dalam Milyaran Rupiah)</th>
        </tr>
        <tr>
            <th>Barang</th>
            <th>Modal</th>
            <th>Lainnya *)</th>
            <th>Jumlah</th>
        </tr>
        <tr>
            <th>(1)</th>
            <th>(2)</th>
            <th>(3)</th>
            <th>(4)</th>
            <th>(5)</th>
            <th>(6=3+4+5)</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>I.</td>
            <td>Pagu Anggaran DIPA</td>
            <td style="text-align: right">{{number_format($pagu["barang"] / 1e9, 2)}}</td>
            <td style="text-align: right">{{number_format($pagu["modal"] / 1e9, 2)}}</td>
            <td style="text-align: right">{{number_format($pagu["lainnya"] / 1e9, 2)}}</td>
            @php
            $sum_pagu = ($pagu["lainnya"] / 1e9) + ($pagu["modal"] / 1e9) + ($pagu["barang"] / 1e9);
            @endphp
            <td style="text-align: right">{{number_format($sum_pagu, 2)}}</td>
        </tr>
        <tr>
            <td>II.</td>
            <td>Rencana Penyerapan</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>1</td>
            <td>Triwulan I</td>
            <td style="text-align: right">{{number_format($rencana_triwulan[1]["barang"] / 1e9, 2)}}</td>
            <td style="text-align: right">{{number_format($rencana_triwulan[1]["modal"] / 1e9, 2)}}</td>
            <td style="text-align: right">{{number_format($rencana_triwulan[1]["lainnya"] / 1e9, 2)}}</td>
            @php
            $sum_tw1 = ($rencana_triwulan[1]["barang"] / 1e9) + ($rencana_triwulan[1]["modal"] / 1e9) + ($rencana_triwulan[1]["lainnya"] / 1e9);
            @endphp
            <td style="text-align: right">{{number_format($sum_tw1, 2)}}</td>
        </tr>
        <tr>
            <td>2</td>
            <td>Triwulan II</td>
            <td style="text-align: right">{{number_format($rencana_triwulan[2]["barang"] / 1e9, 2)}}</td>
            <td style="text-align: right">{{number_format($rencana_triwulan[2]["modal"] / 1e9, 2)}}</td>
            <td style="text-align: right">{{number_format($rencana_triwulan[2]["lainnya"] / 1e9, 2)}}</td>
            @php
            $sum_tw2 = ($rencana_triwulan[2]["barang"] / 1e9) + ($rencana_triwulan[2]["modal"] / 1e9) + ($rencana_triwulan[2]["lainnya"] / 1e9);
            @endphp
            <td style="text-align: right">{{number_format($sum_tw2, 2)}}</td>
        </tr>
        <tr>
            <td>3</td>
            <td>Triwulan III</td>
            <td style="text-align: right">{{number_format($rencana_triwulan[3]["barang"] / 1e9, 2)}}</td>
            <td style="text-align: right">{{number_format($rencana_triwulan[3]["modal"] / 1e9, 2)}}</td>
            <td style="text-align: right">{{number_format($rencana_triwulan[3]["lainnya"] / 1e9, 2)}}</td>
            @php
            $sum_tw3 = ($rencana_triwulan[3]["barang"] / 1e9) + ($rencana_triwulan[3]["modal"] / 1e9) + ($rencana_triwulan[3]["lainnya"] / 1e9);
            @endphp
            <td style="text-align: right">{{number_format($sum_tw3, 2)}}</td>
        </tr>
        <tr>
            <td>4</td>
            <td>Triwulan IV</td>
            <td style="text-align: right">{{number_format($rencana_triwulan[4]["barang"] / 1e9, 2)}}</td>
            <td style="text-align: right">{{number_format($rencana_triwulan[4]["modal"] / 1e9, 2)}}</td>
            <td style="text-align: right">{{number_format($rencana_triwulan[4]["lainnya"] / 1e9, 2)}}</td>
            @php
            $sum_tw4 = ($rencana_triwulan[4]["barang"] / 1e9) + ($rencana_triwulan[4]["modal"] / 1e9) + ($rencana_triwulan[4]["lainnya"] / 1e9);
            @endphp
            <td style="text-align: right">{{number_format($sum_tw4, 2)}}</td>
        </tr>
        <tr>
            <td></td>
            <td>Total</td>
            @php
            $sum_barang = ($rencana_triwulan[1]["barang"] / 1e9) + ($rencana_triwulan[2]["barang"] / 1e9) + ($rencana_triwulan[3]["barang"] / 1e9) + ($rencana_triwulan[4]["barang"] / 1e9);
            $sum_modal  = ($rencana_triwulan[1]["modal"] / 1e9) + ($rencana_triwulan[2]["modal"] / 1e9) + ($rencana_triwulan[3]["modal"] / 1e9) + ($rencana_triwulan[4]["modal"] / 1e9);
            $sum_lain   = ($rencana_triwulan[1]["lainnya"] / 1e9) + ($rencana_triwulan[2]["lainnya"] / 1e9) + ($rencana_triwulan[3]["lainnya"] / 1e9) + ($rencana_triwulan[4]["lainnya"] / 1e9);
            @endphp
            <td style="text-align: right">{{number_format($sum_barang, 2)}}</td>
            <td style="text-align: right">{{number_format($sum_modal, 2)}}</td>
            <td style="text-align: right">{{number_format($sum_lain, 2)}}</td>
            <td style="text-align: right">
                {{
                    number_format($sum_barang + $sum_modal + $sum_lain,2)
                }}
            </td>
        </tr>
        <tr>
            <td colspan="2">% Rencana Penyerapan terhadap Pagu Anggaran DIPA (II/I)</td>
            <td style="text-align: right">
                @if ($pagu["barang"] == 0)
                0.00%
                @else
                {{number_format($sum_barang / ($pagu["barang"] / 1e9) * 100, 2)}}%
                @endif
            </td>
            <td style="text-align: right">
                @if ($pagu["modal"] == 0)
                0.00%
                @else
                {{number_format($sum_modal / ($pagu["modal"] / 1e9) * 100, 2)}}%
                @endif                
            </td>
            <td style="text-align: right">
                @if ($pagu["lainnya"] == 0)
                0.00%
                @else
                {{number_format($sum_lain / ($pagu["lainnya"] / 1e9) * 100, 2)}}%
                @endif                
            </td>
            <td style="text-align: right">
                @if ($sum_pagu == 0)
                0.00%
                @else
                {{number_format(($sum_barang + $sum_modal + $sum_lain) / $sum_pagu * 100, 2)}}%
                @endif                   
            </td>
        </tr>
    </tbody>
</table>
<br>
<table style="min-width: 50%">
    <tr>
        <td>5.</td>
        <td colspan="3">Target Pengadaan Barang/Jasa yang akan dilelang:</td>
    </tr>
    <tr>
        <td></td>
        <td>a. Jumlah paket pengadaan barang/jasa</td>
        <td>: </td>
        <td>{{$jumlah_paket}} paket</td>
    </tr>
    <tr>
        <td></td>
        <td>b. Nilai paket pengadaan barang/jasa</td>
        <td>: </td>
        <td>Rp. {{number_format($nilai_paket)}}</td>
    </tr>

</table>

<br>
<h2>Penyerapan Anggaran Sampai Dengan Triwulan {{$tw_roman}} Tahun {{$tahun}}</h2>

<p>Perbandingan realisasi dan rencana penyerapan anggaran sampai dengan Triwulan {{$tw_roman}} Tahun {{$tahun}} adalah sebagai berikut:</p>

<table class="bordered" style="width: 100%">
    <thead>
        <tr>
            <th rowspan="2">No.</th>
            <th rowspan="2">Jenis Belanja</th>
            <th colspan="3">Rencana Penyerapan (Milyar Rp)</th>
            <th colspan="3">Realisasi Anggaran (Milyar Rp)</th>
            <th colspan="3">% Terhadap Rencana Penyerapan</th>
        </tr>
        <tr>
            <th>S.d. Triwulan Lalu</th>
            <th>Triwulan {{$tw_roman}}</th>
            <th>S.d. Triwulan {{$tw_roman}}</th>
            <th>S.d. Triwulan Lalu</th>
            <th>Triwulan {{$tw_roman}}</th>
            <th>S.d. Triwulan {{$tw_roman}}</th>
            <th>S.d. Triwulan Lalu</th>
            <th>Triwulan {{$tw_roman}}</th>
            <th>S.d. Triwulan {{$tw_roman}}</th>
        </tr>
        <tr>
            <th>(1)</th>
            <th>(2)</th>
            <th>(3)</th>
            <th>(4)</th>
            <th>(5=3+4)</th>
            <th>(6)</th>
            <th>(7)</th>
            <th>(8=6+7)</th>
            <th>(9=6/3)</th>
            <th>(10=7/4)</th>
            <th>(11=8/5)</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            @php 
            $sum_barang_renc = ($rencana_sd_triwulan_lalu["barang"] + $rencana_triwulan[$triwulan_no]["barang"]) / 1e9;
            $sum_barang_real = ($realisasi_sd_triwulan_lalu["barang"] + $realisasi_triwulan[$triwulan_no]["barang"]) / 1e9; 
            @endphp
            <td>1.</td>
            <td>Belanja Barang</td>
            <td style="text-align: right">{{number_format($rencana_sd_triwulan_lalu["barang"] / 1e9, 2)}}</td>
            <td style="text-align: right">{{number_format($rencana_triwulan[$triwulan_no]["barang"] / 1e9, 2)}}</td>
            <td style="text-align: right">{{number_format($sum_barang_renc, 2)}}</td>
            <td style="text-align: right">{{number_format($realisasi_sd_triwulan_lalu["barang"] / 1e9, 2)}}</td>
            <td style="text-align: right">{{number_format($realisasi_triwulan[$triwulan_no]["barang"] / 1e9, 2)}}</td>
            <td style="text-align: right">{{number_format($sum_barang_real, 2)}}</td>
            <td style="text-align: right">@if($rencana_sd_triwulan_lalu["barang"] == 0) 0.00% @else {{number_format($realisasi_sd_triwulan_lalu["barang"] / $rencana_sd_triwulan_lalu["barang"] * 100, 2)}}% @endif</td>
            <td style="text-align: right">@if($rencana_triwulan[$triwulan_no]["barang"] == 0) 0.00% @else {{number_format($realisasi_triwulan[$triwulan_no]["barang"] / $rencana_triwulan[$triwulan_no]["barang"] * 100, 2)}}% @endif</td>
            <td style="text-align: right">@if($sum_barang_renc == 0) 0.00% @else {{number_format($sum_barang_real / $sum_barang_renc * 100, 2)}}% @endif</td>
        </tr>
        <tr>
            @php 
            $sum_modal_renc = ($rencana_sd_triwulan_lalu["modal"] + $rencana_triwulan[$triwulan_no]["modal"]) / 1e9;
            $sum_modal_real = ($realisasi_sd_triwulan_lalu["modal"] + $realisasi_triwulan[$triwulan_no]["modal"]) / 1e9; 
            @endphp
            <td>2.</td>
            <td>Belanja Modal</td>
            <td style="text-align: right">{{number_format($rencana_sd_triwulan_lalu["modal"] / 1e9, 2)}}</td>
            <td style="text-align: right">{{number_format($rencana_triwulan[$triwulan_no]["modal"] / 1e9, 2)}}</td>
            <td style="text-align: right">{{number_format($sum_modal_renc, 2)}}</td>
            <td style="text-align: right">{{number_format($realisasi_sd_triwulan_lalu["modal"] / 1e9, 2)}}</td>
            <td style="text-align: right">{{number_format($realisasi_triwulan[$triwulan_no]["modal"] / 1e9, 2)}}</td>
            <td style="text-align: right">{{number_format($sum_modal_real, 2)}}</td>
            <td style="text-align: right">@if($rencana_sd_triwulan_lalu["modal"] == 0) 0.00% @else {{number_format($realisasi_sd_triwulan_lalu["modal"] / $rencana_sd_triwulan_lalu["modal"] * 100, 2)}}% @endif</td>
            <td style="text-align: right">@if($rencana_triwulan[$triwulan_no]["modal"] == 0) 0.00% @else {{number_format($realisasi_triwulan[$triwulan_no]["modal"] / $rencana_triwulan[$triwulan_no]["modal"] * 100, 2)}}% @endif</td>
            <td style="text-align: right">@if($sum_modal_renc == 0) 0.00% @else {{number_format($sum_modal_real / $sum_modal_renc * 100, 2)}}% @endif</td>
        </tr>
        <tr>
            @php 
            $sum_lainnya_renc = ($rencana_sd_triwulan_lalu["lainnya"] + $rencana_triwulan[$triwulan_no]["lainnya"]) / 1e9;
            $sum_lainnya_real = ($realisasi_sd_triwulan_lalu["lainnya"] + $realisasi_triwulan[$triwulan_no]["lainnya"]) / 1e9; 
            @endphp            
            <td>3.</td>
            <td>Belanja Lainnya *)</td>
            <td style="text-align: right">{{number_format($rencana_sd_triwulan_lalu["lainnya"] / 1e9, 2)}}</td>
            <td style="text-align: right">{{number_format($rencana_triwulan[$triwulan_no]["lainnya"] / 1e9, 2)}}</td>
            <td style="text-align: right">{{number_format($sum_lainnya_renc, 2)}}</td>
            <td style="text-align: right">{{number_format($realisasi_sd_triwulan_lalu["lainnya"] / 1e9, 2)}}</td>
            <td style="text-align: right">{{number_format($realisasi_triwulan[$triwulan_no]["lainnya"] / 1e9, 2)}}</td>
            <td style="text-align: right">{{number_format($sum_lainnya_real, 2)}}</td>
            <td style="text-align: right">@if($rencana_sd_triwulan_lalu["lainnya"] == 0) 0.00% @else {{number_format($realisasi_sd_triwulan_lalu["lainnya"] / $rencana_sd_triwulan_lalu["lainnya"] * 100, 2)}}% @endif</td>
            <td style="text-align: right">@if($rencana_triwulan[$triwulan_no]["lainnya"] == 0) 0.00% @else {{number_format($realisasi_triwulan[$triwulan_no]["lainnya"] / $rencana_triwulan[$triwulan_no]["lainnya"] * 100, 2)}}% @endif</td>
            <td style="text-align: right">@if($sum_lainnya_renc == 0) 0.00% @else {{number_format($sum_lainnya_real / $sum_lainnya_renc * 100, 2)}}% @endif</td>
        </tr>
        <tr>
            @php
            $sum_sdtl_renc = ($rencana_sd_triwulan_lalu["barang"] + $rencana_sd_triwulan_lalu["modal"] + $rencana_sd_triwulan_lalu["lainnya"]) / 1e9;
            $sum_sdti_renc = ($rencana_triwulan[$triwulan_no]["barang"] + $rencana_triwulan[$triwulan_no]["modal"] + $rencana_triwulan[$triwulan_no]["lainnya"]) / 1e9;
            $sum_sdtl_real = ($realisasi_sd_triwulan_lalu["barang"] + $realisasi_sd_triwulan_lalu["modal"] + $realisasi_sd_triwulan_lalu["lainnya"]) / 1e9;
            $sum_sdti_real = ($realisasi_triwulan[$triwulan_no]["barang"] + $realisasi_triwulan[$triwulan_no]["modal"] + $realisasi_triwulan[$triwulan_no]["lainnya"]) / 1e9;
            @endphp
            <td colspan="2">Total</td>
            <td style="text-align: right">{{number_format($sum_sdtl_renc, 2)}}</td>
            <td style="text-align: right">{{number_format($sum_sdti_renc, 2)}}</td>
            <td style="text-align: right">{{number_format($sum_sdtl_renc + $sum_sdti_renc, 2)}}</td>
            <td style="text-align: right">{{number_format($sum_sdtl_real, 2)}}</td>
            <td style="text-align: right">{{number_format($sum_sdti_real, 2)}}</td>
            <td style="text-align: right">{{number_format($sum_sdtl_real + $sum_sdti_real, 2)}}</td>
            <td style="text-align: right">@if($sum_sdtl_renc == 0) 0.00% @else {{number_format($sum_sdtl_real / $sum_sdtl_renc * 100, 2)}}% @endif</td>
            <td style="text-align: right">@if($sum_sdti_renc == 0) 0.00% @else {{number_format($sum_sdti_real / $sum_sdti_renc * 100, 2)}}% @endif</td>
            <td style="text-align: right">@if($sum_sdtl_renc + $sum_sdti_renc == 0) 0.00% @else {{number_format(($sum_sdtl_real + $sum_sdti_real) / ($sum_sdtl_renc + $sum_sdti_renc) * 100, 2)}}% @endif</td>
        </tr>
    </tbody>
</table>

<br>
<p><i>Keterangan: *) Selain Belanja Barang dan Belanja Modal</i></p>

<p>Penyebab dan solusi atas hambatan yang terjadi pada penyerapan anggaran adalah sebagai berikut:</p>

<table class="bordered" style="width: 100%">
    <thead>
        <tr>
            <th>No</th>
            <th>Penyebab Permasalahan</th>
            <th>Rekomendasi</th>
        </tr>
    </thead>
    <tbody>
    @if(count($permasalahan_realisasi) == 0)
        <tr>
            <td colspan="3">(Tidak ada data)</td>
        </tr>
    @else
    @foreach($permasalahan_realisasi as $i => $p)
        <tr>
            <td>
                {{ ++$i }}
            </td>
            <td>
                <strong>Penyebab pada tahap {{$p->kelompok}}</strong>:<br/>
                <p>{{$p->penyebab}}</p><br/>

                <strong>Penjelasan atas penyebab di atas</strong>:<br/>
                <p>{{$p->penyebab_penjelasan}}</p>
            </td>
            <td>
                <strong>Rekomendasi pada tahap {{$p->kelompok}}</strong>:<br/>
                <p>{{$p->rekomendasi}}</p><br/>

                <strong>Penjelasan atas rekomendasi di atas</strong>:<br/>
                <p>{{$p->rekomendasi_penjelasan}}</p>                                 
            </td>
        </tr>
    @endforeach
    @endif
    </tbody>
</table>

<br>
<h2>Progres Pengadaan Barang/Jasa Sampai Dengan Triwulan {{$tw_roman}} Tahun {{$tahun}}</h2>

<p>Posisi pelaksanaan pengadaan barang/jasa pada akhir Triwulan {{$tw_roman}} Tahun {{$tahun}} adalah sebagai berikut:</p>

<table class="bordered" style="width: 100%">
    <thead>
        <tr>
            <th rowspan="2">No</th>
            <th rowspan="2">Tahapan Pengadaan Barang/Jasa</th>
            <th rowspan="2">Jumlah Paket</th>
            <th rowspan="2">Nilai PBJ (Rp)</th>
            <th colspan="2">% Terhadap Target</th>
        </tr>
        <tr>
            <th>Jumlah Paket</th>
            <th>Nilai PBJ</th>
        </tr>
        <tr>
            <th>(1)</th>
            <th>(2)</th>
            <th>(3)</th>
            <th>(4)</th>
            <th>(5)</th>
            <th>(6)</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>1</td>
            <td>Target 2017</td>
            <td style="text-align: right">{{$jumlah_paket}}</td>
            <td style="text-align: right">{{number_format($nilai_paket, 2)}}</td>
            <td colspan="2" style="background-color: #eeeeee"></td>
        </tr>
        <tr>
            <td>2</td>
            <td>Belum dilelang atau masih dalam proses lelang</td>
            <td style="text-align: right">{{$progres_sd_triwulan_ini["belum_dilelang"]["paket"]}}</td>
            <td style="text-align: right">{{number_format($progres_sd_triwulan_ini["belum_dilelang"]["nilai"], 2)}}</td>
            <td style="text-align: right">@if($jumlah_paket == 0) 0.00% @else {{number_format($progres_sd_triwulan_ini["belum_dilelang"]["paket"] / $jumlah_paket * 100, 2)}}% @endif</td>
            <td style="text-align: right">@if($nilai_paket  == 0) 0.00% @else {{number_format($progres_sd_triwulan_ini["belum_dilelang"]["nilai"] / $nilai_paket  * 100, 2)}}% @endif</td>
        </tr>
        <tr>
            <td>3</td>
            <td>Sudah ditetapkan pemenang lelang</td>
            <td style="text-align: right">{{$progres_sd_triwulan_ini["pemenang"]["paket"]}}</td>
            <td style="text-align: right">{{number_format($progres_sd_triwulan_ini["pemenang"]["nilai"], 2)}}</td>
            <td style="text-align: right">@if($jumlah_paket == 0) 0.00% @else {{number_format($progres_sd_triwulan_ini["pemenang"]["paket"] / $jumlah_paket * 100, 2)}}% @endif</td>
            <td style="text-align: right">@if($nilai_paket  == 0) 0.00% @else {{number_format($progres_sd_triwulan_ini["pemenang"]["nilai"] / $nilai_paket  * 100, 2)}}% @endif</td>
        </tr>
        <tr>
            <td>4</td>
            <td>Sudah tanda tangan kontrak namun belum ada realisasi pekerjaan</td>
            <td style="text-align: right">{{$progres_sd_triwulan_ini["belum_realisasi"]["paket"]}}</td>
            <td style="text-align: right">{{number_format($progres_sd_triwulan_ini["belum_realisasi"]["nilai"], 2)}}</td>
            <td style="text-align: right">@if($jumlah_paket == 0) 0.00% @else {{number_format($progres_sd_triwulan_ini["belum_realisasi"]["paket"] / $jumlah_paket * 100, 2)}}% @endif</td>
            <td style="text-align: right">@if($nilai_paket  == 0) 0.00% @else {{number_format($progres_sd_triwulan_ini["belum_realisasi"]["nilai"] / $nilai_paket  * 100, 2)}}% @endif</td>
        </tr>
        <tr>
            <td>5</td>
            <td>Sudah tanda tangan kontrak dan sudah ada realisasi pekerjaan</td>
            <td colspan="4" style="background-color: #eeeeee"></td>
        </tr>
        <tr>
            <td style="text-align: right">a.</td>
            <td>Progres 1 - 25%</td>
            <td style="text-align: right">{{$progres_sd_triwulan_ini["level1"]["paket"]}}</td>
            <td style="text-align: right">{{number_format($progres_sd_triwulan_ini["level1"]["nilai"], 2)}}</td>
            <td style="text-align: right">@if($jumlah_paket == 0) 0.00% @else {{number_format($progres_sd_triwulan_ini["level1"]["paket"] / $jumlah_paket * 100, 2)}}% @endif</td>
            <td style="text-align: right">@if($nilai_paket  == 0) 0.00% @else {{number_format($progres_sd_triwulan_ini["level1"]["nilai"] / $nilai_paket  * 100, 2)}}% @endif</td>
        </tr>
        <tr>
            <td style="text-align: right">b.</td>
            <td>Progres 26 - 50%</td>
            <td style="text-align: right">{{$progres_sd_triwulan_ini["level2"]["paket"]}}</td>
            <td style="text-align: right">{{number_format($progres_sd_triwulan_ini["level2"]["nilai"], 2)}}</td>
            <td style="text-align: right">@if($jumlah_paket == 0) 0.00% @else {{number_format($progres_sd_triwulan_ini["level2"]["paket"] / $jumlah_paket * 100, 2)}}% @endif</td>
            <td style="text-align: right">@if($nilai_paket  == 0) 0.00% @else {{number_format($progres_sd_triwulan_ini["level2"]["nilai"] / $nilai_paket  * 100, 2)}}% @endif</td>
        </tr>
        <tr>
            <td style="text-align: right">c.</td>
            <td>Progres 51 - 75%</td>
            <td style="text-align: right">{{$progres_sd_triwulan_ini["level3"]["paket"]}}</td>
            <td style="text-align: right">{{number_format($progres_sd_triwulan_ini["level3"]["nilai"], 2)}}</td>
            <td style="text-align: right">@if($jumlah_paket == 0) 0.00% @else {{number_format($progres_sd_triwulan_ini["level3"]["paket"] / $jumlah_paket * 100, 2)}}% @endif</td>
            <td style="text-align: right">@if($nilai_paket  == 0) 0.00% @else {{number_format($progres_sd_triwulan_ini["level3"]["nilai"] / $nilai_paket  * 100, 2)}}% @endif</td>
        </tr>
        <tr>
            <td style="text-align: right">d.</td>
            <td>Progres 76 - 99%</td>
            <td style="text-align: right">{{$progres_sd_triwulan_ini["level4"]["paket"]}}</td>
            <td style="text-align: right">{{number_format($progres_sd_triwulan_ini["level4"]["nilai"], 2)}}</td>
            <td style="text-align: right">@if($jumlah_paket == 0) 0.00% @else {{number_format($progres_sd_triwulan_ini["level4"]["paket"] / $jumlah_paket * 100, 2)}}% @endif</td>
            <td style="text-align: right">@if($nilai_paket  == 0) 0.00% @else {{number_format($progres_sd_triwulan_ini["level4"]["nilai"] / $nilai_paket  * 100, 2)}}% @endif</td>
        </tr>
        <tr>
            <td style="text-align: right">e.</td>
            <td>Selesai 100% (PHO)</td>
            <td style="text-align: right">{{$progres_sd_triwulan_ini["level5"]["paket"]}}</td>
            <td style="text-align: right">{{number_format($progres_sd_triwulan_ini["level5"]["nilai"], 2)}}</td>
            <td style="text-align: right">@if($jumlah_paket == 0) 0.00% @else {{number_format($progres_sd_triwulan_ini["level5"]["paket"] / $jumlah_paket * 100, 2)}}% @endif</td>
            <td style="text-align: right">@if($nilai_paket  == 0) 0.00% @else {{number_format($progres_sd_triwulan_ini["level5"]["nilai"] / $nilai_paket  * 100, 2)}}% @endif</td>
        </tr>
    </tbody>
</table>

<br>
<p>Penyebab dan solusi atas hambatan yang terjadi pada pelaksanaan pengadaan barang/jasa adalah sebagai berikut:</p>

<table class="bordered" style="width: 100%">
    <thead>
        <tr>
            <th>No</th>
            <th>Penyebab Permasalahan</th>
            <th>Rekomendasi</th>
        </tr>
    </thead>
    <tbody>
    @if(count($permasalahan_progres) == 0)
        <tr>
            <td colspan="3">(Tidak ada data)</td>
        </tr>
    @else
    @foreach($permasalahan_progres as $i => $p)
        <tr>
            <td>
                {{ ++$i }}
            </td>
            <td>
                <strong>Penyebab pada tahap {{$p->kelompok}}</strong>:<br/>
                <p>{{$p->penyebab}}</p><br/>

                <strong>Penjelasan atas penyebab di atas</strong>:<br/>
                <p>{{$p->penyebab_penjelasan}}</p>
            </td>
            <td>
                <strong>Rekomendasi pada tahap {{$p->kelompok}}</strong>:<br/>
                <p>{{$p->rekomendasi}}</p><br/>

                <strong>Penjelasan atas rekomendasi di atas</strong>:<br/>
                <p>{{$p->rekomendasi_penjelasan}}</p>                                 
            </td>
        </tr>
    @endforeach
    @endif
    </tbody>
</table>