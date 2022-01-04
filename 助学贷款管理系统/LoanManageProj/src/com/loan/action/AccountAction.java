/**
 * 
 * @Title: AccountAction.java
 * @Package com.loan.action
 * @Description: �˻���Ϣ����
 * @author He ChangYan
 * @date 2012-3-2 ����01:34:09
 * @copyright STARIT   
 */
package com.loan.action;

import java.util.List;

import javax.swing.JOptionPane;

import org.apache.struts2.ServletActionContext;

import com.loan.entity.Account;
import com.loan.service.AccountService;

public class AccountAction {

	private Account account;
	private Account delAccount;
	private Account addAccount;
	private Account updateAccount;
	private List<Account> accountList;// ʵ������
	private List<Account> singleAccount;// ʵ������
	private AccountService accountService;// ʵ����service����

	/* get��set���� */

	public Account getAccount() {
		return account;
	}

	public void setAccount(Account account) {
		this.account = account;
	}

	public Account getAddAccount() {
		return addAccount;
	}

	public void setAddAccount(Account addAccount) {
		this.addAccount = addAccount;
	}

	public Account getDelAccount() {
		return delAccount;
	}

	public void setDelAccount(Account delAccount) {
		this.delAccount = delAccount;
	}

	public Account getUpdateAccount() {
		return updateAccount;
	}

	public void setUpdateAccount(Account updateAccount) {
		this.updateAccount = updateAccount;
	}

	public List<Account> getAccountList() {
		return accountList;
	}

	public void setAccountList(List<Account> accountList) {
		this.accountList = accountList;
	}

	public AccountService getAccountService() {
		return accountService;
	}

	public void setAccountService(AccountService accountService) {
		this.accountService = accountService;
	}

	public List<Account> getSingleAccount() {
		return singleAccount;
	}

	public void setSingleAccount(List<Account> singleAccount) {
		this.singleAccount = singleAccount;
	}

	/**
	 * 
	 * @Title: list
	 * @Description: ��ѯ�����˻���Ϣ
	 * @return
	 * @return String
	 * @throws
	 */
	public String list() {
		accountList = accountService.findAll();
		return "list";
	}

	/**
	 * 
	 * @Title: findAccountByName
	 * @Description: ����NAME����һ������
	 * @return
	 * @return String
	 * @throws
	 */
	public String findAccountByName() {
		String mg = "singleAccount";
		String userName = (String)ServletActionContext.getRequest().getSession().getAttribute("name");
		String sql = "from Account a where LoanId in (" + "from Loan l where StuName = '" + userName +"'"+ ")";
		singleAccount = accountService.findAccountByName(sql);
		if (singleAccount.size() == 0) {
			String msg = "�����ҵ��˻���Ϣ������!�������Ӧ���˻���Ϣ��";
			JOptionPane.showMessageDialog(null, msg, "����", 0);// ������ʾ��Ϣ�Ի���
			mg = "addMyAccount";
		}
		return mg;
	}

	/**
	 * 
	 * @Title: delAccount
	 * @Description: ɾ���˻���Ϣ
	 * @return
	 * @return String
	 * @throws
	 */
	public String delAccount() {
		Account accountDel = accountService.findAccountById(delAccount
				.getAccountId());
		accountService.delAccount(accountDel);
		JOptionPane.showMessageDialog(null, "����ɾ���ɹ���", "��ʾ", 2);
		return list();
	}

	/**
	 * 
	 * @Title: addAccount
	 * @Description: �����˻���Ϣ
	 * @return
	 * @return String
	 * @throws
	 */
	public String addAccount() {
		accountService.addAccount(addAccount);
		return list();
	}

	/**
	 * 
	 * @Title: updateInput
	 * @Description: �����ݿ��в��ҵ�һ������
	 * @return
	 * @return String
	 * @throws
	 */
	public String updateInput() {
		updateAccount = accountService.findAccountById(updateAccount
				.getAccountId());
		return "updateInput";
	}

	/**
	 * 
	 * @Title: updateAccount
	 * @Description: �޸�����Ϣ
	 * @return
	 * @return String
	 * @throws
	 */
	public String updateAccount() {
		accountService.updateAccount(updateAccount);
		JOptionPane.showMessageDialog(null, "�����޸ĳɹ���", "��ʾ", 2);
		return list();
	}
	
	/**
	 * 
	 * @Title: addMyAccount
	 * @Description: �����˻���Ϣ
	 * @return
	 * @return String
	 * @throws
	 */
	public String addMyAccount() {
		accountService.addAccount(addAccount);
		return findAccountByName();
	}
	
	/**
	 * 
	 * @Title: updateInput
	 * @Description: �����ݿ��в��ҵ�һ������
	 * @return
	 * @return String
	 * @throws
	 */
	public String updateMyInput() {
		updateAccount = accountService.findAccountById(updateAccount
				.getAccountId());
		return "updateMyInput";
	}

	/**
	 * 
	 * @Title: updateAccount
	 * @Description: �޸�����Ϣ
	 * @return 
	 * @return String
	 * @throws
	 */
	public String updateMyAccount() {
		accountService.updateAccount(updateAccount);
		JOptionPane.showMessageDialog(null, "�����޸ĳɹ���", "��ʾ", 2);
		return findAccountByName();
	}

	/**
	 * 
	 * @Title: searchAccount
	 * @Description: ����������ѯ�˻���Ϣ
	 * @return
	 * @return String
	 * @throws
	 */
	public String searchAccount() {
		String sql = "from Account where LoanId = '" + account.loan.loanId
				+ "'";
		accountList = accountService.searchAccount(sql);
		if (accountList.size() == 0) {
			String msg = "�����ҵ��˻���Ϣ������!���������Ƿ�����";
			JOptionPane.showMessageDialog(null, msg, "����", 0);// ������ʾ��Ϣ�Ի���
		}
		return "searchAccount";
	}
}
