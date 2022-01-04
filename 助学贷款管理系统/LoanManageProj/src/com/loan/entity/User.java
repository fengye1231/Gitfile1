/**
 * 
 * @Title: User.java
 * @Package com.loan.entity
 * @Description: ʹ�ø�ϵͳ�Ľ�ɫ��Ϣ
 * @author He ChangYan
 * @date 2012-2-27 ����09:07:29
 * @copyright STARIT   
 */
package com.loan.entity;

import java.util.HashSet;
import java.util.Set;

public class User {

	// Fields

	public int userId;// �û�ID
	public String userName;// �û���
	public String userPwd;// �û�����
	public String status;// ���
	public String remark;// ��ע
	public Set student = new HashSet(0);// ѧ����Ϣ����

	// Constructors

	/** default constructor */
	public User() {
	}

	/** full constructor */
	public User(int userId, String userName, String userPwd, String status,
			String remark,Set student) {
		this.userId = userId;
		this.userName = userName;
		this.userPwd = userPwd;
		this.status = status;
		this.remark = remark;
		this.student = student;
	}

	// Property accessors

	public int getUserId() {
		return this.userId;
	}

	public void setUserId(int userId) {
		this.userId = userId;
	}

	public String getStatus() {
		return status;
	}

	public void setStatus(String status) {
		this.status = status;
	}

	public String getUserName() {
		return this.userName;
	}

	public void setUserName(String userName) {
		this.userName = userName;
	}

	public String getUserPwd() {
		return this.userPwd;
	}

	public void setUserPwd(String userPwd) {
		this.userPwd = userPwd;
	}


	public String getRemark() {
		return this.remark;
	}

	public void setRemark(String remark) {
		this.remark = remark;
	}

	public Set getStudent() {
		return this.student;
	}

	public void setStudent(Set student) {
		this.student = student;
	}
}