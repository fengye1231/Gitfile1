/**
 * 
 * @Title: AccountServiceImpl.java
 * @Package com.loan.service.impl
 * @Description: 账户信息业务处理实现类
 * @author He ChangYan
 * @date 2012-3-2 下午01:38:05
 * @copyright STARIT   
 */
package com.loan.service.impl;

import java.util.List;

import com.loan.dao.AccountDao;
import com.loan.entity.Account;
import com.loan.service.AccountService;

public class AccountServiceImpl implements AccountService {

	private AccountDao accountDao;// 实例DAO对象

	public AccountDao getAccountDao() {
		return accountDao;
	}

	public void setAccountDao(AccountDao accountDao) {
		this.accountDao = accountDao;
	}

	/*
	 * (非 Javadoc) <p>Title: findAll</p> <p>Description: 查询所有账户信息</p>
	 * 
	 * @return
	 * 
	 * @see com.loan.service.AccountService#findAll()
	 */
	public List<Account> findAll() {
		return accountDao.findAll();
	}

	/*
	 * (非 Javadoc) <p>Title: delAccount</p> <p>Description: 删除对应的账户信息</p>
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
	 * (非 Javadoc) <p>Title: addAccount</p> <p>Description: 增加账户信息</p>
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
	 * (非 Javadoc) <p>Title: findAccountById</p> <p>Description:
	 * 在数据库中查找到一条数据</p>
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
	 * (非 Javadoc) <p>Title: updateAccount</p> <p>Description: 修改账户信息</p>
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
	 * (非 Javadoc) <p>Title: findAccountByName</p> <p>Description:
	 * 根据NAME查找一条数据</p>
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
	 * (非 Javadoc) <p>Title: searchLoan</p> <p>Description: 根据条件查询账户信息</p>
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
