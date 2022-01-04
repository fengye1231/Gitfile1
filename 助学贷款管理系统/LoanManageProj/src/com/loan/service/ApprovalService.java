/**
* 
* @Title: ApprovalService.java
* @Package com.loan.service
* @Description: 审批情况业务处理接口
* @author He ChangYan
* @date 2012-3-1 下午02:58:34
* @copyright STARIT   
*/
package com.loan.service;

import java.util.List;

import com.loan.entity.Approval;


public interface ApprovalService {

	/**查询所有审批情况*/
	public List<Approval> findAll();
}
