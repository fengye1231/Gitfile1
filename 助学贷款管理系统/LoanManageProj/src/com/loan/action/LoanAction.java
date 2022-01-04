/**
 * 
 * @Title: LoanAction.java
 * @Package com.loan.action
 * @Description: 逻辑处理JavaBean,即控制页面的转向及参数传递问题
 * @author He ChangYan
 * @date 2012-2-28 下午04:05:21
 * @copyright STARIT   
 */
package com.loan.action;

import java.util.List;

import javax.swing.JOptionPane;

import org.apache.struts2.ServletActionContext;

import com.loan.entity.Loan;
import com.loan.service.LoanService;

public class LoanAction {

	public Loan loan;
	public Loan delLoan;
	public Loan addLoan;
	public Loan updateLoan;
	public List<Loan> loanList;
	public List<Loan> singleLoan;
	public LoanService loanService;// 实例化service对象

	/* get和set方法 */
	public Loan getLoan() {
		return loan;
	}

	public void setLoan(Loan loan) {
		this.loan = loan;
	}

	public Loan getDelLoan() {
		return delLoan;
	}

	public void setDelLoan(Loan delLoan) {
		this.delLoan = delLoan;
	}

	public Loan getAddLoan() {
		return addLoan;
	}

	public void setAddLoan(Loan addLoan) {
		this.addLoan = addLoan;
	}

	public Loan getUpdateLoan() {
		return updateLoan;
	}

	public void setUpdateLoan(Loan updateLoan) {
		this.updateLoan = updateLoan;
	}

	public List<Loan> getLoanList() {
		return loanList;
	}

	public void setLoanList(List<Loan> loanList) {
		this.loanList = loanList;
	}

	public LoanService getLoanService() {
		return loanService;
	}

	public void setLoanService(LoanService loanService) {
		this.loanService = loanService;
	}
	
	public List<Loan> getSingleLoan() {
		return singleLoan;
	}

	public void setSingleLoan(List<Loan> singleLoan) {
		this.singleLoan = singleLoan;
	}

	/**
	 * 
	 * @Title: list
	 * @Description: 查找所有贷款信息
	 * @return String
	 * @throws
	 */
	public String list() {
		loanList = loanService.findAll();
		return "list";
	}

	/**
	 * 
	 * @Title: addLoan
	 * @Description: 增加贷款信息
	 * @return
	 * @return String
	 * @throws
	 */
	public String addLoan() {
		loanService.addLoan(addLoan);
		return list();
	}

	/**
	 * 
	 * @Title: delLoan
	 * @Description: 删除贷款信息
	 * @return
	 * @return String
	 * @throws
	 */
	public String delLoan() {
		Loan loanDel = loanService.findLoanById(delLoan.getLoanId());
		loanService.delLoan(loanDel);
		JOptionPane.showMessageDialog(null, "数据删除成功。", "提示", 2);
		return list();
	}

	/**
	 * 
	 * @Title: updateInput
	 * @Description: 从数据库中找到一条数据
	 * @return
	 * @return String
	 * @throws
	 */
	public String updateInput() {
		updateLoan = loanService.findLoanById(updateLoan.getLoanId());
		return "updateInput";
	}
	
	/**
	 * 
	 * @Title: updateLoan
	 * @Description: 修改贷款信息
	 * @return
	 * @return String
	 * @throws
	 */
	public String updateLoan() {
		loanService.updateLoan(updateLoan);
		JOptionPane.showMessageDialog(null, "数据修改成功。", "提示", 2);
		return list();
	}
	
	/**
	 * 
	 * @Title: addMyLoan
	 * @Description: 增加我的贷款信息
	 * @return
	 * @return String
	 * @throws
	 */
	public String addMyLoan() {
		loanService.addLoan(addLoan);
		return findLoanByName();
	}
	
	/**
	 * 
	 * @Title: updateMyInput
	 * @Description: 从数据库中我的贷款信息
	 * @return
	 * @return String
	 * @throws
	 */
	public String updateMyInput() {
		updateLoan = loanService.findLoanById(updateLoan.getLoanId());
		return "updateMyInput";
	}

	/**
	 * 
	 * @Title: updateLoan
	 * @Description: 修改我的贷款信息
	 * @return
	 * @return String
	 * @throws
	 */
	public String updateMyLoan() {
		loanService.updateLoan(updateLoan);
		JOptionPane.showMessageDialog(null, "数据修改成功。", "提示", 2);
		return findLoanByName();
	}

	/**
	 * 
	 * @Title: searchLoan
	 * @Description: 根据条件查询贷款信息
	 * @return
	 * @return String
	 * @throws
	 */
	public String searchLoan() {
		String sql = "from Loan l where LoanId = '" + loan.loanId + "'"
				+ " and StuName = '" + loan.stuName + "'" + " and StuId = '"
				+ loan.student.stuId + "'" +  " and SchoolName = '"
				+ loan.schoolName + "'";
		loanList = loanService.searchLoan(sql);
		if (loanList.size() == 0) {
			String msg = "您输入的查询条件不全面，不能找到相匹配的贷款信息!请检查输入是否有误。";
			JOptionPane.showMessageDialog(null, msg, "警告", 0);// 弹出提示信息对话框
		}
		return "searchLoan";
	}
	
	/**
	 * 
	* @Title: findLoanByName
	* @Description: 查找我的信息
	* @return    
	* @return String 
	* @throws
	 */
	public String findLoanByName() {
		String mg = "singleLoan";
		String userName = (String)ServletActionContext.getRequest().getSession().getAttribute("name");
		String sql = "from Loan l where StuName = '" + userName +"'";
		singleLoan = loanService.findLoanByName(sql);
		if (singleLoan.size() == 0) {
			String msg = "您查找的账户信息不存在!请添加对应的贷款信息。";
			JOptionPane.showMessageDialog(null, msg, "警告", 0);// 弹出提示信息对话框
			mg = "addMyLoan";
		}
		return mg;
	}
}
