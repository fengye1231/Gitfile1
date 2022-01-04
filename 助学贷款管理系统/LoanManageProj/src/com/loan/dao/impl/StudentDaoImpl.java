/**
 * 
 * @Title: StudentDaoImpl.java
 * @Package com.loan.dao.impl
 * @Description: ѧ����Ϣ���ݷ���ʵ����
 * @author He ChangYan
 * @date 2012-3-1 ����08:22:26
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
	 * �������д���ѧ����Ϣ
	 */
	public List<Student> findAll() {
		List<Student> list = null;
		list = this.getSession().createQuery("from Student s").list();
		return list;
	}

	/**
	 * ���Ӵ���ѧ����Ϣ
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
					JOptionPane.showMessageDialog(null, "����ӵ�ѧ����Ϣ�ѱ��浽���ݿ⣬�ɲ�ѯ��", "��ʾ", 2);
				}else {
					JOptionPane.showMessageDialog(null, "����ӵ��û���Ϣ�Ѵ��ڡ�", "��ʾ", 2);
				}
			} else {
				JOptionPane.showMessageDialog(null,
						"������Ϣ�Ѵ���,����Ҫ�ظ���ӡ�", "��ʾ", 1);
			}
		} catch (Exception e) {
			b = false;
			e.printStackTrace();
		}
		return b;
	}

	/**
	 * ɾ������ѧ����Ϣ
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
	 * �޸Ĵ���ѧ����Ϣ
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
	 * �����ݿ��в���һ������
	 */
	public Student findStuById(String StuId) {
		return (Student) getSession().get(Student.class, StuId);
	}

	/**
	 * ����������ѯ����
	 */
	public List<Student> searchStu(String sql) {
		List<Student> list = null;
		list = this.getSession().createQuery(sql).list();
		return list;
	}

	/**
	 * ���Ҹ�����Ϣ
	 */
	public List<Student> findMyInfo(String sql) {
		List<Student> list = null;
		list = this.getSession().createQuery(sql).list();
		return list;
	}
	
	
}
