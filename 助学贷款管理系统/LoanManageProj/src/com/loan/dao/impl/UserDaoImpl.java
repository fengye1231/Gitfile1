/**
 * 
 * @Title: UserDaoImpl.java
 * @Package com.loan.dao.impl
 * @Description: 用户管理数据访问实现类
 * @author He ChangYan
 * @date 2012-2-29 下午05:05:38
 * @copyright STARIT   
 */
package com.loan.dao.impl;

import java.util.List;

import javax.swing.JOptionPane;

import org.springframework.orm.hibernate3.support.HibernateDaoSupport;

import com.loan.dao.UserDao;
import com.loan.entity.User;

public class UserDaoImpl extends HibernateDaoSupport implements UserDao {

	/**
	 * 判断登录用户是否正确
	 */
	public User checkLogin(String sql) {
		User u = null;
		List<User> l = this.getSession().createQuery(sql).list();
		if (l != null && l.size() > 0) {
			u = l.get(0);
		}
		return u;
	}

	/**
	 * 查找所有用户信息
	 */
	public List<User> findAll() {
		List<User> list = null;
		list = this.getSession().createQuery("from User u").list();
		return list;
	}

	/**
	 * 根据条件查询用户信息
	 */
	public List<User> searchUser(String sql) {
		List<User> list = null;
		list = this.getSession().createQuery(sql).list();
		return list;
	}

	/**
	 * 增加用户信息
	 */
	public boolean addUser(User user) {
		boolean b = true;
		try {
			this.getSession().save(user);
		} catch (Exception e) {
			b = false;
			e.printStackTrace();
		}
		return b;
	}

	/**
	 * 删除用户信息
	 */
	public boolean delUser(User user) {
		boolean b = true;
		try {
			this.getSession().delete(user);
		} catch (Exception e) {
			b = false;
			e.printStackTrace();
		}
		return b;
	}

	/**
	 * 修改用户信息
	 */
	public boolean updateUser(User user) {
		boolean b = true;
		try {
			this.getSession().update(user);
		} catch (Exception e) {
			b = false;
			e.printStackTrace();
		}
		return b;
	}

	/**
	 * 查找一条用户信息
	 */
	public User findUserById(int userId) {
		return (User) getSession().get(User.class, userId);
	}

	/**
	 * 注册新用户
	 */
	public User register(String sql) {
		User r = null;
		List<User> l = this.getSession().createQuery(sql).list();
		if (l != null && l.size() > 0) {
			r = l.get(0);
		}
		return r;
	}

}
