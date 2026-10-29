 function PrintData($id=null){
        try {
            // Enable error reporting untuk debugging
            error_reporting(E_ALL);
            ini_set('display_errors', 1);
            
            // Cek folder upload
            $upload_path = FCPATH . 'upload/pm/';
            if (!is_dir($upload_path)) {
                if (!mkdir($upload_path, 0755, true)) {
                    throw new Exception('Gagal membuat folder upload');
                }
            }
            
            if (!is_writable($upload_path)) {
                throw new Exception('Folder upload tidak writable');
            }
            
            $data["data"] = [];
            $data = $this->Mod->getWhere('wo',array('id_wo ' =>$id))->row_array();
            
            if (empty($data)) {
                throw new Exception('Data WO tidak ditemukan');
            }
            
            if (!empty($data['tanggal'])) {
                $data['waktu_tampil'] = waktu($data['tanggal']);
                
                $dateParts = explode("-", substr($data['tanggal'], 0, 10));
                if (count($dateParts) == 3) {
                    $tahun = $dateParts[0];
                    $bulan = $dateParts[1];
                    $tanggal = $dateParts[2];
                    
                    $timestamp = strtotime($data['tanggal']);
                    $namaHari = date('N', $timestamp);
                    
                    $namaHariIndonesia = array(
                        1 => 'Senin',
                        2 => 'Selasa',
                        3 => 'Rabu',
                        4 => 'Kamis',
                        5 => 'Jumat',
                        6 => 'Sabtu',
                        7 => 'Minggu'
                    );
                    
                    $data['tahunsplit'] = $tahun;
                    $data['bulansplit'] = $bulan;
                    $data['tanggalsplit'] = $tanggal;
                    $data['harisplit'] = $namaHariIndonesia[$namaHari];
                }
            }
            
            $query = $this->Mod->GetCustome("SELECT 
                SUBSTRING_INDEX(pelaksana, ',', 1) AS nama_pelaksana_utama
                FROM wo
                WHERE id_wo = '$id'  
            ");
            
            $result = $query->row_array();
            $data['nama_pelaksana_yang_ttd'] = $result['nama_pelaksana_utama'] ?? '-';
            $data['tanggal'] = tgl($data['tanggal'],'l');
            $data['shift_l'] = l_sh($data['shift']);
            
            $data['job'] = $this->Mod->GetCustome("SELECT c.nama as nama_job,b.documentasi
                FROM 
                wo_detail a 
                left join 
                pm_detail b 
                on 
                b.id_pmheader =a.id_pmheader
                left join 
                job_pm c 
                on 
                c.id_jobpm = b.id_job
                WHERE a.id_wo = '".$id."'
                group by  c.nama")->result_array();
            
            $data['c_detail'] = count($data['job']);
            $data['fasilitas'] = $this->Mod->GetCustome("SELECT 
                c.terminal as lokasi,b.id_fasilitas,c.nama_fasilitas,f.nama_perangkat as type,b.catatan_perawatan,b.pengukuran
            FROM 
                wo_detail a 
            LEFT JOIN 
                pm b 
            ON 
                b.id_pmheader = a.id_pmheader 
            LEFT JOIN 
                fasilitas c on c.id_fasilitas = b.id_fasilitas
            LEFT JOIN
                fasilitas_detail d 
            ON  
                d.id_fasilitas = c.id_fasilitas
            LEFT JOIN
                perangkat e
            ON 
                e.id_perangkat = d.id_perangkat
            LEFT JOIN
                model f
            ON 
                f.id_perangkat = e.id_model
            WHERE   
                a.id_wo = '$id' 
            GROUP BY 
                c.terminal,b.id_fasilitas,c.nama_fasilitas,f.nama_perangkat,b.catatan_perawatan,b.pengukuran")->result_array();

            $data['c_fasilitas'] = count($data['fasilitas']);
            $data['lokasi'] = !empty($data['fasilitas'][0]['lokasi']) ? $data['fasilitas'][0]['lokasi'] : '-';
            $data['catatan_perawatan'] = array_column($data['fasilitas'], 'catatan_perawatan');
             $data['pengukuran'] = array_column($data['fasilitas'], 'pengukuran');

                  // TAMBAHKAN DATA KOORDINATOR
        $data['koordinator'] = $this->Mod->getWhere('user',array('status != ' =>8,'type_user'=>'102' , 'unit_kerja'=> sess()['unit']))->result_array();
        
        // Ambil nama koordinator pertama jika ada
        if (!empty($data['koordinator'])) {
            $data['nama_koordinator'] = $data['koordinator'][0]['nama'] ?? 'NAMA KOORDINATOR';
        } else {
            $data['nama_koordinator'] = 'NAMA KOORDINATOR';
        }
           
            
            $dok = $this->Mod->GetCustome("SELECT * FROM `wo_detail` WHERE id_wo='$id' ORDER BY RAND() LIMIT 2")->result_array();
            $dokumentasi = array();
            $pmheader_ids = array();

            foreach ($dok as $value) {
                $pmheader_ids[] = $value['id_pmheader'];
            }

            if (!empty($pmheader_ids)) {
                $ids = implode(",", array_map('intval', $pmheader_ids));
                
                $detail = $this->Mod->GetCustome("SELECT 
                    a.id_job, 
                    a.documentasi, 
                    c.nama,
                    d.nama_fasilitas,
                    a.id_pmheader
                FROM 
                    pm_detail a
                LEFT JOIN 
                    job_pm c ON c.id_jobpm = a.id_job
                LEFT JOIN 
                    pm b ON b.id_pmheader = a.id_pmheader
                LEFT JOIN 
                    fasilitas d ON d.id_fasilitas = b.id_fasilitas
                WHERE 
                    a.id_pmheader IN ($ids)
                GROUP BY 
                    a.id_job, 
                    a.documentasi, 
                    c.nama,
                    d.nama_fasilitas,
                    a.id_pmheader
                ORDER BY
                    a.id_job, d.nama_fasilitas")->result_array();
                    
                $data['dock'] = array();
                foreach ($detail as $value) {
                    $job_id = $value['id_job'];
                    
                    if (!isset($data['dock'][$job_id])) {
                        $data['dock'][$job_id] = array(
                            'id_job' => $job_id,
                            'nama' => $value['nama'],
                            'files' => array()
                        );
                    }

                    $isDuplicate = false;
                    foreach ($data['dock'][$job_id]['files'] as $file) {
                        if ($file['documentasi'] === $value['documentasi']) {
                            $isDuplicate = true;
                            break;
                        }
                    }

                    if (!$isDuplicate && !empty($value['documentasi'])) {
                        $data['dock'][$job_id]['files'][] = array(
                            'documentasi' => $value['documentasi'],
                            'nama_fasilitas' => $value['nama_fasilitas'],
                            'id_pmheader' => $value['id_pmheader']
                        );
                    }
                }
            }

            $data['pm_type'] = $this->Mod->getWhere('pm_type',array('idpm_type ' =>$data['idpm_type']))->row_array();
            
            $catagory_check = $this->Mod->getWhere('job_pm_catagory',array('id_unit ' =>$data['id_unit'],'idpm_type'=>$data['idpm_type'] ))->result_array();
            foreach ($catagory_check as $key => $value) {
                $catagory_check[$key]['checklist'] = $this->Mod->getWhere('job_pm_check',array('catagory' =>$value['id_job_catagory'],'id_unit'=>$value['id_unit'] ))->result_array();
            }
            $data['check'] = $catagory_check;

            // Panggil fungsi PM sesuai unit
            if (sess()['unit'] == 3) {
                $this->PM_CCTV($data);
            } elseif (sess()['unit'] == 1) {
                $this->PM_PSIT($data);
            } else {
                $this->PM_All($data);
            }
            
        } catch (Exception $e) {
            log_message('error', 'PDF Error: ' . $e->getMessage());
            echo "Error generating PDF: " . $e->getMessage();
        }
    }