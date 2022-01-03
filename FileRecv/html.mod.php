<?php

/**
 * 模块：静态内容显示
 * @copyright (C)2011 Cenwor Inc.
 * @author Moyo <dev@uuland.org>
 * @package module
 * @name html.mod.php
 * @version 1.1
 */

class ModuleObject extends MasterObject
{
	function ModuleObject( $config )
	{
		$this->MasterObject($config);
		$runCode = Load::moduleCode($this, false, false);
		$this->load($runCode);
	}
	function load($pageName)
	{    
        $pconfig = ConfigHandler::get('product');   
		$html = logic('html')->query($pageName);
		if ($pageName=='sjhb' || $pageName=='whsc' || $pageName=='tcjd' || $pageName=='index'){
			$html=str_replace('default_purchase_cash',$pconfig['default_purchase_cash'],$html);
			$html=str_replace('default_hkd_purchase_cash',$pconfig['default_hkd_purchase_cash'],$html);
			$html=str_replace('default_eur_purchase_cash',$pconfig['default_eur_purchase_cash'],$html);
			$html=str_replace('default_jpy_purchase_cash',$pconfig['default_jpy_purchase_cash'],$html);
			$html=str_replace('default_krw_purchase_cash',$pconfig['default_krw_purchase_cash'],$html);
			$html=str_replace('default_gbp_purchase_cash',$pconfig['default_gbp_purchase_cash'],$html);
			$html=str_replace('default_aud_purchase_cash',$pconfig['default_aud_purchase_cash'],$html);
			$html=str_replace('default_cad_purchase_cash',$pconfig['default_cad_purchase_cash'],$html);
			$html=str_replace('default_chf_purchase_cash',$pconfig['default_chf_purchase_cash'],$html);
			$html=str_replace('default_nzd_purchase_cash',$pconfig['default_nzd_purchase_cash'],$html);
			$html=str_replace('default_sgd_purchase_cash',$pconfig['default_sgd_purchase_cash'],$html);
			$html=str_replace('default_hkc_purchase_cash',$pconfig['default_hkc_purchase_cash'],$html);
			$html=str_replace('default_btc_purchase_cash',$pconfig['default_btc_purchase_cash'],$html);
			$html=str_replace('default_eth_purchase_cash',$pconfig['default_eth_purchase_cash'],$html);
			$html=str_replace('default_spot_selling_rate',$pconfig['default_spot_selling_rate'],$html);
			$html=str_replace('default_eur_spot_selling_rate',$pconfig['default_eur_spot_selling_rate'],$html);
			$html=str_replace('default_hkd_spot_selling_rate',$pconfig['default_hkd_spot_selling_rate'],$html);
			$html=str_replace('default_jpy_spot_selling_rate',$pconfig['default_jpy_spot_selling_rate'],$html);
			$html=str_replace('default_krw_spot_selling_rate',$pconfig['default_krw_spot_selling_rate'],$html);
			$html=str_replace('default_gbp_spot_selling_rate',$pconfig['default_gbp_spot_selling_rate'],$html);
			$html=str_replace('default_aud_spot_selling_rate',$pconfig['default_aud_spot_selling_rate'],$html);
			$html=str_replace('default_cad_spot_selling_rate',$pconfig['default_cad_spot_selling_rate'],$html);
			$html=str_replace('default_chf_spot_selling_rate',$pconfig['default_chf_spot_selling_rate'],$html);
			$html=str_replace('default_nzd_spot_selling_rate',$pconfig['default_nzd_spot_selling_rate'],$html);
			$html=str_replace('default_sgd_spot_selling_rate',$pconfig['default_sgd_spot_selling_rate'],$html);
			$html=str_replace('default_hkc_spot_selling_rate',$pconfig['default_hkc_spot_selling_rate'],$html);
			$html=str_replace('default_btc_spot_selling_rate',$pconfig['default_btc_spot_selling_rate'],$html);
			$html=str_replace('default_eth_spot_selling_rate',$pconfig['default_eth_spot_selling_rate'],$html);
			// 
			$html=str_replace('usa_purchase_cash',$pconfig['usa_purchase_cash'],$html);
			$html=str_replace('usa_hkd_purchase_cash',$pconfig['usa_hkd_purchase_cash'],$html);
			$html=str_replace('usa_eur_purchase_cash',$pconfig['usa_eur_purchase_cash'],$html);
			$html=str_replace('usa_jpy_purchase_cash',$pconfig['usa_jpy_purchase_cash'],$html);
			$html=str_replace('usa_krw_purchase_cash',$pconfig['usa_krw_purchase_cash'],$html);
			$html=str_replace('usa_gbp_purchase_cash',$pconfig['usa_gbp_purchase_cash'],$html);
			$html=str_replace('usa_aud_purchase_cash',$pconfig['usa_aud_purchase_cash'],$html);
			$html=str_replace('usa_cad_purchase_cash',$pconfig['usa_cad_purchase_cash'],$html);
			$html=str_replace('usa_chf_purchase_cash',$pconfig['usa_chf_purchase_cash'],$html);
			$html=str_replace('usa_nzd_purchase_cash',$pconfig['usa_nzd_purchase_cash'],$html);
			$html=str_replace('usa_sgd_purchase_cash',$pconfig['usa_sgd_purchase_cash'],$html);
			$html=str_replace('usa_hkc_purchase_cash',$pconfig['usa_hkc_purchase_cash'],$html);
			$html=str_replace('usa_btc_purchase_cash',$pconfig['usa_btc_purchase_cash'],$html);
			$html=str_replace('usa_eth_purchase_cash',$pconfig['usa_eth_purchase_cash'],$html);
			$html=str_replace('usa_spot_selling_rate',$pconfig['usa_spot_selling_rate'],$html);
			$html=str_replace('usa_eur_spot_selling_rate',$pconfig['usa_eur_spot_selling_rate'],$html);
			$html=str_replace('usa_hkd_spot_selling_rate',$pconfig['usa_hkd_spot_selling_rate'],$html);
			$html=str_replace('usa_jpy_spot_selling_rate',$pconfig['usa_jpy_spot_selling_rate'],$html);
			// $html=str_replace('usa_krw_spot_selling_rate',$pconfig['usa_krw_spot_selling_rate'],$html);
			$html=str_replace('usa_gbp_spot_selling_rate',$pconfig['usa_gbp_spot_selling_rate'],$html);
			$html=str_replace('usa_aud_spot_selling_rate',$pconfig['usa_aud_spot_selling_rate'],$html);
			$html=str_replace('usa_cad_spot_selling_rate',$pconfig['usa_cad_spot_selling_rate'],$html);
			$html=str_replace('usa_chf_spot_selling_rate',$pconfig['usa_chf_spot_selling_rate'],$html);
			$html=str_replace('usa_nzd_spot_selling_rate',$pconfig['usa_nzd_spot_selling_rate'],$html);
			$html=str_replace('usa_sgd_spot_selling_rate',$pconfig['usa_sgd_spot_selling_rate'],$html);
			$html=str_replace('usa_hkc_spot_selling_rate',$pconfig['usa_hkc_spot_selling_rate'],$html);
			$html=str_replace('usa_btc_spot_selling_rate',$pconfig['usa_btc_spot_selling_rate'],$html);
			$html=str_replace('usa_eth_spot_selling_rate',$pconfig['usa_eth_spot_selling_rate'],$html);
		}
		//$this->Title = $html['title'];
        $this->Title = '首页';
		include handler('template')->file('html_static');
	}

    
}

?>