<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Caixas extends MY_Controller
{

    /**
     * author: Diego Pereira
     * email: diegohot14@gmail.com
     *
     */

    public function __construct()
    {
        parent::__construct();

        $this->load->helper('form');
        $this->load->model('caixas_model');
        $this->data['menuCaixas'] = 'Caixas';
    }

    public function index()
    {
        $this->gerenciar();
    }

    public function gerenciar()
    {
        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'vServico')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para visualizar caixas.');
            redirect(base_url());
        }

        $this->load->library('pagination');

        $this->data['configuration']['base_url'] = site_url('caixas/gerenciar/');
        $this->data['configuration']['total_rows'] = $this->caixas_model->count('caixas');

        $this->pagination->initialize($this->data['configuration']);

        $this->data['results'] = $this->caixas_model->get('caixas', '*', '', $this->data['configuration']['per_page'], $this->uri->segment(3));

        $this->data['view'] = 'caixas/caixas';
        return $this->layout();
    }

    public function adicionar()
    {
        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'aServico')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para adicionar caixas.');
            redirect(base_url());
        }

        $this->load->library('form_validation');
        $this->data['custom_error'] = '';

        $abre = $_POST['abre'];
        $fecha = $_POST['fecha'];
        $mov = $_POST['mov'];
        $data = date('d/m/Y');
        $tipo = null;
        $idCaixas = 0;
        $_POST['abre'] = $abre;
        $_POST['fecha'] = $fecha;
        $_POST['mov'] = $mov;
        // Abertura de Caixa
        if ($abre == 1) {
            $tipo = "Abertura de Terminal";
            $caixa = $this->caixas_model->getByData($data, $tipo);
            if ($caixa->idCaixas > 0) {
                $this->session->set_flashdata('error', 'Já existe um caixa Aberto no dia de Hoje!');
                redirect(base_url());
            }
        }
        // Fechamento de Caixa
        else if ($fecha == 1) {
            $tipo = "Fechamento de Terminal";
            $caixa = $this->caixas_model->getByData($data, $tipo);
            if ($caixa->idCaixas > 0) {
                $this->session->set_flashdata('error', 'Caixa já Fechado, favor abrir um novo.');
                redirect(base_url());
            }
        }
        // Movimentação de Caixa
        else if ($mov == 1) {
            $tipo = "Movimentação de Terminal";
            $caixa = $this->caixas_model->getByData($data, $tipo);
            if ($caixa->idCaixas > 0) {
                $this->session->set_flashdata('error', 'Caixa já Fechado, favor abrir um novo.');
                redirect(base_url());
            }
        }
        // else {
        //     $this->session->set_flashdata('error', 'Ocorreu um erro.');
        //     $this->data['custom_error'] = '<div class="form_error"><p>Ocorreu um erro.</p></div>';
        //     redirect(base_url());
        // }

        debug();
        if ($this->form_validation->run('caixas') == false) {
            $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">' . validation_errors() . '</div>' : false);
        } else {
            $preco = $this->input->post('preco');
            $preco = str_replace(",", "", $preco);

            $data = [
                'data' => set_value('data'),
                'historico' => set_value('historico'),
                'descricao' => set_value('descricao'),
                'operador' => set_value('operador'),
                //'preco' => $preco,
            ];

            if ($this->caixas_model->add('caixas', $data) == true) {
                $this->session->set_flashdata('success', 'Serviço adicionado com sucesso!');
                log_info('Adicionou um serviço');
                redirect(site_url('caixas/adicionar/'));
            } else {
                $this->data['custom_error'] = '<div class="form_error"><p>Ocorreu um erro.</p></div>';
            }
        }
        $this->data['view'] = 'caixas/adicionarCaixa';
        return $this->layout();
    }

    public function editar()
    {
        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'eServico')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para editar caixas.');
            redirect(base_url());
        }
        $this->load->library('form_validation');
        $this->data['custom_error'] = '';

        if ($this->form_validation->run('caixas') == false) {
            $this->data['custom_error'] = (validation_errors() ? '<div class="form_error">' . validation_errors() . '</div>' : false);
        } else {
            $preco = $this->input->post('preco');
            $preco = str_replace(",", "", $preco);
            $data = [
                'nome' => $this->input->post('nome'),
                'descricao' => $this->input->post('descricao'),
                'preco' => $preco,
            ];

            if ($this->caixas_model->edit('caixas', $data, 'idServicos', $this->input->post('idServicos')) == true) {
                $this->session->set_flashdata('success', 'Serviço editado com sucesso!');
                log_info('Alterou um serviço. ID: ' . $this->input->post('idServicos'));
                redirect(site_url('caixas/editar/') . $this->input->post('idServicos'));
            } else {
                $this->data['custom_error'] = '<div class="form_error"><p>Ocorreu um errro.</p></div>';
            }
        }

        $this->data['result'] = $this->caixas_model->getById($this->uri->segment(3));

        $this->data['view'] = 'caixas/editarCaixa';
        return $this->layout();
    }

    public function excluir()
    {
        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'dServico')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para excluir Caixas.');
            redirect(base_url());
        }

        $id = $this->input->post('id');
        if ($id == null) {
            $this->session->set_flashdata('error', 'Erro ao tentar excluir Caixa.');
            redirect(site_url('caixas/gerenciar/'));
        }

        $this->caixas_model->delete('caixas', 'idCaixas', $id);

        log_info('Removeu um Caixa. ID: ' . $id);

        $this->session->set_flashdata('success', 'Caixa excluido com sucesso!');
        redirect(site_url('caixas/gerenciar/'));
    }
}
