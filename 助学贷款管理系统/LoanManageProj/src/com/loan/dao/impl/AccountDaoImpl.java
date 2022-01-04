/**
 * 
 * @Title: AccountDaoImpl.java
 * @Package com.loan.dao.impl
 * @Description: �˻���Ϣ���ݴ���
 * @author He ChangYan
 * @date 2012-3-2 ����01:36:08
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
	 * ��ѯ�����˻���Ϣ
	 */
	public List<Account> findAll() {
		List<Account> list = null;
		list = this.getSession().createQuery("from Account account").list();
		return list;
	}

	/**
	 * ɾ����Ӧ���˻���Ϣ
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
	 * �����˻���Ϣ
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
					JOptionPane.showMessageDialog(null, "����ӵ��˻���Ϣ�ѱ��浽���ݿ⣬�ɲ�ѯ��",
							"��ʾ", 2);
				} else {
					JOptionPane.showMessageDialog(null,
							"�����ӵĴ����Ŷ�Ӧ���˻���Ϣ�Ѵ��ڣ������ظ���ӡ�", "����", 0);
				}
			} else {
				JOptionPane.showMessageDialog(null, "�����ӵĴ����Ų����ڡ�", "����", 0);
			}

		} catch (Exception e) {
			b = false;
			e.printStackTrace();
		}
		return b;
	}

	/**
	 * ����һ������
	 */
	public Account findAccountById(int accountId) {
		return (Account) getSession().get(Account.class, accountId);
	}

	/**
	 * �޸Ķ�Ӧ���˻���Ϣ
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
	 * ����NAME����һ������
	 */
	public List<Account> findAccountByName(String sql) {
		List<Account> list = null;
		list = this.getSession().createQuery(sql).list();
		return list;
	}

	/**
	 * ����������ѯ�˻���Ϣ
	 */
	public List<Account> searchAccount(String sql) {
		List<Account> list = null;
		list = this.getSession().createQuery(sql).list();
		return list;
	}
}
