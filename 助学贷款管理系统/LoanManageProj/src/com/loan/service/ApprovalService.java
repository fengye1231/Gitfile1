/**
* 
* @Title: ApprovalService.java
* @Package com.loan.service
* @Description: �������ҵ����ӿ�
* @author He ChangYan
* @date 2012-3-1 ����02:58:34
* @copyright STARIT   
*/
package com.loan.service;

import java.util.List;

import com.loan.entity.Approval;


public interface ApprovalService {

	/**��ѯ�����������*/
	public List<Approval> findAll();
}
