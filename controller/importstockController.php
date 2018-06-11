<?php

Class importstockController Extends baseController {

    public function index() {

        $this->view->setLayout('admin');

        if (!isset($_SESSION['userid_logined'])) {

            return $this->view->redirect('user/login');

        }

        if ($_SESSION['role_logined'] != 1 && $_SESSION['role_logined'] != 2 && $_SESSION['role_logined'] != 6 && $_SESSION['role_logined'] != 8) {

            $this->view->data['disable_control'] = 1;

        }

        $this->view->data['lib'] = $this->lib;

        $this->view->data['title'] = 'Nhập kho';



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


        }

        else{

            $order_by = $this->registry->router->order_by ? $this->registry->router->order_by : 'import_stock_date';

            $order = $this->registry->router->order_by ? $this->registry->router->order_by : 'DESC';

            $page = $this->registry->router->page ? (int) $this->registry->router->page : 1;

            $keyword = "";

            $limit = 50;

            $batdau = '01-'.date('m-Y');



            $ketthuc = date('t-m-Y');



            $vong = (int)date('m',strtotime($batdau));



            $trangthai = date('Y',strtotime($batdau));

        }



        $ngayketthuc = date('d-m-Y', strtotime($ketthuc. ' + 1 days'));



        $vong = (int)date('m',strtotime($batdau));



        $trangthai = date('Y',strtotime($batdau));


        $costlist_model = $this->model->get('costlistModel');

        $this->view->data['cost_lists'] = $costlist_model->getAllCost();

        $customer_model = $this->model->get('customerModel');

        $customers = $customer_model->getAllCustomer(array('order_by'=>'customer_name','order'=>'ASC'));

        $customer_data = array();

        foreach ($customers as $customer) {

            $customer_data['customer_id'][$customer->customer_id] = $customer->customer_id;
            $customer_data['customer_name'][$customer->customer_id] = $customer->customer_name;

        }

        $this->view->data['customer_data'] = $customer_data;


        $import_model = $this->model->get('importstockModel');

        $sonews = $limit;

        $x = ($page-1) * $sonews;

        $pagination_stages = 2;



        $data = array(

            'where' => 'import_stock_date >= '.strtotime($batdau).' AND import_stock_date < '.strtotime($ngayketthuc),

        );



        

        $tongsodong = count($import_model->getAllStock($data));

        $tongsotrang = ceil($tongsodong / $sonews);

        $data = array(

            'order_by'=>$order_by,

            'order'=>$order,

            'limit'=>$x.','.$sonews,

            'where' => 'import_stock_date >= '.strtotime($batdau).' AND import_stock_date < '.strtotime($ngayketthuc),

            );



       

        

        if ($keyword != '') {

            $ngay = (strtotime(str_replace("/", "-", $keyword))!="")?(' OR import_stock_date LIKE "%'.strtotime(str_replace("/", "-", $keyword)).'%"'):"";

            $search = ' AND ( '.$ngay.' )';

            $data['where'] .= $search;

        }

        

         $imports = $import_model->getAllStock($data);

         $spare_model = $this->model->get('sparestockModel');
         $spare_part_model = $this->model->get('sparepartModel');
         $import_data = array();

         foreach ($imports as $import) {
             $stocks = $spare_model->getStockByWhere(array('import_stock'=>$import->import_stock_id));

             $import_data[$import->import_stock_id]['spare'] = $spare_part_model->getStock($stocks->spare_part)->spare_part_name;
         }

        $this->view->data['import_data'] = $import_data;
        $this->view->data['imports'] = $imports;
        


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



        



        $this->view->data['lastID'] = isset($import_model->getLastStock()->import_stock_id)?$import_model->getLastStock()->import_stock_id:0;

        

        $this->view->show('importstock/index');

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

    public function getreceiver(){



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



                $customer_name = '['.$rs->customer_code.']-'.$rs->customer_name;



                if ($_POST['keyword'] != "*") {



                    $customer_name = str_replace($_POST['keyword'], '<b>'.$_POST['keyword'].'</b>', '['.$rs->customer_code.']-'.$rs->customer_name);



                }



                



                // add new option



                echo '<li onclick="set_item_receiver(\''.$rs->customer_id.'\',\''.$rs->customer_name.'\',\''.$_POST['offset'].'\')">'.$customer_name.'</li>';



            }



        }



    }


    public function add(){

        if (!isset($_SESSION['userid_logined'])) {

            return $this->view->redirect('user/login');

        }

        if ($_SESSION['role_logined'] != 1 && $_SESSION['role_logined'] != 2 && $_SESSION['role_logined'] != 6 && $_SESSION['role_logined'] != 8) {

            return $this->view->redirect('user/login');

        }

        if (isset($_POST['yes'])) {

            $import_model = $this->model->get('importstockModel');

            $stock_model = $this->model->get('sparestockModel');

            $spare_model = $this->model->get('sparepartModel');



            $debit = $this->model->get('debitModel');

            $vat = $this->model->get('vatModel');



            $import_stock_cost_model = $this->model->get('importstockcostModel');



            /**************/



            $import_stock_cost_list = $_POST['import_stock_cost'];



            /**************/



            $data = array(

                        

                        'import_stock_date' => strtotime($_POST['import_stock_date']),

                        'invoice_number' => trim($_POST['invoice_number']),

                        'invoice_date' => strtotime($_POST['invoice_date']),

                        'invoice_customer' => trim($_POST['invoice_customer']),

                        );





            if ($_POST['yes'] != "") {

                    $import = $import_model->getStock($_POST['yes']);



                    $import_model->updateStock($data,array('import_stock_id' => $_POST['yes']));

                    $id_import = $_POST['yes'];

                    /*Log*/

                    /**/
                    if (($import->invoice_customer == "" || $import->invoice_customer == 0 ) && $data['invoice_customer'] > 0) {

                        $data_debit = array(

                                'debit_date'=>$data['import_stock_date'],

                                'customer'=>$data['invoice_customer'],

                                'money'=>0,

                                'money_vat'=>1,

                                'comment'=>'Mua hàng HD số '.$data['invoice_number'],

                                'check_debit'=>2,

                                'import_stock'=>$id_import,

                            );

                            $debit->createDebit($data_debit);



                        $data_vat = array(

                                'in_out'=>1,

                                'vat_number'=>$data['invoice_number'],

                                'vat_date'=>$data['invoice_date'],

                                'import_stock'=>$id_import,

                            );

                            $vat->createVAT($data_vat);

                    }

                    else if($import->invoice_customer > 0 && $data['invoice_customer'] > 0){

                        $data_debit = array(

                            'debit_date'=>$data['import_stock_date'],

                            'customer'=>$data['invoice_customer'],

                            'money'=>0,

                            'money_vat'=>1,

                            'comment'=>'Mua hàng HD số '.$data['invoice_number'],

                            'check_debit'=>2,

                            'import_stock'=>$id_import,

                        );

                        $debit->updateDebit($data_debit,array('import_stock'=>$id_import));



                        $data_vat = array(

                                'in_out'=>1,

                                'vat_number'=>$data['invoice_number'],

                                'vat_date'=>$data['invoice_date'],

                                'import_stock'=>$id_import,

                            );

                            $vat->updateVAT($data_vat,array('import_stock'=>$id_import));

                    }

                    else if($import->invoice_customer > 0 && ($data['invoice_customer'] == 0 || $data['invoice_customer'] == "")){

                        $debit->queryDebit('DELETE FROM debit WHERE import_stock = '.$id_import);

                        $vat->queryVAT('DELETE FROM vat WHERE import_stock = '.$id_import);

                    }



                    foreach ($import_stock_cost_list as $v) {



                        $data_cost = array(



                            'import_stock' => $id_import,



                            'cost' => trim(str_replace(',','',$v['cost'])),



                            'cost_list' => $v['cost_list'],



                            'check_vat' => $v['check_vat'],



                            'comment' => trim($v['comment']),



                            'receiver' => isset($v['receiver'])?$v['receiver']:null,



                            'cost_document' => trim($v['cost_document']),



                            'cost_document_date' => trim(strtotime($v['cost_document_date'])),



                        );





                        if ($v['import_stock_cost_id'] == "") {



                            if ($data_cost['receiver'] > 0) {

                                $import_stock_cost_model->createStock($data_cost);

                                $id_stock_cost = $import_stock_cost_model->getLastStock()->import_stock_cost_id;



                                if ($data_cost['check_vat'] == 1) {

                                    $data_debit = array(

                                        'debit_date'=>$data['import_stock_date'],

                                        'customer'=>$data_cost['receiver'],

                                        'money'=>round($data_cost['cost']/1.1),

                                        'money_vat_price'=>$data_cost['cost']-round($data_cost['cost']/1.1),

                                        'money_vat'=>$data_cost['check_vat'],

                                        'comment'=>$data_cost['comment'].' ('.$data_cost['cost_document'].')',

                                        'check_debit'=>2,

                                        'import_stock_cost'=>$id_stock_cost,

                                    );

                                    $debit->createDebit($data_debit);

                                    $data_vat = array(

                                        'in_out'=>1,

                                        'vat_number'=>$data_cost['cost_document'],

                                        'vat_date'=>$data_cost['cost_document_date'],

                                        'import_stock_cost'=>$id_stock_cost,

                                    );

                                    $vat->createVAT($data_vat);

                                }

                                else{

                                    $data_debit = array(

                                        'debit_date'=>$data['import_stock_date'],

                                        'customer'=>$data_cost['receiver'],

                                        'money'=>$data_cost['cost'],

                                        'money_vat_price'=>0,

                                        'money_vat'=>$data_cost['check_vat'],

                                        'comment'=>$data_cost['comment'].' ('.$data_cost['cost_document'].')',

                                        'check_debit'=>2,

                                        'import_stock_cost'=>$id_stock_cost,

                                    );

                                    $debit->createDebit($data_debit);

                                }

                                $vat_sum = round($data_cost['cost']/1.1);
                                $vat_price = $data_cost['cost']-round($data_cost['cost']/1.1);

                                $vat->updateVAT(array('vat_sum'=>$vat_sum,'vat_price'=>$vat_price),array('import_stock_cost' => $id_stock_cost));

                            }

                            
                            


                        }



                        else if ($v['import_stock_cost_id'] > 0) {

                            $check = $import_stock_cost_model->getStock($v['import_stock_cost_id']);

                            $import_stock_cost_model->updateStock($data_cost,array('import_stock_cost_id'=>$v['import_stock_cost_id']));



                            if ($data_cost['check_vat'] == 1) {

                                $data_debit = array(

                                    'debit_date'=>$data['import_stock_date'],

                                    'customer'=>$data_cost['receiver'],

                                    'money'=>round($data_cost['cost']/1.1),

                                    'money_vat_price'=>$data_cost['cost']-round($data_cost['cost']/1.1),

                                    'money_vat'=>$data_cost['check_vat'],

                                    'comment'=>$data_cost['comment'].' ('.$data_cost['cost_document'].')',

                                    'check_debit'=>2,

                                    'import_stock_cost'=>$v['import_stock_cost_id'],

                                );

                                $debit->updateDebit($data_debit,array('import_stock_cost'=>$v['import_stock_cost_id']));

                            }

                            else{

                                $data_debit = array(

                                    'debit_date'=>$data['import_stock_date'],

                                    'customer'=>$data_cost['receiver'],

                                    'money'=>$data_cost['cost'],

                                    'money_vat_price'=>0,

                                    'money_vat'=>$data_cost['check_vat'],

                                    'comment'=>$data_cost['comment'].' ('.$data_cost['cost_document'].')',

                                    'check_debit'=>2,

                                    'import_stock_cost'=>$v['import_stock_cost_id'],

                                );

                                $debit->updateDebit($data_debit,array('import_stock_cost'=>$v['import_stock_cost_id']));

                            }

                            



                            if ($check->check_vat == 1 && $data_cost['check_vat'] == 1) {

                                 $data_vat = array(

                                    'in_out'=>1,

                                    'vat_number'=>$data_cost['cost_document'],

                                    'vat_date'=>$data_cost['cost_document_date'],

                                    'import_stock_cost'=>$v['import_stock_cost_id'],

                                );

                                $vat->updateVAT($data_vat,array('import_stock_cost'=>$v['import_stock_cost_id']));

                            }

                            else if ($check->check_vat == 1 && $data_cost['check_vat'] != 1) {

                                $vat->queryVAT('DELETE FROM vat WHERE import_stock_cost = '.$v['import_stock_cost_id']);

                            }

                            else if ($check->check_vat != 1 && $data_cost['check_vat'] == 1) {

                                 $data_vat = array(

                                    'in_out'=>1,

                                    'vat_number'=>$data_cost['cost_document'],

                                    'vat_date'=>$data_cost['cost_document_date'],

                                    'import_stock_cost'=>$v['import_stock_cost_id'],

                                );

                                $vat->createVAT($data_vat);

                            }

                            $vat_sum = round($data_cost['cost']/1.1);
                            $vat_price = $data_cost['cost']-round($data_cost['cost']/1.1);

                            $vat->updateVAT(array('vat_sum'=>$vat_sum,'vat_price'=>$vat_price),array('import_stock_cost' => $v['import_stock_cost_id']));

                        }



                    }


                    echo "Cập nhật thành công";



                    date_default_timezone_set("Asia/Ho_Chi_Minh"); 

                        $filename = "action_logs.txt";

                        $text = date('d/m/Y H:i:s')."|".$_SESSION['user_logined']."|"."edit"."|".$_POST['yes']."|import_stock|".implode("-",$data)."\n"."\r\n";

                        

                        $fh = fopen($filename, "a") or die("Could not open log file.");

                        fwrite($fh, $text) or die("Could not write file!");

                        fclose($fh);
                    

                

                

            }

            else{



                    $import_model->createStock($data);

                    $id_import = $import_model->getLastStock()->import_stock_id;

                    /*Log*/

                    /**/
                    if ($data['invoice_customer'] > 0) {

                        $data_debit = array(

                                'debit_date'=>$data['import_stock_date'],

                                'customer'=>$data['invoice_customer'],

                                'money'=>0,

                                'money_vat'=>1,

                                'comment'=>'Mua hàng HD số '.$data['invoice_number'],

                                'check_debit'=>2,

                                'import_stock'=>$id_import,

                            );

                            $debit->createDebit($data_debit);



                            $data_vat = array(

                                'in_out'=>1,

                                'vat_number'=>$data['invoice_number'],

                                'vat_date'=>$data['invoice_date'],

                                'import_stock'=>$id_import,

                            );

                            $vat->createVAT($data_vat);

                    }

                    $vat_sum = 0;
                    $vat_price = 0;

                    foreach ($import_stock_cost_list as $v) {



                        $data_cost = array(



                            'import_stock' => $id_import,



                            'cost' => trim(str_replace(',','',$v['cost'])),



                            'cost_list' => $v['cost_list'],



                            'check_vat' => $v['check_vat'],



                            'comment' => trim($v['comment']),



                            'receiver' => isset($v['receiver'])?$v['receiver']:null,



                            'cost_document' => trim($v['cost_document']),



                            'cost_document_date' => trim(strtotime($v['cost_document_date'])),



                        );





                        if ($v['import_stock_cost_id'] == "") {



                            if ($data_cost['receiver'] > 0) {



                                $import_stock_cost_model->createStock($data_cost);

                                $id_stock_cost = $import_stock_cost_model->getLastStock()->import_stock_cost_id;



                                if ($data_cost['check_vat'] == 1) {

                                    $data_debit = array(

                                        'debit_date'=>$data['import_stock_date'],

                                        'customer'=>$data_cost['receiver'],

                                        'money'=>round($data_cost['cost']/1.1),

                                        'money_vat_price'=>$data_cost['cost']-round($data_cost['cost']/1.1),

                                        'money_vat'=>$data_cost['check_vat'],

                                        'comment'=>$data_cost['comment'].' ('.$data_cost['cost_document'].')',

                                        'check_debit'=>2,

                                        'import_stock_cost'=>$id_stock_cost,

                                    );

                                    $debit->createDebit($data_debit);



                                    $data_vat = array(

                                        'in_out'=>1,

                                        'vat_number'=>$data_cost['cost_document'],

                                        'vat_date'=>$data_cost['cost_document_date'],

                                        'import_stock_cost'=>$id_stock_cost,

                                    );

                                    $vat->createVAT($data_vat);

                                }

                                else{

                                    $data_debit = array(

                                        'debit_date'=>$data['import_stock_date'],

                                        'customer'=>$data_cost['receiver'],

                                        'money'=>$data_cost['cost'],

                                        'money_vat_price'=>0,

                                        'money_vat'=>$data_cost['check_vat'],

                                        'comment'=>$data_cost['comment'].' ('.$data_cost['cost_document'].')',

                                        'check_debit'=>2,

                                        'import_stock_cost'=>$id_stock_cost,

                                    );

                                    $debit->createDebit($data_debit);

                                }

                                



                                $vat_sum = round($data_cost['cost']/1.1);
                                $vat_price = $data_cost['cost']-round($data_cost['cost']/1.1);

                                $vat->updateVAT(array('vat_sum'=>$vat_sum,'vat_price'=>$vat_price),array('import_stock_cost' => $id_stock_cost));



                            }

                            



                        }



                        else if ($v['import_stock_cost_id'] > 0) {

                            $check = $import_stock_cost_model->getStock($v['import_stock_cost_id']);



                            $import_stock_cost_model->updateStock($data_cost,array('import_stock_cost_id'=>$v['import_stock_cost_id']));



                            if ($data_cost['check_vat'] == 1) {

                                $data_debit = array(

                                    'debit_date'=>$data['import_stock_date'],

                                    'customer'=>$data_cost['receiver'],

                                    'money'=>round($data_cost['cost']/1.1),

                                    'money_vat_price'=>$data_cost['cost']-round($data_cost['cost']/1.1),

                                    'money_vat'=>$data_cost['check_vat'],

                                    'comment'=>$data_cost['comment'].' ('.$data_cost['cost_document'].')',

                                    'check_debit'=>2,

                                    'import_stock_cost'=>$v['import_stock_cost_id'],

                                );

                                $debit->updateDebit($data_debit,array('import_stock_cost'=>$v['import_stock_cost_id']));

                            }

                            else{

                                $data_debit = array(

                                    'debit_date'=>$data['import_stock_date'],

                                    'customer'=>$data_cost['receiver'],

                                    'money'=>$data_cost['cost'],

                                    'money_vat_price'=>0,

                                    'money_vat'=>$data_cost['check_vat'],

                                    'comment'=>$data_cost['comment'].' ('.$data_cost['cost_document'].')',

                                    'check_debit'=>2,

                                    'import_stock_cost'=>$v['import_stock_cost_id'],

                                );

                                $debit->updateDebit($data_debit,array('import_stock_cost'=>$v['import_stock_cost_id']));

                            }



                            if ($check->check_vat == 1 && $data_cost['check_vat'] == 1) {

                                 $data_vat = array(

                                    'in_out'=>1,

                                    'vat_number'=>$data_cost['cost_document'],

                                    'vat_date'=>$data_cost['cost_document_date'],

                                    'import_stock_cost'=>$v['import_stock_cost_id'],

                                );

                                $vat->updateVAT($data_vat,array('import_stock_cost'=>$v['import_stock_cost_id']));

                            }

                            else if ($check->check_vat == 1 && $data_cost['check_vat'] != 1) {

                                $vat->queryVAT('DELETE FROM vat WHERE import_stock_cost = '.$v['import_stock_cost_id']);

                            }

                            else if ($check->check_vat != 1 && $data_cost['check_vat'] == 1) {

                                 $data_vat = array(

                                    'in_out'=>1,

                                    'vat_number'=>$data_cost['cost_document'],

                                    'vat_date'=>$data_cost['cost_document_date'],

                                    'import_stock_cost'=>$v['import_stock_cost_id'],

                                );

                                $vat->createVAT($data_vat);

                            }


                            $vat_sum = round($data_cost['cost']/1.1);
                            $vat_price = $data_cost['cost']-round($data_cost['cost']/1.1);

                            $vat->updateVAT(array('vat_sum'=>$vat_sum,'vat_price'=>$vat_price),array('import_stock_cost' => $v['import_stock_cost_id']));
                           



                        }



                    }



                    echo "Thêm thành công";



                    date_default_timezone_set("Asia/Ho_Chi_Minh"); 

                        $filename = "action_logs.txt";

                        $text = date('d/m/Y H:i:s')."|".$_SESSION['user_logined']."|"."add"."|".$import_model->getLastStock()->import_stock_id."|import_stock|".implode("-",$data)."\n"."\r\n";

                        

                        $fh = fopen($filename, "a") or die("Could not open log file.");

                        fwrite($fh, $text) or die("Could not write file!");

                        fclose($fh);

                    

                

                

            }



            $total_number = 0;

            $total_price = 0;

            $total_vat_price = 0;



            $spare_part = $_POST['spare_part'];



            foreach ($spare_part as $v) {




                    if (isset($v['spare_part_id']) && $v['spare_part_id'] > 0) {



                        $id_spare_part = $v['spare_part_id'];



                    }



                    else{



                        $data_spare_part = array(


                            'spare_part_name' => trim($v['spare_part_name']),


                        );



                        $spare_model->createStock($data_spare_part);

                        $id_spare_part = $spare_model->getLastStock()->spare_part_id;

                    }



                    $data_stock = array(



                        'import_stock' => $id_import,



                        'spare_part' => $id_spare_part,



                        'spare_stock_number' => $v['spare_stock_number'],



                        'spare_stock_price' => trim(str_replace(',','',$v['spare_stock_price'])),

                        'spare_stock_total' => trim(str_replace(',','',$v['spare_stock_total'])),

                        'spare_stock_unit' => $v['spare_stock_unit'],

                        

                    );



                    if (!$stock_model->getStockByWhere(array('import_stock'=>$id_import,'spare_part'=>$id_spare_part))) {

                        $stock_model->createStock($data_stock);

                    }

                    else{

                        $id_stock = $stock_model->getStockByWhere(array('import_stock'=>$id_import,'spare_part'=>$id_spare_part))->spare_stock_id;

                        $stock_model->updateStock($data_stock,array('spare_stock_id'=>$id_stock));

                    }



                    $total_number += $data_stock['spare_stock_number'];

                    $total_price += $data_stock['spare_stock_price']*$data_stock['spare_stock_number'];

                }



                $import_model->updateStock(array('import_stock_total'=>$total_number,'import_stock_price'=>$total_price),array('import_stock_id'=>$id_import));

                $data_vat = array(

                    'vat_sum'=>$total_price,

                    'vat_price'=>$total_vat_price,

                );

                $vat->updateVAT($data_vat,array('import_stock'=>$id_import));

                $data_debit = array(

                    'money'=>$total_price,

                    'money_vat_price'=>$total_vat_price,

                );

                $debit->updateDebit($data_debit,array('import_stock'=>$id_import));

                    

        }

    }

    public function delete(){

        if (!isset($_SESSION['userid_logined'])) {

            return $this->view->redirect('user/login');

        }

        if ($_SESSION['role_logined'] != 1 && $_SESSION['role_logined'] != 2 && $_SESSION['role_logined'] != 6 && $_SESSION['role_logined'] != 8) {

            return $this->view->redirect('user/login');

        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $import_model = $this->model->get('importstockModel');

            $stock_model = $this->model->get('sparestockModel');

            $debit = $this->model->get('debitModel');

            $vat = $this->model->get('vatModel');

            $import_stock_cost_model = $this->model->get('importstockcostModel');


            if (isset($_POST['xoa'])) {

                $data = explode(',', $_POST['xoa']);

                foreach ($data as $data) {

                    $costs = $import_stock_cost_model->getAllStock(array('where'=>'import_stock = '.$data));

                    foreach ($costs as $cost) {

                        $debit->queryDebit('DELETE FROM debit WHERE import_stock_cost = '.$cost->import_stock_cost_id);

                        $vat->queryVAT('DELETE FROM vat WHERE import_stock_cost = '.$cost->import_stock_cost_id);

                        $import_stock_cost_model->deleteStock($cost->import_stock_cost_id);

                    }



                    $stock_model->query('DELETE FROM spare_stock WHERE import_stock = '.$data);

                    $debit->queryDebit('DELETE FROM debit WHERE import_stock = '.$data);

                    $vat->queryVAT('DELETE FROM vat WHERE import_stock = '.$data);


                    $import_model->deleteStock($data);

                    

                    

                    date_default_timezone_set("Asia/Ho_Chi_Minh"); 

                        $filename = "action_logs.txt";

                        $text = date('d/m/Y H:i:s')."|".$_SESSION['user_logined']."|"."delete"."|".$data."|import_stock|"."\n"."\r\n";

                        

                        $fh = fopen($filename, "a") or die("Could not open log file.");

                        fwrite($fh, $text) or die("Could not write file!");

                        fclose($fh);

                }



                /*Log*/

                    /**/



                return true;

            }

            else{

                $costs = $import_stock_cost_model->getAllStock(array('where'=>'import_stock = '.$_POST['data']));

                foreach ($costs as $cost) {

                    $debit->queryDebit('DELETE FROM debit WHERE import_stock_cost = '.$cost->import_stock_cost_id);

                    $vat->queryVAT('DELETE FROM vat WHERE import_stock_cost = '.$cost->import_stock_cost_id);

                    $import_stock_cost_model->deleteStock($cost->import_stock_cost_id);

                }



                $stock_model->query('DELETE FROM spare_stock WHERE import_stock = '.$_POST['data']);

                $debit->queryDebit('DELETE FROM debit WHERE import_stock = '.$_POST['data']);

                $vat->queryVAT('DELETE FROM vat WHERE import_stock = '.$_POST['data']);


                /*Log*/

                    /**/

                    date_default_timezone_set("Asia/Ho_Chi_Minh"); 

                        $filename = "action_logs.txt";

                        $text = date('d/m/Y H:i:s')."|".$_SESSION['user_logined']."|"."delete"."|".$_POST['data']."|import_stock|"."\n"."\r\n";

                        

                        $fh = fopen($filename, "a") or die("Could not open log file.");

                        fwrite($fh, $text) or die("Could not write file!");

                        fclose($fh);



                return $import_model->deleteStock($_POST['data']);

            }

            

        }

    }



    public function getSpare(){



        if (!isset($_SESSION['userid_logined'])) {



            return $this->view->redirect('user/login');



        }



        if ($_SERVER['REQUEST_METHOD'] == 'POST') {




            $spare_model = $this->model->get('sparepartModel');

            $spare_stock_model = $this->model->get('sparestockModel');



            if ($_POST['keyword'] == "*") {




                $list = $spare_model->getAllStock();



            }



            else{



                $data = array(



                'where'=>'( spare_part_name LIKE "%'.$_POST['keyword'].'%" )',



                );



                $list = $spare_model->getAllStock($data);




            }



            



            foreach ($list as $rs) {



                // put in bold the written text

                



                $spare_name = $rs->spare_part_name;



                if ($_POST['keyword'] != "*") {



                    $spare_name = str_replace($_POST['keyword'], '<b>'.$_POST['keyword'].'</b>', $rs->spare_part_name);



                }





                $stocks = $spare_stock_model->queryStock('SELECT * FROM spare_stock WHERE spare_part = '.$rs->spare_part_id.' AND import_stock > 0 ORDER BY spare_stock_id DESC LIMIT 1');

                if ($stocks) {

                    foreach ($stocks as $stock) {

                        echo '<li onclick="set_item_other(\''.$rs->spare_part_id.'\',\''.$rs->spare_part_name.'\',\''.$_POST['offset'].'\',\''.$stock->spare_stock_unit.'\',\''.$stock->spare_stock_price.'\')">'.$spare_name.'</li>';

                    }

                    

                }

                else{

                    echo '<li onclick="set_item_other(\''.$rs->spare_part_id.'\',\''.$rs->spare_part_name.'\',\''.$_POST['offset'].'\',\'\',\'\')">'.$spare_name.'</li>';

                    

                }



                



            }



        }



    }

    public function deletespare(){



        if (isset($_POST['import_stock'])) {



            $spare_model = $this->model->get('sparestockModel');







            $spare_model->queryStock('DELETE FROM spare_stock WHERE import_stock = '.$_POST['import_stock'].' AND spare_part = '.$_POST['spare_part']);



            echo 'Đã xóa thành công';



        }



    }


    public function spare(){



        if(isset($_POST['import_stock'])){



            



            $spare_model = $this->model->get('sparestockModel');



            $join = array('table'=>'spare_part','where'=>'spare_part_id = spare_part');

            $data = array(



                'where' => 'import_stock = '.$_POST['import_stock'],



            );



            $codes = $spare_model->getAllStock($data,$join);





            $str = "";



            if (!$codes) {



                $str .= '<tr class="'.$_POST['import_stock'].'">';



                $str .= '<td><input type="checkbox"  name="chk"></td>';



                $str .= '<td><table style="width: 100%">';



                $str .= '<tr class="'.$_POST['import_stock'] .'">';



                $str .= '<td>Tên sản phẩm <br> <input type="text" autocomplete="off" class="spare_part" name="spare_part[]" placeholder="Nhập tên hoặc * để chọn" > <ul class="name_list_id"></ul></td>';



                $str .= '<td>Số lượng <br> <input style="width:100px" type="text" class="spare_stock_number number" name="spare_stock_number[]" ></td>';

                $str .= '<td>ĐVT <br> <input style="width:100px" type="text" class="spare_stock_unit" name="spare_stock_unit[]" ></td>';

                $str .= '<td>Đơn giá <br> <input style="width:100px" type="text" class="spare_stock_price number" name="spare_stock_price[]"></td></tr>';

                $str .= '<td>Thành tiền <br> <input style="width:100px" type="text" class="spare_stock_total number" name="spare_stock_total[]"></td></tr>';

                $str .= '</table></td></tr>';



            }



            else{

                foreach ($codes as $code) {

                    $str .= '<tr class="'.$_POST['import_stock'].'">';



                    $str .= '<td><input type="checkbox"  name="chk" alt="'.$code->spare_part_id.'"  data="'.$_POST['import_stock'].'" ></td>';



                    $str .= '<td><table style="width: 100%">';



                    $str .= '<tr class="'.$_POST['import_stock'] .'">';



                    $str .= '<td>Tên sản phẩm <br> <input type="text" autocomplete="off" class="spare_part" name="spare_part[]" placeholder="Nhập tên hoặc * để chọn" value="'.$code->spare_part_name.'" data="'.$code->spare_part_id.'" > <ul class="name_list_id"></ul></td>';



                    $str .= '<td>Số lượng <br> <input style="width:100px" type="text" class="spare_stock_number number" name="spare_stock_number[]" value="'.$code->spare_stock_number.'" ></td>';


                    $str .= '<td>ĐVT <br> <input style="width:100px" type="text" class="spare_stock_unit" name="spare_stock_unit[]" value="'.$code->spare_stock_unit.'" ></td>';



                    $str .= '<td>Đơn giá <br> <input style="width:100px" type="text" class="spare_stock_price number" name="spare_stock_price[]" value="'.$code->spare_stock_price.'"></td></tr>';

                    $str .= '<td>Thành tiền <br> <input style="width:100px" type="text" class="spare_stock_total number" name="spare_stock_total[]" value="'.$code->spare_stock_total.'"></td></tr>';


                    $str .= '</table></td></tr>';

                    
                }

            }







            echo $str;



        }



    }


    public function deletecost(){



        if (isset($_POST['import_stock_cost_id'])) {



            $import_stock_cost_model = $this->model->get('importstockcostModel');

            $debit = $this->model->get('debitModel');

            $vat = $this->model->get('vatModel');



            $debit->queryDebit('DELETE FROM debit WHERE import_stock_cost = '.$_POST['import_stock_cost_id']);
            $vat->queryVAT('DELETE FROM vat WHERE import_stock_cost = '.$_POST['import_stock_cost_id']);

            $import_stock_cost_model->queryStock('DELETE FROM import_stock_cost WHERE import_stock_cost_id = '.$_POST['import_stock_cost_id']);



            echo 'Đã xóa thành công';



        }



    }

    public function getcost(){



        if(isset($_POST['import_stock'])){



            



            $import_stock_cost_model = $this->model->get('importstockcostModel');

            $cost_list_model = $this->model->get('costlistModel');



            $cost_lists = $cost_list_model->getAllCost();





            $join = array('table'=>'customer, cost_list','where'=>'receiver = customer_id AND cost_list = cost_list_id');



            $data = array(



                'where' => 'import_stock = '.$_POST['import_stock'],



            );



            $costs = $import_stock_cost_model->getAllStock($data,$join);







            $str = "";



            if (!$costs) {



                $cost_data = "";

                foreach ($cost_lists as $cost) {

                    $cost_data .= '<option value="'.$cost->cost_list_id.'">'.$cost->cost_list_name.'</option>';

                }



                $str .= '<tr class="'.$_POST['import_stock'].'">';



                $str .= '<td><input type="checkbox"  name="chk2" data=""></td>';



                $str .= '<td><table style="width: 100%">';



                $str .= '<tr class="'.$_POST['import_stock'] .'">';



                $str .= '<td>Chi phí <a target="_blank" title="Thêm chi phí" href="'.BASE_URL.'/costlist"><i class="fa fa-plus"></i></a></td>';



                $str .= '<td><select style="width:150px" name="cost_list[]" class="cost_list" >';



                    $str .= $cost_data;



                $str .= '</select></td>';



                $str .= '<td>Số tiền</td>';



                $str .= '<td><input style="width:120px" type="text" class="cost number" name="cost[]"><input type="checkbox" class="check_vat" name="check_vat[]" value="1"> VAT</td></tr>';



                $str .= '<tr><td>Nội dung</td>';



                $str .= '<td><textarea class="comment" name="comment[]"></textarea></td>';



                $str .= '<td>Người nhận <a target="_blank" title="Thêm người nhận" href="'.BASE_URL.'/customer/newcus"><i class="fa fa-plus"></i></a></td>';



                $str .= '<td><input type="text" autocomplete="off" class="receiver" name="receiver[]" placeholder="Nhập tên hoặc * để chọn" >';

                $str .= '<ul class="name_list_id_3"></ul></td></tr>';



                $str .= '<tr><td>Số Hóa đơn chứng từ</td>';



                $str .= '<td><input type="text" class="cost_document" name="cost_document[]" style="width:100px" > Ngày <input type="text" class="cost_document_date ngay" name="cost_document_date[]" style="width:60px"></td>';



                $str .= '</tr></table></td></tr>';



            }



            else{



                foreach ($costs as $v) {



                    $cost_data = "";

                    foreach ($cost_lists as $cost) {

                        $cost_data .= '<option '.($v->cost_list==$cost->cost_list_id?'selected="selected"':null).' value="'.$cost->cost_list_id.'">'.$cost->cost_list_name.'</option>';

                    }



                    $checked = $v->check_vat==1?'checked="checked"':null;



                    $str .= '<tr class="'.$_POST['import_stock'].'">';



                    $str .= '<td><input type="checkbox" name="chk2" data="'.$v->import_stock_cost_id.'"  ></td>';



                    $str .= '<td><table style="width: 100%">';



                    $str .= '<tr class="'.$_POST['import_stock'] .'">';



                    $str .= '<td>Chi phí <a target="_blank" title="Thêm chi phí" href="'.BASE_URL.'/costlist"><i class="fa fa-plus"></i></a></td>';



                    $str .= '<td><select style="width:150px" name="cost_list[]" class="cost_list" >';



                        $str .= $cost_data;



                    $str .= '</select></td>';



                    $str .= '<td>Số tiền</td>';



                    $str .= '<td><input style="width:120px" type="text" class="cost number" name="cost[]" value="'.$this->lib->formatMoney($v->cost).'" ><input '.$checked.' type="checkbox" class="check_vat" name="check_vat[]" value="1"> VAT</td></tr>';



                    $str .= '<tr><td>Nội dung</td>';



                    $str .= '<td><textarea class="comment" name="comment[]">'.$v->comment.'</textarea></td>';



                    $str .= '<td>Người nhận <a target="_blank" title="Thêm người nhận" href="'.BASE_URL.'/customer/newcus"><i class="fa fa-plus"></i></a></td>';



                    $str .= '<td><input type="text" autocomplete="off" class="receiver" name="receiver[]" placeholder="Nhập tên hoặc * để chọn" value="'.$v->customer_name.'" data="'.$v->customer_id.'" >';

                    $str .= '<ul class="name_list_id_3"></ul></td></tr>';



                    $str .= '<tr><td>Số Hóa đơn chứng từ</td>';



                    $str .= '<td><input type="text" class="cost_document" name="cost_document[]" style="width:100px" value="'.$v->cost_document.'" > Ngày <input type="text" class="cost_document_date ngay" name="cost_document_date[]" style="width:60px" value="'.($v->cost_document_date>0?date('d-m-Y',$v->cost_document_date):null).'"></td>';



                    $str .= '</tr></table></td></tr>';



                }



            }







            echo $str;



        }



    }


}

?>