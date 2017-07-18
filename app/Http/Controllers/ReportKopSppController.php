<?php 

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Kop_spp;
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

class ReportKopSppController extends Controller {
    
    public function index()
    {  
//        $test = 'TESTING';
//        $dompdf=PDF::getDomPDF();
//        $dompdf->load_html(View::make('report.pdfreport',['test'=>$test]));
//        $dompdf->set_paper("A4", "portrait");
//        $dompdf->render();
//        $dompdf->get_canvas()->get_cpdf()->setEncryption("userpass", "adminpass");
//        return $dompdf->stream("statement.pdf");   
        
        $user = Auth::user();
        $satker = User::orderBy('name')->get();

        return view('report.indexkopspp', compact('user', 'satker'));
    }
    
    public function pdfReport($user_id, $tahun, $encrypt = 'true')
    {
        $user = Auth::user();
        $satker = User::findOrFail($user_id);
        
        $kop_spp = Kop_spp::where('user_id', $user_id)->where('tahun', $tahun)->get();
        foreach ($kop_spp as $row) {
            $decryption_key = Crypto::getDecryptionKey($user, $row->user);
            $row->decrypt($decryption_key);
            $row->getDipa();
        }
        
        // dapatkan semua kategori uraian
        $kop_group_all = [];
        foreach ($kop_spp as $k) $kop_group_all[] = $k->kategori_uraian;        
        $kop_kategori = array_values(array_unique($kop_group_all));
        
        // bikin dictionary
        $kop_group = [];
        $jumlah_kop = [];
        $jumlah_spp = [];
        foreach ($kop_kategori as $kat) {
            $kop_group[$kat] = [];
            $jumlah_kop[$kat] = 0;
            $jumlah_spp[$kat] = 0;
        }
                
        foreach ($kop_spp as $kop) {
            $kat = $kop->kategori_uraian;
            $kop_group[$kat][] = $kop;
            $jumlah_kop[$kat] += $kop->nilai_kop;
            $jumlah_spp[$kat] += $kop->nilai_spp;
        }        
        
        if (count($kop_kategori) == 0 && count($kop_group) == 0) {
            return view('report.empty');
        }        
        
        // RENDER PDF
        
        $dompdf = PDF::getDomPDF();
        $html = View::make('report.pdfreportkopspp', compact('satker', 'tahun', 'kop_kategori', 'jumlah_kop', 'jumlah_spp', 'kop_group'));
        
        $dompdf->load_html($html);
        $dompdf->set_paper("A4", "landscape");
        $dompdf->render();
        
        $filename = sprintf("Laporan Kop dan SPP - %s (%s)", $satker->name, $tahun);
        
        if ($encrypt == 'true') {
            $pdf_password = session()->get('pass_plain');
            $dompdf->get_canvas()->get_cpdf()->setEncryption($pdf_password, $pdf_password);
        }
        
        return $dompdf->stream($filename);
    }

    public function excelReport($user_id, $tahun, $encrypt = 'true')
    {
        $user = Auth::user();
        $satker = User::findOrFail($user_id);
        
        $kop_spp = Kop_spp::where('user_id', $user_id)->where('tahun', $tahun)->get();
        foreach ($kop_spp as $row) {
            $decryption_key = Crypto::getDecryptionKey($user, $row->user);
            $row->decrypt($decryption_key);
            $row->getDipa();
        }
        
        // dapatkan semua kategori uraian
        $kop_group_all = [];
        foreach ($kop_spp as $k) $kop_group_all[] = $k->kategori_uraian;        
        $kop_kategori = array_values(array_unique($kop_group_all));
        
        // bikin dictionary
        $kop_group = [];
        $jumlah_kop = [];
        $jumlah_spp = [];
        foreach ($kop_kategori as $kat) {
            $kop_group[$kat] = [];
            $jumlah_kop[$kat] = 0;
            $jumlah_spp[$kat] = 0;
        }
                
        foreach ($kop_spp as $kop) {
            $kat = $kop->kategori_uraian;
            $kop_group[$kat][] = $kop;
            $jumlah_kop[$kat] += $kop->nilai_kop;
            $jumlah_spp[$kat] += $kop->nilai_spp;
        }        
        
        if (count($kop_kategori) == 0 && count($kop_group) == 0) {
            return view('report.empty');
        }        
        
        // dd($kop_kategori, $kop_group, $jumlah_kop, $jumlah_spp);        
        // EXCEL LOAD
        
        $template = app_path() . '/ExcelTemplates/laporan_kop_spp.xlsx';
        $objPHPExcel = PHPExcel_IOFactory::load($template);

        $sheet = $objPHPExcel->setActiveSheetIndex(0);
        replaceCellValue($sheet, "A1", "{TAHUN}", $tahun);
        replaceCellValue($sheet, "A5", "{SATKER}", $satker->name);        
        
        $row = 12;
        
        $boldFont = array(
            'font' => array(
                'bold' => true
            ),
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        );

        $allBorders = array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        );

        foreach ($kop_kategori as $kat) {
            
            $sheet->setCellValueByColumnAndRow(2, $row, $kat);
            $sheet->setCellValueByColumnAndRow(3, $row, $jumlah_kop[$kat]);
            $sheet->setCellValueByColumnAndRow(11, $row, $jumlah_spp[$kat]);
            
            $sheet->getStyleByColumnAndRow(3, $row)->getNumberFormat()->setFormatCode("#,##0.00");
            $sheet->getStyleByColumnAndRow(11, $row)->getNumberFormat()->setFormatCode("#,##0.00");
            
            $sheet->getStyleByColumnAndRow(0, $row, 12, $row)->applyFromArray($boldFont);
            $row++;
            
            foreach ($kop_group[$kat] as $kop) {
                $sheet->setCellValueByColumnAndRow(0, $row, $kop->no_kop);
                $sheet->setCellValueByColumnAndRow(1, $row, $kop->tgl_kop);
                $sheet->setCellValueByColumnAndRow(2, $row, $kop->uraian_kop);
                $sheet->setCellValueByColumnAndRow(3, $row, $kop->nilai_kop);
                
                $sheet->setCellValueByColumnAndRow(4, $row, $kop->no_kontrak . '/' . $kop->tgl_kontrak);
                $sheet->setCellValueByColumnAndRow(5, $row, $kop->nilai_kontrak);
                $sheet->setCellValueByColumnAndRow(6, $row, $kop->no_bap . '/' . $kop->tgl_bap);
                $sheet->setCellValueByColumnAndRow(7, $row, $kop->no_bast . '/' . $kop->tgl_bast);
                
                $sheet->setCellValueByColumnAndRow(8, $row, $kop->uraian_spp);
                $sheet->setCellValueByColumnAndRow(9, $row, $kop->no_spp);
                $sheet->setCellValueByColumnAndRow(10, $row, $kop->tgl_spp);
                $sheet->setCellValueByColumnAndRow(11, $row, $kop->nilai_spp);
                $sheet->setCellValueByColumnAndRow(12, $row, $kop->nilai_kop - $kop->nilai_spp);

                $sheet->getStyleByColumnAndRow(3, $row)->getNumberFormat()->setFormatCode("#,##0.00");
                $sheet->getStyleByColumnAndRow(5, $row)->getNumberFormat()->setFormatCode("#,##0.00");
                
                $sheet->getStyleByColumnAndRow(11, $row)->getNumberFormat()->setFormatCode("#,##0.00");                
                $sheet->getStyleByColumnAndRow(12, $row)->getNumberFormat()->setFormatCode("#,##0.00");                
                
                $sheet->getStyleByColumnAndRow(0, $row, 12, $row)->applyFromArray($allBorders);
                $row++;
            }  
            
            $sheet->getStyleByColumnAndRow(0, $row, 12, $row)->applyFromArray($allBorders);
            $row++;
            
        }
        
        
        // OUTPUT
        
        $filename = sprintf("Laporan Kop dan SPP - %s (%s).xlsx", $satker->name, $tahun);
        
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
