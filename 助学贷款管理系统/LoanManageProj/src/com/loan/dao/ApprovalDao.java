/**
* 
* @Title: ApprovalDao.java
* @Package com.loan.dao
* @Description: ����������ʽӿ�
* @author Administrator
* @date 2012-3-1 ����02:56:29
* @copyright STARIT   
*/
package com.loan.dao;

import java.util.List;

import com.loan.entity.Approval;


public interface ApprovalDao {

	/**��ѯ�����������*/
	public List<Approval> findAll();
}
