/**
 * 
 * @Title: ApplyServiceImpl.java
 * @Package com.loan.service.impl
 * @Description: ������ǰ����ҵ��ʵ����
 * @author He ChangYan
 * @date 2012-3-26 ����10:37:39
 * @copyright STARIT   
 */
package com.loan.service.impl;

import java.util.List;

import com.loan.dao.ApplyDao;
import com.loan.entity.Apply;
import com.loan.service.ApplyService;

public class ApplyServiceImpl implements ApplyService {

	private ApplyDao applyDao;// ʵ��DAO����

	public ApplyDao getApplyDao() {
		return applyDao;
	}

	public void setApplyDao(ApplyDao applyDao) {
		this.applyDao = applyDao;
	}

	/*
	 * (�� Javadoc) <p>Title: findAll</p> <p>Description: ��ѯ���������¼</p>
	 * 
	 * @return
	 * 
	 * @see com.loan.service.ApplyService#findAll()
	 */
	public List<Apply> findAll() {
		return applyDao.findAll();
	}

	/*
	 * (�� Javadoc) <p>Title: addApply</p> <p>Description: ���������ǰ�����¼</p>
	 * 
	 * @param addApply
	 * 
	 * @return
	 * 
	 * @see com.loan.service.ApplyService#addApply(com.loan.entity.Apply)
	 */
	public boolean addApply(Apply addApply) {
		return applyDao.addApply(addApply);
	}

	/*
	 * (�� Javadoc) <p>Title: findApplyById</p> <p>Description: �����ݿ�
	 * �в��Ҷ�Ӧ��������Ϣ</p>
	 * 
	 * @param applyId
	 * 
	 * @return
	 * 
	 * @see com.loan.service.ApplyService#findApplyById(int)
	 */
	public Apply findApplyById(int applyId) {
		return applyDao.findApplyById(applyId);
	}

	/*
	 * (�� Javadoc) <p>Title: updateApply</p> <p>Description: �޸�������Ϣ</p>
	 * 
	 * @param updateApply
	 * 
	 * @return
	 * 
	 * @see com.loan.service.ApplyService#updateApply(com.loan.entity.Apply)
	 */
	public boolean updateApply(Apply updateApply) {
		return applyDao.updateApply(updateApply);
	}

	/*
	 * (�� Javadoc) <p>Title: findApplyByName</p> <p>Description: ������������������Ϣ</p>
	 * 
	 * @param sql
	 * 
	 * @return
	 * 
	 * @see com.loan.service.ApplyService#findApplyByName(java.lang.String)
	 */
	public List<Apply> findApplyByName(String sql) {
		return applyDao.findApplyByName(sql);
	}

	/*
	 * (�� Javadoc) <p>Title: delApply</p> <p>Description: ɾ�������¼</p>
	 * 
	 * @param delApply
	 * 
	 * @return
	 * 
	 * @see com.loan.service.ApplyService#delApply(com.loan.entity.Apply)
	 */
	public boolean delApply(Apply delApply) {
		return applyDao.delApply(delApply);
	}
}
