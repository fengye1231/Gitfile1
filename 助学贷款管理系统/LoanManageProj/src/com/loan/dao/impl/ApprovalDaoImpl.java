/**
* 
* @Title: ApprovalDaoImpl.java
* @Package com.loan.dao.impl
* @Description: 审批情况数据访问实现
* @author He ChangYan
* @date 2012-3-1 下午02:57:37
* @copyright STARIT   
*/
package com.loan.dao.impl;

import java.util.List;

import org.springframework.orm.hibernate3.support.HibernateDaoSupport;

import com.loan.dao.ApprovalDao;
import com.loan.entity.Approval;


public class ApprovalDaoImpl extends HibernateDaoSupport implements ApprovalDao {

	/**
	 * 查找所有审批信息
	 */
	public List<Approval> findAll() {
		List<Approval> list = null;
		list = this.getSession().createQuery("from ApprovalInfo a").list();
		return list;
	}

}
