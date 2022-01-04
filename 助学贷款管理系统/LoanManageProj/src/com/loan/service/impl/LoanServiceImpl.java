/**
 * 
 * @Title: LoanServiceImpl.java
 * @Package com.loan.service.impl
 * @Description: 贷款信息的实现服务类的接口的实现类
 * @author He ChangYan
 * @date 2012-2-28 下午04:12:25
 * @copyright STARIT   
 */
package com.loan.service.impl;

import java.util.List;

import com.loan.dao.LoanDao;
import com.loan.entity.Loan;
import com.loan.service.LoanService;

public class LoanServiceImpl implements LoanService {

	private LoanDao loanDao;// 实例DAO对象

	public LoanDao getLoanDao() {
		return loanDao;
	}

	public void setLoanDao(LoanDao loanDao) {
		this.loanDao = loanDao;
	}

	/*
	 * (非 Javadoc) <p>Title: findAll</p>
	 * 
	 * <p>Description: 查找所有贷款信息</p>
	 * 
	 * @return
	 * 
	 * @see com.loan.service.LoanService#findAll()
	 */
	public List<Loan> findAll() {

		return loanDao.findAll();
	}

	/*
	 * (非 Javadoc) <p>Title: addLoan</p> <p>Description: 增加贷款信息</p>
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
	 * (非 Javadoc) <p>Title: delLoan</p> <p>Description: 删除贷款信息</p>
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
	 * (非 Javadoc) <p>Title: findLoanById</p> <p>Description: 从数据库中查找一条数据</p>
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
	 * (非 Javadoc) <p>Title: updateLoan</p> <p>Description: 修改贷款信息</p>
	 * 
	 * @param loan
	 * 
	 * @see com.loan.service.LoanService#updateLoan(com.loan.entity.Loan)
	 */
	public void updateLoan(Loan loan) {
		loanDao.updateLoan(loan);
	}

	/*
	 * (非 Javadoc) <p>Title: searchStu</p> <p>Description: 根据条件查询贷款信息</p>
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
	 * (非 Javadoc) <p>Title: findLoanByName</p> <p>Description: 根据NAME查找一条数据</p>
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
