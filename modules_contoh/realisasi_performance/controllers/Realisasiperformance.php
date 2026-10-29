<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');



class Realisasiperformance extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->library('excel');
        $this->load->model("m_data");
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
        $data["title"] = "Operasional";
        $data["title_des"] = "Daftar Operasional";
        $data["content"] = "v_index";

   
        $this->load->view('template_v2', $data);
        $menu = fetch_menu();
    }

     public function Realisasi() 
        {
             // Membuat array realisasi yang akan dikirimkan ke view
    $realisasi = [
        '2M' => ['rencana' => $total2m, 'realisasi' => $duaM, 'deviasi' => $total2m - $duaM, 'persentase' => ($total2m > 0) ? round(($duaM / $total2m) * 100, 2) : 0],
        '1B' => ['rencana' => $total1b, 'realisasi' => $satuB, 'deviasi' => $total1b - $satuB, 'persentase' => ($total1b > 0) ? round(($satuB / $total1b) * 100, 2) : 0],
        '3B' => ['rencana' => $total3b, 'realisasi' => $tigaB, 'deviasi' => $total3b - $tigaB, 'persentase' => ($total3b > 0) ? round(($tigaB / $total3b) * 100, 2) : 0],
        '6B' => ['rencana' => $total6b, 'realisasi' => $enamB, 'deviasi' => $total6b - $enamB, 'persentase' => ($total6b > 0) ? round(($enamB / $total6b) * 100, 2) : 0],
        'T' => ['rencana' => $totalT, 'realisasi' => $satuT, 'deviasi' => $totalT - $satuT, 'persentase' => ($totalT > 0) ? round(($satuT / $totalT) * 100, 2) : 0],
    ];

    $data = [
        'realisasi' => $realisasi
    ];

            
            // Sample data - replace with your actual database query
            $data['Realisasi'] = [
                'mei' => [
                    '14' => ['on' => 96, 'off' => 4, 'name' => 'NVA'],
                    '15' => ['on' => 91.71, 'off' => 8.29, 'name' => 'SVA'],
                    '16' => ['on' => 99.29, 'off' => 0.71, 'name' => 'EU'],
                    '17' => ['on' => 93.34, 'off' => 6.66, 'name' => 'UPS&CONV']
                ],
                'juni' => [
                    '14' => ['on' => 97, 'off' => 3, 'name' => 'NVA'],
                    '15' => ['on' => 91.18, 'off' => 8.82, 'name' => 'SVA'],
                    '16' => ['on' => 99.25, 'off' => 0.75, 'name' => 'EU'],
                    '17' => ['on' => 93.34, 'off' => 6.66, 'name' => 'UPS&CONV']
                ],
                'juli' => [
                    '14' => ['on' => 97, 'off' => 3, 'name' => 'NVA'],
                    '15' => ['on' => 85.27, 'off' => 14,73, 'name' => 'SVA'],
                    '16' => ['on' => 99.23, 'off' => 0.77, 'name' => 'EU'],
                    '17' => ['on' => 93.34, 'off' => 6.66, 'name' => 'UPS&CONV']
                ]
            ];
            
            $this->load->view('fasilitas/v_performa2', $data);
        }
     public function performa2() 
        {
            $data['title'] = "Performance Monitoring Alat";
            $data['title_des'] = "Data Performa On/Off Per Bulan";
            
            // Sample data - replace with your actual database query
            $data['performance_data'] = [
                'mei' => [
                    '14' => ['on' => 96, 'off' => 4, 'name' => 'NVA'],
                    '15' => ['on' => 91.71, 'off' => 8.29, 'name' => 'SVA'],
                    '16' => ['on' => 99.29, 'off' => 0.71, 'name' => 'EU'],
                    '17' => ['on' => 93.34, 'off' => 6.66, 'name' => 'UPS&CONV']
                ],
                'juni' => [
                    '14' => ['on' => 97, 'off' => 3, 'name' => 'NVA'],
                    '15' => ['on' => 91.18, 'off' => 8.82, 'name' => 'SVA'],
                    '16' => ['on' => 99.25, 'off' => 0.75, 'name' => 'EU'],
                    '17' => ['on' => 93.34, 'off' => 6.66, 'name' => 'UPS&CONV']
                ],
                'juli' => [
                    '14' => ['on' => 97, 'off' => 3, 'name' => 'NVA'],
                    '15' => ['on' => 85.27, 'off' => 14,73, 'name' => 'SVA'],
                    '16' => ['on' => 99.23, 'off' => 0.77, 'name' => 'EU'],
                    '17' => ['on' => 93.34, 'off' => 6.66, 'name' => 'UPS&CONV']
                ]
            ];
            
            $this->load->view('fasilitas/v_performa2', $data);
        }
      
   

   
}
