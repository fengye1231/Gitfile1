/**
* 
* @Title: StudentDao.java
* @Package com.loan.dao
* @Description: ѧ����Ϣ���ݷ��ʽӿ�
* @author He ChangYan
* @date 2012-3-1 ����08:21:56
* @copyright STARIT   
*/
package com.loan.dao;

import java.util.List;

import com.loan.entity.Student;

public interface StudentDao {

	/**�������д���ѧ������Ϣ*/
	public List<Student> findAll();

	/**���Ӵ���ѧ����Ϣ*/
	public boolean addStu(Student student);
	
	/**ɾ������ѧ����Ϣ*/
	public boolean delStu(Student student);
	
	/**�޸Ĵ���ѧ����Ϣ*/
	public boolean updateStu(Student student);

	/**����һ������*/
	public Student findStuById(String StuId);
	
	/**����������ѯ����*/
	public List<Student> searchStu(String sql);
	
	/**�����Լ�����Ϣ*/
	public List<Student> findMyInfo(String sql);
}
