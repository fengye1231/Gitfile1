/**
* 
* @Title: AccountService.java
* @Package com.loan.service
* @Description: 账户信息业务处理接口
* @author He ChangYan
* @date 2012-3-2 下午01:37:10
* @copyright STARIT   
*/
package com.loan.service;

import java.util.List;

import com.loan.entity.Account;


public interface AccountService {

	/**查询所有账户信息*/
	public List<Account> findAll();
	
	/**删除对应的账户信息*/
	public boolean delAccount(Account delAccount);
	
	/**增加账户信息*/
	public boolean addAccount(Account addAccount);
	
	/**根据ID查找一条数据*/
	public Account findAccountById(int accountId);
	
	/**根据NAME查找一条数据*/
	public List<Account> findAccountByName(String sql);
	
	/**修改账户信息*/
	public boolean updateAccount(Account updateAccount);
	
	/**根据条件查询账户信息*/
	public List<Account> searchAccount(String sql);
}
