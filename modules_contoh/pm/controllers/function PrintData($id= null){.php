 function PrintData($id= null){
        
        $data["plugin"][]           = "plugin/datatable";
        $data["plugin"][]           = "plugin/select2";
        $data["title"]              = "PREVENTIVE MAINTENANCE BULANAN";
        $data["title_des"]          = "Lorem ipsum dolor sit amet";
        $data["content"]            = "PM Bulanan";
      
        // $pm                             = $this->Mod->getWhere('pm',array('id_pmheader' =>$id ))->row_array();

        $pm  = $this->Mod->GetCustome("SELECT 
             *,CONCAT(TIME_FORMAT(jam_mulai, '%H:%i'),' - ',TIME_FORMAT(jam_selesai, '%H:%i')) as waktu
         FROM pm WHERE id_pmheader = '".$id."'" )->row_array();
      
       
        $pm['pm_type']                  = $this->Mod->getWhere('pm_type',array('idpm_type' =>$pm['idpm_type']))->row_array();
        $pm['terbilang']                = tgl_($pm['tanggal_pm']);
       // $pm['jenis']                    = $this->Mod->GetCustome("SELECT a.id_jenisperangkat,COUNT(a.id_jenisperangkat)as jumlah,b.nama FROM change_divice_detail a left join jenis_perangkat b on b.id_jenisperangkat= a.id_jenisperangkat where a.id_change = '".$id."' group by a.id_jenisperangkat ")->row_array();
        // $ap2                            = $this->Mod->getWhere('user',array('id' =>$pm['id_organik']))->row_array();
       
        $fasilitas                      = $this->Mod->getWhere('fasilitas',array('id_fasilitas' => $pm['id_fasilitas'] ))->row_array();
        $pm['fasilitas']                = $fasilitas['nama_fasilitas'];
        $fas                  = $this->Mod->getWhere('terminal',array('id' =>$fasilitas['id_lokasi']))->row_array();
        $pm['lokasi'] = $fas['nama_terminal'];
        $cat                  = $this->Mod->getWhere('fasilitas_catagory',array('id_catagory' =>$fasilitas['id_catagory']))->row_array();
        $pm['catagory'] = $cat['nama'];
        // $pm_job                         = $this->Mod->getWhere('job_pm',array('id_pmtype' => $pm['idpm_type'] ), '')->result_array();
        // $pm_detail                      = $this->Mod->getWhere('pm_detail',array('id_pmheader' => $pm['id_pmheader'] ))->result_array();
        
        
        $pm['job']= $this->Mod->GetCustome("SELECT 
        a.documentasi,b.nama as nama_job 
        FROM 
        pm_detail a 
        LEFT JOIN 
        job_pm b 
        on 
        b.id_jobpm = a.id_job 
        WHERE 
        a.id_pmheader= '".$pm['id_pmheader']."' GROUP  BY a.id_pmdetail,a.documentasi,b.nama ORDER BY order_by ASC " )->result_array();


        // foreach ($pm_detail as $key => $value) {
        //     $detail     = $this->Mod->getWhere('job_pm',array('id_jobpm' =>$value['id_job']))->row_array();
        //     $pm_detail[$key]['nama_job'] = $detail['nama'];
        // }
        $pm['tanggal'] = Hari_($pm['tanggal_pm']) . ' ' . tgl($pm['tanggal_pm'], 'sm');
        $data = $pm;

    //   echo "<pre>",print_r (sess() ),"</pre>";
      
     //echo "<pre>",print_r ($data),"</pre>";
      
    //    echo "<pre>",print_r ($data),"</pre>";
        // $html= $this->load->view('v_bulanan',$data, true);

          //
      
            $this->PM_ALL($data);
        
        
        echo "<pre>",print_r ($data),"</pre>";
    }
