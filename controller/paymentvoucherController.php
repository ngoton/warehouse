<?php



Class paymentvoucherController Extends baseController {



    public function index() {



        $this->view->setLayout('admin');



        if (!isset($_SESSION['userid_logined'])) {



            return $this->view->redirect('user/login');



        }



        if ($_SESSION['role_logined'] != 1 && $_SESSION['role_logined'] != 2 && $_SESSION['role_logined'] != 3) {

            $this->view->data['disable_control'] = 1;

        }



        $this->view->data['lib'] = $this->lib;



        $this->view->data['title'] = 'Báo cáo chi tiền mặt - tiền gửi ngân hàng';







        if ($_SERVER['REQUEST_METHOD'] == 'POST') {



            $order_by = isset($_POST['order_by']) ? $_POST['order_by'] : null;



            $order = isset($_POST['order']) ? $_POST['order'] : null;



            $page = isset($_POST['page']) ? $_POST['page'] : null;



            $keyword = isset($_POST['keyword']) ? $_POST['keyword'] : null;



            $limit = isset($_POST['limit']) ? $_POST['limit'] : 18446744073709;



            $batdau = isset($_POST['batdau']) ? $_POST['batdau'] : null;



            $ketthuc = isset($_POST['ketthuc']) ? $_POST['ketthuc'] : null;


            $kh = isset($_POST['trangthai']) ? $_POST['trangthai'] : null;



            $vong = isset($_POST['vong']) ? $_POST['vong'] : null;



            $trangthai = isset($_POST['staff']) ? $_POST['staff'] : null;



            



        }



        else{



            $order_by = $this->registry->router->order_by ? $this->registry->router->order_by : 'payment_voucher_date';



            $order = $this->registry->router->order_by ? $this->registry->router->order_by : 'ASC';



            $page = $this->registry->router->page ? (int) $this->registry->router->page : 1;



            $keyword = "";



            $limit = 50;



            $batdau = '01-'.date('m-Y');



            $ketthuc = date('t-m-Y');



            $kh = 0;



            $vong = (int)date('m',strtotime($batdau));



            $trangthai = date('Y',strtotime($batdau));



            



        }


        $id = $this->registry->router->param_id;


        $ngayketthuc = date('d-m-Y', strtotime($ketthuc. ' + 1 days'));



        $vong = (int)date('m',strtotime($batdau));



        $trangthai = date('Y',strtotime($batdau));


        $bank_model = $this->model->get('bankModel');

        $banks = $bank_model->getAllBank();

        $this->view->data['banks'] = $banks;



        $customer_model = $this->model->get('customerModel');


        $customers = $customer_model->getAllCustomer();


        $this->view->data['customers'] = $customers;

        $customer_data = array();


        foreach ($customers as $customer) {


                $customer_data[$customer->customer_id]['id'] = $customer->customer_id;



                $customer_data[$customer->customer_id]['name'] = $customer->customer_name;

        }



        $this->view->data['data_customer'] = $customer_data;



        $join = array('table'=>'bank','where'=>'bank_out = bank_id');



        $payment_model = $this->model->get('paymentvoucherModel');



        $sonews = $limit;



        $x = ($page-1) * $sonews;



        $pagination_stages = 2;







        $data = array(



            'where' => "1=1",



            );



        if($batdau != "" && $ketthuc != "" ){



            $data['where'] = $data['where'].' AND payment_voucher_date >= '.strtotime($batdau).' AND payment_voucher_date < '.strtotime($ngayketthuc);



        }

        if (isset($id) && $id > 0) {
            $data['where'] = 'payment_voucher_id = '.$id;
        }

        if($kh > 0){



            $data['where'] = $data['where'].' AND customer = '.$kh;



        }







        $tongsodong = count($payment_model->getAllPayment($data,$join));



        $tongsotrang = ceil($tongsodong / $sonews);



        







        $this->view->data['page'] = $page;



        $this->view->data['order_by'] = $order_by;



        $this->view->data['order'] = $order;



        $this->view->data['keyword'] = $keyword;



        $this->view->data['pagination_stages'] = $pagination_stages;



        $this->view->data['tongsotrang'] = $tongsotrang;



        $this->view->data['sonews'] = $sonews;







        $this->view->data['batdau'] = $batdau;



        $this->view->data['ketthuc'] = $ketthuc;



        $this->view->data['vong'] = $vong;



        $this->view->data['trangthai'] = $trangthai;


        $this->view->data['kh'] = $kh;




        $this->view->data['limit'] = $limit;











        $data = array(



            'order_by'=>$order_by,



            'order'=>$order,



            'limit'=>$x.','.$sonews,



            'where' => "1=1",



            );



        if($batdau != "" && $ketthuc != "" ){



            $data['where'] = $data['where'].' AND payment_voucher_date >= '.strtotime($batdau).' AND payment_voucher_date < '.strtotime($ngayketthuc);



        }


        if (isset($id) && $id > 0) {
            $data['where'] = 'payment_voucher_id = '.$id;
        }

        if($kh > 0){



            $data['where'] = $data['where'].' AND customer = '.$kh;



        }



        





        if ($keyword != '') {



            $ngay = (strtotime(str_replace("/", "-", $keyword))!="")?(' OR payment_voucher_date LIKE "%'.strtotime(str_replace("/", "-", $keyword)).'%"'):"";



            $search = '(



                    payment_voucher_number LIKE "%'.$keyword.'%"



                    OR customer IN (SELECT customer_id FROM customer WHERE customer_name LIKE "%'.$keyword.'%") 

                    '.$ngay.'



                        )';



            $data['where'] = $data['where']." AND ".$search;



        }







        $payments = $payment_model->getAllPayment($data,$join);



        

        $this->view->data['payments'] = $payments;





        $this->view->data['lastID'] = isset($payment_model->getLastPayment()->payment_voucher_id)?$payment_model->getLastPayment()->payment_voucher_id:0;





        $this->view->show('paymentvoucher/index');



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

    public function getDebit(){



        if (!isset($_SESSION['userid_logined'])) {



            return $this->view->redirect('user/login');



        }



        if ($_SERVER['REQUEST_METHOD'] == 'POST') {



            $debit_model = $this->model->get('debitModel');

            $debit_pay_model = $this->model->get('debitpayModel');


            $join = array('table'=>'customer','where'=>'customer = customer_id');

            $data = array(
                'where' => 'check_debit = 2 AND customer = '.$_POST['customer'],
            );

            if ($_POST['keyword'] == "*") {
                $list = $debit_model->getAllDebit($data,$join);
            }


            else{


                $data['where'] .= ' AND ( comment LIKE "%'.$_POST['keyword'].'%" )';



                $list = $debit_model->getAllDebit($data,$join);



            }



            foreach ($list as $rs) {
                $pay_money = 0;

                $pays = $debit_pay_model->getAllDebit(array('where'=>'debit = '.$rs->debit_id));

                foreach ($pays as $pay) {
                    $pay_money += $pay->debit_pay_money;
                }

                if (($rs->money + $rs->money_vat_price) > $pay_money) {
                    $debit_comment = '['.$this->lib->hien_thi_ngay_thang($rs->debit_date).'] '.$rs->comment;
                    if ($_POST['keyword'] != "*") {
                        $debit_comment = str_replace($_POST['keyword'], '<b>'.$_POST['keyword'].'</b>', '['.$this->lib->hien_thi_ngay_thang($rs->debit_date).'] '.$rs->comment);

                    }

                    // add new option
                    echo '<li onclick="set_item_debit(\''.$rs->debit_id.'\',\''.$rs->comment.'\',\''.date('d-m-Y',$rs->debit_date).'\',\''.($rs->money + $rs->money_vat_price).'\',\''.(($rs->money + $rs->money_vat_price) - $pay_money).'\',\''.$_POST['offset'].'\')">'.$debit_comment.'</li>';
                }

                // put in bold the written text

                

            }

            



        }



    }

    

    public function add(){

        if (!isset($_SESSION['userid_logined'])) {

            return $this->view->redirect('user/login');

        }

        if ($_SESSION['role_logined'] != 1 && $_SESSION['role_logined'] != 2 && $_SESSION['role_logined'] != 3) {

            return $this->view->redirect('user/login');

        }

        if (isset($_POST['yes'])) {

            $payment_model = $this->model->get('paymentvoucherModel');

            $bank_balance_model = $this->model->get('bankbalanceModel');
            $debit_pay_model = $this->model->get('debitpayModel');

            /**************/



            $debit_list = $_POST['debit_pay'];



            /**************/



            $data = array(

                        'payment_voucher_number' => trim($_POST['payment_voucher_number']),

                        'payment_voucher_date' => strtotime($_POST['payment_voucher_date']),

                        'payment_voucher_comment' => trim($_POST['payment_voucher_comment']),

                        'payment_voucher_money' => trim(str_replace(',','',$_POST['payment_voucher_money'])),

                        'payment_voucher_attach' => trim($_POST['payment_voucher_attach']),

                        'bank_out' => trim($_POST['bank_out']),

                        'customer' => trim($_POST['customer']),

                        );




            if ($_POST['yes'] != "") {

                if ($payment_model->checkPayment($_POST['yes'].' AND payment_voucher_number = "'.trim($_POST['payment_voucher_number']).'"')) {

                    echo "Thông tin này đã tồn tại";

                    return false;

                }

                else{

                    $payment_model->updatePayment($data,array('payment_voucher_id' => $_POST['yes']));

                    $id_payment = $_POST['yes'];

                    /*Log*/

                    /**/
                    if (!$bank_balance_model->getBankByWhere(array('payment_voucher'=>$id_payment))) {
                        $data_bank = array(
                            'bank_balance_date' => $data['payment_voucher_date'],
                            'bank' => $data['bank_out'],
                            'bank_balance_money' => (0-$data['payment_voucher_money']),
                            'payment_voucher' => $id_payment,
                        );

                        $bank_balance_model->createBank($data_bank);
                    }
                    else{
                        $data_bank = array(
                            'bank_balance_date' => $data['payment_voucher_date'],
                            'bank' => $data['bank_out'],
                            'bank_balance_money' => (0-$data['payment_voucher_money']),
                            'payment_voucher' => $id_payment,
                        );

                        $bank_balance_model->updateBank($data_bank,array('payment_voucher'=>$id_payment));
                    }

                    

                    echo "Cập nhật thành công";



                    date_default_timezone_set("Asia/Ho_Chi_Minh"); 

                        $filename = "action_logs.txt";

                        $text = date('d/m/Y H:i:s')."|".$_SESSION['user_logined']."|"."edit"."|".$_POST['yes']."|payment_voucher|".implode("-",$data)."\n"."\r\n";

                        

                        $fh = fopen($filename, "a") or die("Could not open log file.");

                        fwrite($fh, $text) or die("Could not write file!");

                        fclose($fh);

                    }

                

                

            }

            else{



                if ($payment_model->getPaymentByWhere(array('payment_voucher_number'=>$data['payment_voucher_number']))) {

                    echo "Thông tin này đã tồn tại";

                    return false;

                }

                else{

                    $payment_model->createPayment($data);

                    $id_payment = $payment_model->getLastPayment()->payment_voucher_id;

                    /*Log*/

                    /**/
                    $data_bank = array(
                        'bank_balance_date' => $data['payment_voucher_date'],
                        'bank' => $data['bank_out'],
                        'bank_balance_money' => (0-$data['payment_voucher_money']),
                        'payment_voucher' => $id_payment,
                    );

                    $bank_balance_model->createBank($data_bank);



                    echo "Thêm thành công";



                    date_default_timezone_set("Asia/Ho_Chi_Minh"); 

                        $filename = "action_logs.txt";

                        $text = date('d/m/Y H:i:s')."|".$_SESSION['user_logined']."|"."add"."|".$payment_model->getLastPayment()->payment_voucher_id."|payment_voucher|".implode("-",$data)."\n"."\r\n";

                        

                        $fh = fopen($filename, "a") or die("Could not open log file.");

                        fwrite($fh, $text) or die("Could not write file!");

                        fclose($fh);

                    }

                

                

            }





            foreach ($debit_list as $v) {



                if (isset($v['debit_pay_id']) && $v['debit_pay_id'] > 0) {



                    $data_debit = array(

                        'payment_voucher'=>$id_payment,

                        'debit'=>trim($v['debit_id']),

                        'debit_pay_date'=>$data['payment_voucher_date'],

                        'debit_pay_money'=>trim(str_replace(',','',$v['debit_pay_money'])),

                    );



                    $debit_pay_model->updateDebit($data_debit,array('debit_pay_id'=>$v['debit_pay_id']));



                }

                else{

                    $data_debit = array(

                        'payment_voucher'=>$id_payment,

                        'debit'=>trim($v['debit_id']),

                        'debit_pay_date'=>$data['payment_voucher_date'],

                        'debit_pay_money'=>trim(str_replace(',','',$v['debit_pay_money'])),

                    );

                    $debit_pay_model->createDebit($data_debit);

                }



                    

            }



                    

        }

    }

    public function add2(){

        if (!isset($_SESSION['userid_logined'])) {

            return $this->view->redirect('user/login');

        }

        if ($_SESSION['role_logined'] != 1 && $_SESSION['role_logined'] != 2 && $_SESSION['role_logined'] != 3) {

            return $this->view->redirect('user/login');

        }

        if (isset($_POST['yes'])) {

            $payment_model = $this->model->get('paymentvoucherModel');

            $bank_balance_model = $this->model->get('bankbalanceModel');

            /**************/

            /**************/



            $data = array(

                        'payment_voucher_number' => trim($_POST['payment_voucher_number']),

                        'payment_voucher_date' => strtotime($_POST['payment_voucher_date']),

                        'payment_voucher_comment' => trim($_POST['payment_voucher_comment']),

                        'payment_voucher_money' => trim(str_replace(',','',$_POST['payment_voucher_money'])),

                        'payment_voucher_attach' => trim($_POST['payment_voucher_attach']),

                        'bank_out' => trim($_POST['bank_out']),

                        'payment_voucher_type' => 2,

                        );




            if ($_POST['yes'] != "") {

                if ($payment_model->checkPayment($_POST['yes'].' AND payment_voucher_number = "'.trim($_POST['payment_voucher_number']).'"')) {

                    echo "Thông tin này đã tồn tại";

                    return false;

                }

                else{

                    $payment_model->updatePayment($data,array('payment_voucher_id' => $_POST['yes']));

                    $id_payment = $_POST['yes'];

                    /*Log*/

                    /**/
                    if (!$bank_balance_model->getBankByWhere(array('payment_voucher'=>$id_payment))) {
                        $data_bank = array(
                            'bank_balance_date' => $data['payment_voucher_date'],
                            'bank' => $data['bank_out'],
                            'bank_balance_money' => (0-$data['payment_voucher_money']),
                            'payment_voucher' => $id_payment,
                        );

                        $bank_balance_model->createBank($data_bank);
                    }
                    else{
                        $data_bank = array(
                            'bank_balance_date' => $data['payment_voucher_date'],
                            'bank' => $data['bank_out'],
                            'bank_balance_money' => (0-$data['payment_voucher_money']),
                            'payment_voucher' => $id_payment,
                        );

                        $bank_balance_model->updateBank($data_bank,array('payment_voucher'=>$id_payment));
                    }

                    

                    echo "Cập nhật thành công";



                    date_default_timezone_set("Asia/Ho_Chi_Minh"); 

                        $filename = "action_logs.txt";

                        $text = date('d/m/Y H:i:s')."|".$_SESSION['user_logined']."|"."edit"."|".$_POST['yes']."|payment_voucher|".implode("-",$data)."\n"."\r\n";

                        

                        $fh = fopen($filename, "a") or die("Could not open log file.");

                        fwrite($fh, $text) or die("Could not write file!");

                        fclose($fh);

                    }

                

                

            }

            else{



                if ($payment_model->getPaymentByWhere(array('payment_voucher_number'=>$data['payment_voucher_number']))) {

                    echo "Thông tin này đã tồn tại";

                    return false;

                }

                else{

                    $payment_model->createPayment($data);

                    $id_payment = $payment_model->getLastPayment()->payment_voucher_id;

                    /*Log*/

                    /**/
                    $data_bank = array(
                        'bank_balance_date' => $data['payment_voucher_date'],
                        'bank' => $data['bank_out'],
                        'bank_balance_money' => (0-$data['payment_voucher_money']),
                        'payment_voucher' => $id_payment,
                    );

                    $bank_balance_model->createBank($data_bank);



                    echo "Thêm thành công";



                    date_default_timezone_set("Asia/Ho_Chi_Minh"); 

                        $filename = "action_logs.txt";

                        $text = date('d/m/Y H:i:s')."|".$_SESSION['user_logined']."|"."add"."|".$payment_model->getLastPayment()->payment_voucher_id."|payment_voucher|".implode("-",$data)."\n"."\r\n";

                        

                        $fh = fopen($filename, "a") or die("Could not open log file.");

                        fwrite($fh, $text) or die("Could not write file!");

                        fclose($fh);

                    }

                

                

            }



                    

        }

    }

    public function delete(){

        if (!isset($_SESSION['userid_logined'])) {

            return $this->view->redirect('user/login');

        }

        if ($_SESSION['role_logined'] != 1 && $_SESSION['role_logined'] != 2 && $_SESSION['role_logined'] != 3) {

            return $this->view->redirect('user/login');

        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $payment_model = $this->model->get('paymentvoucherModel');

            $debit_pay_model = $this->model->get('debitpayModel');

            $bank_balance_model = $this->model->get('bankbalanceModel');



            if (isset($_POST['xoa'])) {

                $data = explode(',', $_POST['xoa']);

                foreach ($data as $data) {



                    $debit_pay_model->queryDebit('DELETE FROM debit_pay WHERE payment_voucher = '.$data);

                    $bank_balance_model->queryBank('DELETE FROM bank_balance WHERE payment_voucher = '.$data);



                    $payment_model->deletePayment($data);

                    

                    

                    date_default_timezone_set("Asia/Ho_Chi_Minh"); 

                        $filename = "action_logs.txt";

                        $text = date('d/m/Y H:i:s')."|".$_SESSION['user_logined']."|"."delete"."|".$data."|payment_voucher|"."\n"."\r\n";

                        

                        $fh = fopen($filename, "a") or die("Could not open log file.");

                        fwrite($fh, $text) or die("Could not write file!");

                        fclose($fh);

                }



                /*Log*/

                    /**/



                return true;

            }

            else{



                $debit_pay_model->queryDebit('DELETE FROM debit_pay WHERE payment_voucher = '.$_POST['data']);

                $bank_balance_model->queryBank('DELETE FROM bank_balance WHERE payment_voucher = '.$_POST['data']);

                /*Log*/

                    /**/

                    date_default_timezone_set("Asia/Ho_Chi_Minh"); 

                        $filename = "action_logs.txt";

                        $text = date('d/m/Y H:i:s')."|".$_SESSION['user_logined']."|"."delete"."|".$_POST['data']."|payment_voucher|"."\n"."\r\n";

                        

                        $fh = fopen($filename, "a") or die("Could not open log file.");

                        fwrite($fh, $text) or die("Could not write file!");

                        fclose($fh);



                return $payment_model->deletePayment($_POST['data']);

            }

            

        }

    }



    public function getdebitadd(){



        if(isset($_POST['payment_voucher'])){



            



            $debit_pay_model = $this->model->get('debitpayModel');





            $join = array('table'=>'debit','where'=>'debit = debit_id');



            $data = array(



                'where' => 'payment_voucher = '.$_POST['payment_voucher'],



            );



            $debits = $debit_pay_model->getAllDebit($data,$join);







            $str = "";



            if (!$debits) {



                $str .= '<tr class="'.$_POST['payment_voucher'].'">';



                $str .= '<td><input type="checkbox"  name="chk" title="0" ></td>';



                $str .= '<td><table style="width: 100%">';



                $str .= '<tr class="'.$_POST['payment_voucher'] .'">';



                $str .= '<td>Công nợ <br><input type="text" class="comment" name="comment[]" placeholder="Nhập số hóa đơn,DO hoặc nội dung" autocomplete="off" ><ul class="name_list_id"></ul></td>';

                $str .= '<td>Ngày <br><input type="text" class="debit_date ngay" name="debit_date[]" style="width:80px" disabled ></td>';

                $str .= '<td>Số tiền phải chi <br><input type="text" class="money numbers" name="money[]" style="width:120px" disabled ></td>';

                $str .= '<td>Còn lại<br><input type="text" class="money_conlai numbers" name="money_conlai[]" style="width:120px" disabled ></td>';

                $str .= '<td>Số tiền <br><input type="text" class="debit_pay_money numbers" name="debit_pay_money[]" style="width:120px" ></td>';



                $str .= '</tr></table></td></tr>';



            }



            else{

                $i = 0;

                foreach ($debits as $v) {

                    $pay_money = 0;

                    $pays = $debit_pay_model->getAllDebit(array('where'=>'debit = '.$v->debit.' AND debit_pay_id != '.$v->debit_pay_id));

                    foreach ($pays as $pay) {
                        $pay_money += $pay->debit_pay_money;
                    }


                    $str .= '<tr class="'.$_POST['payment_voucher'].'">';



                    $str .= '<td><input type="checkbox" name="chk" data="'.$v->debit_pay_id.'"  alt="'.$v->payment_voucher.'" title="'.$i.'" ></td>';



                    $str .= '<td><table style="width: 100%">';



                    $str .= '<tr class="'.$_POST['payment_voucher'] .'">';



                    $str .= '<td>Công nợ <br><input type="text" class="comment" name="comment[]" placeholder="Nhập số hóa đơn,DO hoặc nội dung" autocomplete="off" data="'.$v->debit.'" alt="'.$v->debit_pay_id.'" value="'.$v->comment.'" ><ul class="name_list_id"></ul></td>';

                    $str .= '<td>Ngày <br><input type="text" class="debit_date ngay" name="debit_date[]" style="width:80px" disabled value="'.date('d-m-Y',$v->debit_date).'" ></td>';

                    $str .= '<td>Số tiền phải chi <br><input type="text" class="money numbers" name="money[]" style="width:120px" disabled value="'.$this->lib->formatMoney($v->money+$v->money_vat_price).'" ></td>';

                    $str .= '<td>Còn lại<br><input type="text" class="money_conlai numbers" name="money_conlai[]" style="width:120px" disabled value="'.$this->lib->formatMoney($v->money+$v->money_vat_price-$pay_money).'" ></td>';

                    $str .= '<td>Số tiền <br><input type="text" class="debit_pay_money numbers" name="debit_pay_money[]" style="width:120px" value="'.$this->lib->formatMoney($v->debit_pay_money).'" ></td>';


                    $str .= '</tr></table></td></tr>';


                    $i++;

                }



            }







            echo $str;



        }



    }



    public function deletedebit(){



        if (isset($_POST['debit_pay_id'])) {



            $debit_pay_model = $this->model->get('debitpayModel');

            $debit_pay_model->queryDebit('DELETE FROM debit_pay WHERE debit_pay_id = '.$_POST['debit_pay_id']);



            echo 'Đã xóa thành công';



        }



    }



    function export(){



        $this->view->disableLayout();



        if (!isset($_SESSION['userid_logined'])) {



            return $this->view->redirect('user/login');



        }







        $batdau = $this->registry->router->param_id;



        $ketthuc = $this->registry->router->page;



        $xe = $this->registry->router->order_by;



        $kh = $this->registry->router->order;



        $ngayketthuc = strtotime(date('d-m-Y', strtotime(date('d-m-Y',$ketthuc). ' + 1 days')));



        $info_model = $this->model->get('infoModel');

        $infos = $info_model->getLastInfo();





        $shipment_model = $this->model->get('shipmentModel');



        $join = array('table'=>'customer, vehicle, cont_unit','where'=>'customer.customer_id = shipment.customer AND vehicle.vehicle_id = shipment.vehicle AND cont_unit = cont_unit_id');







        $data = array(



            'where' => "shipment_ton > 0",



            );



        if($batdau != "" && $ketthuc != "" ){



            $data['where'] = $data['where'].' AND shipment_date >= '.$batdau.' AND shipment_date < '.$ngayketthuc;



        }



        if($xe > 0){



            $data['where'] = $data['where'].' AND vehicle = '.$xe;



        }



        if($kh > 0){



            $data['where'] = $data['where'].' AND customer = '.$kh;



        }



        







        /*if ($_SESSION['role_logined'] == 3) {



            $data['where'] = $data['where'].' AND shipment_create_user = '.$_SESSION['userid_logined'];



            



        }*/







        











        $data['order_by'] = 'shipment_date';



        $data['order'] = 'ASC';







        $shipments = $shipment_model->getAllShipment($data,$join);



        



        $place_model = $this->model->get('placeModel');



        $place_data = array();





        $customer_sub_model = $this->model->get('customersubModel');

        $customer_types = array();









        $data['order_by'] = 'customer';



        $data['order'] = 'ASC';







        $shipment_lists = $shipment_model->getAllShipment($data,$join);







        $number_sheet = $shipment_model->queryShipment('SELECT COUNT(DISTINCT customer) AS customer FROM shipment WHERE shipment_date >= '.$batdau.' AND shipment_date < '.$ngayketthuc);







        







            require("lib/Classes/PHPExcel/IOFactory.php");



            require("lib/Classes/PHPExcel.php");







            $objPHPExcel = new PHPExcel();







            







            $index_worksheet = 0; //(worksheet mặc định là 0, nếu tạo nhiều worksheet $index_worksheet += 1)



            $objPHPExcel->setActiveSheetIndex($index_worksheet)



                ->setCellValue('A1', mb_strtoupper($infos->info_company, "UTF-8"))



                ->setCellValue('A2', 'ĐỘI VẬN TẢI')



                ->setCellValue('H1', 'CỘNG HÒA XÃ CHỦ NGHĨA VIỆT NAM')



                ->setCellValue('H2', 'Độc lập - Tự do - Hạnh phúc')



                ->setCellValue('A4', 'BẢNG KÊ QUYẾT TOÁN SẢN LƯỢNG VÀ DOANH THU VẬN CHUYỂN HÀNG')



                ->setCellValue('A6', 'STT')



               ->setCellValue('B6', 'Ngày')



               ->setCellValue('C6', 'Xe')



               ->setCellValue('D6', 'Khách hàng')



               ->setCellValue('E6', 'Nhận hàng')



               ->setCellValue('F6', 'Giao hàng')



               ->setCellValue('G6', 'Loại hàng')



               ->setCellValue('H6', 'Sản lượng')



               ->setCellValue('I6', 'ĐVT')



               ->setCellValue('J6', 'Đơn giá')



               ->setCellValue('K6', 'Doanh thu khác')



               ->setCellValue('L6', 'Thành tiền')



               ->setCellValue('M6', 'Thuế VAT')



               ->setCellValue('N6', 'Tổng tiền');



               







            







            



            



            







            if ($shipments) {







                $hang = 7;



                $i=1;







                $kho_data = array();



                $k=0;

                foreach ($shipments as $row) {



                    $qr = "SELECT * FROM vehicle_work WHERE vehicle = ".$row->vehicle." AND start_work <= ".$row->shipment_date." AND end_work >= ".$row->shipment_date;

                    if ($shipment_model->queryShipment($qr)) {

                    

                        $places = $place_model->getAllPlace(array('where'=>'place_id = '.$row->shipment_from.' OR place_id = '.$row->shipment_to));



            







                        foreach ($places as $place) {



                            



                                $place_data['place_id'][$place->place_id] = $place->place_id;



                                $place_data['place_name'][$place->place_id] = $place->place_name;



                            



                            



                        }



                        $customer_sub = "";

                        $sts = explode(',', $row->customer_type);

                        foreach ($sts as $key) {

                            $subs = $customer_sub_model->getCustomer($key);

                            if ($subs) {

                                if ($customer_sub == "")

                                    $customer_sub .= $subs->customer_sub_name;

                                else

                                    $customer_sub .= ','.$subs->customer_sub_name;

                            }

                            

                        }

                        $customer_types[$row->shipment_id] = $customer_sub;











                        //$objPHPExcel->setActiveSheetIndex(0)->getStyle('B'.$hang)->getNumberFormat()->setFormatCode( PHPExcel_Style_NumberFormat::FORMAT_TEXT );



                         $objPHPExcel->setActiveSheetIndex(0)



                            ->setCellValue('A' . $hang, $i++)



                            ->setCellValueExplicit('B' . $hang, $this->lib->hien_thi_ngay_thang($row->shipment_date))



                            ->setCellValue('C' . $hang, $row->vehicle_number)



                            ->setCellValue('D' . $hang, $row->customer_name)



                            ->setCellValue('E' . $hang, $place_data['place_name'][$row->shipment_from])



                            ->setCellValue('F' . $hang, $place_data['place_name'][$row->shipment_to])



                            ->setCellValue('G' . $hang, $customer_types[$row->shipment_id])



                            ->setCellValue('H' . $hang, $row->shipment_ton)



                            ->setCellValue('I' . $hang, $row->cont_unit_name)



                            ->setCellValue('J' . $hang, $row->shipment_charge)



                            ->setCellValue('K' . $hang, $row->revenue_other+$row->shipment_charge_excess)



                            ->setCellValue('L' . $hang, '=(H'.$hang.'*J'.$hang.')+K'.$hang)



                            ->setCellValue('M' . $hang, '=L'.$hang.'*10%')



                            ->setCellValue('N' . $hang, '=M'.$hang.'+L'.$hang);



                         $hang++;







                        $tencongty = $row->customer_company;







                      }



                }



            }







            $check_customer = 0;







            $objPHPExcel->setActiveSheetIndex($index_worksheet)



                ->setCellValue('A'.$hang, 'TỔNG')





               ->setCellValue('L'.$hang, '=SUM(L7:L'.($hang-1).')')



               ->setCellValue('M'.$hang, '=SUM(M7:M'.($hang-1).')')



               ->setCellValue('N'.$hang, '=SUM(N7:N'.($hang-1).')');







            $objPHPExcel->getActiveSheet()->getStyle('A6:N'.$hang)->applyFromArray(



                array(



                    



                    'borders' => array(



                        'allborders' => array(



                          'style' => PHPExcel_Style_Border::BORDER_THIN



                        )



                    )



                )



            );











            $cell = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow(13, $hang)->getCalculatedValue();



            $objPHPExcel->setActiveSheetIndex($index_worksheet)



                ->setCellValue('A'.($hang+1), 'Bằng chữ: '.$this->lib->convert_number_to_words(round($cell)).' đồng');







            $objPHPExcel->getActiveSheet()->mergeCells('A'.$hang.':J'.$hang);



            $objPHPExcel->getActiveSheet()->mergeCells('A'.($hang+1).':N'.($hang+1));











            $objPHPExcel->getActiveSheet()->getStyle('A'.$hang)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);



            $objPHPExcel->getActiveSheet()->getStyle('A'.$hang)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);











            $objPHPExcel->setActiveSheetIndex($index_worksheet)



                ->setCellValue('A'.($hang+3), 'NGƯỜI LẬP BIỂU')



                ->setCellValue('E'.($hang+3), mb_strtoupper($infos->info_company, "UTF-8"))



               ->setCellValue('I'.($hang+3), mb_strtoupper($tencongty, "UTF-8"));







            $objPHPExcel->getActiveSheet()->mergeCells('A'.($hang+3).':D'.($hang+3));



            $objPHPExcel->getActiveSheet()->mergeCells('E'.($hang+3).':H'.($hang+3));



            $objPHPExcel->getActiveSheet()->mergeCells('I'.($hang+3).':M'.($hang+3));







            $objPHPExcel->getActiveSheet()->getStyle('A'.($hang+3).':M'.($hang+3))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);



            $objPHPExcel->getActiveSheet()->getStyle('A'.($hang+3).':M'.($hang+3))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);







            $objPHPExcel->getActiveSheet()->getStyle('A'.$hang.':N'.($hang+3))->applyFromArray(



                array(



                    



                    'font' => array(



                        'bold'  => true,



                        'color' => array('rgb' => '000000')



                    )



                )



            );











            $highestRow = $objPHPExcel->getActiveSheet()->getHighestRow();







            $highestRow ++;







            $objPHPExcel->getActiveSheet()->mergeCells('A1:E1');



            $objPHPExcel->getActiveSheet()->mergeCells('H1:M1');



            $objPHPExcel->getActiveSheet()->mergeCells('A2:E2');



            $objPHPExcel->getActiveSheet()->mergeCells('H2:M2');







            $objPHPExcel->getActiveSheet()->mergeCells('A4:M4');







            $objPHPExcel->getActiveSheet()->getStyle('A1:N4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);



            $objPHPExcel->getActiveSheet()->getStyle('A1:N4')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);







            $objPHPExcel->getActiveSheet()->getStyle("A4")->getFont()->setSize(16);







            $objPHPExcel->getActiveSheet()->getStyle('A1:N4')->applyFromArray(



                array(



                    



                    'font' => array(



                        'bold'  => true,



                        'color' => array('rgb' => '000000')



                    )



                )



            );







            $objPHPExcel->getActiveSheet()->getStyle('A2:H2')->applyFromArray(



                array(



                    



                    'font' => array(



                        'underline' => PHPExcel_Style_Font::UNDERLINE_SINGLE,



                    )



                )



            );







            $objPHPExcel->getActiveSheet()->getStyle('I7:N'.$highestRow)->getNumberFormat()->setFormatCode("#,##0_);[Black](#,##0)");



            $objPHPExcel->getActiveSheet()->getStyle('A6:N6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);



            $objPHPExcel->getActiveSheet()->getStyle('A6:N6')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);



            $objPHPExcel->getActiveSheet()->getStyle('A6:N6')->getFont()->setBold(true);



            $objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(26);



            $objPHPExcel->getActiveSheet()->getDefaultColumnDimension()->setWidth(14);



            $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);



            //$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(25);







            // Set properties



            $objPHPExcel->getProperties()->setCreator("TCMT")



                            ->setLastModifiedBy($_SESSION['user_logined'])



                            ->setTitle("Sale Report")



                            ->setSubject("Sale Report")



                            ->setDescription("Sale Report.")



                            ->setKeywords("Sale Report")



                            ->setCategory("Sale Report");



            $objPHPExcel->getActiveSheet()->setTitle("Bang ke san luong");







            $objPHPExcel->getActiveSheet()->freezePane('A7');



            $objPHPExcel->setActiveSheetIndex(0);















            







            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');







            header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");



            header("Content-Disposition: attachment; filename= BẢNG KÊ SẢN LƯỢNG.xlsx");



            header("Cache-Control: max-age=0");



            ob_clean();



            $objWriter->save("php://output");



        



    }











    







}



?>