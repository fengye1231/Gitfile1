/**
 * 
 * @Title: AccountAction.java
 * @Package com.loan.action
 * @Description: 账户信息处理
 * @author He ChangYan
 * @date 2012-3-2 下午01:34:09
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
	private List<Account> accountList;// 实例对象
	private List<Account> singleAccount;// 实例对象
	private AccountService accountService;// 实例化service对象

	/* get和set方法 */

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
	 * @Description: 查询所有账户信息
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
	 * @Description: 根据NAME查找一条数据
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
			String msg = "您查找的账户信息不存在!请添加相应的账户信息。";
			JOptionPane.showMessageDialog(null, msg, "警告", 0);// 弹出提示信息对话框
			mg = "addMyAccount";
		}
		return mg;
	}

	/**
	 * 
	 * @Title: delAccount
	 * @Description: 删除账户信息
	 * @return
	 * @return String
	 * @throws
	 */
	public String delAccount() {
		Account accountDel = accountService.findAccountById(delAccount
				.getAccountId());
		accountService.delAccount(accountDel);
		JOptionPane.showMessageDialog(null, "数据删除成功。", "提示", 2);
		return list();
	}

	/**
	 * 
	 * @Title: addAccount
	 * @Description: 增加账户信息
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
	 * @Description: 从数据库中查找到一条数据
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
	 * @Description: 修改账信息
	 * @return
	 * @return String
	 * @throws
	 */
	public String updateAccount() {
		accountService.updateAccount(updateAccount);
		JOptionPane.showMessageDialog(null, "数据修改成功。", "提示", 2);
		return list();
	}
	
	/**
	 * 
	 * @Title: addMyAccount
	 * @Description: 增加账户信息
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
	 * @Description: 从数据库中查找到一条数据
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
	 * @Description: 修改账信息
	 * @return 
	 * @return String
	 * @throws
	 */
	public String updateMyAccount() {
		accountService.updateAccount(updateAccount);
		JOptionPane.showMessageDialog(null, "数据修改成功。", "提示", 2);
		return findAccountByName();
	}

	/**
	 * 
	 * @Title: searchAccount
	 * @Description: 根据条件查询账户信息
	 * @return
	 * @return String
	 * @throws
	 */
	public String searchAccount() {
		String sql = "from Account where LoanId = '" + account.loan.loanId
				+ "'";
		accountList = accountService.searchAccount(sql);
		if (accountList.size() == 0) {
			String msg = "您查找的账户信息不存在!请检查输入是否有误。";
			JOptionPane.showMessageDialog(null, msg, "警告", 0);// 弹出提示信息对话框
		}
		return "searchAccount";
	}
}
