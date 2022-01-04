/**
 * 
 * @Title: ApplyServiceImpl.java
 * @Package com.loan.service.impl
 * @Description: 申请提前还款业务实现类
 * @author He ChangYan
 * @date 2012-3-26 上午10:37:39
 * @copyright STARIT   
 */
package com.loan.service.impl;

import java.util.List;

import com.loan.dao.ApplyDao;
import com.loan.entity.Apply;
import com.loan.service.ApplyService;

public class ApplyServiceImpl implements ApplyService {

	private ApplyDao applyDao;// 实例DAO对象

	public ApplyDao getApplyDao() {
		return applyDao;
	}

	public void setApplyDao(ApplyDao applyDao) {
		this.applyDao = applyDao;
	}

	/*
	 * (非 Javadoc) <p>Title: findAll</p> <p>Description: 查询所有申请记录</p>
	 * 
	 * @return
	 * 
	 * @see com.loan.service.ApplyService#findAll()
	 */
	public List<Apply> findAll() {
		return applyDao.findAll();
	}

	/*
	 * (非 Javadoc) <p>Title: addApply</p> <p>Description: 添加申请提前还款记录</p>
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
	 * (非 Javadoc) <p>Title: findApplyById</p> <p>Description: 从数据库
	 * 中查找对应的申请信息</p>
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
	 * (非 Javadoc) <p>Title: updateApply</p> <p>Description: 修改申请信息</p>
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
	 * (非 Javadoc) <p>Title: findApplyByName</p> <p>Description: 根据姓名查找申请信息</p>
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
	 * (非 Javadoc) <p>Title: delApply</p> <p>Description: 删除申请记录</p>
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
