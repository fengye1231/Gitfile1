/**
* 
* @Title: ApplyDao.java
* @Package com.loan.dao
* @Description: 申请提前还款数据访问接口
* @author He ChangYan
* @date 2012-3-26 上午10:39:15
* @copyright STARIT   
*/
package com.loan.dao;

import java.util.List;

import com.loan.entity.Apply;


public interface ApplyDao {

	/**查询所有申请记录*/
	public List<Apply> findAll();
	
	/**添加申请提前还款记录*/
	public boolean addApply(Apply addApply);
	
	/**从数据库 中查找对应的申请信息*/
	public Apply findApplyById(int applyId);
	
	/**修改申请信息*/
	public boolean updateApply(Apply updateApply);
	
	/**根据姓名查找申请信息*/
	public List<Apply> findApplyByName(String sql);
	
	/**删除申请记录*/
	public boolean delApply(Apply delApply);
}
