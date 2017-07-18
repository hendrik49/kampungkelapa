package xlsxencrypt;

import java.io.FileInputStream;
import java.io.FileOutputStream;
import java.io.File;
import java.io.OutputStream;

import org.apache.poi.poifs.crypt.*;
import org.apache.poi.openxml4j.opc.*;
import org.apache.poi.poifs.filesystem.POIFSFileSystem;
import org.apache.poi.ss.usermodel.*;

/**
 *
 * @author abrari
 */
public class XlsxEncrypt {

    public static void encrypt_xlsx(String in_fname, String out_fname, String password) throws Exception {
        
        File in_f = new File(in_fname);
        Workbook in_wb = WorkbookFactory.create(in_f, password);
        FileInputStream in_fis = new FileInputStream(in_fname);
        in_wb.close();
        
        POIFSFileSystem out_poi_fs = new POIFSFileSystem();
        EncryptionInfo info = new EncryptionInfo(EncryptionMode.agile);
        Encryptor enc = info.getEncryptor();
        enc.confirmPassword(password);
        OPCPackage opc = OPCPackage.open(in_f, PackageAccess.READ_WRITE);
        OutputStream out_os = enc.getDataStream(out_poi_fs);
        opc.save(out_os);
        opc.close();
        
        FileOutputStream out_fos = new FileOutputStream(out_fname);
        out_poi_fs.writeFilesystem(out_fos);
        out_fos.close();
        
    }
    
    public static void main(String[] args) throws Exception {
        // TODO code application logic here
        
        String in_f  = args[0];
        String out_f = args[1];
        String pass  = args[2];
        
        encrypt_xlsx(in_f, out_f, pass);
        
        
    }
    
}
