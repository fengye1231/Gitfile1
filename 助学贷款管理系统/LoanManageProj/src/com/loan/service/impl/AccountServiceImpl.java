/**
 * 
 * @Title: AccountServiceImpl.java
 * @Package com.loan.service.impl
 * @Description: �˻���Ϣҵ����ʵ����
 * @author He ChangYan
 * @date 2012-3-2 ����01:38:05
 * @copyright STARIT   
 */
package com.loan.service.impl;

import java.util.List;

import com.loan.dao.AccountDao;
import com.loan.entity.Account;
import com.loan.service.AccountService;

public class AccountServiceImpl implements AccountService {

	private AccountDao accountDao;// ʵ��DAO����

	public AccountDao getAccountDao() {
		return accountDao;
	}

	public void setAccountDao(AccountDao accountDao) {
		this.accountDao = accountDao;
	}

	/*
	 * (�� Javadoc) <p>Title: findAll</p> <p>Description: ��ѯ�����˻���Ϣ</p>
	 * 
	 * @return
	 * 
	 * @see com.loan.service.AccountService#findAll()
	 */
	public List<Account> findAll() {
		return accountDao.findAll();
	}

	/*
	 * (�� Javadoc) <p>Title: delAccount</p> <p>Description: ɾ����Ӧ���˻���Ϣ</p>
	 * 
	 * @param delAccount
	 * 
	 * @return
	 * 
	 * @see com.loan.service.AccountService#delAccount(com.loan.entity.Account)
	 */
	public boolean delAccount(Account delAccount) {
		return accountDao.delAccount(delAccount);
	}

	/*
	 * (�� Javadoc) <p>Title: addAccount</p> <p>Description: �����˻���Ϣ</p>
	 * 
	 * @param addAccount
	 * 
	 * @return
	 * 
	 * @see com.loan.service.AccountService#addAccount(com.loan.entity.Account)
	 */
	public boolean addAccount(Account addAccount) {
		return accountDao.addAccount(addAccount);
	}

	/*
	 * (�� Javadoc) <p>Title: findAccountById</p> <p>Description:
	 * �����ݿ��в��ҵ�һ������</p>
	 * 
	 * @param accountId
	 * 
	 * @return
	 * 
	 * @see com.loan.service.AccountService#findAccountById(int)
	 */
	public Account findAccountById(int accountId) {
		return accountDao.findAccountById(accountId);
	}

	/*
	 * (�� Javadoc) <p>Title: updateAccount</p> <p>Description: �޸��˻���Ϣ</p>
	 * 
	 * @param updateAccount
	 * 
	 * @return
	 * 
	 * @see
	 * com.loan.service.AccountService#updateAccount(com.loan.entity.Account)
	 */
	public boolean updateAccount(Account updateAccount) {
		return accountDao.updateAccount(updateAccount);
	}

	/*
	 * (�� Javadoc) <p>Title: findAccountByName</p> <p>Description:
	 * ����NAME����һ������</p>
	 * 
	 * @param name
	 * 
	 * @return
	 * 
	 * @see com.loan.service.AccountService#findAccountByName(java.lang.String)
	 */
	public List<Account> findAccountByName(String sql) {
		return accountDao.findAccountByName(sql);
	}

	/*
	 * (�� Javadoc) <p>Title: searchLoan</p> <p>Description: ����������ѯ�˻���Ϣ</p>
	 * 
	 * @param sql
	 * 
	 * @return
	 * 
	 * @see com.loan.service.AccountService#searchLoan(java.lang.String)
	 */
	public List<Account> searchAccount(String sql) {
		return accountDao.searchAccount(sql);
	}

}
