<?php

Class productController Extends baseController {

    public function index() {

        $this->view->setLayout('admin');

        if (!isset($_SESSION['userid_logined'])) {

            return $this->view->redirect('user/login');

        }

        if ($_SESSION['role_logined'] != 1 && $_SESSION['role_logined'] != 2 && $_SESSION['role_logined'] != 6 && $_SESSION['role_logined'] != 8) {

            $this->view->data['disable_control'] = 1;

        }

        $this->view->data['lib'] = $this->lib;

        $this->view->data['title'] = 'Sản phẩm';



        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $order_by = isset($_POST['order_by']) ? $_POST['order_by'] : null;

            $order = isset($_POST['order']) ? $_POST['order'] : null;

            $page = isset($_POST['page']) ? $_POST['page'] : null;

            $keyword = isset($_POST['keyword']) ? $_POST['keyword'] : null;

            $limit = isset($_POST['limit']) ? $_POST['limit'] : 18446744073709;

        }

        else{

            $order_by = $this->registry->router->order_by ? $this->registry->router->order_by : 'product_code';

            $order = $this->registry->router->order_by ? $this->registry->router->order_by : 'ASC';

            $page = $this->registry->router->page ? (int) $this->registry->router->page : 1;

            $keyword = "";

            $limit = 50;


        }

        $id = $this->registry->router->param_id;

        $product_model = $this->model->get('productModel');

        $sonews = $limit;

        $x = ($page-1) * $sonews;

        $pagination_stages = 2;



        $data = array(

            'where' => '1=1',

        );


        if (isset($id) && $id > 0) {
            $data['where'] .= ' AND product_id = '.$id;
        }
        

        $tongsodong = count($product_model->getAllProduct($data));

        $tongsotrang = ceil($tongsodong / $sonews);

        $data = array(

            'order_by'=>$order_by,

            'order'=>$order,

            'limit'=>$x.','.$sonews,

            'where' => '1=1',

            );


        if (isset($id) && $id > 0) {
            $data['where'] .= ' AND product_id = '.$id;
        }
       

        

        if ($keyword != '') {

            $search = ' AND ( product_code LIKE "%'.$keyword.'%" )';

            $data['where'] .= $search;

        }

        

         $products = $product_model->getAllProduct($data);

        
        $this->view->data['products'] = $products;
        


        $this->view->data['page'] = $page;

        $this->view->data['order_by'] = $order_by;

        $this->view->data['order'] = $order;

        $this->view->data['keyword'] = $keyword;

        $this->view->data['pagination_stages'] = $pagination_stages;

        $this->view->data['tongsotrang'] = $tongsotrang;

        $this->view->data['sonews'] = $sonews;

        $this->view->data['limit'] = $limit;




        $this->view->data['lastID'] = isset($product_model->getLastProduct()->product_id)?$product_model->getLastProduct()->product_id:0;

        

        $this->view->show('product/index');

    }




    public function add(){

        if (!isset($_SESSION['userid_logined'])) {

            return $this->view->redirect('user/login');

        }

        if ($_SESSION['role_logined'] != 1 && $_SESSION['role_logined'] != 2 && $_SESSION['role_logined'] != 6 && $_SESSION['role_logined'] != 8) {

            return $this->view->redirect('user/login');

        }

        if (isset($_POST['yes'])) {

            $product_model = $this->model->get('productModel');

            $product_list_model = $this->model->get('productlistModel');

            $spare_model = $this->model->get('sparepartModel');



            /**************/


            /**************/



            $data = array(

                        

                        'product_code' => trim($_POST['product_code']),

                        );





            if ($_POST['yes'] != "") {

                   

                if ($product_model->getAllProductByWhere($_POST['yes'].' AND product_code = '.$data['product_code'])) {
                    echo "Thông tin này đã tồn tại";
                    return false;
                }
                else{

                    $product_model->updateProduct($data,array('product_id' => $_POST['yes']));

                    $id_product = $_POST['yes'];

                    /*Log*/

                    /**/


                    echo "Cập nhật thành công";



                    date_default_timezone_set("Asia/Ho_Chi_Minh"); 

                        $filename = "action_logs.txt";

                        $text = date('d/m/Y H:i:s')."|".$_SESSION['user_logined']."|"."edit"."|".$_POST['yes']."|product|".implode("-",$data)."\n"."\r\n";

                        

                        $fh = fopen($filename, "a") or die("Could not open log file.");

                        fwrite($fh, $text) or die("Could not write file!");

                        fclose($fh);
                    
                }
                

                

            }

            else{

                if ($product_model->getProductByWhere(array('product_code'=>$data['product_code']))) {
                    echo "Thông tin này đã tồn tại";
                    return false;
                }
                else{

                    $product_model->createProduct($data);

                    $id_product = $product_model->getLastProduct()->product_id;

                    /*Log*/

                    /**/



                    echo "Thêm thành công";



                    date_default_timezone_set("Asia/Ho_Chi_Minh"); 

                        $filename = "action_logs.txt";

                        $text = date('d/m/Y H:i:s')."|".$_SESSION['user_logined']."|"."add"."|".$product_model->getLastProduct()->product_id."|product|".implode("-",$data)."\n"."\r\n";

                        

                        $fh = fopen($filename, "a") or die("Could not open log file.");

                        fwrite($fh, $text) or die("Could not write file!");

                        fclose($fh);

                    
                }
                

                

            }


            if (isset($id_product)) {
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



                    $data_product = array(



                        'product' => $id_product,


                        'spare_part' => $id_spare_part,


                        'spare_part_number' => trim($v['spare_part_number']),


                        'spare_part_price' => trim(str_replace(',','',$v['spare_part_price'])),


                        'spare_part_unit' => $v['spare_part_unit'],

                        

                    );



                    if (!$product_list_model->getProductByWhere(array('product'=>$id_product,'spare_part'=>$id_spare_part))) {

                        $product_list_model->createProduct($data_product);

                    }

                    else{

                        $id_product_list = $product_list_model->getProductByWhere(array('product'=>$id_product,'spare_part'=>$id_spare_part))->product_list_id;

                        $product_list_model->updateProduct($data_product,array('product_list_id'=>$id_product_list));

                    }



                    $sl = $data_product['spare_part_number'];

                    $total_number += $data_product['spare_part_number'];

                    if ($sl == "" || $sl == 0) {
                        $sl = 1;
                    }

                    $total_price += (float)$data_product['spare_part_price']*$sl;

                }



                $product_model->updateProduct(array('product_number'=>$total_number,'product_price'=>$total_price),array('product_id'=>$id_product));
            }

            

                

                    

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

            $product_model = $this->model->get('productModel');

            $product_list_model = $this->model->get('productlistModel');


            if (isset($_POST['xoa'])) {

                $data = explode(',', $_POST['xoa']);

                foreach ($data as $data) {


                    $product_list_model->query('DELETE FROM product_list WHERE product = '.$data);


                    $product_model->deleteProduct($data);

                    

                    

                    date_default_timezone_set("Asia/Ho_Chi_Minh"); 

                        $filename = "action_logs.txt";

                        $text = date('d/m/Y H:i:s')."|".$_SESSION['user_logined']."|"."delete"."|".$data."|product|"."\n"."\r\n";

                        

                        $fh = fopen($filename, "a") or die("Could not open log file.");

                        fwrite($fh, $text) or die("Could not write file!");

                        fclose($fh);

                }



                /*Log*/

                    /**/



                return true;

            }

            else{



                $product_list_model->query('DELETE FROM product_list WHERE product = '.$_POST['data']);

                /*Log*/

                    /**/

                    date_default_timezone_set("Asia/Ho_Chi_Minh"); 

                        $filename = "action_logs.txt";

                        $text = date('d/m/Y H:i:s')."|".$_SESSION['user_logined']."|"."delete"."|".$_POST['data']."|product|"."\n"."\r\n";

                        

                        $fh = fopen($filename, "a") or die("Could not open log file.");

                        fwrite($fh, $text) or die("Could not write file!");

                        fclose($fh);



                return $product_model->deleteProduct($_POST['data']);

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





                $products = $spare_stock_model->queryStock('SELECT * FROM spare_stock WHERE spare_part = '.$rs->spare_part_id.' AND import_stock > 0 ORDER BY spare_stock_id DESC LIMIT 1');

                if ($products) {

                    foreach ($products as $product) {

                        echo '<li onclick="set_item_other(\''.$rs->spare_part_id.'\',\''.$rs->spare_part_name.'\',\''.$_POST['offset'].'\',\''.$product->spare_stock_unit.'\',\''.$product->spare_stock_price.'\')">'.$spare_name.'</li>';

                    }

                    

                }

                else{

                    echo '<li onclick="set_item_other(\''.$rs->spare_part_id.'\',\''.$rs->spare_part_name.'\',\''.$_POST['offset'].'\',\'\',\'\')">'.$spare_name.'</li>';

                    

                }



                



            }



        }



    }

    public function deletespare(){



        if (isset($_POST['product'])) {



            $product_list_model = $this->model->get('productlistModel');







            $product_list_model->queryProduct('DELETE FROM product_list WHERE product = '.$_POST['product'].' AND spare_part = '.$_POST['spare_part']);



            echo 'Đã xóa thành công';



        }



    }


    public function spare(){



        if(isset($_POST['product'])){



            



            $product_list_model = $this->model->get('productlistModel');



            $join = array('table'=>'spare_part','where'=>'spare_part_id = spare_part');

            $data = array(



                'where' => 'product = '.$_POST['product'],



            );



            $codes = $product_list_model->getAllProduct($data,$join);





            $str = "";



            if (!$codes) {



                $str .= '<tr class="'.$_POST['product'].'">';



                $str .= '<td><input type="checkbox"  name="chk"></td>';



                $str .= '<td><table style="width: 100%">';



                $str .= '<tr class="'.$_POST['product'] .'">';



                $str .= '<td>Tên sản phẩm <br> <input type="text" autocomplete="off" class="spare_part" name="spare_part[]" placeholder="Nhập tên hoặc * để chọn" > <ul class="name_list_id"></ul></td>';



                $str .= '<td>Số lượng <br> <input style="width:100px" type="text" class="spare_part_number number" name="spare_part_number[]" ></td>';

                $str .= '<td>ĐVT <br> <input style="width:100px" type="text" class="spare_part_unit" name="spare_part_unit[]" ></td>';

                $str .= '<td>Đơn giá <br> <input style="width:100px" type="text" class="spare_part_price number" name="spare_part_price[]"></td></tr>';



                $str .= '</table></td></tr>';



            }



            else{

                foreach ($codes as $code) {

                    $str .= '<tr class="'.$_POST['product'].'">';



                    $str .= '<td><input type="checkbox"  name="chk" alt="'.$code->spare_part_id.'"  data="'.$_POST['product'].'" ></td>';



                    $str .= '<td><table style="width: 100%">';



                    $str .= '<tr class="'.$_POST['product'] .'">';



                    $str .= '<td>Tên sản phẩm <br> <input type="text" autocomplete="off" class="spare_part" name="spare_part[]" placeholder="Nhập tên hoặc * để chọn" value="'.$code->spare_part_name.'" data="'.$code->spare_part_id.'" > <ul class="name_list_id"></ul></td>';



                    $str .= '<td>Số lượng <br> <input style="width:100px" type="text" class="spare_part_number number" name="spare_part_number[]" value="'.$code->spare_part_number.'" ></td>';


                    $str .= '<td>ĐVT <br> <input style="width:100px" type="text" class="spare_part_unit" name="spare_part_unit[]" value="'.$code->spare_part_unit.'" ></td>';



                    $str .= '<td>Đơn giá <br> <input style="width:100px" type="text" class="spare_part_price number" name="spare_part_price[]" value="'.$code->spare_part_price.'"></td></tr>';



                    $str .= '</table></td></tr>';

                    
                }

            }







            echo $str;



        }



    }





}

?>