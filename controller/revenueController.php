<?php

Class revenueController Extends baseController {

    public function index() {

        $this->view->setLayout('admin');

        if (!isset($_SESSION['userid_logined'])) {

            return $this->view->redirect('user/login');

        }

        if ($_SESSION['role_logined'] != 1 && $_SESSION['role_logined'] != 2 && $_SESSION['role_logined'] != 4) {

            $this->view->data['disable_control'] = 1;

        }

        $this->view->data['lib'] = $this->lib;

        $this->view->data['title'] = 'Báo cáo doanh thu';



        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $order_by = isset($_POST['order_by']) ? $_POST['order_by'] : null;

            $order = isset($_POST['order']) ? $_POST['order'] : null;

            $page = isset($_POST['page']) ? $_POST['page'] : null;

            $keyword = isset($_POST['keyword']) ? $_POST['keyword'] : null;

            $limit = isset($_POST['limit']) ? $_POST['limit'] : 18446744073709;

            $batdau = isset($_POST['batdau']) ? $_POST['batdau'] : null;

            $ketthuc = isset($_POST['ketthuc']) ? $_POST['ketthuc'] : null;

            $vong = isset($_POST['vong']) ? $_POST['vong'] : null;

            $trangthai = isset($_POST['staff']) ? $_POST['staff'] : null;

            $kh = isset($_POST['nv']) ? $_POST['nv'] : null;

        }

        else{

            $order_by = $this->registry->router->order_by ? $this->registry->router->order_by : 'sell_date';

            $order = $this->registry->router->order_by ? $this->registry->router->order_by : 'ASC';

            $page = $this->registry->router->page ? (int) $this->registry->router->page : 1;

            $keyword = "";

            $limit = 50;

            $batdau = '01-'.date('m-Y');

            $ketthuc = date('t-m-Y');

            $vong = (int)date('m',strtotime($batdau));

            $trangthai = date('Y',strtotime($batdau));

            $kh = 0;

        }

        $id = $this->registry->router->param_id;

        $ngayketthuc = date('d-m-Y', strtotime($ketthuc. ' + 1 days'));

        $vong = (int)date('m',strtotime($batdau));

        $trangthai = date('Y',strtotime($batdau));

        $customer_model = $this->model->get('customerModel');

        $customers = $customer_model->getAllCustomer();

        $this->view->data['customers'] = $customers;


        $sell_model = $this->model->get('sellModel');

        $sonews = $limit;

        $x = ($page-1) * $sonews;

        $pagination_stages = 2;

        $join = array('table'=>'customer','where'=>'sell_customer = customer_id');

        $data = array(

            'where' => 'sell_date >= '.strtotime($batdau).' AND sell_date < '.strtotime($ngayketthuc),

        );


        if (isset($id) && $id > 0) {
            $data['where'] .= ' AND sell_id = '.$id;
        }
        if($kh > 0){
            $data['where'] = $data['where'].' AND sell_customer = '.$kh;
        }
        

        $tongsodong = count($sell_model->getAllSell($data,$join));

        $tongsotrang = ceil($tongsodong / $sonews);

        $data = array(

            'order_by'=>$order_by,

            'order'=>$order,

            'limit'=>$x.','.$sonews,

            'where' => 'sell_date >= '.strtotime($batdau).' AND sell_date < '.strtotime($ngayketthuc),

            );


        if (isset($id) && $id > 0) {
            $data['where'] .= ' AND sell_id = '.$id;
        }
       if($kh > 0){
            $data['where'] = $data['where'].' AND sell_customer = '.$kh;
        }

        

        if ($keyword != '') {

            $ngay = (strtotime(str_replace("/", "-", $keyword))!="")?(' OR sell_date LIKE "%'.strtotime(str_replace("/", "-", $keyword)).'%"'):"";

            $search = ' AND ( sell_code LIKE "%'.$keyword.'%" 
                OR customer_name LIKE "%'.$keyword.'%" 
                    '.$ngay.'
                )';

            $data['where'] .= $search;

        }

        

         $sells = $sell_model->getAllSell($data,$join);

        
        $this->view->data['sells'] = $sells;
        


        $this->view->data['page'] = $page;

        $this->view->data['order_by'] = $order_by;

        $this->view->data['order'] = $order;

        $this->view->data['keyword'] = $keyword;

        $this->view->data['pagination_stages'] = $pagination_stages;

        $this->view->data['tongsotrang'] = $tongsotrang;

        $this->view->data['sonews'] = $sonews;

        $this->view->data['limit'] = $limit;

        $this->view->data['batdau'] = $batdau;

        $this->view->data['ketthuc'] = $ketthuc;

        $this->view->data['vong'] = $vong;

        $this->view->data['trangthai'] = $trangthai;

        $this->view->data['kh'] = $kh;



        $this->view->data['lastID'] = isset($sell_model->getLastSell()->sell_id)?$sell_model->getLastSell()->sell_id:0;

        

        $this->view->show('revenue/index');

    }

    public function detail($id){
        $this->view->disableLayout();

        if (!$id) {
            return $this->view->redirect('sell');
        }
        $this->view->data['lib'] = $this->lib;

        $sell_list_model = $this->model->get('selllistModel');
        $product_list_model = $this->model->get('productlistModel');

        $join = array('table'=>'product','where'=>'product = product_id');
        $data = array(
            'where'=> 'sell = '.$id,
        );
        $sell_lists = $sell_list_model->getAllSell($data,$join);

        $join = array('table'=>'spare_part','where'=>'spare_part = spare_part_id');
        $sell_list_data = array();
        foreach ($sell_lists as $sell_list) {
            $data = array(
                'where'=> 'product = '.$sell_list->product,
            );
            $sell_list_data[$sell_list->sell_list_id] = $product_list_model->getAllProduct($data,$join);
        }

        $this->view->data['sell_lists'] = $sell_lists;
        $this->view->data['sell_list_data'] = $sell_list_data;

        $this->view->show('sell/detail');
    }


    



}

?>