/**
* 
* @Title: ApprovalDao.java
* @Package com.loan.dao
* @Description: 审批情况访问接口
* @author Administrator
* @date 2012-3-1 下午02:56:29
* @copyright STARIT   
*/
package com.loan.dao;

import java.util.List;

import com.loan.entity.Approval;


public interface ApprovalDao {

	/**查询所有审批情况*/
	public List<Approval> findAll();
}
