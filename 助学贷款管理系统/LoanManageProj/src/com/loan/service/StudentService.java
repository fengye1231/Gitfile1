/**
* 
* @Title: StudentService.java
* @Package com.loan.service
* @Description: ѧ����Ϣҵ����ӿ�
* @author He ChangYan
* @date 2012-3-1 ����08:22:44
* @copyright STARIT   
*/
package com.loan.service;

import java.util.List;

import com.loan.entity.Student;


public interface StudentService {

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
