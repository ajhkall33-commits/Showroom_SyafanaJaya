<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');



class List_approval_leader extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        //$this->load->library('excel');
        $this->load->model("m_data");
    }

    public function index()
    {

        $data["plugin"][] = "plugin/datatable";
        $data["plugin"][] = "plugin/select2";
        $data["title"] = "List Aproval Tindak Lanjut";
        $data["title_des"] = "Persetujuan Tindak Lanjut";
        $data["content"] = "v_index";

        $data["data"] = $data;

        $this->load->view('template_v2', $data);
        // echo "<pre>",print_r ( $this->session->userdata()),"</pre>";
    }


    public function LoadData()
    {
        $limit = 3000;
        $start = 0;

        // SK Manager: filter unit dinamis berdasarkan pilihan dropdown atau semua unit yang dikelola
        $unit_filter_sql = get_unit_filter_sql('filter_unit');

        // Ambil data tinjut yang membutuhkan approval (status NOT IN 8, 0)
        $data = $this->Mod->GetCustome("SELECT 
                 a.*, b.nama_fasilitas, b.terminal AS nama_terminal
             FROM 
                 tinjut a  
             LEFT JOIN 
                 fasilitas b 
             ON 
                 b.id_fasilitas = a.id_fasilitas
             WHERE 
                 a.status NOT IN ('8','0') AND a.id_unit $unit_filter_sql ORDER BY a.create_date DESC LIMIT $start, $limit")->result_array();

        foreach ($data as $key => $value) {
            $data[$key]['label_status'] =  st($value['status']);
            $data[$key]['formatted_tanggal'] = Hari_($value['create_date']) . ' ' . tgl($value['create_date'], 'sm');
            
            // Format tanggal mulai dan selesai sesuai modul tindaklanjut
            $data[$key]['tgl_mulai_f'] = $value['tanggal_mulai'] ? Hari_($value['tanggal_mulai']) . ' ' . tgl($value['tanggal_mulai'], 'l') : '-';
            $data[$key]['tgl_selesai_f'] = $value['tanggal_selesai'] ? Hari_($value['tanggal_selesai']) . ' ' . tgl($value['tanggal_selesai'], 'l') : '-';
            
            // Fetch dokumentasi (Before, Process, After)
            $dbefore = $this->Mod->GetCustome("SELECT nama FROM dokumentasi_before WHERE id_tinjut = '".$value['id_tinjut']."' LIMIT 1")->row_array();
            $dproses = $this->Mod->GetCustome("SELECT nama FROM dokumentasi_proses WHERE id_tinjut = '".$value['id_tinjut']."' LIMIT 1")->row_array();
            $dafter = $this->Mod->GetCustome("SELECT nama FROM dokumentasi_after WHERE id_tinjut = '".$value['id_tinjut']."' LIMIT 1")->row_array();
            
            $data[$key]['foto_before'] = isset($dbefore['nama']) ? 'dokumentasi_before/'.$dbefore['nama'] : '';
            $data[$key]['foto_proses'] = isset($dproses['nama']) ? 'dokumentasi_proses/'.$dproses['nama'] : '';
            $data[$key]['foto_after']  = isset($dafter['nama']) ? 'dokumentasi_after/'.$dafter['nama'] : '';
            
            $data[$key]['terminal'] = $value['nama_terminal']; // mapping for consistency
        }

        echo json_encode($data);
    }


    public function ProsesReject($id = null)
    {
        if (empty($id)) {
            echo json_encode(['code' => '500', 'msg' => 'Invalid ID']);
            return;
        }

        try {
            $tinjut = $this->Mod->getWhere('tinjut', array('id_tinjut' => $id))->row_array();
            if (empty($tinjut)) {
                echo json_encode(['code' => '404', 'msg' => 'Data tidak ditemukan']);
                return;
            }

            // Update tinjut and its child tables to status = 0
            $data_tinjut = ['status' => 0];
            $result = $this->Mod->update2('tinjut', array('id_tinjut' => $id), $data_tinjut);
            $result_detail = $this->Mod->update2('tinjut_detail', array('id_tinjut' => $id), $data_tinjut);

            $this->db->where('id_tinjut', $id)->update('jenis_masalah_terpakai', $data_tinjut);
            $this->db->where('id_tinjut', $id)->update('komponen_terpakai', $data_tinjut);
            $this->db->where('id_tinjut', $id)->update('dokumentasi_before', $data_tinjut);
            $this->db->where('id_tinjut', $id)->update('dokumentasi_proses', $data_tinjut);
            $this->db->where('id_tinjut', $id)->update('dokumentasi_after', $data_tinjut);

            // Update temuan and its child tables to status = 2 if rel_id exists
            if (!empty($tinjut['id_temuan'])) {
                $id_temuan = $tinjut['id_temuan'];
                $data_temuan = [
                    'status'      => 2,
                    'update_by'   => sess()['id'],
                    'update_date' => date('Y-m-d')
                ];
                $this->Mod->update2('temuan', array('id_temuan' => $id_temuan), $data_temuan);
                $this->Mod->update2('temuan_detail', array('id_temuan' => $id_temuan), array('status' => 2));
                $this->db->where('id_temuan', $id_temuan)->update('dokumentasi_temuan', array('status' => 2));
            }

            $response = [
                'code' => '200',
                'msg'  => 'Data Berhasil Di Reject'
            ];
        } catch (Exception $e) {
            $response = [
                'code' => '500',
                'msg'  => 'Gagal memproses reject data'
            ];
        }
        echo json_encode($response);
    }

    public function ProsesApprove($id = null)
    {
        try {
            $approved_by = sess()['nama']; // Ambil nama pengguna yang sedang login
            $data = [
                'status'        => 9,
                'approved_by'  => $approved_by, // Menyimpan nama yang mengapprove secara otomatis
            ];
            
            // Update status dan approved_by di tabel tinjut
            $result = $this->Mod->update2('tinjut', array('id_tinjut' => $id), $data);
            
            // Update status di tabel tinjut_detail
            $data_detail = [
                'status'        => 9,
            ];
            $result_detail = $this->Mod->update2('tinjut_detail', array('id_tinjut' => $id), $data_detail);

            // Update status = 9 for other relational tables linked to id_tinjut
            $this->db->where('id_tinjut', $id)->update('jenis_masalah_terpakai', array('status' => 9));
            $this->db->where('id_tinjut', $id)->update('komponen_terpakai', array('status' => 9));
            $this->db->where('id_tinjut', $id)->update('dokumentasi_before', array('status' => 9));
            $this->db->where('id_tinjut', $id)->update('dokumentasi_proses', array('status' => 9));
            $this->db->where('id_tinjut', $id)->update('dokumentasi_after', array('status' => 9));

            // Ambil data tinjut untuk mendapatkan relasi ke temuan
            $tinjut = $this->Mod->getWhere('tinjut', array('id_tinjut' => $id))->row_array();
            
            // Update status di tabel temuan, temuan_detail, dan dokumentasi_temuan jika ada relasi
            if (!empty($tinjut['id_temuan'])) {
                $id_temuan = $tinjut['id_temuan'];
                $data_temuan = [
                    'status'      => 9,
                    'update_by'   => sess()['id'],
                    'update_date' => date('Y-m-d')
                ];
                $this->Mod->update2('temuan', array('id_temuan' => $id_temuan), $data_temuan);
                $this->Mod->update2('temuan_detail', array('id_temuan' => $id_temuan), array('status' => 9));
                $this->db->where('id_temuan', $id_temuan)->update('dokumentasi_temuan', array('status' => 9));
            }

            // Memasukkan riwayat corrective maintenance ke dalam logbook
            $tinjut_detail = $this->Mod->getWhere('tinjut_detail', array('id_tinjut' => $id))->result_array();
            foreach ($tinjut_detail as $key => $value) {
                $log = [
                    'id_fasilitas'          => $tinjut['id_fasilitas'],
                    'id_perangkat'          => $value['id_perangkat'],
                    'id_unit'               => $tinjut['id_unit'],
                    'tittle'                => 'Corrective Maintenance',
                    'note'                  => ' fix ',
                    'rel_id'                => $tinjut['id_tinjut'],
                    'rel_type'              => 'tinjut',
                    'start_time'            => $tinjut['tanggal_mulai'],
                    'end_time'              => $tinjut['tanggal_selesai'],
                    'create_by'             => $tinjut['create_by'],
                    'create_date'           => date('Y-m-d'),
                    'shift'                 => GetShift()['shift']
                ];
                $this->db->insert('logbook', $log);
            }
            $response = [
                'code'      => '200',
                'msg'       => 'Data Berhasil Di Proses'
            ];
        } catch (Exception $e) {
            $response = [
                'code'          => '500',
                'msg'           => 'Gagal memproses data'
            ];
        }

        echo json_encode($response);
    }

    public function ProsesDelete($id = null)
    {
        if (empty($id)) {
            echo json_encode(['code' => '500', 'msg' => 'Invalid ID']);
            return;
        }

        try {
            $tinjut = $this->Mod->getWhere('tinjut', array('id_tinjut' => $id))->row_array();
            if (empty($tinjut)) {
                echo json_encode(['code' => '404', 'msg' => 'Data tidak ditemukan']);
                return;
            }

            // Update tinjut and its child tables to status = 8 (deleted)
            $data_tinjut = ['status' => 8];
            $result = $this->Mod->update2('tinjut', array('id_tinjut' => $id), $data_tinjut);
            $result_detail = $this->Mod->update2('tinjut_detail', array('id_tinjut' => $id), $data_tinjut);

            $this->db->where('id_tinjut', $id)->update('jenis_masalah_terpakai', $data_tinjut);
            $this->db->where('id_tinjut', $id)->update('komponen_terpakai', $data_tinjut);
            $this->db->where('id_tinjut', $id)->update('dokumentasi_before', $data_tinjut);
            $this->db->where('id_tinjut', $id)->update('dokumentasi_proses', $data_tinjut);
            $this->db->where('id_tinjut', $id)->update('dokumentasi_after', $data_tinjut);

            // Update temuan and its child tables to status = 1 if rel_id exists
            if (!empty($tinjut['id_temuan'])) {
                $id_temuan = $tinjut['id_temuan'];
                $data_temuan = [
                    'status'      => 1,
                    'update_by'   => sess()['id'],
                    'update_date' => date('Y-m-d')
                ];
                $this->Mod->update2('temuan', array('id_temuan' => $id_temuan), $data_temuan);
                $this->Mod->update2('temuan_detail', array('id_temuan' => $id_temuan), array('status' => 1));
                $this->db->where('id_temuan', $id_temuan)->update('dokumentasi_temuan', array('status' => 1));
            }

            $response = [
                'code' => '200',
                'msg'  => 'Data Berhasil Dihapus'
            ];
        } catch (Exception $e) {
            $response = [
                'code' => '500',
                'msg'  => 'Gagal menghapus data'
            ];
        }
        echo json_encode($response);
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

    public function SaveTtdApi() {
        $id_tinjut  = $this->input->post('id_tinjut');
        $id_unit    = $this->input->post('id_unit');
        $image_data = $this->input->post('image_data'); // base64 PNG dari canvas

        if (empty($id_tinjut) || empty($id_unit) || empty($image_data)) {
            echo json_encode(['code' => '500', 'msg' => 'Data tidak lengkap']);
            return;
        }

        // Buat folder: doc/ttd_corrective/{id_unit}/API/
        $folder = './doc/ttd_corrective/' . $id_unit . '/API/';
        if (!is_dir($folder)) {
            mkdir($folder, 0777, true);
        }

        // Nama file: ttd_api_{id_tinjut}_{timestamp}.png
        $now      = date('Ymd_His');
        $filename = 'ttd_api_' . $id_tinjut . '_' . $now . '.png';

        // Decode dan simpan gambar PNG
        $image_clean = str_replace('data:image/png;base64,', '', $image_data);
        $image_clean = str_replace(' ', '+', $image_clean);
        $decoded     = base64_decode($image_clean);

        if ($decoded === false || strlen($decoded) < 100) {
            echo json_encode(['code' => '500', 'msg' => 'Data gambar tidak valid']);
            return;
        }

        file_put_contents($folder . $filename, $decoded);

        // Update field ttd_api di tabel tinjut
        $this->Mod->update2('tinjut', ['id_tinjut' => $id_tinjut], ['ttd_api' => $filename]);

        echo json_encode(['code' => '200', 'msg' => 'TTD API berhasil disimpan', 'filename' => $filename]);
    }
}
