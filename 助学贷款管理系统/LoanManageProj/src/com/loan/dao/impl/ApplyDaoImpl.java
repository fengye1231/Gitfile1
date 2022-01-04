/**
* 
* @Title: ApplyDaoImpl.java
* @Package com.loan.dao.impl
* @Description: 申请提前还款数据访问实现类
* @author He ChangYan
* @date 2012-3-26 上午10:40:12
* @copyright STARIT   
*/
package com.loan.dao.impl;

import java.util.List;

import javax.swing.JOptionPane;

import org.springframework.orm.hibernate3.support.HibernateDaoSupport;

import com.loan.dao.ApplyDao;
import com.loan.entity.Apply;


public class ApplyDaoImpl extends HibernateDaoSupport implements ApplyDao {

	/**
	 * 查询所有申请记录
	 */
	public List<Apply> findAll(){
		List<Apply> list = null;
		list = this.getSession().createQuery("from Apply apply").list();
		return list;
	}
	
	/**
	 * 添加申请提前还款记录
	 */
	public boolean addApply(Apply addApply){
		boolean b=true;
		try {
			String sql = "from Apply a where LoanId = '"
				+ addApply.getLoan().loanId + "'";
			List<Apply> list = null;
			list = this.getSession().createQuery(sql).list();
			if(list.size() == 0){
				this.getSession().save(addApply);
				JOptionPane.showMessageDialog(null, "您的提前还款申请信息已保存到数据库，可查询。", "提示", 2);
			}else {
				JOptionPane.showMessageDialog(null,
						"该用户的申请信息已存在，不可重复申请，可修改申请信息。", "警告", 0);
			}
		} catch (Exception e) {
			b=false;
			e.printStackTrace();
		} 
		return b;
	}
	
	/**
	 * 从数据库 中查找对应的申请信息
	 */
	public Apply findApplyById(int applyId) {
		return (Apply)getSession().get(Apply.class, applyId);
	}
	
	/**
	 * 修改申请信息
	 */
	public boolean updateApply(Apply updateApply){
		boolean b=true;
		try {
			this.getSession().update(updateApply);
		} catch (Exception e) {
			b=false;
			e.printStackTrace();
		} 
		return b;
	}
	
	/**
	 * 根据姓名查找申请信息
	 */
	public List<Apply> findApplyByName(String sql) {
		List<Apply> list = null;
		list = this.getSession().createQuery(sql).list();
		return list;
	}
	
	/**
	 * 删除申请记录
	 */
	public boolean delApply(Apply delApply) {
		boolean b = true;
		try {
			this.getSession().delete(delApply);
		} catch (Exception e) {
			b = false;
			e.printStackTrace();
		}
		return b;
	}
}
