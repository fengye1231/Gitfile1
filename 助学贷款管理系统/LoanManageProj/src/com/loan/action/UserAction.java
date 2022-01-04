/**
 * 
 * @Title: UserAction.java
 * @Package com.loan.action
 * @Description: 用户管理逻辑处理类
 * @author He ChangYan
 * @date 2012-2-29 下午05:03:35
 * @copyright STARIT   
 */
package com.loan.action;

import java.util.List;
import java.util.Map;

import javax.swing.JOptionPane;

import org.apache.struts2.ServletActionContext;

import com.loan.entity.User;
import com.loan.service.UserService;
import com.opensymphony.xwork2.ActionContext;

public class UserAction {

	private User user;
	private User addUser;
	private User delUser;
	private User updateUser;
	private User updateMy;
	private User register;
	private List<User> userList;
	private String msg;// 登陆提示信息
	private UserService userService;// 实例化userService对象
	private Map<String, Object> session;

	/* get和set方法 */
	public User getUser() {
		return user;
	}

	public void setUser(User user) {
		this.user = user;
	}

	public User getRegister() {
		return register;
	}

	public void setRegister(User register) {
		this.register = register;
	}

	public User getAddUser() {
		return addUser;
	}

	public void setAddUser(User addUser) {
		this.addUser = addUser;
	}

	public User getDelUser() {
		return delUser;
	}

	public void setDelUser(User delUser) {
		this.delUser = delUser;
	}

	public User getUpdateUser() {
		return updateUser;
	}

	public void setUpdateUser(User updateUser) {
		this.updateUser = updateUser;
	}

	public List<User> getUserList() {
		return userList;
	}

	public void setUserList(List<User> userList) {
		this.userList = userList;
	}

	public String getMsg() {
		return msg;
	}

	public void setMsg(String msg) {
		this.msg = msg;
	}

	public UserService getUserService() {
		return userService;
	}

	public void setUserService(UserService userService) {
		this.userService = userService;
	}

	public Map<String, Object> getSession() {
		return session;
	}

	public void setSession(Map<String, Object> session) {
		this.session = session;
	}
	
	public User getUpdateMy() {
		return updateMy;
	}

	public void setUpdateMy(User updateMy) {
		this.updateMy = updateMy;
	}

	/**
	 * 
	 * @Title: list
	 * @Description: 查找所有用户信息
	 * @return
	 * @return String
	 * @throws
	 */
	public String list() {
		userList = userService.findAll();
		return "list";
	}

	/**
	 * 
	 * @Title: login
	 * @Description: 验证登录的用户名和密码是否正确
	 * @return
	 * @return String
	 * @throws
	 */
	public String login() {
		String flag = "stuLogin";
		String sql = "from User u where UserName = '" + user.getUserName()
				+ "' and UserPwd = '" + user.getUserPwd() + "'";
		user = userService.checkLogin(sql);
		if (user != null) {
			Map<String, Object> session = ActionContext.getContext()
					.getSession();
			session.put("userId", user.getUserId());
			session.put("userName", user.getUserName());
			ServletActionContext.getRequest().getSession().setAttribute("name", user.getUserName());
			session.put("status", user.getStatus());
			if (user.getStatus().equals("助贷小组")) {
				flag = "loanLogin";
			} else if (user.getStatus().equals("院领导")) {
				flag = "academyLogin";
			} else if (user.getStatus().equals("管理员")) {
				flag = "adminLogin";
			}
		} else {
			msg = "用户名或密码错误!";
			JOptionPane.showMessageDialog(null, msg, "警告", 2);
			flag = "fail";
		}
		return flag;
	}

	/**
	 * 
	 * @Title: register
	 * @Description: 注册新用户
	 * @return
	 * @return String
	 * @throws
	 */
	public String register() {
		String flag = "register";
		String sql = "from User u where UserName = '" + register.getUserName()
				+ "'";
		User reg = userService.register(sql);
		if (reg != null) {
			if (reg.getUserName().equals(register.getUserName())) {
				msg = "该用户名已存在，请重新输入用户名!";
				JOptionPane.showMessageDialog(null, msg, "警告", 2);
				flag = "regFail";
			}
		} else {
			userService.addUser(register);
		}
		return flag;
	}

	/**
	 * 
	 * @Title: searchUser
	 * @Description: 根据条件查询用户信息
	 * @return
	 * @return String
	 * @throws
	 */
	public String searchUser() {
		String sql = "from User u where userId = '" + user.getUserId() + "'"
				+ " and userName = '" + user.getUserName() + "'"
				+ " and status = '" + user.getStatus() + "'";
		userList = userService.searchUser(sql);
		if (userList.size() == 0) {
			String msg = "您输入的查询条件不全面，不能找到相匹配的用户信息!请检查输入是否有误。";
			JOptionPane.showMessageDialog(null, msg, "警告", 0);// 弹出提示信息对话框
		}
		return "searchUser";
	}

	/**
	 * 
	 * @Title: addUser
	 * @Description: 增加用户信息
	 * @return
	 * @return String
	 * @throws
	 */
	public String addUser() {
		userService.addUser(addUser);
		return list();
	}

	/**
	 * 
	 * @Title: delUser
	 * @Description: 删除用户信息
	 * @return
	 * @return String
	 * @throws
	 */
	public String delUser() {
		User userDel = userService.findUserById(delUser.getUserId());
		userService.delUser(userDel);
		JOptionPane.showMessageDialog(null, "数据删除成功。", "提示", 2);
		return list();
	}

	/**
	 * 
	 * @Title: updateUser
	 * @Description: 修改用户信息
	 * @return
	 * @return String
	 * @throws
	 */
	public String updateUser() {
		userService.updateUser(updateUser);
		JOptionPane.showMessageDialog(null, "密码修改成功，请记住您修改的新密码。", "提示", 2);
		return "updateUser";
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
		updateUser = userService.findUserById(updateUser.getUserId());
		return "updateInput";
	}
	

}
