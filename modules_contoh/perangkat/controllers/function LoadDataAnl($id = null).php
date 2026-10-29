  function LoadDataAnl($id = null)
{
    $perangkat = $this->Mod->GetCustome("SELECT a.*,c.nama_fasilitas,d.nama as jenis_perangkat,e.nama as merk from perangkat a LEFT join fasilitas_detail b on b.id_perangkat = a.id_perangkat left join fasilitas c on c.id_fasilitas = b.id_fasilitas LEFT JOIN jenis_perangkat d on d.id_jenisperangkat= a.id_jenisperangkat LEFT JOIN merk e on e.id = a.merk_id where a.id_perangkat = '" . $id . "'")->row_array();
    $perangkat_detail = $this->Mod->GetCustome("SELECT a.*,b.nama as property_name FROM perangkat_detail a left join master_perangkat_detail b on b.idmaster_detail_perangkat = a.idmaster_detail_perangkat WHERE id_perangkat ='" . $perangkat['id_perangkat'] . "' ")->result_array();
    $perangkat['detail'] = $perangkat_detail;
    $todayDate = date('Y-m-d');
    $logHistory = $this->Mod->GetCustome("   SELECT 
            a.*, b.nama_masalah, c.nama_perangkat 
        FROM tinjut a 
        LEFT JOIN tinjut_detail td 
        ON td.id_tinjut = a.id_tinjut 
        LEFT JOIN perangkat c 
        ON c.id_perangkat = td.id_perangkat 
        left join jenis_masalah b 
        on b.id = td.id_jenismasalah 
        WHERE td.id_perangkat = '" . $id . "' ")->result_array();
    $result['LogHistory'] = $logHistory;

    // AMBIL ID UNIT DARI SESSION - CARA YANG LEBIH FLEKSIBEL
    $id_unit = !empty(sess()['unit']) ? sess()['unit'] : null;

    // ID UNIT KHUSUS (14, 15, 16, 17) - PERHITUNGAN BULANAN
    if (in_array($id_unit, [14, 15, 16, 17])) {
        $total_minutes_in_month = date('t') * 24 * 60;
        
        // Cek status dari tinjut dan tinjut_detail
        $status_query = $this->Mod->GetCustome("
            SELECT t.status AS tinjut_status, td.status AS tinjut_detail_status
            FROM tinjut t
            LEFT JOIN tinjut_detail td ON td.id_tinjut = t.id_tinjut
            WHERE td.id_perangkat = '" . $id . "'
            AND MONTH(t.start_time) = MONTH(NOW()) 
            AND YEAR(t.start_time) = YEAR(NOW())
        ")->row_array();
        
        $tinjut_status = !empty($status_query['tinjut_status']) ? $status_query['tinjut_status'] : null;
        $tinjut_detail_status = !empty($status_query['tinjut_detail_status']) ? $status_query['tinjut_detail_status'] : null;

        // Jika status di kedua tabel adalah 2, atau kosong, set performa 100%
        if (($tinjut_status == 2 || empty($tinjut_status)) && ($tinjut_detail_status == 2 || empty($tinjut_detail_status))) {
            $performa = 100;
        } else {
            // Hitung downtime bulan berjalan
            $downtime_query = $this->Mod->GetCustome("
                SELECT SUM(TIMESTAMPDIFF(MINUTE, t.start_time, t.end_time)) AS total_downtime 
                FROM tinjut t
                LEFT JOIN tinjut_detail td ON td.id_tinjut = t.id_tinjut
                WHERE td.id_perangkat = '" . $id . "'
                AND MONTH(t.start_time) = MONTH(NOW()) 
                AND YEAR(t.start_time) = YEAR(NOW())
            ")->row_array();
            
            $downtime = !empty($downtime_query['total_downtime']) ? $downtime_query['total_downtime'] : 0;
            //$total_minutes_in_month > 0 ? round((($total_minutes_in_month - $downtime) / $total_minutes_in_month) * 100, 2): 100;
            //Hitung performa berdasarkan rumus bulanan
            if ($total_minutes_in_month > 0) {
                $performa = (($total_minutes_in_month - $downtime) / $total_minutes_in_month) * 100;
                $performa = round($performa, 2);
            } else {
                $performa = 100; // Fallback jika pembagian nol
            }
        }

    // UNIT LAIN - PERHITUNGAN TAHUNAN (RUMUS YANG ANDA MINTA)
    } 
    elseif (in_array($id_unit, [18, 17, 19, 20, 21, 22, 23]))
    {
        // Hitung total menit dalam tahun berjalan dengan DateTime
        $current_year = date('Y');
        $start_of_year = new DateTime("$current_year-01-01");
        $end_of_year = new DateTime("$current_year-12-31");
        $total_days_in_year = $end_of_year->diff($start_of_year)->days + 1;
        $total_minutes_in_year = $total_days_in_year * 24 * 60;
        
        // Hitung total downtime dalam menit untuk tahun berjalan
        $downtime_query = $this->Mod->GetCustome("
            SELECT SUM(TIMESTAMPDIFF(MINUTE, t.start_time, t.end_time)) AS total_downtime 
            FROM tinjut t
            LEFT JOIN tinjut_detail td ON td.id_tinjut = t.id_tinjut
            WHERE td.id_perangkat = '" . $id . "'
            AND YEAR(t.start_time) = YEAR(NOW())
        ")->row_array();
        
        $downtime = !empty($downtime_query['total_downtime']) ? $downtime_query['total_downtime'] : 0;
        $performa = $total_minutes_in_year > 0 ? round(100 - (($downtime / $total_minutes_in_year) * 100), 2): 100;
        // RUMUS PERFORMANCE SCORE YANG ANDA MINTA
        if ($total_minutes_in_year > 0) {
            $downtime_percentage = ($downtime / $total_minutes_in_year) * 100;
            $performa = 100 - $downtime_percentage;
            $performa = round($performa, 2);
        } else {
            $performa = 100;
        }
         
    }
    else
    {
         // AMBIL DATA FASILITAS BERDASARKAN PERANGKAT
        $fasilitas_query = $this->Mod->GetCustome("
            SELECT c.kode 
            FROM perangkat a 
            LEFT JOIN fasilitas_detail b ON b.id_perangkat = a.id_perangkat 
            LEFT JOIN fasilitas c ON c.id_fasilitas = b.id_fasilitas 
            WHERE a.id_perangkat = '" . $id . "'
        ")->row_array();
        
        $kode_fasilitas = !empty($fasilitas_query['kode']) ? $fasilitas_query['kode'] : null;
        
        // LOGIKA BERDASARKAN KODE FASILITAS
        if ($kode_fasilitas == 1) {
            // FASILITAS KODE 1 - RUMUS TAHUNAN
            $current_year = date('Y');
            $start_of_year = new DateTime("$current_year-01-01");
            $end_of_year = new DateTime("$current_year-12-31");
            $total_days_in_year = $end_of_year->diff($start_of_year)->days + 1;
            $total_minutes_in_year = $total_days_in_year * 24 * 60;
            
            // Hitung total downtime dalam menit untuk tahun berjalan
            $downtime_query = $this->Mod->GetCustome("
                SELECT SUM(TIMESTAMPDIFF(MINUTE, t.start_time, t.end_time)) AS total_downtime 
                FROM tinjut t
                LEFT JOIN tinjut_detail td ON td.id_tinjut = t.id_tinjut
                WHERE td.id_perangkat = '" . $id . "'
                AND YEAR(t.start_time) = YEAR(NOW())
            ")->row_array();
            
            $downtime = !empty($downtime_query['total_downtime']) ? $downtime_query['total_downtime'] : 0;
            
            if ($total_minutes_in_year > 0) {
                $downtime_percentage = ($downtime / $total_minutes_in_year) * 100;
                $performa = 100 - $downtime_percentage;
                $performa = round($performa, 2);
            } else {
                $performa = 100;
            }
            
        } elseif ($kode_fasilitas == 2) {
            // FASILITAS KODE 2 - RUMUS BULANAN
            $total_minutes_in_month = date('t') * 24 * 60;
            
            // Cek status dari tinjut dan tinjut_detail
            $status_query = $this->Mod->GetCustome("
                SELECT t.status AS tinjut_status, td.status AS tinjut_detail_status
                FROM tinjut t
                LEFT JOIN tinjut_detail td ON td.id_tinjut = t.id_tinjut
                WHERE td.id_perangkat = '" . $id . "'
                AND MONTH(t.start_time) = MONTH(NOW()) 
                AND YEAR(t.start_time) = YEAR(NOW())
            ")->row_array();
            
            $tinjut_status = !empty($status_query['tinjut_status']) ? $status_query['tinjut_status'] : null;
            $tinjut_detail_status = !empty($status_query['tinjut_detail_status']) ? $status_query['tinjut_detail_status'] : null;

            // Jika status di kedua tabel adalah 2, atau kosong, set performa 100%
            if (($tinjut_status == 2 || empty($tinjut_status)) && ($tinjut_detail_status == 2 || empty($tinjut_detail_status))) {
                $performa = 100;
            } else {
                // Hitung downtime bulan berjalan
                $downtime_query = $this->Mod->GetCustome("
                    SELECT SUM(TIMESTAMPDIFF(MINUTE, t.start_time, t.end_time)) AS total_downtime 
                    FROM tinjut t
                    LEFT JOIN tinjut_detail td ON td.id_tinjut = t.id_tinjut
                    WHERE td.id_perangkat = '" . $id . "'
                    AND MONTH(t.start_time) = MONTH(NOW()) 
                    AND YEAR(t.start_time) = YEAR(NOW())
                ")->row_array();
                
                $downtime = !empty($downtime_query['total_downtime']) ? $downtime_query['total_downtime'] : 0;
                
                if ($total_minutes_in_month > 0) {
                    $performa = (($total_minutes_in_month - $downtime) / $total_minutes_in_month) * 100;
                    $performa = round($performa, 2);
                } else {
                    $performa = 100;
                }
            }
        } else {
            // DEFAULT JIKA TIDAK ADA KODE FASILITAS YANG COCOK
            $performa = 100;
        }
    }

    // Pastikan performa tidak kosong
    if (empty($performa)) {
        $performa = 100;
    }

    // Formatting dan warna
    $performa_formatted = number_format($performa, 1);

    if ($performa_formatted <= 35) {
        $warna = '#f20505';
    } elseif ($performa_formatted <= 75) {
        $warna = '#f27b05';
    } else {
        $warna = '#3380ff';
    }

    $result['perfomChart'] = array(
        'Performa' => $performa,
        'color' => $warna
    );
    
    $result['nilai_Asli'] = $performa_formatted;
    
    $result['perfomPie'] = array(
        'Display OFF' => 30,
        'HDMI' => 10,
        'Kamera Rusak' => 0,
        'Listrik OFF' => 20,
        'Jaringan Bermasalah'  => 20
    );

    $jm = $this->Mod->GetCustome("SELECT a.*,c.id as id_jenismasalah,c.nama_masalah FROM perangkat a left join jenis_perangkat b on b.id_jenisperangkat = a.id_jenisperangkat left join jenis_masalah c on c.parent_id = b.id_jenisperangkat where a.id_perangkat = '" . $id . "'")->result_array();

    foreach ($jm as $key => $value) {
        $total = $this->Mod->GetCustome("SELECT COUNT(*)as total,id_jenismasalah,id_perangkat 
                 FROM `logbook` 
                 where id_perangkat = '" . $id . "' and id_jenismasalah = '" . $value['id_jenismasalah'] . "' group by id_jenismasalah,id_perangkat  ")->row_array();
        
        if ($total != 0) {
            $result['ProgressData']['lebel'][] = $value['nama_masalah'];
            $result['ProgressData']['value'][] = (!empty($total['total']) ? $total['total'] : '0');
            $result['ProgressData']['color'][] = colrand();
        } else {
            $result['ProgressData']['lebel'][] = $value['nama_masalah'];
            $result['ProgressData']['value'][] = (!empty($total['total']) ? $total['total'] : '0');
            $result['ProgressData']['color'][] = colrand();
        }
    }
    
    $result['perangkat'] = $perangkat;
    echo json_encode($result);
}
