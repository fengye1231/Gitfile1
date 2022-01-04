/**
 * 
 * @Title: UserService.java
 * @Package com.loan.service
 * @Description: 用户管理业务逻辑处理接口类
 * @author He ChangYan
 * @date 2012-2-29 下午05:07:02
 * @copyright STARIT   
 */
package com.loan.service;

import java.util.List;

import com.loan.entity.User;

public interface UserService {

	/** 判断登录用户是否正确 */
	public User checkLogin(String sql);

	/** 查找所有用户信息 */
	public List<User> findAll();

	/** 根据条件查询用户信息 */
	public List<User> searchUser(String sql);

	/** 增加用户信息 */
	public boolean addUser(User user);

	/** 增加用户信息 */
	public boolean delUser(User user);

	/** 增加用户信息 */
	public boolean updateUser(User user);

	/** 根据ID查找一条用户信息 */
	public User findUserById(int userId);

	/** 注册新用户 */
	public User register(String sql);
}
