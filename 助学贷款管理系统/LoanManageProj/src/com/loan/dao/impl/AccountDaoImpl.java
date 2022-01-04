/**
 * 
 * @Title: AccountDaoImpl.java
 * @Package com.loan.dao.impl
 * @Description: 账户信息数据处理
 * @author He ChangYan
 * @date 2012-3-2 下午01:36:08
 * @copyright STARIT   
 */
package com.loan.dao.impl;

import java.util.List;

import javax.swing.JOptionPane;

import org.springframework.orm.hibernate3.support.HibernateDaoSupport;

import com.loan.dao.AccountDao;
import com.loan.entity.Account;

public class AccountDaoImpl extends HibernateDaoSupport implements AccountDao {

	/**
	 * 查询所有账户信息
	 */
	public List<Account> findAll() {
		List<Account> list = null;
		list = this.getSession().createQuery("from Account account").list();
		return list;
	}

	/**
	 * 删除对应的账户信息
	 */
	public boolean delAccount(Account delAccount) {
		boolean b = true;
		try {
			this.getSession().delete(delAccount);
		} catch (Exception e) {
			b = false;
			e.printStackTrace();
		}
		return b;
	}

	/**
	 * 增加账户信息
	 */
	public boolean addAccount(Account addAccount) {
		boolean b = true;
		try {
			String sql = "from Loan l where LoanId = '"
					+ addAccount.getLoan().getLoanId() + "'";
			List<Account> list = null;
			list = this.getSession().createQuery(sql).list();
			if (list.size() > 0) {
				String sql1 = "from Account a where LoanId = '"
						+ addAccount.getLoan().getLoanId() + "'";
				List<Account> list1 = null;
				list1 = this.getSession().createQuery(sql1).list();
				if (list1.size() == 0) {
					this.getSession().save(addAccount);
					JOptionPane.showMessageDialog(null, "您添加的账户信息已保存到数据库，可查询。",
							"提示", 2);
				} else {
					JOptionPane.showMessageDialog(null,
							"您增加的贷款编号对应的账户信息已存在，不可重复添加。", "警告", 0);
				}
			} else {
				JOptionPane.showMessageDialog(null, "您增加的贷款编号不存在。", "警告", 0);
			}

		} catch (Exception e) {
			b = false;
			e.printStackTrace();
		}
		return b;
	}

	/**
	 * 查找一条数据
	 */
	public Account findAccountById(int accountId) {
		return (Account) getSession().get(Account.class, accountId);
	}

	/**
	 * 修改对应的账户信息
	 */
	public boolean updateAccount(Account updateAccount) {
		boolean b = true;
		try {
			this.getSession().update(updateAccount);
		} catch (Exception e) {
			b = false;
			e.printStackTrace();
		}
		return b;
	}

	/**
	 * 根据NAME查找一条数据
	 */
	public List<Account> findAccountByName(String sql) {
		List<Account> list = null;
		list = this.getSession().createQuery(sql).list();
		return list;
	}

	/**
	 * 根据条件查询账户信息
	 */
	public List<Account> searchAccount(String sql) {
		List<Account> list = null;
		list = this.getSession().createQuery(sql).list();
		return list;
	}
}
