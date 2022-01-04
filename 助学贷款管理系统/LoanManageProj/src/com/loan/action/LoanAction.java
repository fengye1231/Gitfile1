/**
 * 
 * @Title: LoanAction.java
 * @Package com.loan.action
 * @Description: �߼�����JavaBean,������ҳ���ת�򼰲�����������
 * @author He ChangYan
 * @date 2012-2-28 ����04:05:21
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
	public LoanService loanService;// ʵ����service����

	/* get��set���� */
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
	 * @Description: �������д�����Ϣ
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
	 * @Description: ���Ӵ�����Ϣ
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
	 * @Description: ɾ��������Ϣ
	 * @return
	 * @return String
	 * @throws
	 */
	public String delLoan() {
		Loan loanDel = loanService.findLoanById(delLoan.getLoanId());
		loanService.delLoan(loanDel);
		JOptionPane.showMessageDialog(null, "����ɾ���ɹ���", "��ʾ", 2);
		return list();
	}

	/**
	 * 
	 * @Title: updateInput
	 * @Description: �����ݿ����ҵ�һ������
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
	 * @Description: �޸Ĵ�����Ϣ
	 * @return
	 * @return String
	 * @throws
	 */
	public String updateLoan() {
		loanService.updateLoan(updateLoan);
		JOptionPane.showMessageDialog(null, "�����޸ĳɹ���", "��ʾ", 2);
		return list();
	}
	
	/**
	 * 
	 * @Title: addMyLoan
	 * @Description: �����ҵĴ�����Ϣ
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
	 * @Description: �����ݿ����ҵĴ�����Ϣ
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
	 * @Description: �޸��ҵĴ�����Ϣ
	 * @return
	 * @return String
	 * @throws
	 */
	public String updateMyLoan() {
		loanService.updateLoan(updateLoan);
		JOptionPane.showMessageDialog(null, "�����޸ĳɹ���", "��ʾ", 2);
		return findLoanByName();
	}

	/**
	 * 
	 * @Title: searchLoan
	 * @Description: ����������ѯ������Ϣ
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
			String msg = "������Ĳ�ѯ������ȫ�棬�����ҵ���ƥ��Ĵ�����Ϣ!���������Ƿ�����";
			JOptionPane.showMessageDialog(null, msg, "����", 0);// ������ʾ��Ϣ�Ի���
		}
		return "searchLoan";
	}
	
	/**
	 * 
	* @Title: findLoanByName
	* @Description: �����ҵ���Ϣ
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
			String msg = "�����ҵ��˻���Ϣ������!����Ӷ�Ӧ�Ĵ�����Ϣ��";
			JOptionPane.showMessageDialog(null, msg, "����", 0);// ������ʾ��Ϣ�Ի���
			mg = "addMyLoan";
		}
		return mg;
	}
}
