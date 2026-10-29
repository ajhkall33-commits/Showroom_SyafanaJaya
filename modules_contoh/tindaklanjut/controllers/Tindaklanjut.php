<?php
// application/modules/req_open/controllers/Req_open.php
defined('BASEPATH') OR exit('No direct script access allowed');
    use PhpOffice\PhpSpreadsheet\Spreadsheet;
    use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

    use PhpOffice\PhpSpreadsheet\Style\Alignment;
    use PhpOffice\PhpSpreadsheet\Style\Fill;


class Tindaklanjut extends MX_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->role();
        $this->load->library('Excel');
       
        $this->load->library('pdfgenerator');
    }

    private function role() {
        $url = urlencode(current_url());
       
        if (session("username") == "") {
             redirect(base_url('login/auth'));
        }
    }

    public function index() {
        $data["plugin"][]   = "plugin/datatable";
        $data["plugin"][]   = "plugin/select2";
        $data["title"]      = "Tindak Lanjut";
        $data["title_des"]  = "Daftar Tindak Lanjut";
        $data["content"]    = "v_index";
        $data["data"]       = $data;

        
        $data['koordinator']         =  $this->Mod->getWhere('user ',array('status != ' =>8,'type_user'=>'102' , 'unit_kerja'=> sess()['unit']))->result_array();
         $data['pengawas'] = $this->Mod->getWhere('user ',array('status != ' =>8,'type_user'=>'2' , 'unit_kerja'=> sess()['unit']))->result_array();
        $unit = sess()['unit'];
        $data['pelaksana'] = $this->Mod->GetCustome("SELECT * FROM user WHERE status != 8 AND type_user IN (1,102,107) AND unit_kerja = '$unit'")->result_array();
        $this->load->view('template_v2', $data);
    }


    function LoadData($from=null){
    if(isset($_POST['limit'])) {
        $limit = $_POST['limit'];
    } else {
        $limit = 3000; 
    }
    
    // Ambil parameter tanggal dari POST
    $tanggal = $this->input->post('tanggal');
    
    $from = $this->uri->segment(3);
    $start = ($from>1) ? ($from * $limit) - $limit : 0;

    // SK Manager: filter unit dinamis berdasarkan pilihan dropdown atau semua unit yang dikelola
    $unit_filter_sql = get_unit_filter_sql('filter_unit');
    
    // Tambahkan kondisi WHERE untuk filter tanggal
    $whereTanggal = "";
    if(!empty($tanggal)){
        $whereTanggal = " AND DATE(a.tanggal_mulai) = '$tanggal'";
    }
    
    // PERBAIKAN: Query yang lebih sederhana
    $res = $this->Mod->GetCustome("SELECT 
                a.*,
                b.nama_fasilitas,
                b.terminal
            FROM 
                tinjut a  
            LEFT JOIN 
                fasilitas b ON b.id_fasilitas = a.id_fasilitas
            WHERE 
                YEAR(a.create_date) = YEAR(CURRENT_DATE)
                AND a.status NOT IN (8) 
                AND a.id_unit $unit_filter_sql
                $whereTanggal
                AND a.status != 8
            ORDER BY a.create_date DESC 
            LIMIT $start, $limit");
                    
    $result = $res->result_array();
    
    // PERBAIKAN: Tambahkan debug untuk melihat data
    // echo "<pre>"; print_r($result); echo "</pre>"; exit;
    
    foreach ($result as $key => $value) {
        $result[$key]['description'] = $value['tindakan'] ?? '';
        $result[$key]['label_status'] = sts('3',$value['status']);
        $result[$key]['start_time'] = $value['tanggal_mulai'] ? date('H:i', strtotime($value['tanggal_mulai'])) : '';
        $result[$key]['tanggal'] = $value['tanggal_mulai'] ? Hari_($value['tanggal_mulai']) . ' ' . tgl($value['tanggal_mulai'], 'sm') : '';
        
        $result[$key]['tgl_mulai_f'] = $value['tanggal_mulai'] ? Hari_($value['tanggal_mulai']) . ' ' . tgl($value['tanggal_mulai'], 'l') : '-';
        $result[$key]['tgl_selesai_f'] = $value['tanggal_selesai'] ? Hari_($value['tanggal_selesai']) . ' ' . tgl($value['tanggal_selesai'], 'l') : '-';
        
        $dbefore = $this->Mod->GetCustome("SELECT nama FROM dokumentasi_before WHERE id_tinjut = '".$value['id_tinjut']."' AND status != 8")->result_array();
        $dproses = $this->Mod->GetCustome("SELECT nama FROM dokumentasi_proses WHERE id_tinjut = '".$value['id_tinjut']."' AND status != 8")->result_array();
        $dafter = $this->Mod->GetCustome("SELECT nama FROM dokumentasi_after WHERE id_tinjut = '".$value['id_tinjut']."' AND status != 8")->result_array();
        
        $result[$key]['foto_before'] = array_column($dbefore, 'nama');
        $result[$key]['foto_proses'] = array_column($dproses, 'nama');
        $result[$key]['foto_after']  = array_column($dafter, 'nama');
        
        // PERBAIKAN: Ambil detail perangkat untuk setiap tinjut
        $detail_perangkat = $this->Mod->GetCustome("
            SELECT p.nama_perangkat 
            FROM tinjut_detail td 
            LEFT JOIN perangkat p ON td.id_perangkat = p.id_perangkat 
            WHERE td.id_tinjut = '".$value['id_tinjut']."'
        ")->result_array();
        
        $result[$key]['perangkat_list'] = array_column($detail_perangkat, 'nama_perangkat');
    } 

    $data['data'] = $result;
    
    // Hitung total data dengan filter yang sama
    $whereTotal = array(
        'status !=' => 8,
        'id_unit' => sess()['unit']
    );
    
    // SK Manager: override id_unit untuk count query
    if (is_sk_manager()) {
        $sk_units = get_allowed_units();
        $chosen_unit = $this->input->post('filter_unit');
        if (!empty($chosen_unit) && in_array((int)$chosen_unit, $sk_units)) {
            $this->db->where('id_unit', (int)$chosen_unit);
        } else if (!empty($sk_units)) {
            $this->db->where_in('id_unit', $sk_units);
        }
        if (!empty($tanggal)) {
            $this->db->where('DATE(tanggal_mulai)', $tanggal);
        }
        $total_data = $this->db->where('status !=', 8)->get('tinjut')->num_rows();
    } else {
        if(!empty($tanggal)){
            $whereTotal['DATE(tanggal_mulai)'] = $tanggal;
        }
        $total_data = $this->Mod->getWhere('tinjut', $whereTotal)->num_rows();
    }
    $total_page = ceil($total_data/$limit);
    
    $data['pag'] = BTNPag($from,$total_page,$total_data,$limit);
    echo json_encode($data);
}
    public function SaveData() {
        $id_temuan = $this->input->post('id_temuan');
        $id_fasilitas = $this->input->post('id_fasilitas');
        $tanggal_mulai = $this->input->post('tanggal_mulai');
        $tanggal_selesai = $this->input->post('tanggal_selesai');
        $nomor = $this->input->post('nomor');
        $tindakan = $this->input->post('tindakan');
        
        $pelaksana_post = $this->input->post('pelaksana');
        $pelaksana = is_array($pelaksana_post) ? implode(',', $pelaksana_post) : '';
        
        $approved_by_post = $this->input->post('approved_by');
        $approved_by = is_array($approved_by_post) ? implode(',', $approved_by_post) : '';

        // If relasi temuan is selected, sync the nomor field with the selected temuan's nomor
        if (!empty($id_temuan)) {
            $temuan = $this->Mod->getWhere('temuan', array('id_temuan' => $id_temuan))->row_array();
            if ($temuan) {
                $nomor = $temuan['nomor'];
            }
        }

        $tinjut_data = [
            'id_temuan'       => !empty($id_temuan) ? $id_temuan : null,
            'id_fasilitas'    => $id_fasilitas,
            'nomor'           => $nomor,
            'tanggal_mulai'   => $tanggal_mulai,
            'tanggal_selesai' => $tanggal_selesai,
            'pelaksana'       => $pelaksana,
            'tindakan'        => $tindakan,
            'id_unit'         => sess()['unit'],
            'create_date'     => date('Y-m-d H:i:s'),
            'create_by'       => sess()['username'],
            'status'          => 0,
            'approved_by'     => $approved_by,
        ];

        $this->db->insert('tinjut', $tinjut_data);
        $idtinjut = $this->db->insert_id();

        if (empty($idtinjut)) {
            echo json_encode([
                'code' => '500',
                'msg'  => 'Gagal menyimpan data tindak lanjut.'
            ]);
            return;
        }

        // Update status temuan jika ada relasi menjadi 2 (Tindak Lanjut)
        if (!empty($id_temuan)) {
             $this->Mod->update2('temuan', array('id_temuan' => $id_temuan), array('status' => 2));
             
             // Sinkronkan status temuan_detail menjadi 2 (kecuali yang di-softdelete status = 8)
             $this->db->where('id_temuan', $id_temuan);
             $this->db->where('status !=', 8);
             $this->db->update('temuan_detail', array('status' => 2));

             // Sinkronkan status dokumentasi_temuan menjadi 2 (kecuali yang di-softdelete status = 8)
             $this->db->where('id_temuan', $id_temuan);
             $this->db->where('status !=', 8);
             $this->db->update('dokumentasi_temuan', array('status' => 2));
        }

        // Insert Perangkat (tinjut_detail)
        $perangkat_list = $this->input->post('perangkat');
        if (is_array($perangkat_list)) {
            foreach ($perangkat_list as $id_perangkat) {
                if (empty($id_perangkat)) continue;
                $this->db->insert('tinjut_detail', [
                    'id_tinjut'    => $idtinjut,
                    'id_perangkat' => $id_perangkat,
                    'status'       => 0
                ]);
            }
        }

        // Insert Jenis Masalah (jenis_masalah_terpakai)
        $jenis_masalah_list = $this->input->post('jenis_masalah');
        if (is_array($jenis_masalah_list)) {
            foreach ($jenis_masalah_list as $id_jenis_masalah) {
                if (empty($id_jenis_masalah)) continue;
                
                $max_q = $this->db->select_max('id_jenis_masalah_terpakai')->get('jenis_masalah_terpakai')->row_array();
                $next_id = isset($max_q['id_jenis_masalah_terpakai']) ? intval($max_q['id_jenis_masalah_terpakai']) + 1 : 1;

                $this->db->insert('jenis_masalah_terpakai', [
                    'id_jenis_masalah_terpakai' => $next_id,
                    'id_tinjut'                 => $idtinjut,
                    'id_jenis_masalah'          => $id_jenis_masalah,
                    'status'                    => 0
                ]);
            }
        }

        // Insert Komponen (komponen_terpakai)
        $komponen_id_list = $this->input->post('komponen_id');
        $komponen_qty_list = $this->input->post('komponen_qty');
        if (is_array($komponen_id_list)) {
            foreach ($komponen_id_list as $index => $id_komponen) {
                if (empty($id_komponen)) continue;
                $qty = isset($komponen_qty_list[$index]) ? intval($komponen_qty_list[$index]) : 1;
                $this->db->insert('komponen_terpakai', [
                    'id_tinjut'       => $idtinjut,
                    'id_komponen'     => $id_komponen,
                    'satuan_terpakai' => $qty,
                    'status'          => 0
                ]);
            }
        }

        // Handle File Uploads (Before, Proses, After)
        $this->load->library('upload');
        $folders = ['dokumentasi_before', 'dokumentasi_proses', 'dokumentasi_after'];
        foreach ($folders as $folder) {
            $path = './upload/' . $folder;
            if (!is_dir($path)) {
                mkdir($path, 0777, true);
            }
        }

        $file_fields = ['foto_before', 'foto_proses', 'foto_after'];
        $db_tables = ['dokumentasi_before', 'dokumentasi_proses', 'dokumentasi_after'];

        foreach ($file_fields as $index => $file_field) {
            if (!empty($_FILES[$file_field]['name'][0])) {
                $filesCount = count($_FILES[$file_field]['name']);
                for($i = 0; $i < $filesCount; $i++){
                    if(empty($_FILES[$file_field]['name'][$i])) continue;
                    
                    $_FILES['file']['name']     = $_FILES[$file_field]['name'][$i];
                    $_FILES['file']['type']     = $_FILES[$file_field]['type'][$i];
                    $_FILES['file']['tmp_name'] = $_FILES[$file_field]['tmp_name'][$i];
                    $_FILES['file']['error']    = $_FILES[$file_field]['error'][$i];
                    $_FILES['file']['size']     = $_FILES[$file_field]['size'][$i];

                    $config = array();
                    $config['upload_path']   = './upload/' . $db_tables[$index] . '/';
                    $config['allowed_types'] = 'jpg|jpeg|png|gif';
                    $config['max_size']      = 10000;
                    $config['encrypt_name']  = TRUE;

                    $this->upload->initialize($config);

                    if($this->upload->do_upload('file')){
                        $fileData = $this->upload->data();
                        $uploadData = array(
                            'id_tinjut' => $idtinjut,
                            'nama' => $fileData['file_name'],
                            'tanggal' => date('Y-m-d H:i:s'),
                            'status' => 0
                        );
                        $this->db->insert($db_tables[$index], $uploadData);
                    }
                }
            }
        }

        echo json_encode([
            'code' => '200',
            'msg'  => 'Data berhasil disimpan.'
        ]);
    }

    public function EditData($id = null) {
        $data = $this->Mod->getWhere('tinjut', array('id_tinjut ' => $id))->row_array();
        if (empty($data)) {
            echo json_encode([]);
            return;
        }

        $unit = $this->Mod->getWhere('unit', array('id_unit ' => $data['id_unit']))->row_array();
        $fasilitas = $this->Mod->getWhere('fasilitas', array('id_fasilitas ' => $data['id_fasilitas']))->row_array();
        $data['c_date'] = Hari_($data['create_date']) . ' ' . tgl($data['create_date'], 'sm');
        
        $data['s_date'] = $data['tanggal_mulai'] ? date('H:i', strtotime($data['tanggal_mulai'])) : '';
        $data['e_date'] = $data['tanggal_selesai'] ? date('H:i', strtotime($data['tanggal_selesai'])) : '';
        
        $data['tgl_mulai_f'] = $data['tanggal_mulai'] ? Hari_($data['tanggal_mulai']) . ' ' . tgl($data['tanggal_mulai'], 'l') : '-';
        $data['tgl_selesai_f'] = $data['tanggal_selesai'] ? Hari_($data['tanggal_selesai']) . ' ' . tgl($data['tanggal_selesai'], 'l') : '-';
        
        $data['nama_fasilitas'] = $fasilitas['nama_fasilitas'] ?? '-';
        $data['nama_unit'] = $unit['kode_unit'] ?? '-';
        
        // Fetch separate relations
        $data['perangkat_detail'] = $this->Mod->GetCustome("
            SELECT td.*, p.nama_perangkat, p.serial_number, p.id_jenisperangkat
            FROM tinjut_detail td
            LEFT JOIN perangkat p ON p.id_perangkat = td.id_perangkat
            WHERE td.id_tinjut = '$id' AND td.status != 8
        ")->result_array();

        $data['masalah_detail'] = $this->Mod->GetCustome("
            SELECT jmt.*, jm.nama_masalah
            FROM jenis_masalah_terpakai jmt
            LEFT JOIN jenis_masalah jm ON jm.id = jmt.id_jenis_masalah
            WHERE jmt.id_tinjut = '$id'
        ")->result_array();

        $data['komponen_detail'] = $this->Mod->GetCustome("
            SELECT kt.*, k.nama_komponen
            FROM komponen_terpakai kt
            LEFT JOIN komponen k ON k.id_komponen = kt.id_komponen
            WHERE kt.id_tinjut = '$id'
        ")->result_array();
        
        $data['foto_before_arr'] = $this->Mod->getWhere('dokumentasi_before', array('id_tinjut' => $id))->result_array();
        $data['foto_proses_arr'] = $this->Mod->getWhere('dokumentasi_proses', array('id_tinjut' => $id))->result_array();
        $data['foto_after_arr']  = $this->Mod->getWhere('dokumentasi_after', array('id_tinjut' => $id))->result_array();

        // Ambil info temuan jika ada relasi
        if (!empty($data['id_temuan'])) {
            $temuan = $this->Mod->GetCustome("SELECT a.id_temuan, a.nomor, a.tanggal, a.uraian_kejadian, b.nama_fasilitas FROM temuan a LEFT JOIN fasilitas b ON b.id_fasilitas = a.id_fasilitas WHERE a.id_temuan = '".$data['id_temuan']."'")->row_array();
            if ($temuan) {
                $data['temuan_label'] = $temuan['nomor'];
                $data['temuan_tanggal'] = $temuan['tanggal'];
                $data['temuan_tgl_f'] = $temuan['tanggal'] ? Hari_($temuan['tanggal']) . ' ' . tgl($temuan['tanggal'], 'l') : '-';
                $data['temuan_uraian'] = $temuan['uraian_kejadian'] ?? '-';
                
                // Ambil gambar temuan
                $data['temuan_foto_arr'] = $this->Mod->getWhere('dokumentasi_temuan', array('id_temuan' => $data['id_temuan'], 'status !=' => 8))->result_array();
            }
        }

        echo json_encode($data);
    }

    public function ViewData($id = null) {
        $data = $this->Mod->getWhere('tinjut', array('id_tinjut ' => $id))->row_array();
        if (empty($data)) {
            echo json_encode([]);
            return;
        }

        $unit = $this->Mod->getWhere('unit', array('id_unit ' => $data['id_unit']))->row_array();
        $fasilitas = $this->Mod->getWhere('fasilitas', array('id_fasilitas ' => $data['id_fasilitas']))->row_array();
        $data['c_date'] = Hari_($data['create_date']) . ' ' . tgl($data['create_date'], 'sm');
        
        $data['s_date'] = $data['tanggal_mulai'] ? date('H:i', strtotime($data['tanggal_mulai'])) : '';
        $data['e_date'] = $data['tanggal_selesai'] ? date('H:i', strtotime($data['tanggal_selesai'])) : '';
        
        $data['tgl_mulai_f'] = $data['tanggal_mulai'] ? Hari_($data['tanggal_mulai']) . ' ' . tgl($data['tanggal_mulai'], 'l') : '-';
        $data['tgl_selesai_f'] = $data['tanggal_selesai'] ? Hari_($data['tanggal_selesai']) . ' ' . tgl($data['tanggal_selesai'], 'l') : '-';
        
        $data['nama_fasilitas'] = $fasilitas['nama_fasilitas'] ?? '-';
        $data['nama_unit'] = $unit['kode_unit'] ?? '-';
        
        // Fetch separate relations
        $data['perangkat_detail'] = $this->Mod->GetCustome("
            SELECT td.*, p.nama_perangkat, p.serial_number, p.id_jenisperangkat
            FROM tinjut_detail td
            LEFT JOIN perangkat p ON p.id_perangkat = td.id_perangkat
            WHERE td.id_tinjut = '$id' AND td.status != 8
        ")->result_array();

        $data['masalah_detail'] = $this->Mod->GetCustome("
            SELECT jmt.*, jm.nama_masalah
            FROM jenis_masalah_terpakai jmt
            LEFT JOIN jenis_masalah jm ON jm.id = jmt.id_jenis_masalah
            WHERE jmt.id_tinjut = '$id'
        ")->result_array();

        $data['komponen_detail'] = $this->Mod->GetCustome("
            SELECT kt.*, k.nama_komponen
            FROM komponen_terpakai kt
            LEFT JOIN komponen k ON k.id_komponen = kt.id_komponen
            WHERE kt.id_tinjut = '$id'
        ")->result_array();
        
        $data['foto_before_arr'] = $this->Mod->getWhere('dokumentasi_before', array('id_tinjut' => $id))->result_array();
        $data['foto_proses_arr'] = $this->Mod->getWhere('dokumentasi_proses', array('id_tinjut' => $id))->result_array();
        $data['foto_after_arr']  = $this->Mod->getWhere('dokumentasi_after', array('id_tinjut' => $id))->result_array();

        // Ambil info temuan jika ada relasi
        if (!empty($data['id_temuan'])) {
            $temuan = $this->Mod->GetCustome("SELECT a.id_temuan, a.nomor, a.tanggal, a.uraian_kejadian, b.nama_fasilitas FROM temuan a LEFT JOIN fasilitas b ON b.id_fasilitas = a.id_fasilitas WHERE a.id_temuan = '".$data['id_temuan']."'")->row_array();
            if ($temuan) {
                $data['temuan_label'] = $temuan['nomor'];
                $data['temuan_tanggal'] = $temuan['tanggal'];
                $data['temuan_tgl_f'] = $temuan['tanggal'] ? Hari_($temuan['tanggal']) . ' ' . tgl($temuan['tanggal'], 'l') : '-';
                $data['temuan_uraian'] = $temuan['uraian_kejadian'] ?? '-';
                
                // Ambil gambar temuan
                $data['temuan_foto_arr'] = $this->Mod->getWhere('dokumentasi_temuan', array('id_temuan' => $data['id_temuan'], 'status !=' => 8))->result_array();
            }
        }

        echo json_encode($data);
    }

    public function UpdateData($id = null) {
        if (empty($id)) {
            echo json_encode(['code' => '500', 'msg' => 'ID Tidak Valid']);
            return;
        }

        $id_temuan = $this->input->post('id_temuan');
        $id_fasilitas = $this->input->post('id_fasilitas');
        $tanggal_mulai = $this->input->post('tanggal_mulai');
        $tanggal_selesai = $this->input->post('tanggal_selesai');
        $nomor = $this->input->post('nomor');
        $tindakan = $this->input->post('tindakan');
        
        $pelaksana_post = $this->input->post('pelaksana');
        $pelaksana = is_array($pelaksana_post) ? implode(',', $pelaksana_post) : '';
        
        $approved_by_post = $this->input->post('approved_by');
        $approved_by = is_array($approved_by_post) ? implode(',', $approved_by_post) : '';

        // Get current status so we don't reset it
        $current_tinjut = $this->Mod->getWhere('tinjut', array('id_tinjut' => $id))->row_array();
        $current_status = $current_tinjut ? $current_tinjut['status'] : 0;

        // If relasi temuan is selected, sync the nomor field with the selected temuan's nomor
        if (!empty($id_temuan)) {
            $temuan = $this->Mod->getWhere('temuan', array('id_temuan' => $id_temuan))->row_array();
            if ($temuan) {
                $nomor = $temuan['nomor'];
            }
        }

        $tinjut_data = [
            'id_temuan'       => !empty($id_temuan) ? $id_temuan : null,
            'id_fasilitas'    => $id_fasilitas,
            'nomor'           => $nomor,
            'tanggal_mulai'   => $tanggal_mulai,
            'tanggal_selesai' => $tanggal_selesai,
            'pelaksana'       => $pelaksana,
            'tindakan'        => $tindakan,
            'id_unit'         => sess()['unit'],
            'approved_by'     => $approved_by,
            'status'          => $current_status,
        ];

        $this->Mod->update2('tinjut', array('id_tinjut' => $id), $tinjut_data);

        // Clear existing relations
        $this->db->delete('tinjut_detail', array('id_tinjut' => $id));
        $this->db->delete('jenis_masalah_terpakai', array('id_tinjut' => $id));
        $this->db->delete('komponen_terpakai', array('id_tinjut' => $id));

        // Insert new relations - Perangkat
        $perangkat_list = $this->input->post('perangkat');
        if (is_array($perangkat_list)) {
            foreach ($perangkat_list as $id_perangkat) {
                if (empty($id_perangkat)) continue;
                $this->db->insert('tinjut_detail', [
                    'id_tinjut'    => $id,
                    'id_perangkat' => $id_perangkat,
                    'status'       => $current_status
                ]);
            }
        }

        // Insert new relations - Jenis Masalah
        $jenis_masalah_list = $this->input->post('jenis_masalah');
        if (is_array($jenis_masalah_list)) {
            foreach ($jenis_masalah_list as $id_jenis_masalah) {
                if (empty($id_jenis_masalah)) continue;
                
                $max_q = $this->db->select_max('id_jenis_masalah_terpakai')->get('jenis_masalah_terpakai')->row_array();
                $next_id = isset($max_q['id_jenis_masalah_terpakai']) ? intval($max_q['id_jenis_masalah_terpakai']) + 1 : 1;

                $this->db->insert('jenis_masalah_terpakai', [
                    'id_jenis_masalah_terpakai' => $next_id,
                    'id_tinjut'                 => $id,
                    'id_jenis_masalah'          => $id_jenis_masalah,
                    'status'                    => $current_status
                ]);
            }
        }

        // Insert new relations - Komponen
        $komponen_id_list = $this->input->post('komponen_id');
        $komponen_qty_list = $this->input->post('komponen_qty');
        if (is_array($komponen_id_list)) {
            foreach ($komponen_id_list as $index => $id_komponen) {
                if (empty($id_komponen)) continue;
                $qty = isset($komponen_qty_list[$index]) ? intval($komponen_qty_list[$index]) : 1;
                $this->db->insert('komponen_terpakai', [
                    'id_tinjut'       => $id,
                    'id_komponen'     => $id_komponen,
                    'satuan_terpakai' => $qty,
                    'status'          => $current_status
                ]);
            }
        }

        // Handle File Uploads (Before, Proses, After)
        $this->load->library('upload');
        $folders = ['dokumentasi_before', 'dokumentasi_proses', 'dokumentasi_after'];
        foreach ($folders as $folder) {
            $path = './upload/' . $folder;
            if (!is_dir($path)) {
                mkdir($path, 0777, true);
            }
        }

        $file_fields = ['foto_before', 'foto_proses', 'foto_after'];
        $db_tables = ['dokumentasi_before', 'dokumentasi_proses', 'dokumentasi_after'];

        foreach ($file_fields as $index => $file_field) {
            if (!empty($_FILES[$file_field]['name'][0])) {
                $filesCount = count($_FILES[$file_field]['name']);
                for($i = 0; $i < $filesCount; $i++){
                    if(empty($_FILES[$file_field]['name'][$i])) continue;
                    
                    $_FILES['file']['name']     = $_FILES[$file_field]['name'][$i];
                    $_FILES['file']['type']     = $_FILES[$file_field]['type'][$i];
                    $_FILES['file']['tmp_name'] = $_FILES[$file_field]['tmp_name'][$i];
                    $_FILES['file']['error']    = $_FILES[$file_field]['error'][$i];
                    $_FILES['file']['size']     = $_FILES[$file_field]['size'][$i];

                    $config = array();
                    $config['upload_path']   = './upload/' . $db_tables[$index] . '/';
                    $config['allowed_types'] = 'jpg|jpeg|png|gif';
                    $config['max_size']      = 10000;
                    $config['encrypt_name']  = TRUE;

                    $this->upload->initialize($config);

                    if($this->upload->do_upload('file')){
                        $fileData = $this->upload->data();
                        $uploadData = array(
                            'id_tinjut' => $id,
                            'nama' => $fileData['file_name'],
                            'tanggal' => date('Y-m-d H:i:s'),
                            'status' => $current_status
                        );
                        $this->db->insert($db_tables[$index], $uploadData);
                    }
                }
            }
        }

        echo json_encode([
            'code' => '200',
            'msg'  => 'Data berhasil diupdate.'
        ]);
    }

    function ProsesData($id=null){
        if (!empty($id)) {
            $data= [ 
                'status' => '1'
            ];
            $result = $this->Mod->update2('tinjut', array('id_tinjut' => $id),$data);
            
            if ($result) {
                $this->db->where('id_tinjut', $id);
                $this->db->where('status !=', 8);
                $this->db->update('tinjut_detail', array('status' => 1));

                $this->db->where('id_tinjut', $id);
                $this->db->where('status !=', 8);
                $this->db->update('jenis_masalah_terpakai', array('status' => 1));

                $this->db->where('id_tinjut', $id);
                $this->db->where('status !=', 8);
                $this->db->update('komponen_terpakai', array('status' => 1));

                $this->db->where('id_tinjut', $id);
                $this->db->where('status !=', 8);
                $this->db->update('dokumentasi_before', array('status' => 1));

                $this->db->where('id_tinjut', $id);
                $this->db->where('status !=', 8);
                $this->db->update('dokumentasi_proses', array('status' => 1));

                $this->db->where('id_tinjut', $id);
                $this->db->where('status !=', 8);
                $this->db->update('dokumentasi_after', array('status' => 1));

                $response=[
                    'code' => '200',
                    'msg'    =>  'Data Berhasil Di Proses'
                ];
            }else{
                $response=[
                    'code'      => '500',
                    'msg'    => 'Gagal Proses Data'
                ];
            }
        }else{
            $response=[
                'code'      => '500',
                'msg'    =>  'Gagal Proses Data'
            ];
        }
       
        echo json_encode($response);
    }

    public function GetDataTinjut($id=null){
        $data = $this->Mod->getWhere('tinjut',array('status' => 2, 'id_unit' => sess()['unit']))->result_array();
        if (!empty($id)) {
            foreach ($data as $key => $value) {
                $cek = $this->Mod->getWhere('tiket_cm_detail',array('id_tinjut' => $value['id_tinjut'], 'id_tiket' => $id))->num_rows();
                if ($cek != 0) {
                    $data[$key]['checked'] = 1;
                }
                $fasilitas = $this->Mod->getWhere('fasilitas',array('id_fasilitas' =>$value['id_fasilitas'] ))->row_array();
                $data[$key]['fasilitas'] = $fasilitas['nama_fasilitas'];
            }
        }else{
            foreach ($data as $key => $value) {
                $cek = $this->Mod->getWhere('tiket_cm_detail',array('id_tinjut' => $value['id_tinjut'],'status' => 1))->num_rows();
                if ($cek != 0) {
                    $data[$key]['checked'] = 0;
                }else{
                    $fasilitas = $this->Mod->getWhere('fasilitas',array('id_fasilitas' =>$value['id_fasilitas'] ))->row_array();
                    $data[$key]['fasilitas'] = $fasilitas['nama_fasilitas'];
                }
            }
        }
        echo json_encode($data);
    }

    public function Delete($id = null) {
        if (empty($id)) {
            echo json_encode(['code' => '500', 'msg' => 'Invalid ID']);
            return;
        }
        
        // Ambil id_temuan sebelum status tinjut diubah
        $tinjut = $this->Mod->getWhere('tinjut', array('id_tinjut' => $id))->row_array();
        $id_temuan = !empty($tinjut) ? $tinjut['id_temuan'] : null;

        $data = ['status' => 8];
        $result = $this->Mod->update2('tinjut', array('id_tinjut' => $id), $data);
        $result_detail = $this->Mod->update2('tinjut_detail', array('id_tinjut' => $id), $data);

        // Soft-delete all relational tables to status 8
        $this->db->where('id_tinjut', $id)->update('jenis_masalah_terpakai', $data);
        $this->db->where('id_tinjut', $id)->update('komponen_terpakai', $data);
        $this->db->where('id_tinjut', $id)->update('dokumentasi_before', $data);
        $this->db->where('id_tinjut', $id)->update('dokumentasi_proses', $data);
        $this->db->where('id_tinjut', $id)->update('dokumentasi_after', $data);

        if ($result && $result_detail) {
            // Jika ada relasi temuan, kembalikan status temuan, temuan_detail, dan dokumentasi_temuan ke 1
            if (!empty($id_temuan)) {
                $this->Mod->update2('temuan', array('id_temuan' => $id_temuan, 'status !=' => 8), array('status' => 1));

                $this->db->where('id_temuan', $id_temuan);
                $this->db->where('status !=', 8);
                $this->db->update('temuan_detail', array('status' => 1));

                $this->db->where('id_temuan', $id_temuan);
                $this->db->where('status !=', 8);
                $this->db->update('dokumentasi_temuan', array('status' => 1));
            }

            echo json_encode(['code' => '200', 'msg' => 'Data Berhasil Dihapus/Dibatalkan']);
        } else {
            echo json_encode(['code' => '500', 'msg' => 'Gagal Menghapus Data']);
        }
    }

    public function SearchTemuan() {
        $q = $this->input->get('q');
        $unit = sess()['unit'];
        
        $sql = "SELECT a.id_temuan, a.nomor, a.tanggal, b.nama_fasilitas 
                FROM temuan a 
                LEFT JOIN fasilitas b ON a.id_fasilitas = b.id_fasilitas 
                WHERE a.status = 1 AND a.id_unit = '$unit'";
        
        if ($q) {
            $sql .= " AND a.nomor LIKE '%$q%'";
        }
        
        $res = $this->Mod->GetCustome($sql)->result_array();
        $data = [];
        foreach ($res as $row) {
            $data[] = [
                'id' => $row['id_temuan'],
                'text' => $row['nomor']
            ];
        }
        echo json_encode($data);
    }

    public function GetTemuanDetail($id_temuan = null) {
        if (empty($id_temuan)) {
            echo json_encode([]);
            return;
        }
        $temuan = $this->Mod->GetCustome("SELECT id_temuan, nomor, tanggal, uraian_kejadian, id_fasilitas FROM temuan WHERE id_temuan = '$id_temuan'")->row_array();
        if (empty($temuan)) {
            echo json_encode([]);
            return;
        }
        
        $devices = $this->Mod->GetCustome("
            SELECT td.id_perangkat, p.nama_perangkat, p.id_jenisperangkat
            FROM temuan_detail td
            LEFT JOIN perangkat p ON p.id_perangkat = td.id_perangkat
            WHERE td.id_temuan = '$id_temuan' AND td.status != 8
        ")->result_array();
        
        $fotos = $this->Mod->getWhere('dokumentasi_temuan', array('id_temuan' => $id_temuan, 'status !=' => 8))->result_array();
        
        $temuan['devices'] = $devices;
        $temuan['tgl_f'] = $temuan['tanggal'] ? Hari_($temuan['tanggal']) . ' ' . tgl($temuan['tanggal'], 'l') : '-';
        $temuan['fotos'] = $fotos;
        echo json_encode($temuan);
    }

    public function GetActiveMasalah() {
        $unit = sess()['unit'];
        $id_fasilitas = $this->input->post('id_fasilitas');
        
        $whereFasilitas = "";
        if (!empty($id_fasilitas)) {
            $whereFasilitas = " AND parent_id IN (SELECT DISTINCT p.id_jenisperangkat FROM fasilitas_detail fd JOIN perangkat p ON fd.id_perangkat = p.id_perangkat WHERE fd.id_fasilitas = '$id_fasilitas' AND p.status != 8 AND fd.status != 8) ";
        }

        $res = $this->Mod->GetCustome("SELECT * FROM jenis_masalah WHERE status != 8 AND id_unit = '$unit' $whereFasilitas ORDER BY nama_masalah ASC")->result_array();
        echo json_encode($res);
    }

    public function GetActiveKomponen() {
        $unit = sess()['unit'];
        $id_fasilitas = $this->input->post('id_fasilitas');

        $whereFasilitas = "";
        if (!empty($id_fasilitas)) {
            $whereFasilitas = " AND id_jenisperangkat IN (SELECT DISTINCT p.id_jenisperangkat FROM fasilitas_detail fd JOIN perangkat p ON fd.id_perangkat = p.id_perangkat WHERE fd.id_fasilitas = '$id_fasilitas' AND p.status != 8 AND fd.status != 8) ";
        }

        $res = $this->Mod->GetCustome("SELECT * FROM komponen WHERE status != 8 AND id_unit = '$unit' $whereFasilitas ORDER BY nama_komponen ASC")->result_array();
        echo json_encode($res);
    }

   function PrintData($id = null) {
        if (empty($id)) {
            echo "ID tidak valid.";
            return;
        }

        $data = $this->Mod->getWhere('tinjut', array('id_tinjut ' => $id))->row_array();
        if (empty($data)) {
            echo "Data tidak ditemukan.";
            return;
        }

        $unit = $this->Mod->getWhere('unit', array('id_unit ' => $data['id_unit']))->row_array();
        $fasilitas = $this->Mod->getWhere('fasilitas', array('id_fasilitas ' => $data['id_fasilitas']))->row_array();
        $data['c_date'] = Hari_($data['create_date']) . ' ' . tgl($data['create_date'], 'sm');
        
        $data['s_date'] = $data['tanggal_mulai'] ? date('H:i', strtotime($data['tanggal_mulai'])) : '';
        $data['e_date'] = $data['tanggal_selesai'] ? date('H:i', strtotime($data['tanggal_selesai'])) : '';
        
        $data['tgl_mulai_f'] = $data['tanggal_mulai'] ? Hari_($data['tanggal_mulai']) . ' ' . tgl($data['tanggal_mulai'], 'l') : '-';
        $data['tgl_selesai_f'] = $data['tanggal_selesai'] ? Hari_($data['tanggal_selesai']) . ' ' . tgl($data['tanggal_selesai'], 'l') : '-';
        
        $data['nama_fasilitas'] = $fasilitas['nama_fasilitas'] ?? '-';
        $data['nama_unit'] = $unit['name_unit'] ?? '-';
        $data['unit_kode'] = $unit['kode_unit'] ?? '-';
        
        // Fetch separate relations
        $data['perangkat_detail'] = $this->Mod->GetCustome("
            SELECT td.*, p.nama_perangkat, p.serial_number, p.id_jenisperangkat
            FROM tinjut_detail td
            LEFT JOIN perangkat p ON p.id_perangkat = td.id_perangkat
            WHERE td.id_tinjut = '$id' AND td.status != 8
        ")->result_array();

        $data['masalah_detail'] = $this->Mod->GetCustome("
            SELECT jmt.*, jm.nama_masalah
            FROM jenis_masalah_terpakai jmt
            LEFT JOIN jenis_masalah jm ON jm.id = jmt.id_jenis_masalah
            WHERE jmt.id_tinjut = '$id'
        ")->result_array();

        $data['komponen_detail'] = $this->Mod->GetCustome("
            SELECT kt.*, k.nama_komponen
            FROM komponen_terpakai kt
            LEFT JOIN komponen k ON k.id_komponen = kt.id_komponen
            WHERE kt.id_tinjut = '$id'
        ")->result_array();
        
        $data['foto_before_arr'] = $this->Mod->getWhere('dokumentasi_before', array('id_tinjut' => $id))->result_array();
        $data['foto_proses_arr'] = $this->Mod->getWhere('dokumentasi_proses', array('id_tinjut' => $id))->result_array();
        $data['foto_after_arr']  = $this->Mod->getWhere('dokumentasi_after', array('id_tinjut' => $id))->result_array();

        // Ambil info temuan jika ada relasi
        if (!empty($data['id_temuan'])) {
            $temuan = $this->Mod->GetCustome("SELECT a.id_temuan, a.nomor, a.tanggal, a.uraian_kejadian, b.nama_fasilitas FROM temuan a LEFT JOIN fasilitas b ON b.id_fasilitas = a.id_fasilitas WHERE a.id_temuan = '".$data['id_temuan']."'")->row_array();
            if ($temuan) {
                $data['temuan_label'] = $temuan['nomor'];
                $data['temuan_tanggal'] = $temuan['tanggal'];
                $data['temuan_tgl_f'] = $temuan['tanggal'] ? Hari_($temuan['tanggal']) . ' ' . tgl($temuan['tanggal'], 'l') : '-';
                $data['temuan_uraian'] = $temuan['uraian_kejadian'] ?? '-';
                
                // Ambil gambar temuan
                $data['temuan_foto_arr'] = $this->Mod->getWhere('dokumentasi_temuan', array('id_temuan' => $data['id_temuan'], 'status !=' => 8))->result_array();
            }
        }

        $koordinator = $this->Mod->getWhere('user', [
            'status !=' => 8,
            'type_user' => 102,
            'unit_kerja' => sess()['unit']
        ])->row_array();

        $data['nama_koordinator'] = $koordinator['nama'] ?? '-';
        $data['ttd_iass'] = $data['ttd_iass'] ?? null;
        $data['ttd_api']  = $data['ttd_api']  ?? null;

        $this->load->view('v_tinjut3', $data);
    }

    function PrintData2($id = null) {
        if (empty($id)) {
            echo "ID tidak valid.";
            return;
        }

        $data = $this->Mod->getWhere('tinjut', array('id_tinjut ' => $id))->row_array();
        if (empty($data)) {
            echo "Data tidak ditemukan.";
            return;
        }

        $unit = $this->Mod->getWhere('unit', array('id_unit ' => $data['id_unit']))->row_array();
        $fasilitas = $this->Mod->getWhere('fasilitas', array('id_fasilitas ' => $data['id_fasilitas']))->row_array();
        $data['c_date'] = Hari_($data['create_date']) . ' ' . tgl($data['create_date'], 'sm');
        
        $data['s_date'] = $data['tanggal_mulai'] ? date('H:i', strtotime($data['tanggal_mulai'])) : '';
        $data['e_date'] = $data['tanggal_selesai'] ? date('H:i', strtotime($data['tanggal_selesai'])) : '';
        
        $data['tgl_mulai_f'] = $data['tanggal_mulai'] ? Hari_($data['tanggal_mulai']) . ' ' . tgl($data['tanggal_mulai'], 'l') : '-';
        $data['tgl_selesai_f'] = $data['tanggal_selesai'] ? Hari_($data['tanggal_selesai']) . ' ' . tgl($data['tanggal_selesai'], 'l') : '-';
        
        $data['nama_fasilitas'] = $fasilitas['nama_fasilitas'] ?? '-';
        $data['nama_unit'] = $unit['name_unit'] ?? '-';
        $data['unit_kode'] = $unit['kode_unit'] ?? '-';
        
        // Fetch separate relations
        $data['perangkat_detail'] = $this->Mod->GetCustome("
            SELECT td.*, p.nama_perangkat, p.serial_number, p.id_jenisperangkat
            FROM tinjut_detail td
            LEFT JOIN perangkat p ON p.id_perangkat = td.id_perangkat
            WHERE td.id_tinjut = '$id' AND td.status != 8
        ")->result_array();

        $data['masalah_detail'] = $this->Mod->GetCustome("
            SELECT jmt.*, jm.nama_masalah
            FROM jenis_masalah_terpakai jmt
            LEFT JOIN jenis_masalah jm ON jm.id = jmt.id_jenis_masalah
            WHERE jmt.id_tinjut = '$id'
        ")->result_array();

        $data['komponen_detail'] = $this->Mod->GetCustome("
            SELECT kt.*, k.nama_komponen
            FROM komponen_terpakai kt
            LEFT JOIN komponen k ON k.id_komponen = kt.id_komponen
            WHERE kt.id_tinjut = '$id'
        ")->result_array();
        
        $data['foto_before_arr'] = $this->Mod->getWhere('dokumentasi_before', array('id_tinjut' => $id))->result_array();
        $data['foto_proses_arr'] = $this->Mod->getWhere('dokumentasi_proses', array('id_tinjut' => $id))->result_array();
        $data['foto_after_arr']  = $this->Mod->getWhere('dokumentasi_after', array('id_tinjut' => $id))->result_array();

        // Ambil info temuan jika ada relasi
        if (!empty($data['id_temuan'])) {
            $temuan = $this->Mod->GetCustome("SELECT a.id_temuan, a.nomor, a.tanggal, a.uraian_kejadian, b.nama_fasilitas FROM temuan a LEFT JOIN fasilitas b ON b.id_fasilitas = a.id_fasilitas WHERE a.id_temuan = '".$data['id_temuan']."'")->row_array();
            if ($temuan) {
                $data['temuan_label'] = $temuan['nomor'];
                $data['temuan_tanggal'] = $temuan['tanggal'];
                $data['temuan_tgl_f'] = $temuan['tanggal'] ? Hari_($temuan['tanggal']) . ' ' . tgl($temuan['tanggal'], 'l') : '-';
                $data['temuan_uraian'] = $temuan['uraian_kejadian'] ?? '-';
                
                // Ambil gambar temuan
                $data['temuan_foto_arr'] = $this->Mod->getWhere('dokumentasi_temuan', array('id_temuan' => $data['id_temuan'], 'status !=' => 8))->result_array();
            }
        }

        $koordinator = $this->Mod->getWhere('user', [
            'status !=' => 8,
            'type_user' => 102,
            'unit_kerja' => sess()['unit']
        ])->row_array();

        $data['nama_koordinator'] = $koordinator['nama'] ?? '-';
        $data['ttd_iass'] = $data['ttd_iass'] ?? null;
        $data['ttd_api']  = $data['ttd_api']  ?? null;

        $this->load->view('v_tinjut31', $data);
    }
        function PrintData3($id = null) {
        if (empty($id)) {
            echo "ID tidak valid.";
            return;
        }

        $data = $this->Mod->getWhere('tinjut', array('id_tinjut ' => $id))->row_array();
        if (empty($data)) {
            echo "Data tidak ditemukan.";
            return;
        }

        $unit = $this->Mod->getWhere('unit', array('id_unit ' => $data['id_unit']))->row_array();
        $fasilitas = $this->Mod->getWhere('fasilitas', array('id_fasilitas ' => $data['id_fasilitas']))->row_array();
        $data['c_date'] = Hari_($data['create_date']) . ' ' . tgl($data['create_date'], 'sm');
        
        $data['s_date'] = $data['tanggal_mulai'] ? date('H:i', strtotime($data['tanggal_mulai'])) : '';
        $data['e_date'] = $data['tanggal_selesai'] ? date('H:i', strtotime($data['tanggal_selesai'])) : '';
        
        $data['tgl_mulai_f'] = $data['tanggal_mulai'] ? Hari_($data['tanggal_mulai']) . ' ' . tgl($data['tanggal_mulai'], 'l') : '-';
        $data['tgl_selesai_f'] = $data['tanggal_selesai'] ? Hari_($data['tanggal_selesai']) . ' ' . tgl($data['tanggal_selesai'], 'l') : '-';
        
        $data['nama_fasilitas'] = $fasilitas['nama_fasilitas'] ?? '-';
        $data['nama_unit'] = $unit['name_unit'] ?? '-';
        $data['unit_kode'] = $unit['kode_unit'] ?? '-';
        
        // Fetch separate relations
        $data['perangkat_detail'] = $this->Mod->GetCustome("
            SELECT td.*, p.nama_perangkat, p.serial_number, p.id_jenisperangkat
            FROM tinjut_detail td
            LEFT JOIN perangkat p ON p.id_perangkat = td.id_perangkat
            WHERE td.id_tinjut = '$id' AND td.status != 8
        ")->result_array();

        $data['masalah_detail'] = $this->Mod->GetCustome("
            SELECT jmt.*, jm.nama_masalah
            FROM jenis_masalah_terpakai jmt
            LEFT JOIN jenis_masalah jm ON jm.id = jmt.id_jenis_masalah
            WHERE jmt.id_tinjut = '$id'
        ")->result_array();

        $data['komponen_detail'] = $this->Mod->GetCustome("
            SELECT kt.*, k.nama_komponen
            FROM komponen_terpakai kt
            LEFT JOIN komponen k ON k.id_komponen = kt.id_komponen
            WHERE kt.id_tinjut = '$id'
        ")->result_array();
        
        $data['foto_before_arr'] = $this->Mod->getWhere('dokumentasi_before', array('id_tinjut' => $id))->result_array();
        $data['foto_proses_arr'] = $this->Mod->getWhere('dokumentasi_proses', array('id_tinjut' => $id))->result_array();
        $data['foto_after_arr']  = $this->Mod->getWhere('dokumentasi_after', array('id_tinjut' => $id))->result_array();

        // Ambil info temuan jika ada relasi
        if (!empty($data['id_temuan'])) {
            $temuan = $this->Mod->GetCustome("SELECT a.id_temuan, a.nomor, a.tanggal, a.uraian_kejadian, b.nama_fasilitas FROM temuan a LEFT JOIN fasilitas b ON b.id_fasilitas = a.id_fasilitas WHERE a.id_temuan = '".$data['id_temuan']."'")->row_array();
            if ($temuan) {
                $data['temuan_label'] = $temuan['nomor'];
                $data['temuan_tanggal'] = $temuan['tanggal'];
                $data['temuan_tgl_f'] = $temuan['tanggal'] ? Hari_($temuan['tanggal']) . ' ' . tgl($temuan['tanggal'], 'l') : '-';
                $data['temuan_uraian'] = $temuan['uraian_kejadian'] ?? '-';
                
                // Ambil gambar temuan
                $data['temuan_foto_arr'] = $this->Mod->getWhere('dokumentasi_temuan', array('id_temuan' => $data['id_temuan'], 'status !=' => 8))->result_array();
            }
        }

        $koordinator = $this->Mod->getWhere('user', [
            'status !=' => 8,
            'type_user' => 102,
            'unit_kerja' => sess()['unit']
        ])->row_array();

        $data['nama_koordinator'] = $koordinator['nama'] ?? '-';
        $data['ttd_iass'] = $data['ttd_iass'] ?? null;
        $data['ttd_api']  = $data['ttd_api']  ?? null;

        $this->load->view('v_tinjut2logo', $data);
    }



    public function SaveTtdIass() {
        $id_tinjut  = $this->input->post('id_tinjut');
        $id_unit    = $this->input->post('id_unit');
        $image_data = $this->input->post('image_data'); // base64 PNG dari canvas

        if (empty($id_tinjut) || empty($id_unit) || empty($image_data)) {
            echo json_encode(['code' => '500', 'msg' => 'Data tidak lengkap']);
            return;
        }

        // Buat folder: doc/ttd_corrective/{id_unit}/IASS/
        $folder = './doc/ttd_corrective/' . $id_unit . '/IASS/';
        if (!is_dir($folder)) {
            mkdir($folder, 0777, true);
        }

        // Nama file: ttd_iass_{id_tinjut}_{timestamp}.png
        $now      = date('Ymd_His');
        $filename = 'ttd_iass_' . $id_tinjut . '_' . $now . '.png';

        // Decode dan simpan gambar PNG
        $image_clean = str_replace('data:image/png;base64,', '', $image_data);
        $image_clean = str_replace(' ', '+', $image_clean);
        $decoded     = base64_decode($image_clean);

        if ($decoded === false || strlen($decoded) < 100) {
            echo json_encode(['code' => '500', 'msg' => 'Data gambar tidak valid']);
            return;
        }

        file_put_contents($folder . $filename, $decoded);

        // Update field ttd_iass di tabel tinjut
        $this->Mod->update2('tinjut', ['id_tinjut' => $id_tinjut], ['ttd_iass' => $filename]);

        echo json_encode(['code' => '200', 'msg' => 'TTD IASS berhasil disimpan', 'filename' => $filename]);
    }

    public function DeleteGambarLama() {
        $nama_file = $this->input->post('nama_file');
        $kategori = $this->input->post('kategori');
        $id = $this->input->post('id');

        if (empty($nama_file) || empty($kategori) || empty($id)) {
            echo json_encode(['code' => '500', 'msg' => 'Data tidak lengkap.']);
            return;
        }

        $table = '';
        $path = '';
        $id_column = '';
        if ($kategori === 'before') {
            $table = 'dokumentasi_before';
            $path = './upload/dokumentasi_before/';
            $id_column = 'id_dokumentasi_before';
        } else if ($kategori === 'proses') {
            $table = 'dokumentasi_proses';
            $path = './upload/dokumentasi_proses/';
            $id_column = 'id_dokumentasi_proses';
        } else if ($kategori === 'after') {
            $table = 'dokumentasi_after';
            $path = './upload/dokumentasi_after/';
            $id_column = 'id_dokumentasi_after';
        } else {
            echo json_encode(['code' => '500', 'msg' => 'Kategori tidak valid.']);
            return;
        }

        // Hard delete from database
        $this->db->where($id_column, $id);
        $this->db->where('nama', $nama_file);
        $result = $this->db->delete($table);

        if ($result) {
            // Delete physical file
            $file_path = $path . $nama_file;
            if (file_exists($file_path)) {
                unlink($file_path);
            }
            echo json_encode(['code' => '200', 'msg' => 'Gambar berhasil dihapus.']);
        } else {
            echo json_encode(['code' => '500', 'msg' => 'Gagal menghapus gambar dari database.']);
        }
    }
}


