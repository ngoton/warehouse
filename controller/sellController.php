<?php

Class sellController Extends baseController {

    public function index() {

        $this->view->setLayout('admin');

        if (!isset($_SESSION['userid_logined'])) {

            return $this->view->redirect('user/login');

        }

        if ($_SESSION['role_logined'] != 1 && $_SESSION['role_logined'] != 2 && $_SESSION['role_logined'] != 4) {

            $this->view->data['disable_control'] = 1;

        }

        $this->view->data['lib'] = $this->lib;

        $this->view->data['title'] = 'Đơn hàng';



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

        

        $this->view->show('sell/index');

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


    public function add(){

        if (!isset($_SESSION['userid_logined'])) {

            return $this->view->redirect('user/login');

        }

        if ($_SESSION['role_logined'] != 1 && $_SESSION['role_logined'] != 2 && $_SESSION['role_logined'] != 4) {

            return $this->view->redirect('user/login');

        }

        if (isset($_POST['yes'])) {

            $sell_model = $this->model->get('sellModel');

            $sell_list_model = $this->model->get('selllistModel');

            $product_model = $this->model->get('productModel');

            $product_list_model = $this->model->get('productlistModel');

            $stock_model = $this->model->get('sparestockModel');



            /**************/


            /**************/



            $data = array(

                        'sell_date' => strtotime($_POST['sell_date']),

                        'sell_code' => trim($_POST['sell_code']),

                        'sell_customer' => trim($_POST['sell_customer']),

                        'sell_comment' => trim($_POST['sell_comment']),

                        );





            if ($_POST['yes'] != "") {

                   

                if ($sell_model->getAllSellByWhere($_POST['yes'].' AND sell_code = '.$data['sell_code'])) {
                    echo "Thông tin này đã tồn tại";
                    return false;
                }
                else{

                    $sell_model->updateSell($data,array('sell_id' => $_POST['yes']));

                    $id_sell = $_POST['yes'];

                    /*Log*/

                    /**/


                    echo "Cập nhật thành công";



                    date_default_timezone_set("Asia/Ho_Chi_Minh"); 

                        $filename = "action_logs.txt";

                        $text = date('d/m/Y H:i:s')."|".$_SESSION['user_logined']."|"."edit"."|".$_POST['yes']."|sell|".implode("-",$data)."\n"."\r\n";

                        

                        $fh = fopen($filename, "a") or die("Could not open log file.");

                        fwrite($fh, $text) or die("Could not write file!");

                        fclose($fh);
                    
                }
                

                

            }

            else{

                if ($sell_model->getSellByWhere(array('sell_code'=>$data['sell_code']))) {
                    echo "Thông tin này đã tồn tại";
                    return false;
                }
                else{

                    $sell_model->createSell($data);

                    $id_sell = $sell_model->getLastSell()->sell_id;

                    /*Log*/

                    /**/



                    echo "Thêm thành công";



                    date_default_timezone_set("Asia/Ho_Chi_Minh"); 

                        $filename = "action_logs.txt";

                        $text = date('d/m/Y H:i:s')."|".$_SESSION['user_logined']."|"."add"."|".$sell_model->getLastSell()->sell_id."|sell|".implode("-",$data)."\n"."\r\n";

                        

                        $fh = fopen($filename, "a") or die("Could not open log file.");

                        fwrite($fh, $text) or die("Could not write file!");

                        fclose($fh);

                    
                }
                

                

            }


            if (isset($id_sell)) {
                $total_number = 0;

                $total_price = 0;

                $total_vat_price = 0;



                $product = $_POST['product'];



                foreach ($product as $v) {




                    if (isset($v['product_id']) && $v['product_id'] > 0) {



                        $id_product = $v['product_id'];

                        $data_sell = array(



                            'sell' => $id_sell,


                            'product' => $id_product,


                            'sell_list_number' => trim($v['sell_list_number']),


                            'sell_list_price' => trim(str_replace(',','',$v['sell_list_price'])),


                            'sell_list_unit' => $v['sell_list_unit'],

                            

                        );



                        if (!$sell_list_model->getSellByWhere(array('sell'=>$id_sell,'product'=>$id_product))) {

                            $sell_list_model->createSell($data_sell);

                            $id_sell_list = $sell_list_model->getLastSell()->sell_list_id;

                            $product_lists = $product_list_model->getAllProduct(array('where'=>'product = '.$id_product));

                            foreach ($product_lists as $product_list) {
                                $stock_data =array(
                                    'spare_part' => $product_list->spare_part,
                                    'spare_stock_number' => $product_list->spare_part_number*$data_sell['sell_list_number'],
                                    'spare_stock_price' => $product_list->spare_part_price,
                                    'spare_stock_unit' => $product_list->spare_part_unit,
                                    'sell_list' => $id_sell_list,
                                );
                                $stock_model->createStock($stock_data);
                            }

                        }

                        else{

                            $id_sell_list = $sell_list_model->getSellByWhere(array('sell'=>$id_sell,'product'=>$id_product))->sell_list_id;

                            $sell_list_model->updateSell($data_sell,array('sell_list_id'=>$id_sell_list));

                            $product_lists = $product_list_model->getAllProduct(array('where'=>'product = '.$id_product));

                            foreach ($product_lists as $product_list) {
                                $stock_data =array(
                                    'spare_part' => $product_list->spare_part,
                                    'spare_stock_number' => $product_list->spare_part_number*$data_sell['sell_list_number'],
                                    'spare_stock_price' => $product_list->spare_part_price,
                                    'spare_stock_unit' => $product_list->spare_part_unit,
                                    'sell_list' => $id_sell_list,
                                );
                                $stock_model->updateStock($stock_data,array('sell_list'=>$id_sell_list,'spare_part'=>$product_list->spare_part));
                            }

                        }



                        $total_number += $data_sell['sell_list_number'];
                        $total_price += (float)$data_sell['sell_list_price']*$data_sell['sell_list_number'];

                    }




                    

                }



                $sell_model->updateSell(array('sell_number'=>$total_number,'sell_money'=>$total_price),array('sell_id'=>$id_sell));
            }

            

                

                    

        }

    }

    public function delete(){

        if (!isset($_SESSION['userid_logined'])) {

            return $this->view->redirect('user/login');

        }

        if ($_SESSION['role_logined'] != 1 && $_SESSION['role_logined'] != 2 && $_SESSION['role_logined'] != 4) {

            return $this->view->redirect('user/login');

        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $sell_model = $this->model->get('sellModel');

            $sell_list_model = $this->model->get('selllistModel');

            $stock_model = $this->model->get('sparestockModel');


            if (isset($_POST['xoa'])) {

                $data = explode(',', $_POST['xoa']);

                foreach ($data as $data) {

                    $sell_lists = $sell_list_model->getAllSell(array('where'=>'sell = '.$data));
                    foreach ($sell_lists as $sell) {
                        $stock_model->query('DELETE FROM spare_stock WHERE sell_list = '.$sell->sell_list_id);
                        $sell_list_model->query('DELETE FROM sell_list WHERE sell_list_id = '.$sell->sell_list_id);
                    }


                    $sell_model->deleteSell($data);

                    

                    

                    date_default_timezone_set("Asia/Ho_Chi_Minh"); 

                        $filename = "action_logs.txt";

                        $text = date('d/m/Y H:i:s')."|".$_SESSION['user_logined']."|"."delete"."|".$data."|sell|"."\n"."\r\n";

                        

                        $fh = fopen($filename, "a") or die("Could not open log file.");

                        fwrite($fh, $text) or die("Could not write file!");

                        fclose($fh);

                }



                /*Log*/

                    /**/



                return true;

            }

            else{


                $sell_lists = $sell_list_model->getAllSell(array('where'=>'sell = '.$_POST['data']));
                foreach ($sell_lists as $sell) {
                    $stock_model->query('DELETE FROM spare_stock WHERE sell_list = '.$sell->sell_list_id);
                    $sell_list_model->query('DELETE FROM sell_list WHERE sell_list_id = '.$sell->sell_list_id);
                }

                /*Log*/

                    /**/

                    date_default_timezone_set("Asia/Ho_Chi_Minh"); 

                        $filename = "action_logs.txt";

                        $text = date('d/m/Y H:i:s')."|".$_SESSION['user_logined']."|"."delete"."|".$_POST['data']."|sell|"."\n"."\r\n";

                        

                        $fh = fopen($filename, "a") or die("Could not open log file.");

                        fwrite($fh, $text) or die("Could not write file!");

                        fclose($fh);



                return $sell_model->deleteSell($_POST['data']);

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

    public function getProduct(){



        if (!isset($_SESSION['userid_logined'])) {



            return $this->view->redirect('user/login');



        }



        if ($_SERVER['REQUEST_METHOD'] == 'POST') {




            $product_model = $this->model->get('productModel');

            $sell_list_model = $this->model->get('selllistModel');


            if ($_POST['keyword'] == "*") {




                $list = $product_model->getAllProduct();



            }



            else{



                $data = array(



                'where'=>'( product_code LIKE "%'.$_POST['keyword'].'%" )',



                );



                $list = $product_model->getAllProduct($data);




            }



            



            foreach ($list as $rs) {



                // put in bold the written text

                



                $product_code = $rs->product_code;



                if ($_POST['keyword'] != "*") {



                    $product_code = str_replace($_POST['keyword'], '<b>'.$_POST['keyword'].'</b>', $rs->product_code);



                }





                $sells = $sell_list_model->querySell('SELECT * FROM sell_list WHERE product = '.$rs->product_id.' ORDER BY sell_list_id DESC LIMIT 1');

                if ($sells) {

                    foreach ($sells as $sell) {

                        echo '<li onclick="set_item_other(\''.$rs->product_id.'\',\''.$rs->product_code.'\',\''.$_POST['offset'].'\',\''.$sell->sell_list_unit.'\',\''.$sell->sell_list_price.'\')">'.$product_code.'</li>';

                    }

                    

                }

                else{

                    echo '<li onclick="set_item_other(\''.$rs->product_id.'\',\''.$rs->product_code.'\',\''.$_POST['offset'].'\',\'\',\'\')">'.$product_code.'</li>';

                    

                }



                



            }



        }



    }

    public function deleteproduct(){



        if (isset($_POST['sell'])) {



            $sell_list_model = $this->model->get('selllistModel');

            $stock_model = $this->model->get('sparestockModel');


            $sell_lists = $sell_list_model->getAllSell(array('where'=>'sell = '.$_POST['sell'].' AND product = '.$_POST['product']));
            foreach ($sell_lists as $sell) {
                $stock_model->query('DELETE FROM spare_stock WHERE sell_list = '.$sell->sell_list_id);
                $sell_list_model->query('DELETE FROM sell_list WHERE sell_list_id = '.$sell->sell_list_id);
            }




            echo 'Đã xóa thành công';



        }



    }


    public function product(){



        if(isset($_POST['sell'])){



            



            $sell_list_model = $this->model->get('selllistModel');



            $join = array('table'=>'product','where'=>'product_id = product');

            $data = array(



                'where' => 'sell = '.$_POST['sell'],



            );



            $codes = $sell_list_model->getAllSell($data,$join);





            $str = "";



            if (!$codes) {



                $str .= '<tr class="'.$_POST['sell'].'">';



                $str .= '<td><input type="checkbox"  name="chk"></td>';



                $str .= '<td><table style="width: 100%">';



                $str .= '<tr class="'.$_POST['sell'] .'">';



                $str .= '<td>Mã sản phẩm <br> <input type="text" autocomplete="off" class="product" name="product[]" placeholder="Nhập tên hoặc * để chọn" > <ul class="name_list_id"></ul></td>';



                $str .= '<td>Số lượng <br> <input style="width:100px" type="text" class="sell_list_number number" name="sell_list_number[]" ></td>';

                $str .= '<td>ĐVT <br> <input style="width:100px" type="text" class="sell_list_unit" name="sell_list_unit[]" ></td>';

                $str .= '<td>Đơn giá <br> <input style="width:100px" type="text" class="sell_list_price number" name="sell_list_price[]"></td></tr>';



                $str .= '</table></td></tr>';



            }



            else{

                foreach ($codes as $code) {

                    $str .= '<tr class="'.$_POST['sell'].'">';



                    $str .= '<td><input type="checkbox"  name="chk" alt="'.$code->product_id.'"  data="'.$_POST['sell'].'" ></td>';



                    $str .= '<td><table style="width: 100%">';



                    $str .= '<tr class="'.$_POST['sell'] .'">';



                    $str .= '<td>Mã sản phẩm <br> <input type="text" autocomplete="off" class="product" name="product[]" placeholder="Nhập tên hoặc * để chọn" value="'.$code->product_code.'" data="'.$code->product_id.'" > <ul class="name_list_id"></ul></td>';



                    $str .= '<td>Số lượng <br> <input style="width:100px" type="text" class="sell_list_number number" name="sell_list_number[]" value="'.$code->sell_list_number.'" ></td>';


                    $str .= '<td>ĐVT <br> <input style="width:100px" type="text" class="sell_list_unit" name="sell_list_unit[]" value="'.$code->sell_list_unit.'" ></td>';



                    $str .= '<td>Đơn giá <br> <input style="width:100px" type="text" class="sell_list_price number" name="sell_list_price[]" value="'.$code->sell_list_price.'"></td></tr>';



                    $str .= '</table></td></tr>';

                    
                }

            }







            echo $str;



        }



    }





}

?>