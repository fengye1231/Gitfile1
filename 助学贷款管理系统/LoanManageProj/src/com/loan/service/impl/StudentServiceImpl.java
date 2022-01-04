/**
 * 
 * @Title: StudentServiceImpl.java
 * @Package com.loan.service.impl
 * @Description: ѧ����Ϣҵ����ʵ����
 * @author He ChangYan
 * @date 2012-3-1 ����08:23:15
 * @copyright STARIT   
 */
package com.loan.service.impl;

import java.util.List;

import com.loan.dao.StudentDao;
import com.loan.entity.Student;
import com.loan.service.StudentService;

public class StudentServiceImpl implements StudentService {

	private StudentDao studentDao;// ʵ��DAO����

	public StudentDao getStudentDao() {
		return studentDao;
	}

	public void setStudentDao(StudentDao studentDao) {
		this.studentDao = studentDao;
	}

	/*
	 * (�� Javadoc) <p>Title: findAll</p> <p>Description: �������д���ѧ������Ϣ</p>
	 * 
	 * @return
	 * 
	 * @see com.loan.service.StudentService#findAll()
	 */
	public List<Student> findAll() {
		return studentDao.findAll();
	}

	/*
	 * (�� Javadoc) <p>Title: addStu</p> <p>Description: ���Ӵ���ѧ����Ϣ</p>
	 * 
	 * @param student
	 * 
	 * @see com.loan.service.StudentService#addStu(com.loan.entity.Student)
	 */
	public boolean addStu(Student student) {
		return studentDao.addStu(student);
	}

	/*
	 * (�� Javadoc) <p>Title: delStu</p> <p>Description: ɾ������ѧ����Ϣ</p>
	 * 
	 * @param student
	 * 
	 * @return
	 * 
	 * @see com.loan.service.StudentService#delStu(com.loan.entity.Student)
	 */
	public boolean delStu(Student student) {
		return studentDao.delStu(student);
	}

	/*
	 * (�� Javadoc) <p>Title: updateStu</p> <p>Description: �޸Ĵ���ѧ����Ϣ</p>
	 * 
	 * @param student
	 * 
	 * @return
	 * 
	 * @see com.loan.service.StudentService#updateStu(com.loan.entity.Student)
	 */
	public boolean updateStu(Student student) {
		return studentDao.updateStu(student);
	}

	/*
	 * (�� Javadoc) <p>Title: findStuById</p> <p>Description: �����ݿ��в���һ������</p>
	 * 
	 * @param StuId
	 * 
	 * @return
	 * 
	 * @see com.loan.service.StudentService#findStuById(java.lang.String)
	 */
	public Student findStuById(String StuId) {
		return studentDao.findStuById(StuId);
	}

	/*
	 * (�� Javadoc) <p>Title: selectStuInfo</p> <p>Description: ����������ѯ����</p>
	 * 
	 * @param sql
	 * 
	 * @return
	 * 
	 * @see com.loan.service.StudentService#selectStuInfo(java.lang.String)
	 */
	public List<Student> searchStu(String sql) {
		return studentDao.searchStu(sql);
	}

	/*
	 * (�� Javadoc) <p>Title: findMyInfo</p> <p>Description: �����Լ�����Ϣ</p>
	 * 
	 * @param sql
	 * 
	 * @return
	 * 
	 * @see com.loan.service.StudentService#findMyInfo(java.lang.String)
	 */
	public List<Student> findMyInfo(String sql) {
		return studentDao.findMyInfo(sql);
	}

}
