/**
 * 
 * @Title: ApplyAction.java
 * @Package com.loan.action
 * @Description: 申请提前还款记录
 * @author He ChangYan
 * @date 2012-3-26 上午10:32:25
 * @copyright STARIT   
 */
package com.loan.action;

import java.util.List;

import javax.swing.JOptionPane;

import org.apache.struts2.ServletActionContext;

import com.loan.entity.Apply;
import com.loan.service.ApplyService;

public class ApplyAction {

	private Apply addApply;
	private Apply delApply;
	private Apply updateApply;
	private List<Apply> applyList;// 申请信息集合
	private List<Apply> myApplyList;
	private ApplyService applyService;// 实例化service对象

	/* get和set方法 */
	public Apply getAddApply() {
		return addApply;
	}

	public void setAddApply(Apply addApply) {
		this.addApply = addApply;
	}

	public Apply getDelApply() {
		return delApply;
	}

	public void setDelApply(Apply delApply) {
		this.delApply = delApply;
	}

	public Apply getUpdateApply() {
		return updateApply;
	}

	public void setUpdateApply(Apply updateApply) {
		this.updateApply = updateApply;
	}

	public List<Apply> getApplyList() {
		return applyList;
	}

	public void setApplyList(List<Apply> applyList) {
		this.applyList = applyList;
	}

	public ApplyService getApplyService() {
		return applyService;
	}

	public void setApplyService(ApplyService applyService) {
		this.applyService = applyService;
	}

	public List<Apply> getMyApplyList() {
		return myApplyList;
	}

	public void setMyApplyList(List<Apply> myApplyList) {
		this.myApplyList = myApplyList;
	}

	
	/**
	 * 
	 * @Title: list
	 * @Description: 返回所有申请记录
	 * @return
	 * @return String
	 * @throws
	 */
	public String list() {
		applyList = applyService.findAll();
		return "list";
	}
	
	/**
	 * 
	* @Title: findAccountByName
	* @Description: 根据姓名查找申请信息
	* @return    
	* @return String 
	* @throws
	 */
	public String findApplyByName() {
		String flag = "myApplyList";
		String userName = (String)ServletActionContext.getRequest().getSession().getAttribute("name");
		String sql = "from Apply a where StuName = '" + userName +"'";
		myApplyList = applyService.findApplyByName(sql);
		if (myApplyList.size() == 0) {
			String msg = "您查找的申请信息不存在!请填写申请表。";
			JOptionPane.showMessageDialog(null, msg, "警告", 0);// 弹出提示信息对话框
			flag = "addMyApply";
		}
		return flag;
	}
	
	/**
	 * 
	 * @Title: addApply
	 * @Description: 添加申请提前还款记录
	 * @return
	 * @return String
	 * @throws
	 */
	public String addApply() {
		applyService.addApply(addApply);
		return findApplyByName();
	}

	/**
	 * 
	* @Title: delApply
	* @Description: 删除申请记录
	* @return    
	* @return String 
	* @throws
	 */
	public String delApply() {
		Apply applyDel = applyService.findApplyById(delApply.getApplyId());
		applyService.delApply(applyDel);
		JOptionPane.showMessageDialog(null, "数据删除成功。", "提示", 2);
		return list();
	}
	
	/**
	 * 
	 * @Title: updateInput
	 * @Description: 从数据库 中查找对应的申请信息
	 * @return
	 * @return String
	 * @throws
	 */
	public String updateInput() {
		updateApply = applyService.findApplyById(updateApply.getApplyId());
		return "updateInput";
	}

	/**
	 * 
	 * @Title: updateApply
	 * @Description: 修改申請信息
	 * @return
	 * @return String
	 * @throws
	 */
	public String updateApply() {
		applyService.updateApply(updateApply);
		JOptionPane.showMessageDialog(null, "数据修改成功。", "提示", 2);
		return list();
	}
	
	/**
	 * 
	 * @Title: updateInput
	 * @Description: 从数据库 中查找对应的申请信息
	 * @return
	 * @return String
	 * @throws
	 */
	public String updateMyInput() {
		updateApply = applyService.findApplyById(updateApply.getApplyId());
		return "updateMyInput";
	}

	/**
	 * 
	 * @Title: updateApply
	 * @Description: 修改申請信息
	 * @return
	 * @return String
	 * @throws
	 */
	public String updateMyApply() {
		applyService.updateApply(updateApply);
		JOptionPane.showMessageDialog(null, "数据修改成功。", "提示", 2);
		return findApplyByName();
	}
}
