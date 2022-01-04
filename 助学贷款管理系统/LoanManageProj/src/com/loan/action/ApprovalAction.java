/**
 * 
 * @Title: ApprovalAction.java
 * @Package com.loan.action
 * @Description: 审批情况
 * @author He ChangYan
 * @date 2012-3-1 下午02:55:32
 * @copyright STARIT   
 */
package com.loan.action;

import java.util.List;

import com.loan.entity.Approval;
import com.loan.service.ApprovalService;

public class ApprovalAction {

	private Approval approval;// 实例对象
	private List<Approval> approvalList;// 审批情况集合
	private ApprovalService approvalService;// 实例业务处理对象

	/* get和set方法 */
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
	* @Description: 查询所有的审批信息
	* @return    
	* @return String 
	* @throws
	 */
	private String list() {
		approvalList = approvalService.findAll();
		return "list";
	}
}
