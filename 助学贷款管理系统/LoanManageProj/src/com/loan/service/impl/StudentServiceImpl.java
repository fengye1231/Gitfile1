/**
 * 
 * @Title: StudentServiceImpl.java
 * @Package com.loan.service.impl
 * @Description: 学生信息业务处理实现类
 * @author He ChangYan
 * @date 2012-3-1 上午08:23:15
 * @copyright STARIT   
 */
package com.loan.service.impl;

import java.util.List;

import com.loan.dao.StudentDao;
import com.loan.entity.Student;
import com.loan.service.StudentService;

public class StudentServiceImpl implements StudentService {

	private StudentDao studentDao;// 实例DAO对象

	public StudentDao getStudentDao() {
		return studentDao;
	}

	public void setStudentDao(StudentDao studentDao) {
		this.studentDao = studentDao;
	}

	/*
	 * (非 Javadoc) <p>Title: findAll</p> <p>Description: 查找所有贷款学生的信息</p>
	 * 
	 * @return
	 * 
	 * @see com.loan.service.StudentService#findAll()
	 */
	public List<Student> findAll() {
		return studentDao.findAll();
	}

	/*
	 * (非 Javadoc) <p>Title: addStu</p> <p>Description: 增加贷款学生信息</p>
	 * 
	 * @param student
	 * 
	 * @see com.loan.service.StudentService#addStu(com.loan.entity.Student)
	 */
	public boolean addStu(Student student) {
		return studentDao.addStu(student);
	}

	/*
	 * (非 Javadoc) <p>Title: delStu</p> <p>Description: 删除贷款学生信息</p>
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
	 * (非 Javadoc) <p>Title: updateStu</p> <p>Description: 修改贷款学生信息</p>
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
	 * (非 Javadoc) <p>Title: findStuById</p> <p>Description: 从数据库中查找一条数据</p>
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
	 * (非 Javadoc) <p>Title: selectStuInfo</p> <p>Description: 根据条件查询数据</p>
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
	 * (非 Javadoc) <p>Title: findMyInfo</p> <p>Description: 查找自己的信息</p>
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
