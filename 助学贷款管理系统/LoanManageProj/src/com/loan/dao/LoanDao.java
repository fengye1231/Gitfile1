/**
 * 
 * @Title: LoanDao.java
 * @Package com.loan.dao
 * @Description: 贷款信息数据访问接口类
 * @author He ChangYan
 * @date 2012-2-28 下午03:56:03
 * @copyright STARIT   
 */
package com.loan.dao;

import java.util.List;

import com.loan.entity.Loan;

public interface LoanDao {

	/** 查找所有贷款信息 */
	public List<Loan> findAll();

	/** 增加贷款信息 */
	public boolean addLoan(Loan loan);

	/** 删除贷款信息 */
	public boolean delLoan(Loan loan);

	/** 查找一条数据 */
	public Loan findLoanById(String loanId);

	/** 修改贷款信息 */
	public boolean updateLoan(Loan loan);

	/** 根据条件查询数据 */
	public List<Loan> searchLoan(String sql);
	
	/** 根据NAME查找一条数据 */
	public List<Loan> findLoanByName(String sql);
}
