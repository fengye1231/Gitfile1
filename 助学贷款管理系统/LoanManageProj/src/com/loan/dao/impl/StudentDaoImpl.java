/**
 * 
 * @Title: StudentDaoImpl.java
 * @Package com.loan.dao.impl
 * @Description: 学生信息数据访问实现类
 * @author He ChangYan
 * @date 2012-3-1 上午08:22:26
 * @copyright STARIT   
 */
package com.loan.dao.impl;

import java.util.List;

import javax.swing.JOptionPane;

import org.springframework.orm.hibernate3.support.HibernateDaoSupport;

import com.loan.dao.StudentDao;
import com.loan.entity.Student;

public class StudentDaoImpl extends HibernateDaoSupport implements StudentDao {

	/**
	 * 查找所有贷款学生信息
	 */
	public List<Student> findAll() {
		List<Student> list = null;
		list = this.getSession().createQuery("from Student s").list();
		return list;
	}

	/**
	 * 增加贷款学生信息
	 */
	public boolean addStu(Student student) {
		boolean b = true;
		try {
			String sql = "from Student s where StuName = '" + student.stuName + "'"
				+ " or StuId = '" + student.stuId + "'";
			List<Student> list = null;
			list = this.getSession().createQuery(sql).list();
			if (list.size() == 0) {
				String sql1 = "from User u where UserId = '" + student.getUser().userId + "'";
				List<Student> list1 = null;
				list1 = this.getSession().createQuery(sql1).list();
				if(list1.size() > 0){
					this.getSession().save(student);
					JOptionPane.showMessageDialog(null, "您添加的学生信息已保存到数据库，可查询。", "提示", 2);
				}else {
					JOptionPane.showMessageDialog(null, "您添加的用户信息已存在。", "提示", 2);
				}
			} else {
				JOptionPane.showMessageDialog(null,
						"您的信息已存在,不需要重复添加。", "提示", 1);
			}
		} catch (Exception e) {
			b = false;
			e.printStackTrace();
		}
		return b;
	}

	/**
	 * 删除贷款学生信息
	 */
	public boolean delStu(Student student) {
		boolean b = true;
		try {
			this.getSession().delete(student);
		} catch (Exception e) {
			b = false;
			e.printStackTrace();
		}
		return b;
	}

	/**
	 * 修改贷款学生信息
	 */
	public boolean updateStu(Student student) {
		boolean b = true;
		try {
			this.getSession().update(student);
		} catch (Exception e) {
			b = false;
			e.printStackTrace();
		}
		return b;
	}

	/**
	 * 从数据库中查找一条数据
	 */
	public Student findStuById(String StuId) {
		return (Student) getSession().get(Student.class, StuId);
	}

	/**
	 * 根据条件查询数据
	 */
	public List<Student> searchStu(String sql) {
		List<Student> list = null;
		list = this.getSession().createQuery(sql).list();
		return list;
	}

	/**
	 * 查找个人信息
	 */
	public List<Student> findMyInfo(String sql) {
		List<Student> list = null;
		list = this.getSession().createQuery(sql).list();
		return list;
	}
	
	
}
