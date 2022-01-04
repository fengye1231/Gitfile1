/**
 * 
 * @Title: AccountDao.java
 * @Package com.loan.dao
 * @Description: �˻���Ϣ���ݷ��ʽӿ�
 * @author He ChangYan
 * @date 2012-3-2 ����01:34:56
 * @copyright STARIT   
 */
package com.loan.dao;

import java.util.List;

import com.loan.entity.Account;

public interface AccountDao {

	/** ��ѯ�����˻���Ϣ */
	public List<Account> findAll();

	/** ɾ����Ӧ���˻���Ϣ */
	public boolean delAccount(Account delAccount);

	/** �����˻���Ϣ */
	public boolean addAccount(Account addAccount);

	/** ����ID����һ������ */
	public Account findAccountById(int accountId);

	/** ����NAME����һ������ */
	public List<Account> findAccountByName(String sql);

	/** �޸��˻���Ϣ */
	public boolean updateAccount(Account updateAccount);
	
	/** ����������ѯ�˻���Ϣ */
	public List<Account> searchAccount(String sql);
}
