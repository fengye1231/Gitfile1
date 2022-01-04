/**
 * 
 * @Title: ApprovalAction.java
 * @Package com.loan.action
 * @Description: �������
 * @author He ChangYan
 * @date 2012-3-1 ����02:55:32
 * @copyright STARIT   
 */
package com.loan.action;

import java.util.List;

import com.loan.entity.Approval;
import com.loan.service.ApprovalService;

public class ApprovalAction {

	private Approval approval;// ʵ������
	private List<Approval> approvalList;// �����������
	private ApprovalService approvalService;// ʵ��ҵ�������

	/* get��set���� */
	public Approval getApproval() {
		return approval;
	}

	public void setApproval(Approval approval) {
		this.approval = approval;
	}

	public List<Approval> getApprovalList() {
		return approvalList;
	}

	public void setApprovalList(List<Approval> approvalList) {
		this.approvalList = approvalList;
	}

	public ApprovalService getApprovalService() {
		return approvalService;
	}

	public void setApprovalService(ApprovalService approvalService) {
		this.approvalService = approvalService;
	}

	/**
	 * 
	* @Title: list
	* @Description: ��ѯ���е�������Ϣ
	* @return    
	* @return String 
	* @throws
	 */
	private String list() {
		approvalList = approvalService.findAll();
		return "list";
	}
}
