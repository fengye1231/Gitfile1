/**
 * 
 * @Title: LoanDaoImpl.java
 * @Package com.loan.dao.impl
 * @Description: 数据访问实现类
 * @author Administrator
 * @date 2012-2-28 下午04:19:33
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
	 * 查找所有贷款信息
	 */
	public List<Loan> findAll() {
		List<Loan> list = null;
		list = this.getSession().createQuery("from Loan loan").list();
		return list;
	}

	/**
	 * 增加贷款信息
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
						JOptionPane.showMessageDialog(null, "您添加的贷款信息已保存到数据库，可查询。", "提示", 2);
					}else {
						JOptionPane.showMessageDialog(null,
								"该学生的贷款信息已存在，一个学生只能有一个贷款编号。", "警告", 0);
					}
				}else {
					JOptionPane.showMessageDialog(null,
							"该贷款编号已存在，且贷款编号是唯一的，不可重复。", "警告", 0);
				}
			} else {
				JOptionPane.showMessageDialog(null,
						"该学生信息不存在,若有该贷款学生，请先添加学生基本休息。", "警告", 0);
			}
		} catch (Exception e) {
			b = false;
			e.printStackTrace();
		}
		return b;
	}

	/**
	 * 删除贷款信息
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
	 * 从数据库中查找一条数据
	 */
	public Loan findLoanById(String loanId) {
		return (Loan) getSession().get(Loan.class, loanId);
	}

	/**
	 * 修改贷款信息
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
	 * 根据条件查询贷款信息
	 */
	public List<Loan> searchLoan(String sql) {
		List<Loan> list = null;
		list = this.getSession().createQuery(sql).list();
		return list;
	}


	/**
	 * 根据NAME查找一条数据
	 */
	public List<Loan> findLoanByName(String sql) {
		List<Loan> list = null;
		list = this.getSession().createQuery(sql).list();
		return list;
	}

}
