/**
 * 
 * @Title: LoanDao.java
 * @Package com.loan.dao
 * @Description: ������Ϣ���ݷ��ʽӿ���
 * @author He ChangYan
 * @date 2012-2-28 ����03:56:03
 * @copyright STARIT   
 */
package com.loan.dao;

import java.util.List;

import com.loan.entity.Loan;

public interface LoanDao {

	/** �������д�����Ϣ */
	public List<Loan> findAll();

	/** ���Ӵ�����Ϣ */
	public boolean addLoan(Loan loan);

	/** ɾ��������Ϣ */
	public boolean delLoan(Loan loan);

	/** ����һ������ */
	public Loan findLoanById(String loanId);

	/** �޸Ĵ�����Ϣ */
	public boolean updateLoan(Loan loan);

	/** ����������ѯ���� */
	public List<Loan> searchLoan(String sql);
	
	/** ����NAME����һ������ */
	public List<Loan> findLoanByName(String sql);
}
