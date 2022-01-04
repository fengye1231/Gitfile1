/**
 * 
 * @Title: LoanService.java
 * @Package com.loan.service
 * @Description: 服务类接口
 * @author He ChangYan
 * @date 2012-2-28 下午04:10:36
 * @copyright STARIT   
 */
package com.loan.service;

import java.util.List;

import com.loan.entity.Loan;

public interface LoanService {

	/** 查找所有贷款信息 */
	public List<Loan> findAll();

	/** 增加贷款信息 */
	public boolean addLoan(Loan loan);

	/** 删除贷款信息 */
	public boolean delLoan(Loan loan);

	/** 查找一条数据 */
	public Loan findLoanById(String loanId);

	/** 修改贷款信息 */
	public void updateLoan(Loan loan);

	/** 根据条件查询数据 */
	public List<Loan> searchLoan(String sql);
	
	/** 根据NAME查找一条数据 */
	public List<Loan> findLoanByName(String sql);
}
