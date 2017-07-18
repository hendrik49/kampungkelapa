<style>

    body {
        font-family: 'sans-serif';
    }
    table thead td {
        text-align: center;
    }
    table , td, th {
        border: 1px solid #595959;
        border-collapse: collapse;
        font-size: 11px;
        padding: 5px;
    }
    td, th {
        padding: 3px;
        width: 30px;
        height: 25px;
    }
    th {
        background: #dddddd;
    }    

</style>

<h1>Laporan Kop & SPP Itjen TNI Tahun {{$tahun}}</h1>

<h3>Unit Organisasi: {{$satker->name}}</h3>

<table width="100%">
    <thead>
        <tr>
            <td colspan="4">KOP</td>
            <td rowspan="2">NO KONTRAK/SPK</td>
            <td rowspan="3">NILAI KONTRAK</td>
            <td rowspan="2">NO BAP</td>
            <td rowspan="2">NO BAST</td>
            <td rowspan="3">URAIAN SPP</td>
            <td colspan="3">SPP</td>
            <td rowspan="3">SISA ANGGARAN</td>
        </tr>
        <tr>
            <td rowspan="2">NO KOP</td>
            <td rowspan="2">TGL KOP</td>
            <td rowspan="2">PERIHAL KOP</td>
            <td rowspan="2">DANA DITERIMA NILAI KOP</td>
            <td rowspan="2">NO SPP</td>
            <td rowspan="2">TGL SPP</td>
            <td rowspan="2">NILAI SPP</td>
        </tr>
        <tr>
            <td>Tanggal</td>
            <td>Tanggal</td>
            <td>Tanggal</td>
        </tr>
        <tr>
            <td>1</td>
            <td>2</td>
            <td>3</td>
            <td>4</td>
            <td>5</td>
            <td>6</td>
            <td>7</td>
            <td>8</td>
            <td>9</td>
            <td>10</td>
            <td>11</td>
            <td>12</td>
            <td>13</td>
        </tr>
        <tr>
            <td colspan="13" style="background-color: #DDDDDD;">DIPA PUSAT</td>
        </tr>
    </thead>
    <tbody>
        @foreach($kop_kategori as $kat)
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>        
        <tr>
            <td></td>
            <td></td>
            <td><b>{{$kat}}</b></td>
            <td><b>{{number_format($jumlah_kop[$kat])}}</b></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td><b>{{number_format($jumlah_spp[$kat])}}</b></td>
            <td></td>
        </tr>
        @foreach($kop_group[$kat] as $kop)
        <tr>
            <td>{{ $kop->no_kop }}</td>
            <td>{{ $kop->tgl_kop }}</td>
            <td>{{ $kop->uraian_kop }}</td>
            <td>{{ number_format($kop->nilai_kop) }}</td>
            <td>{{ $kop->no_kontrak . '/' . $kop->tgl_kontrak }}</td>
            <td>{{ number_format($kop->nilai_kontrak) }}</td>
            <td>{{ $kop->no_bap . '/' . $kop->tgl_bap }}</td>
            <td>{{ $kop->no_bast . '/' . $kop->tgl_bast }}</td>
            <td>{{ $kop->uraian_spp }}</td>
            <td>{{ $kop->no_spp }}</td>
            <td>{{ $kop->tgl_spp }}</td>
            <td>{{ number_format($kop->nilai_spp) }}</td>
            <td>{{ number_format($kop->nilai_kop - $kop->nilai_spp) }}</td>
        </tr>        
        @endforeach
        @endforeach
    </tbody>
    
</table>