/**
 * 
 * @Title: Student.java
 * @Package com.loan.entity
 * @Description: 贷款学生的基本信息
 * @author He ChangYan
 * @date 2012-2-27 下午09:16:38
 * @copyright STARIT   
 */
package com.loan.entity;

import java.util.HashSet;
import java.util.Set;


public class Student {

	// Fields

	public String stuId;// 学号
	public String stuName;// 姓名
	public String stuSex;// 性别
	public String stuIdentity;// 身份证号
	public String enterSchoolTime;// 入学时间
	public String stuNation;// 民族
	public String stuPolitic;// 政治面貌
	public String stuNative;// 籍贯
	public String stuMobileTel;// 移动电话
	public String stuFamilyTel;// 家庭电话
	public String academy;// 学院
	public String classes;// 班级
	public String major;// 专业
	public String stuRemark;// 备注
	
	public User user;//用户信息集合	
	public Set loan = new HashSet(0);

	// Constructors

	/** default constructor */
	public Student() {
	}


	/** full constructor */
	public Student(String stuId,String stuName, String stuSex, String stuIdentity,
			String enterSchoolTime, String stuNation, String stuPolitic,
			String stuNative, String stuMobileTel, String stuFamilyTel,
			String academy, String classes, String major, 
			String stuRemark, User user, Set loan) {
		this.stuId = stuId;
		this.stuName = stuName;
		this.stuSex = stuSex;
		this.stuIdentity = stuIdentity;
		this.enterSchoolTime = enterSchoolTime;
		this.stuNation = stuNation;
		this.stuPolitic = stuPolitic;
		this.stuNative = stuNative;
		this.stuMobileTel = stuMobileTel;
		this.stuFamilyTel = stuFamilyTel;
		this.academy = academy;
		this.classes = classes;
		this.major = major;
		this.stuRemark = stuRemark;
		this.user = user;
		this.loan = loan;
	}

	// Property accessors

	
	
	public String getStuId() {
		return this.stuId;
	}

	public void setStuId(String stuId) {
		this.stuId = stuId;
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

	public String getStuIdentity() {
		return this.stuIdentity;
	}

	public void setStuIdentity(String stuIdentity) {
		this.stuIdentity = stuIdentity;
	}


	public String getEnterSchoolTime() {
		return enterSchoolTime;
	}


	public void setEnterSchoolTime(String enterSchoolTime) {
		this.enterSchoolTime = enterSchoolTime;
	}


	public String getStuNation() {
		return this.stuNation;
	}

	public void setStuNation(String stuNation) {
		this.stuNation = stuNation;
	}

	public String getStuPolitic() {
		return this.stuPolitic;
	}

	public void setStuPolitic(String stuPolitic) {
		this.stuPolitic = stuPolitic;
	}

	public String getStuNative() {
		return this.stuNative;
	}

	public void setStuNative(String stuNative) {
		this.stuNative = stuNative;
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

	public String getAcademy() {
		return this.academy;
	}

	public void setAcademy(String academy) {
		this.academy = academy;
	}

	public String getClasses() {
		return this.classes;
	}

	public void setClasses(String classes) {
		this.classes = classes;
	}

	public String getMajor() {
		return this.major;
	}

	public void setMajor(String major) {
		this.major = major;
	}


	public String getStuRemark() {
		return this.stuRemark;
	}

	public void setStuRemark(String stuRemark) {
		this.stuRemark = stuRemark;
	}
	
	public User getUser() {
		return user;
	}

	public void setUser(User user) {
		this.user = user;
	}


	public Set getLoan() {
		return loan;
	}


	public void setLoan(Set loan) {
		this.loan = loan;
	}

}