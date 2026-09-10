<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Recharge extends CI_Controller {

    public function index(){
        $this->base->checkSession();
          // Passar a taxa de desconto e os valores para a view
        $data = array(
            'discount_rate' => $this->session->userdata('agent')->percent,
            'values' => [300, 500, 750, 1000, 2000, 10000]
        );

        $data['notifications'] = $this->notifications->getAll();
        $data['title'] = 'Recarga';
        
        $this->load->view('layout/header',$data);
		$this->load->view('pages/recharge',$data);
		$this->load->view('layout/footer');
    }

    public function pay($valor) {

        if($valor < 300){
            $this->session->set_flashdata('error', 'O valor mínimo para recarga é de R$ 300,00');
            redirect (site_url('recharge'));
        }

        $this->db->where('id', $this->session->userdata('agent')->id);
        $myData = $this->db->get('agents')->row();

        // Dados para o POST
        $postData = array(
            "valor" => $valor, // Convertendo valor para o formato adequado
            "nome" => "Athilson da Silva",
            "cpf" => "92730030018",
            "email" => "josesilva@gmail.com",
            "telefone" => "+5562999815500"
        );

        // Inicializando o cURL
        $ch = curl_init('https://grovichub.online/pagamento');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $response = curl_exec($ch);
        curl_close($ch);
        $responseData = json_decode($response, true);

        log_message('DEBUG', 'Response: ' . $response);

        if (isset($responseData)) {
            $istData = array('agentCode' => $myData->agentCode,
                             'valor' => $valor,
                             'transaction_id' => $responseData['transaction_id'],
                             'qrCodeImage' => $responseData['qrCodeImage'],
                             'paymentLink' => $responseData['paymentLink'],
                             'codeCopyAndPaste' => $responseData['codeCopyAndPaste'],
                             'status' => $responseData['status'],
                             'createdAt' => date('Y-m-d H:i:s'));
            $this->db->insert('agent_recharge', $istData);
            $nid = $this->db->insert_id();

            redirect (site_url('recharge/checkout/'.$nid));

        } else {

            $this->session->set_flashdata('error', 'Erro ao obter o QR Code, entre em contato com o suporte!');
			redirect (site_url('recharge'));
        }
    }
    public function checkout($id) {

        $data['notifications'] = $this->notifications->getAll();
        $data['title'] = 'Recarga Pagamento';

        $myData =  $this->db->get_where('agent_recharge', array('id' => $id))->row();
        $data['valor'] = $myData->valor;
        $data['qrCodeImage'] = $myData->qrCodeImage;
        $data['codeCopyAndPaste'] = $myData->codeCopyAndPaste;
        $data['paymentLink'] = $myData->paymentLink;
        $data['id'] = $id;
        $data['status'] = $myData->status;

        $this->load->view('layout/header',$data);
		$this->load->view('pages/checkout',$data);
		$this->load->view('layout/footer');

    }
    public function check($id) {
        $myData =  $this->db->get_where('agent_recharge', array('id' => $id))->row();
        // Inicializando o cURL
        $ch = curl_init('https://grovichub.online/status/'.$myData->transaction_id);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($ch, CURLOPT_POST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $response = curl_exec($ch);
        curl_close($ch);
        $responseData = json_decode($response, true);

        log_message('DEBUG', 'Check Response: ' . $response);

        $id = $myData->id;

        if ($responseData['status'] == 'COMPLETED') {

            $data = array('status' => $responseData['status']);
            $this->db->where('id', $id);
            $this->db->update('agent_recharge', $data);

            $total_credit = ($myData->valor * 100) / $this->session->userdata('agent')->percent;

            $this->base->ajustBalanceAdd($myData->agentCode, $total_credit);
            $this->session->set_flashdata('error', 'Recarga realizada com sucesso!');
            redirect (site_url('recharge/checkout/'.$id));
        } else {
            $this->session->set_flashdata('error', 'Pagamento ainda não realizado, realize o quanto antes.');
            redirect (site_url('recharge/checkout/'.$id));
        }

    }

}