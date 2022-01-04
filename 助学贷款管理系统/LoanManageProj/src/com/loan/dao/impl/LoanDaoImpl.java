/**
 * 
 * @Title: LoanDaoImpl.java
 * @Package com.loan.dao.impl
 * @Description: ���ݷ���ʵ����
 * @author Administrator
 * @date 2012-2-28 ����04:19:33
 * @copyright STARIT   
 */
package com.loan.dao.impl;

import java.util.List;

import javax.swing.JOptionPane;

import org.springframework.orm.hibernate3.support.HibernateDaoSupport;

import com.loan.dao.LoanDao;
import com.loan.entity.Loan;

public class LoanDaoImpl extends HibernateDaoSupport implements LoanDao {

	/**
	 * �������д�����Ϣ
	 */
	public List<Loan> findAll() {
		List<Loan> list = null;
		list = this.getSession().createQuery("from Loan loan").list();
		return list;
	}

	/**
	 * ���Ӵ�����Ϣ
	 */
	public boolean addLoan(Loan loan) {
		boolean b = true;
		try {
			String sql = "from Student s where StuId = '"
					+ loan.getStudent().getStuId() + "'";
			List<Loan> list = null;
			list = this.getSession().createQuery(sql).list();
			if (list.size() > 0) {
				String sql1 = "from Loan l where LoanId = '"
					+ loan.getLoanId() + "'";
				List<Loan> list1 = null;
				list1 = this.getSession().createQuery(sql1).list();
				if(list1.size() == 0){
					String sql2 = "from Loan l where StuId = '"
						+ loan.getStudent().getStuId() + "'";
					List<Loan> list2 = null;
					list2 = this.getSession().createQuery(sql2).list();
					if(list2.size() == 0){
						this.getSession().save(loan);
						JOptionPane.showMessageDialog(null, "����ӵĴ�����Ϣ�ѱ��浽���ݿ⣬�ɲ�ѯ��", "��ʾ", 2);
					}else {
						JOptionPane.showMessageDialog(null,
								"��ѧ���Ĵ�����Ϣ�Ѵ��ڣ�һ��ѧ��ֻ����һ�������š�", "����", 0);
					}
				}else {
					JOptionPane.showMessageDialog(null,
							"�ô������Ѵ��ڣ��Ҵ�������Ψһ�ģ������ظ���", "����", 0);
				}
			} else {
				JOptionPane.showMessageDialog(null,
						"��ѧ����Ϣ������,���иô���ѧ�����������ѧ��������Ϣ��", "����", 0);
			}
		} catch (Exception e) {
			b = false;
			e.printStackTrace();
		}
		return b;
	}

	/**
	 * ɾ��������Ϣ
	 */
	public boolean delLoan(Loan loan) {
		boolean b = true;
		try {
			this.getSession().delete(loan);
		} catch (Exception e) {
			b = false;
			e.printStackTrace();
		}
		return b;
	}

	/**
	 * �����ݿ��в���һ������
	 */
	public Loan findLoanById(String loanId) {
		return (Loan) getSession().get(Loan.class, loanId);
	}

	/**
	 * �޸Ĵ�����Ϣ
	 */
	public boolean updateLoan(Loan loan) {
		boolean b = true;
		try {
			this.getSession().update(loan);
		} catch (Exception e) {
			b = false;
			e.printStackTrace();
		}
		return b;
	}

	/**
	 * ����������ѯ������Ϣ
	 */
	public List<Loan> searchLoan(String sql) {
		List<Loan> list = null;
		list = this.getSession().createQuery(sql).list();
		return list;
	}


	/**
	 * ����NAME����һ������
	 */
	public List<Loan> findLoanByName(String sql) {
		List<Loan> list = null;
		list = this.getSession().createQuery(sql).list();
		return list;
	}

}
