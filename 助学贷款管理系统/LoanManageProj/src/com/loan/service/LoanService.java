/**
 * 
 * @Title: LoanService.java
 * @Package com.loan.service
 * @Description: ������ӿ�
 * @author He ChangYan
 * @date 2012-2-28 ����04:10:36
 * @copyright STARIT   
 */
package com.loan.service;

import java.util.List;

import com.loan.entity.Loan;

public interface LoanService {

	/** �������д�����Ϣ */
	public List<Loan> findAll();

	/** ���Ӵ�����Ϣ */
	public boolean addLoan(Loan loan);

	/** ɾ��������Ϣ */
	public boolean delLoan(Loan loan);

	/** ����һ������ */
	public Loan findLoanById(String loanId);

	/** �޸Ĵ�����Ϣ */
	public void updateLoan(Loan loan);

	/** ����������ѯ���� */
	public List<Loan> searchLoan(String sql);
	
	/** ����NAME����һ������ */
	public List<Loan> findLoanByName(String sql);
}
