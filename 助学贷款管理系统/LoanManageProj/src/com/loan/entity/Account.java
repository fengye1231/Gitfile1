/**
 * 
 * @Title: Account.java
 * @Package com.loan.entity
 * @Description: 账户信息实体
 * @author He ChangYan
 * @date 2012-3-2 下午01:20:49
 * @copyright STARIT   
 */
package com.loan.entity;

public class Account {

	// Fields

	public int accountId;// 账户编号
	public Loan loan;// 贷款编号
	public Double loanAccount;// 贷款金额
	public String paymentAccount;// 还款账号
	public String paymentStyle;// 还款方式
	public Double balance;// 贷款余额

	// Constructors

	/** default constructor */
	public Account() {
	}

	/** full constructor */
	public Account(int accountId, Loan loan, Double loanAccount,
			String paymentAccount, String paymentStyle, Double balance) {
		this.accountId = accountId;
		this.loan = loan;
		this.loanAccount = loanAccount;
		this.paymentAccount = paymentAccount;
		this.paymentStyle = paymentStyle;
		this.balance = balance;
	}

	// Property accessors

	public int getAccountId() {
		return accountId;
	}

	public void setAccountId(int accountId) {
		this.accountId = accountId;
	}

	public Loan getLoan() {
		return loan;
	}

	public void setLoan(Loan loan) {
		this.loan = loan;
	}

	public Double getLoanAccount() {
		return loanAccount;
	}

	public void setLoanAccount(Double loanAccount) {
		this.loanAccount = loanAccount;
	}

	public String getPaymentAccount() {
		return paymentAccount;
	}

	public void setPaymentAccount(String paymentAccount) {
		this.paymentAccount = paymentAccount;
	}

	public String getPaymentStyle() {
		return paymentStyle;
	}

	public void setPaymentStyle(String paymentStyle) {
		this.paymentStyle = paymentStyle;
	}

	public Double getBalance() {
		return balance;
	}

	public void setBalance(Double balance) {
		this.balance = balance;
	}
}
