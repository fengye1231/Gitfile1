/**
 * 
 * @Title: Loan.java
 * @Package com.loan.entity
 * @Description: 贷款基本信息
 * @author He ChangYan
 * @date 2012-2-27 下午09:24:35
 * @copyright STARIT   
 */
package com.loan.entity;

import java.util.HashSet;
import java.util.Set;

public class Loan {

	// Fields

	public String loanId;// 贷款编号
	public Double loanAccount;// 贷款金额
	public String stuName;// 姓名
	public String stuSex;// 性别
	public String education;// 学历
	public String schoolName;// 学校名称
	public String major;// 专业
	public String applyLoanTime;// 申请贷款时间
	public String address;// 家庭住址
	public String remark;// 备注

	public Student student;// 学生信息实例
	public Set account = new HashSet(0);
	public Set apply = new HashSet(0);//申请记录

	// Constructors

	/** default constructor */
	public Loan() {
	}

	/** full constructor */
	public Loan(Student student, Double loanAccount, String stuName,
			String stuSex, String education, String schoolName, String major,
			String applyLoanTime, String address, String remark,
			Set account, Set apply) {
		this.student = student;
		this.loanAccount = loanAccount;
		this.stuName = stuName;
		this.stuSex = stuSex;
		this.education = education;
		this.schoolName = schoolName;
		this.major = major;
		this.applyLoanTime = applyLoanTime;
		this.address = address;
		this.remark = remark;
		this.account = account;
		this.apply = apply;
	}

	// Property accessors

	public String getLoanId() {
		return this.loanId;
	}

	public void setLoanId(String loanId) {
		this.loanId = loanId;
	}

	public Student getStudent() {
		return this.student;
	}

	public void setStudent(Student student) {
		this.student = student;
	}

	public Double getLoanAccount() {
		return this.loanAccount;
	}

	public void setLoanAccount(Double loanAccount) {
		this.loanAccount = loanAccount;
	}

	public String getStuName() {
		return this.stuName;
	}

	public void setStuName(String stuName) {
		this.stuName = stuName;
	}

	public String getStuSex() {
		return this.stuSex;
	}

	public void setStuSex(String stuSex) {
		this.stuSex = stuSex;
	}

	public String getEducation() {
		return this.education;
	}

	public void setEducation(String education) {
		this.education = education;
	}

	public String getSchoolName() {
		return this.schoolName;
	}

	public void setSchoolName(String schoolName) {
		this.schoolName = schoolName;
	}

	public String getMajor() {
		return this.major;
	}

	public void setMajor(String major) {
		this.major = major;
	}
	
	public String getApplyLoanTime() {
		return applyLoanTime;
	}

	public void setApplyLoanTime(String applyLoanTime) {
		this.applyLoanTime = applyLoanTime;
	}

	public String getAddress() {
		return this.address;
	}

	public void setAddress(String address) {
		this.address = address;
	}

	public String getRemark() {
		return this.remark;
	}

	public void setRemark(String remark) {
		this.remark = remark;
	}


	public Set getAccount() {
		return account;
	}

	public void setAccount(Set account) {
		this.account = account;
	}

	public Set getApply() {
		return apply;
	}

	public void setApply(Set apply) {
		this.apply = apply;
	}
	
}