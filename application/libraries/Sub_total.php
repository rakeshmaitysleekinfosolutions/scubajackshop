<?php

class Sub_total{
	
	private $ci;
	public function __construct()
	{
		
		$this->ci = &get_instance();
		$this->ci->load->library('Customer');
		$this->ci->load->library('session');

	}

	public function getTotal($total) {

		$sub_total = $this->ci->ecart->getSubTotal();

		if (!empty($this->ci->session->userdata('vouchers'))) {
			foreach ($this->ci->session->userdata('vouchers') as $voucher) {
				$sub_total += $voucher['amount'];
			}
		}

		$total['totals'][] = array(
			'code'       => 'sub_total',
			'title'      => $this->ci->config->item('text_sub_total'),
			'value'      => $sub_total,
			'sort_order' => $this->ci->config->item('sub_total')['value']
		);

		$total['total'] += $sub_total;
	}
	public function factory($attr = array()) {
		return new Sub_total($attr);
	}
}
