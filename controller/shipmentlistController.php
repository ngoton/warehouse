<?php



Class shipmentlistController Extends baseController {



    public function index() {



        $this->view->setLayout('admin');



        if (!isset($_SESSION['userid_logined'])) {



            return $this->view->redirect('user/login');



        }



        if ($_SESSION['role_logined'] != 1 && $_SESSION['role_logined'] != 2 && $_SESSION['role_logined'] != 3 && $_SESSION['role_logined'] != 4) {

            $this->view->data['disable_control'] = 1;

        }



        $this->view->data['lib'] = $this->lib;



        $this->view->data['title'] = 'Bảng kê đơn hàng';







        if ($_SERVER['REQUEST_METHOD'] == 'POST') {



            $order_by = isset($_POST['order_by']) ? $_POST['order_by'] : null;



            $order = isset($_POST['order']) ? $_POST['order'] : null;



            $page = isset($_POST['page']) ? $_POST['page'] : null;



            $keyword = isset($_POST['keyword']) ? $_POST['keyword'] : null;



            $limit = isset($_POST['limit']) ? $_POST['limit'] : 18446744073709;



            $batdau = isset($_POST['batdau']) ? $_POST['batdau'] : null;



            $ketthuc = isset($_POST['ketthuc']) ? $_POST['ketthuc'] : null;



            $kh = isset($_POST['nv']) ? $_POST['nv'] : null;



            $vong = isset($_POST['vong']) ? $_POST['vong'] : null;



            $trangthai = isset($_POST['staff']) ? $_POST['staff'] : null;



            



        }



        else{



            $order_by = $this->registry->router->order_by ? $this->registry->router->order_by : 'shipment_list_date';



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





        $ngayketthuc = date('d-m-Y', strtotime($ketthuc. ' + 1 days'));



        $vong = (int)date('m',strtotime($batdau));



        $trangthai = date('Y',strtotime($batdau));






        $customer_model = $this->model->get('customerModel');



        $customers = $customer_model->getAllCustomer();



        $this->view->data['customers'] = $customers;



        $join = array('table'=>'customer','where'=>'customer = customer_id');



        $shipment_list_model = $this->model->get('shipmentlistModel');



        $sonews = $limit;



        $x = ($page-1) * $sonews;



        $pagination_stages = 2;







        $data = array(



            'where' => "1=1",



            );



        if($batdau != "" && $ketthuc != "" ){



            $data['where'] = $data['where'].' AND shipment_list_date >= '.strtotime($batdau).' AND shipment_list_date < '.strtotime($ngayketthuc);



        }




        if($kh > 0){



            $data['where'] = $data['where'].' AND customer = '.$kh;



        }







        $tongsodong = count($shipment_list_model->getAllShipment($data,$join));



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



            $data['where'] = $data['where'].' AND shipment_list_date >= '.strtotime($batdau).' AND shipment_list_date < '.strtotime($ngayketthuc);



        }



        if($kh > 0){



            $data['where'] = $data['where'].' AND customer = '.$kh;



        }



        





        if ($keyword != '') {



            $ngay = (strtotime(str_replace("/", "-", $keyword))!="")?(' OR shipment_list_date LIKE "%'.strtotime(str_replace("/", "-", $keyword)).'%"'):"";



            $search = '(



                    shipment_list_number LIKE "%'.$keyword.'%"



                    OR customer_name LIKE "%'.$keyword.'%"



                    '.$ngay.'



                        )';



            $data['where'] = $data['where']." AND ".$search;



        }







        $shipment_lists = $shipment_list_model->getAllShipment($data,$join);



        

        $this->view->data['shipment_lists'] = $shipment_lists;





        $this->view->data['lastID'] = isset($shipment_list_model->getLastShipment()->shipment_list_id)?$shipment_list_model->getLastShipment()->shipment_list_id:0;





        $this->view->show('shipmentlist/index');



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



                echo '<li onclick="set_item_customer(\''.$rs->customer_id.'\',\''.$rs->customer_name.'\',\''.$rs->customer_mst.'\',\''.$rs->customer_address.'\',\''.$rs->customer_sub.'\')">'.$customer_name.'</li>';



            }



        }



    }

    

    public function getshipment(){



        if (!isset($_SESSION['userid_logined'])) {



            return $this->view->redirect('user/login');



        }





        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $id = trim($_POST['id']);
            $id = $id>0?$id:0;

            $customer = trim($_POST['customer']);
            $batdau = trim($_POST['start_time']);
            $ketthuc = trim($_POST['end_time']);
            $ngayketthuc = date('d-m-Y', strtotime($ketthuc. ' + 1 days'));


            $sell_model = $this->model->get('sellModel');

            $shipment_list_model = $this->model->get('shipmentlistModel');


            $data = array(

                'where'=>'sell_customer = '.$customer.' AND sell_date >= '.strtotime($batdau).' AND sell_date < '.strtotime($ngayketthuc),

                'order_by'=>'sell_date ASC',

                );

            $shipments = $sell_model->getAllSell($data);



            $str = '<table class="table_data">';
            $str .= '<thead><tr><th class="fix"><input checked type="checkbox" onclick="checkall(\'checkbox\', this)" name="checkall"/></th><th class="fix">STT</th><th class="fix">Ngày</th><th class="fix">Số đơn hàng</th><th class="fix">Nội dung</th><th class="fix">Số lượng</th><th class="fix">Thành tiền</th></tr></thead>';
            $str .= '<tbody>';

            $i = 1; $tongtien = 0;
            foreach ($shipments as $shipment) {

                $shipment_lists = $shipment_list_model->queryShipment('SELECT shipment FROM shipment_list WHERE shipment LIKE "'.$shipment->sell_id.'" OR shipment LIKE "'.$shipment->sell_id.',%" OR shipment LIKE "%,'.$shipment->sell_id.',%" OR shipment LIKE "%,'.$shipment->sell_id.'"');

                $shipment_list_adds = $shipment_list_model->queryShipment('SELECT shipment FROM shipment_list WHERE shipment_list_id = '.$id.' AND (shipment LIKE "'.$shipment->sell_id.'" OR shipment LIKE "'.$shipment->sell_id.',%" OR shipment LIKE "%,'.$shipment->sell_id.',%" OR shipment LIKE "%,'.$shipment->sell_id.'")');



                if (!$shipment_lists || $shipment_list_adds) {
                    $tien = $shipment->sell_money;
                    $tongtien += $tien;
                    
                    $str .= '<tr class="tr" data="'.$shipment->sell_id.'"><td><input checked name="check_i[]" type="checkbox" class="checkbox" value="'.$shipment->sell_id.'" data="'.$tien.'" ></td><td class="fix">'.$i++.'</td><td class="fix">'.$this->lib->hien_thi_ngay_thang($shipment->sell_date).'</td><td class="fix">'.$shipment->sell_code.'</td><td class="fix">'.$shipment->sell_comment.'</td><td class="fix">'.$shipment->sell_number.'</td><td class="fix">'.$this->lib->formatMoney($tien).'</td></tr>';
                }

                

            }

            $str .= '<tr style="font-weight:bold"><td colspan="6">Tổng cộng</td><td class="fix">'.$this->lib->formatMoney($tongtien).'</td></tr>';

            $str .= '</tbody></table>';

            echo $str;



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

            $shipment_list_model = $this->model->get('shipmentlistModel');


            $data = array(

                        'shipment_list_number' => trim($_POST['shipment_list_number']),

                        'shipment_list_date' => strtotime($_POST['shipment_list_date']),

                        'customer' => trim($_POST['customer']),

                        'shipment_list_price' => trim(str_replace(',','',$_POST['shipment_list_price'])),

                        'shipment' => trim($_POST['shipment']),

                        'start_time' => strtotime($_POST['start_time']),

                        'end_time' => strtotime($_POST['end_time']),

                        );




            if ($_POST['yes'] != "") {

                if ($shipment_list_model->checkShipment($_POST['yes'].' AND shipment_list_number = "'.trim($_POST['shipment_list_number']).'"')) {

                    echo "Thông tin này đã tồn tại";

                    return false;

                }

                else{

                    $shipment_list_model->updateShipment($data,array('shipment_list_id' => $_POST['yes']));

                    $id_shipment_list = $_POST['yes'];

                    /*Log*/

                    /**/

                    

                    echo "Cập nhật thành công";



                    date_default_timezone_set("Asia/Ho_Chi_Minh"); 

                        $filename = "action_logs.txt";

                        $text = date('d/m/Y H:i:s')."|".$_SESSION['user_logined']."|"."edit"."|".$_POST['yes']."|shipment_list|".implode("-",$data)."\n"."\r\n";

                        

                        $fh = fopen($filename, "a") or die("Could not open log file.");

                        fwrite($fh, $text) or die("Could not write file!");

                        fclose($fh);

                    }

                

                

            }

            else{



                if ($shipment_list_model->getShipmentByWhere(array('shipment_list_number'=>$data['shipment_list_number']))) {

                    echo "Thông tin này đã tồn tại";

                    return false;

                }

                else{

                    $shipment_list_model->createShipment($data);

                    $id_shipment_list = $shipment_list_model->getLastShipment()->shipment_list_id;

                    /*Log*/

                    /**/



                    echo "Thêm thành công";



                    date_default_timezone_set("Asia/Ho_Chi_Minh"); 

                        $filename = "action_logs.txt";

                        $text = date('d/m/Y H:i:s')."|".$_SESSION['user_logined']."|"."add"."|".$shipment_list_model->getLastShipment()->shipment_list_id."|shipment_list|".implode("-",$data)."\n"."\r\n";

                        

                        $fh = fopen($filename, "a") or die("Could not open log file.");

                        fwrite($fh, $text) or die("Could not write file!");

                        fclose($fh);

                    }

                

                

            }


            /*$shipment_list_price = 0;


            $arr = explode(',', $data['shipment']);



            foreach ($arr as $key) {

                $d = $shipment_model->getShipment($key);

                $shipment_list_price += $d->shipment_ton*$d->shipment_charge;

            }


            $shipment_list_model->updateShipment(array('shipment_list_price'=>$shipment_list_price),array('shipment_list_id' => $id_shipment_list));*/
            

                    

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

            $shipment_list_model = $this->model->get('shipmentlistModel');


            if (isset($_POST['xoa'])) {

                $data = explode(',', $_POST['xoa']);

                foreach ($data as $data) {


                    $shipment_list_model->deleteShipment($data);

                    

                    

                    date_default_timezone_set("Asia/Ho_Chi_Minh"); 

                        $filename = "action_logs.txt";

                        $text = date('d/m/Y H:i:s')."|".$_SESSION['user_logined']."|"."delete"."|".$data."|shipment_list|"."\n"."\r\n";

                        

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

                        $text = date('d/m/Y H:i:s')."|".$_SESSION['user_logined']."|"."delete"."|".$_POST['data']."|shipment_list|"."\n"."\r\n";

                        

                        $fh = fopen($filename, "a") or die("Could not open log file.");

                        fwrite($fh, $text) or die("Could not write file!");

                        fclose($fh);



                return $shipment_list_model->deleteShipment($_POST['data']);

            }

            

        }

    }



    







}



?>