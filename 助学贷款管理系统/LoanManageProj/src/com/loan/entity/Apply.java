/**
 * 
 * @Title: Apply.java
 * @Package com.loan.entity
 * @Description: ������ʷʵ��
 * @author He ChangYan
 * @date 2012-3-3 ����10:20:49
 * @copyright STARIT   
 */
package com.loan.entity;


public class Apply {

	// Fields

	public int applyId;// �����¼��
	public String stuName;// ����
	public String stuIdentity;// ���֤��
	public String stuMobileTel;// �ƶ��绰
	public String stuFamilyTel;// ��ͥ�绰
	public String paymentAccount;// �����˺�
	public String paymentStyle;// ���ʽ
	public Integer paymentMoney;// ������

	public Loan loan;// ������
	public Approval approval;//�������
	
	// Constructors

	/** default constructor */
	public Apply() {
	}

	/** full constructor */
	public Apply(int applyId, Loan loan, String stuName, String stuIdentity,
			String stuMobileTel, String stuFamilyTel, String paymentAccount,
			String paymentStyle, Integer paymentMoney, Approval approval) {
		this.applyId = applyId;
		this.loan = loan;
		this.stuName = stuName;
		this.stuIdentity = stuIdentity;
		this.stuMobileTel = stuMobileTel;
		this.stuFamilyTel = stuFamilyTel;
		this.paymentAccount = paymentAccount;
		this.paymentStyle = paymentStyle;
		this.paymentMoney = paymentMoney;
		this.approval = approval;
	}

	// Property accessors

	public Integer getApplyId() {
		return this.applyId;
	}

	public void setApplyId(Integer applyId) {
		this.applyId = applyId;
	}

	public Loan getLoan() {
		return loan;
	}

	public void setLoan(Loan loan) {
		this.loan = loan;
	}

	public void setApplyId(int applyId) {
		this.applyId = applyId;
	}

	public void setPaymentMoney(int paymentMoney) {
		this.paymentMoney = paymentMoney;
	}

	public String getStuName() {
		return this.stuName;
	}

	public void setStuName(String stuName) {
		this.stuName = stuName;
	}

	public String getStuIdentity() {
		return this.stuIdentity;
	}

	public void setStuIdentity(String stuIdentity) {
		this.stuIdentity = stuIdentity;
	}

	public String getStuMobileTel() {
		return this.stuMobileTel;
	}

	public void setStuMobileTel(String stuMobileTel) {
		this.stuMobileTel = stuMobileTel;
	}

	public String getStuFamilyTel() {
		return this.stuFamilyTel;
	}

	public void setStuFamilyTel(String stuFamilyTel) {
		this.stuFamilyTel = stuFamilyTel;
	}

	public String getPaymentAccount() {
		return this.paymentAccount;
	}

	public void setPaymentAccount(String paymentAccount) {
		this.paymentAccount = paymentAccount;
	}

	public String getPaymentStyle() {
		return this.paymentStyle;
	}

	public void setPaymentStyle(String paymentStyle) {
		this.paymentStyle = paymentStyle;
	}

	public Integer getPaymentMoney() {
		return this.paymentMoney;
	}

	public void setPaymentMoney(Integer paymentMoney) {
		this.paymentMoney = paymentMoney;
	}

	public Approval getApproval() {
		return approval;
	}

	public void setApproval(Approval approval) {
		this.approval = approval;
	}

}