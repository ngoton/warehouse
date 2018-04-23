<?php
Class adminController Extends baseController {
    public function index() {
    	$this->view->setLayout('admin');
    	if (!isset($_SESSION['role_logined'])) {
            return $this->view->redirect('user/login');
        }
        $this->view->data['lib'] = $this->lib;
        $this->view->data['title'] = 'Dashboard';

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $batdau = isset($_POST['batdau']) ? $_POST['batdau'] : null;
            $ketthuc = isset($_POST['ketthuc']) ? $_POST['ketthuc'] : null;
        }
        else{
            $batdau = '01-'.date('m-Y');
            $ketthuc = date('t-m-Y');
        }

        $this->view->data['batdau'] = $batdau;
        $this->view->data['ketthuc'] = $ketthuc;

        $ngayketthuc = date('d-m-Y', strtotime($ketthuc. ' + 1 days'));


        $sell_model = $this->model->get('sellModel');
        $cost_model = $this->model->get('costModel');

        $data = array(

            'where' => 'sell_date >= '.strtotime($batdau).' AND sell_date < '.strtotime($ngayketthuc),

            );

        $sells = $sell_model->getAllSell($data);


        $doanhthu = 0;
        $sanluong = 0;
        $khachhang = 0;
        $donhang = 0;
        $sl = array();
        $old_cus = array();
        $cp = array();

        $shipment_costs = $cost_model->getAllCost(array('where' => 'cost_date >= '.strtotime($batdau).' AND cost_date < '.strtotime($ngayketthuc)));
        foreach ($shipment_costs as $cost) {
            $cp['ngay'][(int)date('d',$cost->cost_date)] = isset($cp['ngay'][(int)date('d',$cost->cost_date)])?$cp['ngay'][(int)date('d',$cost->cost_date)]+$cost->cost_money:$cost->cost_money;
            $cp['thang'][(int)date('m',$cost->cost_date)] = isset($cp['thang'][(int)date('m',$cost->cost_date)])?$cp['thang'][(int)date('m',$cost->cost_date)]+$cost->cost_money:$cost->cost_money;
        }

        foreach ($sells as $shipment) {
        	if (!in_array($shipment->sell_customer,$old_cus)) {
        		$khachhang++;
                $old_cus[] = $shipment->sell_customer;
            }
        	$donhang++;
        	$sanluong += $shipment->sell_number;
        	$doanhthu += $shipment->sell_money;

        	$sl['ngay'][(int)date('d',$shipment->sell_date)] = isset($sl['ngay'][(int)date('d',$shipment->sell_date)])?$sl['ngay'][(int)date('d',$shipment->sell_date)]+$shipment->sell_money:$shipment->sell_money;
            $sl['thang'][(int)date('m',$shipment->sell_date)] = isset($sl['thang'][(int)date('m',$shipment->sell_date)])?$sl['thang'][(int)date('m',$shipment->sell_date)]+$shipment->sell_money:$shipment->sell_money;
		}

        $start = date('d',strtotime($batdau));
        $start_month = date('m',strtotime($batdau));
        $start_year = date('Y',strtotime($batdau));
        $end = date('d',strtotime($ketthuc));
        $end_month = date('m',strtotime($ketthuc));
        $end_year = date('Y',strtotime($ketthuc));
        $graph = array();
        $bar_chart_label = array();
        $bar_chart_dt = array();
        $bar_chart_cp = array();
        if ($start_month == $end_month && $start_year == $end_year) {
            for ($i=$start; $i <= $end; $i++) { 
                $graph[]['y'] = $start_year.'-'.$start_month.'-'.$i;
                $graph[]['item1'] = isset($sl['ngay'][$i])?$sl['ngay'][$i]:0;

                $bar_chart_label[] = $i.'-'.$start_month.'-'.$start_year;
                $bar_chart_cp[] = isset($cp['ngay'][$i])?$cp['ngay'][$i]:0;
                $bar_chart_dt[] = isset($sl['ngay'][$i])?$sl['ngay'][$i]:0;
            }
        }
        elseif ($start_month != $end_month && $start_year == $end_year) {
            for ($i=$start_month; $i <= $end_month; $i++) { 
                $graph[]['y'] = $start_year.'-'.$i;
                $graph[]['item1'] = isset($sl['thang'][$i])?$sl['thang'][$i]:0;

                $bar_chart_label[] = $start_year.'-'.$i;
                $bar_chart_cp[] = isset($cp['thang'][$i])?$cp['thang'][$i]:0;
                $bar_chart_dt[] = isset($sl['thang'][$i])?$sl['thang'][$i]:0;
            }
        }
        
        $graph = str_replace('"},{"i','","i',json_encode($graph));
        $bar_chart_label = json_encode($bar_chart_label);
        $bar_chart_cp = json_encode($bar_chart_cp);
        $bar_chart_dt = json_encode($bar_chart_dt);

        $this->view->data['doanhthu'] = $doanhthu;
        $this->view->data['sanluong'] = $sanluong;
        $this->view->data['khachhang'] = $khachhang;
        $this->view->data['donhang'] = $donhang;
        $this->view->data['graph'] = $graph;
        $this->view->data['bar_chart_label'] = $bar_chart_label;
        $this->view->data['bar_chart_cp'] = $bar_chart_cp;
        $this->view->data['bar_chart_dt'] = $bar_chart_dt;

        $bank_model = $this->model->get('bankModel');
        $banks = $bank_model->getAllBank();
        
        $this->view->data['banks'] = $banks;

        $bank_balance_model = $this->model->get('bankbalanceModel');

        $data_bank = array();

        $balances = $bank_balance_model->getAllBank(array('where'=>'bank_balance_date < '.strtotime($batdau)));

        foreach ($balances as $ba) {
            $data_bank[$ba->bank]['dauki'] = isset($data_bank[$ba->bank]['dauki'])?$data_bank[$ba->bank]['dauki']+$ba->bank_balance_money:$ba->bank_balance_money;
        }

        $balances = $bank_balance_model->getAllBank(array('where'=>'bank_balance_date >= '.strtotime($batdau).' AND bank_balance_date <= '.strtotime($ketthuc)));

        
        foreach ($balances as $balance) {
            if ($balance->bank_balance_money > 0) {
                $data_bank[$balance->bank]['receipt'] = isset($data_bank[$balance->bank]['receipt'])?$data_bank[$balance->bank]['receipt']+$balance->bank_balance_money:$balance->bank_balance_money;
            }
            else {
                $data_bank[$balance->bank]['payment'] = isset($data_bank[$balance->bank]['payment'])?$data_bank[$balance->bank]['payment']+$balance->bank_balance_money:$balance->bank_balance_money;
            }
        }

        $this->view->data['data_bank'] = $data_bank;

        $this->view->show('admin/index');
    }


}
?>