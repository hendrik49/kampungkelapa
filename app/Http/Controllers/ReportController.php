<?php 

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Penyerapan_anggaran_target_pjb;
use App\Models\Penyerapan_anggaran_perjenis_belanja;
use App\Models\Penyerapan_anggaran_setahun_pjb;
use App\Models\Penyerapan_anggaran_triwulan_modal;
use App\Models\Penyerapan_anggaran_triwulan_barang;
use App\Models\Penyerapan_anggaran_triwulan_lainnya;
use App\Models\Realisasi_anggaran_target_pjb;
use App\Models\Progres_pjb;
use App\User;
use Illuminate\Support\Facades\Auth;
use App\Helpers\Crypto;
use PHPExcel_IOFactory;
use PHPExcel_Style_Border;
use PDF;
use View;

function startsWith($haystack, $needle)
{
    $length = strlen($needle);
    return (substr($haystack, 0, $length) === $needle);
}

function replaceCellValue($sheet, $coords, $find, $replace)
{
    $sheet->setCellValue($coords, str_replace($find, $replace, $sheet->getCell($coords)->getValue()));
}

function M($value)
{
    // TODO: dibagi semilyar
    return $value / 1e9;
}

function triwulan_roman($no) {
    return ['', 'I', 'II', 'III', 'IV'][$no];
}

class ReportController extends Controller {
    
    public function index()
    {  
        $user = Auth::user();
        $satker = User::orderBy('name')->get();

        $currMonth = intval(date('m'));
        $triwu = [1 => 'I', 2 => 'II', 3 => 'III', 4 => 'IV'];
        $currTriwu = ceil($currMonth/3);

        return view('report.index', compact('user', 'satker', 'triwu', 'currTriwu'));
    }

    public static function getPjbSetahun($user_id, $tahun)
    {
        if (intval($user_id) === 0)
            $penyerapan_anggaran_setahun_pjbs_q = Penyerapan_anggaran_setahun_pjb::get();
        else
            $penyerapan_anggaran_setahun_pjbs_q = Penyerapan_anggaran_setahun_pjb::Where('user_id', intval($user_id))->get();

        $penyerapan_anggaran_setahun_pjbs = [];
        foreach ($penyerapan_anggaran_setahun_pjbs_q as $row) {
            $decryption_key = Crypto::getDecryptionKey(Auth::user(), $row->user);
            $row->decrypt($decryption_key);
            if (intval($row->tahun) == intval($tahun)) {
                $penyerapan_anggaran_setahun_pjbs[] = $row;
            }
        }     

        return $penyerapan_anggaran_setahun_pjbs;
    }    
    
    public static function getRencanaAnggaran($user_id, $tahun)
    {
        if (intval($user_id) === 0)
            $penyerapan_anggaran_target_pjbs_q = Penyerapan_anggaran_target_pjb::get();
        else
            $penyerapan_anggaran_target_pjbs_q = Penyerapan_anggaran_target_pjb::Where('user_id', intval($user_id))->get();

        $penyerapan_anggaran_target_pjbs = [];
        foreach ($penyerapan_anggaran_target_pjbs_q as $row) {
            $decryption_key = Crypto::getDecryptionKey(Auth::user(), $row->user);
            $row->decrypt($decryption_key);
            if ($row->tahun_anggaran == intval($tahun) && $row->jenis == 'd' && $row->status == 'FINAL') {
                $penyerapan_anggaran_target_pjbs[] = $row;
            }
        }     

        return $penyerapan_anggaran_target_pjbs;
    }

    public static function getRealisasiAnggaran($user_id, $tahun)
    {
         if (intval($user_id) === 0)
            $realisasi_anggaran_target_pjbs_q = Realisasi_anggaran_target_pjb::get();
         else          
            $realisasi_anggaran_target_pjbs_q = Realisasi_anggaran_target_pjb::Where('user_id', intval($user_id))->get();
         
        $realisasi_anggaran_target_pjbs = [];
        foreach ($realisasi_anggaran_target_pjbs_q as $row) {
            $decryption_key = Crypto::getDecryptionKey(Auth::user(), $row->user);
            $row->decrypt($decryption_key);
            $row->getDetails();
            if ($row->tahun_anggaran == intval($tahun) && $row->jenis == 'd' && $row->status == 'FINAL') {
                $realisasi_anggaran_target_pjbs[] = $row;
            }
        }     

        return $realisasi_anggaran_target_pjbs;
    }
    
    public static function getProgressAnggaran($user_id, $tahun)
    {
         if (intval($user_id) === 0)
            $progres_pjbs_q = Progres_pjb::get();
         else          
            $progres_pjbs_q = Progres_pjb::Where('user_id', intval($user_id))->get();
         
        $progres_pjbs = [];
        foreach ($progres_pjbs_q as $row) {
            $decryption_key = Crypto::getDecryptionKey(Auth::user(), $row->user);
            $row->decrypt($decryption_key);
            if ($row->tahun_anggaran == intval($tahun) && $row->status == 'FINAL') {
                $progres_pjbs[] = $row;
            }
        }     

        return $progres_pjbs;
    }    
    
    private function aggregateTriwulan($triwulan, $until)
    {
        $agg = ["barang" => 0, "modal" => 0, "sosial" => 0, "lainnya" => 0];
        for ($t = 1; $t <= $until; $t++) {
            $agg['barang'] += $triwulan[$t]['barang'];
            $agg['modal'] += $triwulan[$t]['modal'];
            $agg['sosial'] += $triwulan[$t]['sosial'];
            $agg['lainnya'] += $triwulan[$t]['lainnya'];
        }
        return $agg;
    }

    private function aggregateTriwulanProgres($triwulan, $until)
    {
        $agg = [
            "belum_dilelang"    => ["paket" => 0,"nilai" => 0], 
            "pemenang"          => ["paket" => 0,"nilai" => 0], 
            "belum_realisasi"   => ["paket" => 0,"nilai" => 0], 
            "level1"            => ["paket" => 0,"nilai" => 0], 
            "level2"            => ["paket" => 0,"nilai" => 0], 
            "level3"            => ["paket" => 0,"nilai" => 0], 
            "level4"            => ["paket" => 0,"nilai" => 0], 
            "level5"            => ["paket" => 0,"nilai" => 0],            
        ];
        $pt_keys = array_keys($agg);
        for ($t = 1; $t <= $until; $t++) {
            foreach ($pt_keys as $key) {
                $agg[$key]["paket"] += $triwulan[$t][$key]["paket"];
                $agg[$key]["nilai"] += $triwulan[$t][$key]["nilai"];
            }
        }
        return $agg;
    }    
    
    public function download($format, $user_id, $tahun, $triwulan_no, $encrypt = 'true')
    {
        $user = Auth::user();
        
        if (intval($user_id) !== 0) {
            $satker = User::findOrFail($user_id);
        } else {
            $satker = new \stdClass();
            $satker->name = "Seluruh Satuan Kerja";
        }

        // CALCULATIONS
        $pagu = ["barang" => 0, "modal" => 0, "sosial" => 0, "lainnya" => 0];
        $rencana_triwulan = [];
        $rencana_triwulan[1] = ["barang" => 0, "modal" => 0, "sosial" => 0, "lainnya" => 0];
        $rencana_triwulan[2] = ["barang" => 0, "modal" => 0, "sosial" => 0, "lainnya" => 0];
        $rencana_triwulan[3] = ["barang" => 0, "modal" => 0, "sosial" => 0, "lainnya" => 0];
        $rencana_triwulan[4] = ["barang" => 0, "modal" => 0, "sosial" => 0, "lainnya" => 0];

        $realisasi_triwulan = [];
        $realisasi_triwulan[1] = ["barang" => 0, "modal" => 0, "sosial" => 0, "lainnya" => 0];
        $realisasi_triwulan[2] = ["barang" => 0, "modal" => 0, "sosial" => 0, "lainnya" => 0];
        $realisasi_triwulan[3] = ["barang" => 0, "modal" => 0, "sosial" => 0, "lainnya" => 0];
        $realisasi_triwulan[4] = ["barang" => 0, "modal" => 0, "sosial" => 0, "lainnya" => 0];        
        
        $progres_triwulan = [];
        $progres_triwulan[1] = [
            "belum_dilelang"    => ["paket" => 0,"nilai" => 0], 
            "pemenang"          => ["paket" => 0,"nilai" => 0], 
            "belum_realisasi"   => ["paket" => 0,"nilai" => 0], 
            "level1"            => ["paket" => 0,"nilai" => 0], 
            "level2"            => ["paket" => 0,"nilai" => 0], 
            "level3"            => ["paket" => 0,"nilai" => 0], 
            "level4"            => ["paket" => 0,"nilai" => 0], 
            "level5"            => ["paket" => 0,"nilai" => 0],
        ];
        $progres_triwulan[2] = [
            "belum_dilelang"    => ["paket" => 0,"nilai" => 0], 
            "pemenang"          => ["paket" => 0,"nilai" => 0], 
            "belum_realisasi"   => ["paket" => 0,"nilai" => 0], 
            "level1"            => ["paket" => 0,"nilai" => 0], 
            "level2"            => ["paket" => 0,"nilai" => 0], 
            "level3"            => ["paket" => 0,"nilai" => 0], 
            "level4"            => ["paket" => 0,"nilai" => 0], 
            "level5"            => ["paket" => 0,"nilai" => 0],
        ];
        $progres_triwulan[3] = [
            "belum_dilelang"    => ["paket" => 0,"nilai" => 0], 
            "pemenang"          => ["paket" => 0,"nilai" => 0], 
            "belum_realisasi"   => ["paket" => 0,"nilai" => 0], 
            "level1"            => ["paket" => 0,"nilai" => 0], 
            "level2"            => ["paket" => 0,"nilai" => 0], 
            "level3"            => ["paket" => 0,"nilai" => 0], 
            "level4"            => ["paket" => 0,"nilai" => 0], 
            "level5"            => ["paket" => 0,"nilai" => 0],
        ];
        $progres_triwulan[4] = [
            "belum_dilelang"    => ["paket" => 0,"nilai" => 0], 
            "pemenang"          => ["paket" => 0,"nilai" => 0], 
            "belum_realisasi"   => ["paket" => 0,"nilai" => 0], 
            "level1"            => ["paket" => 0,"nilai" => 0], 
            "level2"            => ["paket" => 0,"nilai" => 0], 
            "level3"            => ["paket" => 0,"nilai" => 0], 
            "level4"            => ["paket" => 0,"nilai" => 0], 
            "level5"            => ["paket" => 0,"nilai" => 0],
        ];
        
        $nama_dipa = [];
        $tanggal_dipa = [];
        $jumlah_paket = 0; // setahun
        $nilai_paket = 0;  // setahun

        list($count_rencana, $count_realisasi, $count_progres) = [0, 0, 0];
        
        // untuk setiap DIPA rencana
        foreach (self::getRencanaAnggaran($user_id, $tahun) as $dipa) {
            $nama_dipa[] = $dipa->nama_dipa;
            $tanggal_dipa[] = $dipa->tanggal_dipa;
            $penyerapan_anggaran_perjenis_belanja = Penyerapan_anggaran_perjenis_belanja::find($dipa->id);
            if ($penyerapan_anggaran_perjenis_belanja) {
                $decryption_key = Crypto::getDecryptionKey($user, $penyerapan_anggaran_perjenis_belanja->user);
                $penyerapan_anggaran_perjenis_belanja->decrypt($decryption_key);
                $pagu['barang']  += $penyerapan_anggaran_perjenis_belanja->belanja_barang;
                $pagu['modal']   += $penyerapan_anggaran_perjenis_belanja->belanja_modal;
                $pagu['lainnya'] += $penyerapan_anggaran_perjenis_belanja->belanja_lainnya;
            }
            
            $penyerapan_anggaran_triwulan_modal = Penyerapan_anggaran_triwulan_modal::find($dipa->id);
            if ($penyerapan_anggaran_triwulan_modal) {
                $decryption_key = Crypto::getDecryptionKey($user, $penyerapan_anggaran_triwulan_modal->user);
                $penyerapan_anggaran_triwulan_modal->decrypt($decryption_key);
                for ($t = 1; $t <= 4; $t++) 
                    $rencana_triwulan[$t]['modal'] += $penyerapan_anggaran_triwulan_modal->{"triwulan_" . $t};
            }

            $penyerapan_anggaran_triwulan_barang = Penyerapan_anggaran_triwulan_barang::find($dipa->id);
            if ($penyerapan_anggaran_triwulan_barang) {
                $decryption_key = Crypto::getDecryptionKey($user, $penyerapan_anggaran_triwulan_barang->user);
                $penyerapan_anggaran_triwulan_barang->decrypt($decryption_key);
                for ($t = 1; $t <= 4; $t++) 
                    $rencana_triwulan[$t]['barang'] += $penyerapan_anggaran_triwulan_barang->{"triwulan_" . $t};
            }

            $penyerapan_anggaran_triwulan_lainnya = Penyerapan_anggaran_triwulan_lainnya::find($dipa->id);
            if ($penyerapan_anggaran_triwulan_lainnya) {
                $decryption_key = Crypto::getDecryptionKey($user, $penyerapan_anggaran_triwulan_lainnya->user);
                $penyerapan_anggaran_triwulan_lainnya->decrypt($decryption_key);
                for ($t = 1; $t <= 4; $t++) 
                    $rencana_triwulan[$t]['lainnya'] += $penyerapan_anggaran_triwulan_lainnya->{"triwulan_" . $t};
            }

            $count_rencana++;
        }
        
        // untuk setiap PJB setaun
        foreach (self::getPjbSetahun($user_id, $tahun) as $p) {
            $jumlah_paket += $p->target_paket_pjb;
            $nilai_paket  += $p->nilai_paket_pjb;
        }        
        
        // untuk setiap DIPA realisasi
        $permasalahan_realisasi = [];
        foreach (self::getRealisasiAnggaran($user_id, $tahun) as $realisasi) {
            $t = intval($realisasi->triwulan);
            $realisasi_triwulan[$t]['barang']  += $realisasi->belanja_barang;
            $realisasi_triwulan[$t]['modal']   += $realisasi->belanja_modal;
            $realisasi_triwulan[$t]['lainnya'] += $realisasi->belanja_lainnya;
            if (isset($realisasi->permasalahan) && $realisasi->triwulan == $triwulan_no)
                $permasalahan_realisasi = array_merge($permasalahan_realisasi, $realisasi->permasalahan);
            $count_realisasi++;
        }
        
        // untuk setiap DIPA progress
        $pt_keys = array_keys($progres_triwulan[1]);
        $permasalahan_progres = [];
        foreach (self::getProgressAnggaran($user_id, $tahun) as $progress) {
            $t = intval($progress->triwulan);
            foreach ($pt_keys as $key) {
                $progres_triwulan[$t][$key]["paket"] += $progress->{"jumlah_paket_" . $key}; // magic
                $progres_triwulan[$t][$key]["nilai"] += $progress->{"nilai_pjb_" . $key};
            }
            if (isset($progress->permasalahan) && $progress->triwulan == $triwulan_no)
                $permasalahan_progres = array_merge($permasalahan_progres, $progress->permasalahan);
            $count_progres++;
        }
        
        if ($count_rencana == 0 && $count_realisasi == 0 && $count_progres == 0) {
            return view('report.empty');
        }
        
        $triwulan_lalu = $triwulan_no - 1;
        $rencana_sd_triwulan_lalu = $this->aggregateTriwulan($rencana_triwulan, $triwulan_lalu);
        $realisasi_sd_triwulan_lalu = $this->aggregateTriwulan($realisasi_triwulan, $triwulan_lalu);
        $progres_sd_triwulan_ini = $this->aggregateTriwulanProgres($progres_triwulan, $triwulan_no);
        
        // dd($progres_triwulan, $progres_sd_triwulan_ini);        
        // dd($rencana_sd_triwulan_lalu, $realisasi_sd_triwulan_lalu, $realisasi_triwulan);
        
        if ($format == 'pdf') {
            
            $tw_roman = triwulan_roman($triwulan_no);            
            
            $dompdf = PDF::getDomPDF();
            $html = View::make('report.pdfreport', compact(
                        'tw_roman', 'tahun', 'satker', 'nama_dipa', 'tanggal_dipa', 'pagu', 'rencana_triwulan', 'jumlah_paket', 'nilai_paket', 
                        'triwulan_no', 'rencana_sd_triwulan_lalu', 'realisasi_sd_triwulan_lalu', 'rencana_triwulan', 'realisasi_triwulan', 'permasalahan_realisasi',
                        'progres_sd_triwulan_ini', 'permasalahan_progres'
                    ));

            $dompdf->load_html($html);
            $dompdf->set_paper("A4", "portrait");
            $dompdf->render();

            $filename = sprintf("Laporan Anggaran - %s (Triwulan %s - %s)", $satker->name, triwulan_roman($triwulan_no), $tahun);

            if ($encrypt == 'true') {
                $pdf_password = session()->get('pass_plain');
                $dompdf->get_canvas()->get_cpdf()->setEncryption($pdf_password, $pdf_password);
            }

            return $dompdf->stream($filename);
            
            
        } // else:        
        
        $template = app_path() . '/ExcelTemplates/laporan_anggaran.xlsx';
        $objPHPExcel = PHPExcel_IOFactory::load($template);
        
        $allBorders = array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        );        
        
        // WORKSHEET: Rencana
        $sheet = $objPHPExcel->setActiveSheetIndexByName("Rencana");
        replaceCellValue($sheet, "B2", "{TAHUN}", $tahun);
        replaceCellValue($sheet, "B3", "{SATKER}", $satker->name);
        
        $sheet->setCellValue("E5", implode(", ", $nama_dipa));
        $sheet->setCellValue("E6", implode(", ", $tanggal_dipa));

        $sheet->setCellValue("E8",  ($pagu['barang']));
        $sheet->setCellValue("E9",  ($pagu['modal']));
        $sheet->setCellValue("E10", ($pagu['lainnya']));
        
        $sheet->setCellValue("D19", M($pagu['barang']));
        $sheet->setCellValue("E19", M($pagu['modal']));
        $sheet->setCellValue("F19", M($pagu['lainnya']));

        $sheet->setCellValue("D21", M($rencana_triwulan[1]['barang']));
        $sheet->setCellValue("E21", M($rencana_triwulan[1]['modal']));
        $sheet->setCellValue("F21", M($rencana_triwulan[1]['lainnya']));

        $sheet->setCellValue("D22", M($rencana_triwulan[2]['barang']));
        $sheet->setCellValue("E22", M($rencana_triwulan[2]['modal']));
        $sheet->setCellValue("F22", M($rencana_triwulan[2]['lainnya']));

        $sheet->setCellValue("D23", M($rencana_triwulan[3]['barang']));
        $sheet->setCellValue("E23", M($rencana_triwulan[3]['modal']));
        $sheet->setCellValue("F23", M($rencana_triwulan[3]['lainnya']));

        $sheet->setCellValue("D24", M($rencana_triwulan[4]['barang']));
        $sheet->setCellValue("E24", M($rencana_triwulan[4]['modal']));
        $sheet->setCellValue("F24", M($rencana_triwulan[4]['lainnya']));
        
        replaceCellValue($sheet, "E31", "{JUMLAH_PAKET}", (string)$jumlah_paket);
        replaceCellValue($sheet, "E32", "{NILAI_PAKET}", (string)(number_format($nilai_paket, 2)));

        // WORKSHEET: Realisasi        
        $sheet = $objPHPExcel->setActiveSheetIndexByName("Realisasi");
        replaceCellValue($sheet, "B2", "{TRIWULAN_R}", triwulan_roman($triwulan_no));
        replaceCellValue($sheet, "B2", "{TAHUN}", $tahun);
        replaceCellValue($sheet, "B5", "{TRIWULAN_R}", triwulan_roman($triwulan_no));
        replaceCellValue($sheet, "B5", "{TAHUN}", $tahun);
        replaceCellValue($sheet, "B3", "{SATKER}", $satker->name);
        for ($i = ord('D'); $i <= ord('L'); $i++)
            replaceCellValue($sheet, chr($i) . "8", "{TRIWULAN_R}", triwulan_roman($triwulan_no));

        $sheet->setCellValue("D10", M($rencana_sd_triwulan_lalu['barang']));
        $sheet->setCellValue("D11", M($rencana_sd_triwulan_lalu['modal']));
        $sheet->setCellValue("D12", M($rencana_sd_triwulan_lalu['lainnya']));

        $sheet->setCellValue("E10", M($rencana_triwulan[$triwulan_no]['barang']));
        $sheet->setCellValue("E11", M($rencana_triwulan[$triwulan_no]['modal']));
        $sheet->setCellValue("E12", M($rencana_triwulan[$triwulan_no]['lainnya']));
        
        $sheet->setCellValue("G10", M($realisasi_sd_triwulan_lalu['barang']));
        $sheet->setCellValue("G11", M($realisasi_sd_triwulan_lalu['modal']));
        $sheet->setCellValue("G12", M($realisasi_sd_triwulan_lalu['lainnya']));        
        
        $sheet->setCellValue("H10", M($realisasi_triwulan[$triwulan_no]['barang']));
        $sheet->setCellValue("H11", M($realisasi_triwulan[$triwulan_no]['modal']));
        $sheet->setCellValue("H12", M($realisasi_triwulan[$triwulan_no]['lainnya']));
        
        $row = 20;
        foreach ($permasalahan_realisasi as $i => $p) {
            $sheet->mergeCellsByColumnAndRow(2, $row, 4, $row);
            $sheet->mergeCellsByColumnAndRow(5, $row, 8, $row);
            $sheet->getStyleByColumnAndRow(2, $row, 8, $row)->getAlignment()->setWrapText(true);
            $sheet->getRowDimension($row)->setRowHeight(60);
            $sheet->getStyleByColumnAndRow(1, $row, 8, $row)->applyFromArray($allBorders);
            
            $sheet->setCellValueByColumnAndRow(1, $row, ($i + 1));
            
            $penyebab  = "Penyebab pada tahap {$p->kelompok}: \r\n{$p->penyebab}\r\n\r\n";
            $penyebab .= "Penjelasan atas penyebab di atas: \r\n{$p->penyebab_penjelasan}";
            $rekomendasi  = "Rekomendasi pada tahap {$p->kelompok}: \r\n{$p->rekomendasi}\r\n\r\n";
            $rekomendasi .= "Penjelasan atas rekomendasi di atas: \r\n{$p->rekomendasi_penjelasan}";
            
            $sheet->setCellValueByColumnAndRow(2, $row, $penyebab);
            $sheet->setCellValueByColumnAndRow(5, $row, $rekomendasi);
            
            $row++;
        }

        // WORKSHEET: Progress
        $sheet = $objPHPExcel->setActiveSheetIndexByName("Progres");
        replaceCellValue($sheet, "B2", "{TRIWULAN_R}", triwulan_roman($triwulan_no));
        replaceCellValue($sheet, "B2", "{TAHUN}", $tahun);
        replaceCellValue($sheet, "B5", "{TRIWULAN_R}", triwulan_roman($triwulan_no));
        replaceCellValue($sheet, "B5", "{TAHUN}", $tahun);
        replaceCellValue($sheet, "B3", "{SATKER}", $satker->name);
        replaceCellValue($sheet, "C10", "{TAHUN}", $tahun);

        $sheet->setCellValue("D10", $jumlah_paket);
        $sheet->setCellValue("E10", $nilai_paket);

        $sheet->setCellValue("D11", $progres_sd_triwulan_ini["belum_dilelang"]["paket"]);
        $sheet->setCellValue("E11", $progres_sd_triwulan_ini["belum_dilelang"]["nilai"]);
        $sheet->setCellValue("D12", $progres_sd_triwulan_ini["pemenang"]["paket"]);
        $sheet->setCellValue("E12", $progres_sd_triwulan_ini["pemenang"]["nilai"]);
        $sheet->setCellValue("D13", $progres_sd_triwulan_ini["belum_realisasi"]["paket"]);
        $sheet->setCellValue("E13", $progres_sd_triwulan_ini["belum_realisasi"]["nilai"]);

        $sheet->setCellValue("D15", $progres_sd_triwulan_ini["level1"]["paket"]);
        $sheet->setCellValue("E15", $progres_sd_triwulan_ini["level1"]["nilai"]);
        $sheet->setCellValue("D16", $progres_sd_triwulan_ini["level2"]["paket"]);
        $sheet->setCellValue("E16", $progres_sd_triwulan_ini["level2"]["nilai"]);
        $sheet->setCellValue("D17", $progres_sd_triwulan_ini["level3"]["paket"]);
        $sheet->setCellValue("E17", $progres_sd_triwulan_ini["level3"]["nilai"]);
        $sheet->setCellValue("D18", $progres_sd_triwulan_ini["level4"]["paket"]);
        $sheet->setCellValue("E18", $progres_sd_triwulan_ini["level4"]["nilai"]);
        $sheet->setCellValue("D19", $progres_sd_triwulan_ini["level5"]["paket"]);
        $sheet->setCellValue("E19", $progres_sd_triwulan_ini["level5"]["nilai"]);        
        
        $row = 24;
        foreach ($permasalahan_progres as $i => $p) {
            $sheet->mergeCellsByColumnAndRow(2, $row, 3, $row);
            $sheet->mergeCellsByColumnAndRow(4, $row, 6, $row);
            $sheet->getStyleByColumnAndRow(2, $row, 6, $row)->getAlignment()->setWrapText(true);
            $sheet->getRowDimension($row)->setRowHeight(60);
            $sheet->getStyleByColumnAndRow(1, $row, 6, $row)->applyFromArray($allBorders);
            
            $sheet->setCellValueByColumnAndRow(1, $row, ($i + 1));
            
            $penyebab  = "Penyebab pada tahap {$p->kelompok}: \r\n{$p->penyebab}\r\n\r\n";
            $penyebab .= "Penjelasan atas penyebab di atas: \r\n{$p->penyebab_penjelasan}";
            $rekomendasi  = "Rekomendasi pada tahap {$p->kelompok}: \r\n{$p->rekomendasi}\r\n\r\n";
            $rekomendasi .= "Penjelasan atas rekomendasi di atas: \r\n{$p->rekomendasi_penjelasan}";
            
            $sheet->setCellValueByColumnAndRow(2, $row, $penyebab);
            $sheet->setCellValueByColumnAndRow(4, $row, $rekomendasi);
            
            $row++;
        }
        
        
        // OUTPUT
        $objPHPExcel->setActiveSheetIndexByName("Rencana");
        $filename = sprintf("Laporan Anggaran - %s (Triwulan %s - %s).xlsx", $satker->name, triwulan_roman($triwulan_no), $tahun);
        
        if ($encrypt == 'true') {
            $xlsx_password = session()->get('pass_plain');
            $encrypted_path = $this->saveAndEncrypt($objPHPExcel, $xlsx_password);

            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="' . $filename . '"');
            header('Cache-Control: max-age=0');

            readfile($encrypted_path);
            exit;        
        } else {
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="' . $filename . '"');
            header('Cache-Control: max-age=0');
            
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
            $objWriter->setPreCalculateFormulas(true);
            $objWriter->save('php://output');            
        }

    }
    
    private function saveAndEncrypt($objPHPExcel, $password)
    {
        $tmpIn  = tempnam('/tmp', 'laporan_u_');
        $tmpOut = tempnam('/tmp', 'laporan_e_');
        unlink($tmpOut);
        
        $xlsxEncryptPath = dirname(app_path()) . '/XlsxEncrypt/dist/XlsxEncrypt.jar';
        
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->setPreCalculateFormulas(true);
        $objWriter->save($tmpIn);

        chmod($tmpIn,  0777);
                
        $cmd = sprintf("java -jar %s %s %s %s 2>&1", escapeshellarg($xlsxEncryptPath), escapeshellarg($tmpIn), escapeshellarg($tmpOut), escapeshellarg($password));
        $output = shell_exec($cmd);
        
        if ($output) {
            abort(500, "Error saat mengunci file Excel: " . $output);
        } else {
            unlink($tmpIn);
            return $tmpOut;
        }
        
    }
    
}
