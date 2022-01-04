/**
 * 
 * @Title: ApprovalServiceImpl.java
 * @Package com.loan.service.impl
 * @Description: �������ҵ����ʵ��
 * @author Administrator
 * @date 2012-3-1 ����02:59:44
 * @copyright STARIT   
 */
package com.loan.service.impl;

import java.util.List;

import com.loan.dao.ApprovalDao;
import com.loan.entity.Approval;
import com.loan.service.ApprovalService;

public class ApprovalServiceImpl implements ApprovalService {

	private ApprovalDao approvalDao;// ʵ��DAO����

	public ApprovalDao getApprovalDao() {
		return approvalDao;
	}

	public void setApprovalDao(ApprovalDao approvalDao) {
		this.approvalDao = approvalDao;
	}

	/*
	 * (�� Javadoc) <p>Title: findAll</p> <p>Description: ��������������Ϣ</p>
	 * 
	 * @return
	 * 
	 * @see com.loan.service.ApprovalService#findAll()
	 */
	public List<Approval> findAll() {
		return approvalDao.findAll();
	}

}
