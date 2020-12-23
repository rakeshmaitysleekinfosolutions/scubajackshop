<?php
use Carbon\Carbon;
class Order extends AdminController {
    private $order;
    private $orderInfo;
    public function __construct() {
        parent::__construct();
        $this->order = Order_model::factory();
        //dd($this->options);
    }
    public function index() {
        $this->data['title']        = 'Order List';
        $this->data['heading']        = 'Order List';
        $this->data['columns'][]    = 'Order ID';
        $this->data['columns'][]    = 'Customer';
        $this->data['columns'][]    = 'Shipping Code';
        $this->data['columns'][]    = 'Total';
        $this->data['columns'][]    = 'Status';
        $this->data['columns'][]    = 'Created At';
        $this->data['columns'][]    = 'Updated At';

        $this->data['btnBack']                  = 'Back';
        $this->data['back']                     = url('shop/order');
        $this->data['deleteBtn']                = 'Delete';

        attach('assets/theme/light/js/datatables/dataTables.bootstrap4.css', 'css');
        attach('assets/theme/light/js/datatables/jquery.dataTables.min.js', 'js');
        attach('assets/theme/light/js/datatables/dataTables.bootstrap4.min.js', 'js');
        attach('assets/js/shop/Order.js', 'js');
        render('order/index', $this->data);
    }
    public function info() {

        $order_id = $this->uri->segment(4);
        if(!$order_id) {
            redirect(url('shop/order'));
        }
        $this->orderInfo = $this->order->getOrder($order_id);

        if ($this->orderInfo) {

//            $this->data['shipping']     = $this->url->link('sale/order/shipping', 'user_token=' . $this->session->data['user_token'] . '&order_id=' . (int)$this->request->get['order_id'], true);
  //          $this->data['invoice']      = $this->url->link('sale/order/invoice', 'user_token=' . $this->session->data['user_token'] . '&order_id=' . (int)$this->request->get['order_id'], true);

            $this->data['order_id']     = $order_id;

            if ($this->orderInfo['invoice_no']) {
                $this->data['invoice_no'] = $this->orderInfo['invoice_prefix'] . $this->orderInfo['invoice_no'];
            } else {
                $this->data['invoice_no'] = '';
            }

            $this->data['created_at'] = $this->orderInfo['created_at'];
            $this->data['customer'] = $this->orderInfo['customer'];
            $this->data['uuid'] = $this->orderInfo['uuid'];

            $this->data['firstname'] = $this->orderInfo['firstname'];
            $this->data['lastname'] = $this->orderInfo['lastname'];
            $this->data['gender'] = $this->orderInfo['gender'];

//            if ($this->orderInfo['user_id']) {
//                $this->data['customer'] = $this->url->link('customer/customer/edit', 'user_token=' . $this->session->data['user_token'] . '&customer_id=' . $this->orderInfo['customer_id'], true);
//            } else {
//                $this->data['customer'] = '';
//            }

            $this->data['email'] = $this->orderInfo['email'];
            $this->data['phone'] = $this->orderInfo['phone'];

            $this->data['shipping_method'] = $this->orderInfo['shipping_method'];
            $this->data['payment_method'] = $this->orderInfo['payment_method'];

            if (isset($this->orderInfo['payment_address_format'])) {
                $format = $this->orderInfo['payment_address_format'];
            } else {
                $format = '{firstname} {lastname}' . "\n" . '{address_1}' . "\n" . '{address_2}' . "\n" . '{city} {postcode}' . "\n" . '{zone}' . "\n" . '{country}';
            }
            $find = array(
                '{firstname}',
                '{lastname}',
                '{address_1}',
                '{address_2}',
                '{city}',
                '{postcode}',
                '{zone}',
                '{zone_code}',
                '{country}'
            );

            $replace = array(
                'firstname' => $this->orderInfo['payment_firstname'],
                'lastname'  => $this->orderInfo['payment_lastname'],
                'address_1' => $this->orderInfo['payment_address_1'],
                'address_2' => $this->orderInfo['payment_address_2'],
                'city'      => $this->orderInfo['payment_city'],
                'postcode'  => $this->orderInfo['payment_postcode'],
                'zone'      => $this->orderInfo['payment_zone'],
                'zone_code' => $this->orderInfo['payment_zone_code'],
                'country'   => $this->orderInfo['payment_country']
            );

            $this->data['payment_address'] = str_replace(array("\r\n", "\r", "\n"), '<br />', preg_replace(array("/\s\s+/", "/\r\r+/", "/\n\n+/"), '<br />', trim(str_replace($find, $replace, $format))));

            // Shipping Address
            if (isset($this->orderInfo['shipping_address_format'])) {
                $format = $this->orderInfo['shipping_address_format'];
            } else {
                $format = '{firstname} {lastname}' . "\n" . '{address_1}' . "\n" . '{address_2}' . "\n" . '{city} {postcode}' . "\n" . '{zone}' . "\n" . '{country}';
            }

            $find = array(
                '{firstname}',
                '{lastname}',
                '{company}',
                '{address_1}',
                '{address_2}',
                '{city}',
                '{postcode}',
                '{zone}',
                '{zone_code}',
                '{country}'
            );

            $replace = array(
                'firstname' => $this->orderInfo['shipping_firstname'],
                'lastname'  => $this->orderInfo['shipping_lastname'],
                'address_1' => $this->orderInfo['shipping_address_1'],
                'address_2' => $this->orderInfo['shipping_address_2'],
                'city'      => $this->orderInfo['shipping_city'],
                'postcode'  => $this->orderInfo['shipping_postcode'],
                'zone'      => $this->orderInfo['shipping_zone'],
                'zone_code' => $this->orderInfo['shipping_zone_code'],
                'country'   => $this->orderInfo['shipping_country']
            );

            $this->data['shipping_address'] = str_replace(array("\r\n", "\r", "\n"), '<br />', preg_replace(array("/\s\s+/", "/\r\r+/", "/\n\n+/"), '<br />', trim(str_replace($find, $replace, $format))));

            $this->data['products'] = array();

            $products = OrderProduct_model::factory()->findAll(['order_id' => $order_id]);
           // $this->dd($products);
            foreach ($products as $product) {
                $this->data['products'][] = array(
                    'product_id'       => $product['product_id'],
                    'name'    	 	   => $product['name'],
                    'quantity'		   => $product['quantity'],
                    'price'    		   => $this->currency->format($product['price'], $this->orderInfo['currency_code'], $this->orderInfo['currency_value']),
                    'total'    		   => $this->currency->format($product['total'], $this->orderInfo['currency_code'], $this->orderInfo['currency_value']),
                );
            }
            $this->data['totals'] = array();
            $totals = $this->order->getOrderTotals($order_id);

            foreach ($totals as $total) {
                $this->data['totals'][] = array(
                    'title' => $total['title'],
                    'text'  => $this->currency->format($total['value'], $this->orderInfo['currency_code'], $this->orderInfo['currency_value'])
                );
            }

            $order_status_info = OrderStatus_model::factory()->findOne($this->orderInfo['order_status_id']);

            if ($order_status_info) {
                $this->data['order_status'] = $order_status_info['name'];
            } else {
                $this->data['order_status'] = '';
            }

            $this->data['order_statuses'] = OrderStatus_model::factory()->findAll();

            $this->data['order_status_id'] = $this->orderInfo['order_status_id'];

            // Shipping
            $this->data['ip'] = $this->orderInfo['ip'];
            $this->data['forwarded_ip'] = $this->orderInfo['forwarded_ip'];
            $this->data['user_agent'] = $this->orderInfo['user_agent'];

            $this->data['btnBack']                  = 'Back';
            $this->data['back']                     = url('shop/order');
           // dd($this->data);
            attach('assets/js/shop/Order.js', 'js');
            render('order/view', $this->data);
        }
    }
    /**
     * @return mixed
     */
    public function delete() {
        if($this->isAjaxRequest()) {
            $this->request = $this->input->post();
            if(!empty($this->request['selected']) && isset($this->request['selected'])) {
                if(array_key_exists('selected', $this->request) && is_array($this->request['selected'])) {
                    $this->selected = $this->request['selected'];
                }
            }
            if($this->selected) {
                foreach ($this->selected as $id) {
                   // dd($id);
                    Order_model::factory()->delete($id);
                    OrderHistory_model::factory()->delete(['order_id' => $id]);
                    OrderProduct_model::factory()->delete(['order_id' => $id]);
                    OrderTotal_model::factory()->delete(['order_id' => $id]);
                }
                return $this->output
                    ->set_content_type('application/json')
                    ->set_status_header(200)
                    ->set_output(json_encode(array('data' => $this->onLoadDatatableEventHandler(), 'status' => true,'message' => 'Record has been successfully deleted')));
            }
            return $this->output
                ->set_content_type('application/json')
                ->set_status_header(200)
                ->set_output(json_encode(array('data' => $this->onLoadDatatableEventHandler(), 'status' => false, 'message' => 'Sorry! we could not delete this record')));
        }
    }

    /**
     * @return mixed
     * @throws Exception
     */
    public function onLoadDatatableEventHandler() {
        // Orders
        $order_statuses = OrderStatus_model::factory()->findAll();
        $this->results = $this->order->getOrders();
        //dd($this->results);
        if(!empty($this->results)) {
            $option = '';
            foreach ($this->results as $result) {
                $this->rows[] = array(
                    'id'   => $result['order_id'],
                    'order_id'   => $result['uuid'],
                    'customer'   => $result['customer'],
                    'status'     => $result['order_status'],
                    'order_status_id'     => $result['order_status_id'],
                    'shipping_code' => $result['shipping_code'],
                    'total'      => $this->currency->format($result['total'], $this->options['currency']['code'], $this->options['currency']['value'], true),
                    'created_at' => Carbon::createFromTimeStamp(strtotime($result['created_at'])),
                    'updated_at' => Carbon::createFromTimeStamp(strtotime($result['updated_at'])),
                );
            }
        }
        

        if(!empty($this->rows)) {
            $i = 0;
            foreach($this->rows as $row) {
                if($order_statuses) {
                    foreach ($order_statuses as $status) {
                            $selected = ($row['order_status_id'] == $status['id']) ? "selected" : "";
                        $option .= '<option '.$selected.' value="'.$status['id'].'">'.$status['name'].'</option>';
                    }
                }
                $this->data[$i][] = '<td class="text-center">
                                                <label class="css-control css-control-primary css-checkbox">
                                                    <input type="checkbox" class="css-control-input selectCheckbox" value="'.$row['id'].'" name="selected[]">
                                                    <span class="css-control-indicator"></span>
                                                </label>
                                            </td>';
                $this->data[$i][] = '<td>'.$row['order_id'].'</td>';
                $this->data[$i][] = '<td>'.$row['customer'].'</td>';
                $this->data[$i][] = '<td>'.$row['shipping_code'].'</td>';
                $this->data[$i][] = '<td>'.$row['total'].'</td>';
                $this->data[$i][] = '<td>
                                            <select data-id="'.$row['id'].'" name="status" class="form-control select floating updateStatus" id="input-payment-status" >
                                               '.$option.'
                                            </select>
                                         </td>';
                $this->data[$i][] = '<td>'.$row['created_at'].'</td>';
                $this->data[$i][] = '<td>'.$row['updated_at'].'</td>';
                $this->data[$i][] = '<td class="text-right">
                                    <div class="dropdown">
                                        <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
                                        <ul class="dropdown-menu pull-right">
                                            <li><a class="view" href="'.url('shop/order/info/'.$row['id']).'" ><i class="fa fa-eye m-r-5"></i> View</a></li>
                                        </ul>
                                    </div>
                                </td>
                            ';
                $i++;
            }
        }
        

        if($this->data) {
            return $this->output
                ->set_content_type('application/json')
                ->set_status_header(200)
                ->set_output(json_encode(array('data' => $this->data)));
        } else {
            return $this->output
                ->set_content_type('application/json')
                ->set_status_header(200)
                ->set_output(json_encode(array('data' => [])));
        }
    }

    /**
     * @return mixed
     */
    public function onClickStatusEventHandler() {
        if($this->isAjaxRequest()) {
            $this->request = $this->input->post();
            if(isset($this->request['order_status_id']) && isset($this->request['order_id'])) {
                Order_model::factory()->update(['order_status_id' => $this->request['order_status_id']], ['id' => $this->request['order_id']]);
                OrderHistory_model::factory()->update(['order_status_id' => $this->request['order_status_id']], ['order_id' => $this->request['order_id']]);
                $this->json['status'] = true;
                $this->json['message'] = 'Status has been successfully updated';
                return $this->output
                    ->set_content_type('application/json')
                    ->set_status_header(200)
                    ->set_output(json_encode($this->json));
            }
        }
    }

}