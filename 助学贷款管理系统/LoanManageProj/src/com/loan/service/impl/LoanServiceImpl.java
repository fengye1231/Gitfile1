/**
 * 
 * @Title: LoanServiceImpl.java
 * @Package com.loan.service.impl
 * @Description: ������Ϣ��ʵ�ַ�����Ľӿڵ�ʵ����
 * @author He ChangYan
 * @date 2012-2-28 ����04:12:25
 * @copyright STARIT   
 */
package com.loan.service.impl;

import java.util.List;

import com.loan.dao.LoanDao;
import com.loan.entity.Loan;
import com.loan.service.LoanService;

public class LoanServiceImpl implements LoanService {

	private LoanDao loanDao;// ʵ��DAO����

	public LoanDao getLoanDao() {
		return loanDao;
	}

	public void setLoanDao(LoanDao loanDao) {
		this.loanDao = loanDao;
	}

	/*
	 * (�� Javadoc) <p>Title: findAll</p>
	 * 
	 * <p>Description: �������д�����Ϣ</p>
	 * 
	 * @return
	 * 
	 * @see com.loan.service.LoanService#findAll()
	 */
	public List<Loan> findAll() {

		return loanDao.findAll();
	}

	/*
	 * (�� Javadoc) <p>Title: addLoan</p> <p>Description: ���Ӵ�����Ϣ</p>
	 * 
	 * @param loan
	 * 
	 * @return
	 * 
	 * @see com.loan.service.LoanService#addLoan(com.loan.entity.Loan)
	 */
	public boolean addLoan(Loan loan) {
		return loanDao.addLoan(loan);
	}

	/*
	 * (�� Javadoc) <p>Title: delLoan</p> <p>Description: ɾ��������Ϣ</p>
	 * 
	 * @param loan
	 * 
	 * @return
	 * 
	 * @see com.loan.service.LoanService#delLoan(com.loan.entity.Loan)
	 */
	public boolean delLoan(Loan loan) {
		return loanDao.delLoan(loan);
	}

	/*
	 * (�� Javadoc) <p>Title: findLoanById</p> <p>Description: �����ݿ��в���һ������</p>
	 * 
	 * @param loanId
	 * 
	 * @return
	 * 
	 * @see com.loan.service.LoanService#findLoanById(java.lang.String)
	 */
	public Loan findLoanById(String loanId) {
		return loanDao.findLoanById(loanId);
	}

	/*
	 * (�� Javadoc) <p>Title: updateLoan</p> <p>Description: �޸Ĵ�����Ϣ</p>
	 * 
	 * @param loan
	 * 
	 * @see com.loan.service.LoanService#updateLoan(com.loan.entity.Loan)
	 */
	public void updateLoan(Loan loan) {
		loanDao.updateLoan(loan);
	}

	/*
	 * (�� Javadoc) <p>Title: searchStu</p> <p>Description: ����������ѯ������Ϣ</p>
	 * 
	 * @param sql
	 * 
	 * @return
	 * 
	 * @see com.loan.service.LoanService#searchStu(java.lang.String)
	 */
	public List<Loan> searchLoan(String sql) {
		return loanDao.searchLoan(sql);
	}

	/*
	 * (�� Javadoc) <p>Title: findLoanByName</p> <p>Description: ����NAME����һ������</p>
	 * 
	 * @param sql
	 * 
	 * @return
	 * 
	 * @see com.loan.service.LoanService#findLoanByName(java.lang.String)
	 */
	public List<Loan> findLoanByName(String sql) {
		return loanDao.findLoanByName(sql);
	}

}
