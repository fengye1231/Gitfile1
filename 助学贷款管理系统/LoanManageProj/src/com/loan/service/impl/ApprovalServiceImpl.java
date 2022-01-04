/**
 * 
 * @Title: ApprovalServiceImpl.java
 * @Package com.loan.service.impl
 * @Description: 审批情况业务处理实现
 * @author Administrator
 * @date 2012-3-1 下午02:59:44
 * @copyright STARIT   
 */
package com.loan.service.impl;

import java.util.List;

import com.loan.dao.ApprovalDao;
import com.loan.entity.Approval;
import com.loan.service.ApprovalService;

public class ApprovalServiceImpl implements ApprovalService {

	private ApprovalDao approvalDao;// 实例DAO对象

	public ApprovalDao getApprovalDao() {
		return approvalDao;
	}

	public void setApprovalDao(ApprovalDao approvalDao) {
		this.approvalDao = approvalDao;
	}

	/*
	 * (非 Javadoc) <p>Title: findAll</p> <p>Description: 查找所有审批信息</p>
	 * 
	 * @return
	 * 
	 * @see com.loan.service.ApprovalService#findAll()
	 */
	public List<Approval> findAll() {
		return approvalDao.findAll();
	}

}
