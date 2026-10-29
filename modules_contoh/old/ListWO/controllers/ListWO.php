<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class ListWO extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('EXCEL');
        $this->load->model("m_data");
    }

    public function detail($id) {
        // Misalnya, ambil data work order dan riwayat tindakan dari model
        $this->load->model('WorkOrderModel');
        $data['work_order'] = $this->WorkOrderModel->getWorkOrderById($id);
        $data['riwayat_tindakan'] = $this->WorkOrderModel->getRiwayatTindakan($id);

        // Load view work_order.php dengan data yang diperlukan
        $this->load->view('work_order', $data);
    }

    // private function position() {
    //     $data["position"] = "perangkat";
    //     return $data;
    // }

    public function index()
    {
      
        //$data = $this->position();
        // $data = access($data,"VIEW");
       
        $data["plugin"][] = "plugin/datatable";
        $data["plugin"][] = "plugin/select2";
        $data["title"] = "Work Order";
        $data["title_des"] = " List Work Order";
        $data["content"] = "v_index";

        $data["data"] = $data;

        $this->load->view('template_v2', $data);
        // echo "<pre>",print_r ( $this->session->userdata()),"</pre>";
    }

    
    function LoadData(){
        //$data= $this->position();
       // $acc  = access($data,"VIEW")['access'];
        //  $data          = $this->m_data->getWhere('wo',array('status !=' =>8 ))->result_array();


         
        if(!empty($_POST['limit'])) {
            $limit =$_POST['limit'];
        } else {
            $limit = CountData('wo','id_wo',array('status !='=> 8));
        }

        $from = $this->uri->segment(3);
      
        $totalData= $this->Mod->CountData('wo','id_wo',array('status !=' => 8))->num_rows();
        if ($totalData == 0) {
            $totalpage=0;
        }else{
            $totalpage= ceil($totalData/$limit);
        }
        
      
        $res = pagin('wo','id_wo',array('status !=' => 8),$limit,$from,$totalpage);
        $data['wo']  = $res['data'];
        $data['pag'] = $res['pag'];

      
        echo json_encode($data);
    }

    function AddData(){
        $data["plugin"][] = "plugin/datatable";
        $data["plugin"][] = "plugin/select2";
        $data["title"] = "Add Work Order";
        $data["title_des"] = "Pembuatan Work Order";
        $data["content"] = "FormData";

        $data["data"] = $data;

        $this->load->view('template_v2', $data);
    }


    function SaveData(){
        $data   =   array_filter($_POST);
        unset($data['Newitems']);
        if (!empty($data)) {
            $data['id_unit']        = sess()['unit']; 
            $data['status']         = 0;
            $data['wo_type']        = 1;
            $data['create_by']        = sess()['id'];
            $data['create_time']    =  date("Y-m-d h:i:sa");
            // echo "<pre>",print_r ( $data),"</pre>";
            $this->db->insert('wo',$data);
            $id = $this->db->insert_id();
            if (!empty($_POST['Newitems'])) {
				
				foreach ($_POST['Newitems'] as $key => $value) {
					
					$perangkat=[
                        'id_wo'             =>  $id,
						'id_fasilitas' 		=>  $value['id_fasilitas'],
						'keterangan' 		=>  $value['keterangan_wo'] ,
						'status' 			=>  0,
                        
					];
                    $this->db->insert('wo_detail',$perangkat);
                    // echo "<pre>",print_r ( $perangkat),"</pre>";
				}	
				
			}
        }
    }

    function ProsesData($id=null){
        if (!empty($id)) {
            $data['status'] = 1;
            $this->Mod->update2('wo',array('id_wo ' =>$id ),$data);
            $res =[
                'status'    =>  200,
                'msg'       => 'Data Diproses'
            ];
            echo json_encode($res);
        }else{
             $res =[
                'status'    =>  200,
                'msg'       => 'Data Yang Diproses Tidak Valid'
            ];
            echo json_encode($res);
        }

    }

    function DeleteData($id=null){
        if (!empty($id)) {
            $data['status'] = 8;
            $this->Mod->update2('wo',array('id_wo ' =>$id ),$data);
            $res =[
                'status'    =>  200,
                'msg'       => 'Data Diproses'
            ];
            echo json_encode($res);
        }else{
             $res =[
                'status'    =>  200,
                'msg'       => 'Data Yang Diproses Tidak Valid'
            ];
            echo json_encode($res);
        }

    }
   
    
   
  

    
}