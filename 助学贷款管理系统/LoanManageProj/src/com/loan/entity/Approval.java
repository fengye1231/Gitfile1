/**
 * 
 * @Title: Approval.java
 * @Package com.loan.entity
 * @Description: ��������״̬��Ϣ
 * @author He ChangYan
 * @date 2012-3-1 ����02:07:29
 * @copyright STARIT   
 */
package com.loan.entity;

import java.util.HashSet;
import java.util.Set;


public class Approval {

	// Fields

	public int approvalId;// �������
	public String approvalStatu;// ����״̬
	
	private Set apply = new HashSet(0);

	// Constructors

	/** default constructor */
	public Approval() {
	}

	/** full constructor */
	public Approval(int approvalId, String approvalStatu, Set apply) {
		this.approvalId = approvalId;
		this.approvalStatu = approvalStatu;
		this.apply = apply;
	}

	// Property accessors
	public int getApprovalId() {
		return approvalId;
	}

	public void setApprovalId(int approvalId) {
		this.approvalId = approvalId;
	}

	public String getApprovalStatu() {
		return approvalStatu;
	}

	public void setApprovalStatu(String approvalStatu) {
		this.approvalStatu = approvalStatu;
	}

	public Set getApply() {
		return apply;
	}

	public void setApply(Set apply) {
		this.apply = apply;
	}

}