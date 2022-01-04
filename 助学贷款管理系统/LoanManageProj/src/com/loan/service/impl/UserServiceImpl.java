/**
 * 
 * @Title: UserServiceImpl.java
 * @Package com.loan.service.impl
 * @Description: 用户管理业务逻辑处理实现类
 * @author He ChangYan
 * @date 2012-2-29 下午05:08:14
 * @copyright STARIT   
 */
package com.loan.service.impl;

import java.util.List;

import com.loan.dao.UserDao;
import com.loan.entity.User;
import com.loan.service.UserService;

public class UserServiceImpl implements UserService {

	private UserDao userDao;// 实例DAO对象

	public UserDao getUserDao() {
		return userDao;
	}

	public void setUserDao(UserDao userDao) {
		this.userDao = userDao;
	}

	/*
	 * (非 Javadoc) <p>Title: checkLogin</p> <p>Description: 判断登录用户是否正确</p>
	 * 
	 * @param user
	 * 
	 * @return
	 * 
	 * @see com.loan.service.UserService#checkLogin(com.loan.entity.User)
	 */
	public User checkLogin(String sql) {
		return userDao.checkLogin(sql);
	}

	/*
	 * (非 Javadoc) <p>Title: findAll</p> <p>Description: 查找所有用户信息</p>
	 * 
	 * @return
	 * 
	 * @see com.loan.service.UserService#findAll()
	 */
	public List<User> findAll() {
		return userDao.findAll();
	}

	/*
	 * (非 Javadoc) <p>Title: searchUser</p> <p>Description: 根据条件查询用户信息</p>
	 * 
	 * @param sql
	 * 
	 * @return
	 * 
	 * @see com.loan.service.UserService#searchUser(java.lang.String)
	 */
	public List<User> searchUser(String sql) {
		return userDao.searchUser(sql);
	}

	/*
	 * (非 Javadoc) <p>Title: addUser</p> <p>Description: 增加用户信息</p>
	 * 
	 * @param user
	 * 
	 * @return
	 * 
	 * @see com.loan.service.UserService#addUser(com.loan.entity.User)
	 */
	public boolean addUser(User user) {
		return userDao.addUser(user);
	}

	/*
	 * (非 Javadoc) <p>Title: delUser</p> <p>Description: 删除用户信息</p>
	 * 
	 * @param user
	 * 
	 * @return
	 * 
	 * @see com.loan.service.UserService#delUser(com.loan.entity.User)
	 */
	public boolean delUser(User user) {
		return userDao.delUser(user);
	}

	/*
	 * (非 Javadoc) <p>Title: updateUser</p> <p>Description: 修改用户信息</p>
	 * 
	 * @param user
	 * 
	 * @return
	 * 
	 * @see com.loan.service.UserService#updateUser(com.loan.entity.User)
	 */
	public boolean updateUser(User user) {
		return userDao.updateUser(user);
	}

	/*
	 * (非 Javadoc) <p>Title: findUserById</p> <p>Description: 根据ID查找一条用户信息</p>
	 * 
	 * @param userId
	 * 
	 * @return
	 * 
	 * @see com.loan.service.UserService#findUserById(int)
	 */
	public User findUserById(int userId) {
		return userDao.findUserById(userId);
	}

	/*
	 * (非 Javadoc) <p>Title: register</p> <p>Description: 注册新用户</p>
	 * 
	 * @param register
	 * 
	 * @return
	 * 
	 * @see com.loan.service.UserService#register(com.loan.entity.User)
	 */
	public User register(String sql) {
		return userDao.register(sql);
	}

}
