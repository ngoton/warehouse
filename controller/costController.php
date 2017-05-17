<?php

Class costController Extends baseController {

    public function index() {

        $this->view->setLayout('admin');

        if (!isset($_SESSION['userid_logined'])) {

            return $this->view->redirect('user/login');

        }

        if ($_SESSION['role_logined'] != 1 && $_SESSION['role_logined'] != 2 && $_SESSION['role_logined'] != 3 && $_SESSION['role_logined'] != 4) {

            $this->view->data['disable_control'] = 1;

        }

        $this->view->data['lib'] = $this->lib;

        $this->view->data['title'] = 'Chi phí sản xuất';



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

            $order_by = $this->registry->router->order_by ? $this->registry->router->order_by : 'cost_date';

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

        $cost_list_model = $this->model->get('costlistModel');

        $cost_lists = $cost_list_model->getAllCost();

        $this->view->data['cost_lists'] = $cost_lists;


        $customer_model = $this->model->get('customerModel');

        $customers = $customer_model->getAllCustomer();

        $this->view->data['customers'] = $customers;


        $cost_model = $this->model->get('costModel');

        $sonews = $limit;

        $x = ($page-1) * $sonews;

        $pagination_stages = 2;

        $join = array('table'=>'customer, cost_list','where'=>'cost_customer = customer_id AND cost_list = cost_list_id');

        $data = array(

            'where' => 'cost_date >= '.strtotime($batdau).' AND cost_date < '.strtotime($ngayketthuc),

        );


        if (isset($id) && $id > 0) {
            $data['where'] .= ' AND cost_id = '.$id;
        }
        if($kh > 0){
            $data['where'] = $data['where'].' AND cost_customer = '.$kh;
        }
        

        $tongsodong = count($cost_model->getAllCost($data,$join));

        $tongsotrang = ceil($tongsodong / $sonews);

        $data = array(

            'order_by'=>$order_by,

            'order'=>$order,

            'limit'=>$x.','.$sonews,

            'where' => 'cost_date >= '.strtotime($batdau).' AND cost_date < '.strtotime($ngayketthuc),

            );


        if (isset($id) && $id > 0) {
            $data['where'] .= ' AND cost_id = '.$id;
        }
       if($kh > 0){
            $data['where'] = $data['where'].' AND cost_customer = '.$kh;
        }

        

        if ($keyword != '') {

            $ngay = (strtotime(str_replace("/", "-", $keyword))!="")?(' OR cost_date LIKE "%'.strtotime(str_replace("/", "-", $keyword)).'%"'):"";

            $search = ' AND ( cost_code LIKE "%'.$keyword.'%" 
                OR customer_name LIKE "%'.$keyword.'%" 
                    '.$ngay.'
                )';

            $data['where'] .= $search;

        }

        

         $costs = $cost_model->getAllCost($data,$join);

        
        $this->view->data['costs'] = $costs;
        


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



        $this->view->data['lastID'] = isset($cost_model->getLastCost()->cost_id)?$cost_model->getLastCost()->cost_id:0;

        

        $this->view->show('cost/index');

    }




    public function add(){

        if (!isset($_SESSION['userid_logined'])) {

            return $this->view->redirect('user/login');

        }

        if ($_SESSION['role_logined'] != 1 && $_SESSION['role_logined'] != 2 && $_SESSION['role_logined'] != 3 && $_SESSION['role_logined'] != 4) {

            return $this->view->redirect('user/login');

        }

        if (isset($_POST['yes'])) {

            $cost_model = $this->model->get('costModel');

            
            $debit = $this->model->get('debitModel');

            $vat = $this->model->get('vatModel');



            /**************/


            /**************/



            $data = array(

                        'cost_date' => strtotime($_POST['cost_date']),

                        'cost_customer' => trim($_POST['cost_customer']),

                        'cost_comment' => trim($_POST['cost_comment']),

                        'cost_money' => str_replace(',', '', $_POST['cost_money']),

                        'cost_document' => trim($_POST['cost_document']),

                        'cost_document_date' => strtotime($_POST['cost_document_date']),

                        'cost_list' => trim($_POST['cost_list']),

                        'check_vat' => trim($_POST['check_vat']),

                        );





            if ($_POST['yes'] != "") {

                   $cost = $cost_model->getCost($_POST['yes']);

                    $cost_model->updateCost($data,array('cost_id' => $_POST['yes']));

                    $id_cost = $_POST['yes'];

                    /*Log*/

                    /**/
                    if ($data['check_vat'] == 1) {
                        $data_debit = array(

                            'debit_date'=>$data['cost_date'],

                            'customer'=>$data['cost_customer'],

                            'money'=>round($data['cost_money']/1.1),

                            'money_vat_price'=>$data['cost_money']-round($data['cost_money']/1.1),

                            'money_vat'=>1,

                            'comment'=>$data['cost_comment'].' '.$data['cost_document'],

                            'check_debit'=>2,

                            'cost'=>$id_cost,

                        );

                        $debit->updateDebit($data_debit,array('cost'=>$id_cost));
                    }
                    else{
                        $data_debit = array(

                            'debit_date'=>$data['cost_date'],

                            'customer'=>$data['cost_customer'],

                            'money'=>$data['cost_money'],

                            'money_vat_price'=>0,

                            'money_vat'=>0,

                            'comment'=>$data['cost_comment'].' '.$data['cost_document'],

                            'check_debit'=>2,

                            'cost'=>$id_cost,

                        );

                        $debit->updateDebit($data_debit,array('cost'=>$id_cost));
                    }

                    if ($cost->check_vat != 1 && $data['check_vat'] == 1) {
                        $data_vat = array(

                            'in_out'=>1,

                            'vat_sum'=>round($data['cost_money']/1.1),

                            'vat_price'=>$data['cost_money']-round($data['cost_money']/1.1),

                            'customer'=>$data['cost_customer'],

                            'vat_number'=>$data['cost_document'],

                            'vat_date'=>$data['cost_document_date'],

                            'cost'=>$id_cost,

                        );

                        $vat->createVAT($data_vat);
                    }
                    else if ($cost->check_vat == 1 && $data['check_vat'] == 1) {
                        $data_vat = array(

                            'in_out'=>1,

                            'vat_sum'=>round($data['cost_money']/1.1),

                            'vat_price'=>$data['cost_money']-round($data['cost_money']/1.1),

                            'customer'=>$data['cost_customer'],

                            'vat_number'=>$data['cost_document'],

                            'vat_date'=>$data['cost_document_date'],

                            'cost'=>$id_cost,

                        );

                        $vat->updateVAT($data_vat,array('cost'=>$id_cost));
                    }
                    else if ($cost->check_vat == 1 && $data['check_vat'] != 1) {
                        
                        $vat->queryVAT('DELETE FROM vat WHERE cost = '.$id_cost);
                    }


                    echo "Cập nhật thành công";



                    date_default_timezone_set("Asia/Ho_Chi_Minh"); 

                        $filename = "action_logs.txt";

                        $text = date('d/m/Y H:i:s')."|".$_SESSION['user_logined']."|"."edit"."|".$_POST['yes']."|cost|".implode("-",$data)."\n"."\r\n";

                        

                        $fh = fopen($filename, "a") or die("Could not open log file.");

                        fwrite($fh, $text) or die("Could not write file!");

                        fclose($fh);
                    
                
                

                

            }

            else{


                    $cost_model->createCost($data);

                    $id_cost = $cost_model->getLastCost()->cost_id;

                    /*Log*/

                    /**/



                    if ($data['check_vat'] == 1) {
                        $data_debit = array(

                            'debit_date'=>$data['cost_date'],

                            'customer'=>$data['cost_customer'],

                            'money'=>round($data['cost_money']/1.1),

                            'money_vat_price'=>$data['cost_money']-round($data['cost_money']/1.1),

                            'money_vat'=>1,

                            'comment'=>$data['cost_comment'].' '.$data['cost_document'],

                            'check_debit'=>2,

                            'cost'=>$id_cost,

                        );

                        $debit->createDebit($data_debit);

                        $data_vat = array(

                            'in_out'=>1,

                            'vat_sum'=>round($data['cost_money']/1.1),

                            'vat_price'=>$data['cost_money']-round($data['cost_money']/1.1),

                            'customer'=>$data['cost_customer'],

                            'vat_number'=>$data['cost_document'],

                            'vat_date'=>$data['cost_document_date'],

                            'cost'=>$id_cost,

                        );

                        $vat->createVAT($data_vat);
                    }
                    else{
                        $data_debit = array(

                            'debit_date'=>$data['cost_date'],

                            'customer'=>$data['cost_customer'],

                            'money'=>$data['cost_money'],

                            'money_vat'=>0,

                            'comment'=>$data['cost_comment'].' '.$data['cost_document'],

                            'check_debit'=>2,

                            'cost'=>$id_cost,

                        );

                        $debit->createDebit($data_debit);
                    }

                    



                    echo "Thêm thành công";



                    date_default_timezone_set("Asia/Ho_Chi_Minh"); 

                        $filename = "action_logs.txt";

                        $text = date('d/m/Y H:i:s')."|".$_SESSION['user_logined']."|"."add"."|".$cost_model->getLastCost()->cost_id."|cost|".implode("-",$data)."\n"."\r\n";

                        

                        $fh = fopen($filename, "a") or die("Could not open log file.");

                        fwrite($fh, $text) or die("Could not write file!");

                        fclose($fh);

                    
                
                

                

            }


            
                

                    

        }

    }

    public function delete(){

        if (!isset($_SESSION['userid_logined'])) {

            return $this->view->redirect('user/login');

        }

        if ($_SESSION['role_logined'] != 1 && $_SESSION['role_logined'] != 2 && $_SESSION['role_logined'] != 3 && $_SESSION['role_logined'] != 4) {

            return $this->view->redirect('user/login');

        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $cost_model = $this->model->get('costModel');



            if (isset($_POST['xoa'])) {

                $data = explode(',', $_POST['xoa']);

                foreach ($data as $data) {


                    $cost_model->deleteCost($data);

                    

                    

                    date_default_timezone_set("Asia/Ho_Chi_Minh"); 

                        $filename = "action_logs.txt";

                        $text = date('d/m/Y H:i:s')."|".$_SESSION['user_logined']."|"."delete"."|".$data."|cost|"."\n"."\r\n";

                        

                        $fh = fopen($filename, "a") or die("Could not open log file.");

                        fwrite($fh, $text) or die("Could not write file!");

                        fclose($fh);

                }



                /*Log*/

                    /**/



                return true;

            }

            else{


                /*Log*/

                    /**/

                    date_default_timezone_set("Asia/Ho_Chi_Minh"); 

                        $filename = "action_logs.txt";

                        $text = date('d/m/Y H:i:s')."|".$_SESSION['user_logined']."|"."delete"."|".$_POST['data']."|cost|"."\n"."\r\n";

                        

                        $fh = fopen($filename, "a") or die("Could not open log file.");

                        fwrite($fh, $text) or die("Could not write file!");

                        fclose($fh);



                return $cost_model->deleteCost($_POST['data']);

            }

            

        }

    }

    public function getcustomer(){



        if (!isset($_SESSION['userid_logined'])) {



            return $this->view->redirect('user/login');



        }





        if ($_SERVER['REQUEST_METHOD'] == 'POST') {



            $customer_model = $this->model->get('customerModel');



            



            if ($_POST['keyword'] == "*") {







                $list = $customer_model->getAllCustomer();



            }



            else{



                $data = array(



                'where'=>'( customer_name LIKE "%'.$_POST['keyword'].'%" )',



                );



                $list = $customer_model->getAllCustomer($data);



            }



            



            foreach ($list as $rs) {



                // put in bold the written text



                $customer_name = $rs->customer_name;



                if ($_POST['keyword'] != "*") {



                    $customer_name = str_replace($_POST['keyword'], '<b>'.$_POST['keyword'].'</b>', $rs->customer_name);



                }



                



                // add new option



                echo '<li onclick="set_item_customer(\''.$rs->customer_id.'\',\''.$rs->customer_name.'\')">'.$customer_name.'</li>';



            }



        }



    }

    



}

?>