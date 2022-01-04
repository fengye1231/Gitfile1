/**
* 
* @Title: ApplyDaoImpl.java
* @Package com.loan.dao.impl
* @Description: ������ǰ�������ݷ���ʵ����
* @author He ChangYan
* @date 2012-3-26 ����10:40:12
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
	 * ��ѯ���������¼
	 */
	public List<Apply> findAll(){
		List<Apply> list = null;
		list = this.getSession().createQuery("from Apply apply").list();
		return list;
	}
	
	/**
	 * ���������ǰ�����¼
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
				JOptionPane.showMessageDialog(null, "������ǰ����������Ϣ�ѱ��浽���ݿ⣬�ɲ�ѯ��", "��ʾ", 2);
			}else {
				JOptionPane.showMessageDialog(null,
						"���û���������Ϣ�Ѵ��ڣ������ظ����룬���޸�������Ϣ��", "����", 0);
			}
		} catch (Exception e) {
			b=false;
			e.printStackTrace();
		} 
		return b;
	}
	
	/**
	 * �����ݿ� �в��Ҷ�Ӧ��������Ϣ
	 */
	public Apply findApplyById(int applyId) {
		return (Apply)getSession().get(Apply.class, applyId);
	}
	
	/**
	 * �޸�������Ϣ
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
	 * ������������������Ϣ
	 */
	public List<Apply> findApplyByName(String sql) {
		List<Apply> list = null;
		list = this.getSession().createQuery(sql).list();
		return list;
	}
	
	/**
	 * ɾ�������¼
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
