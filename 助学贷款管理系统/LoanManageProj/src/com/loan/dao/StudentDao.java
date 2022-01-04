/**
* 
* @Title: StudentDao.java
* @Package com.loan.dao
* @Description: 学生信息数据访问接口
* @author He ChangYan
* @date 2012-3-1 上午08:21:56
* @copyright STARIT   
*/
package com.loan.dao;

import java.util.List;

import com.loan.entity.Student;

public interface StudentDao {

	/**查找所有贷款学生的信息*/
	public List<Student> findAll();

	/**增加贷款学生信息*/
	public boolean addStu(Student student);
	
	/**删除贷款学生信息*/
	public boolean delStu(Student student);
	
	/**修改贷款学生信息*/
	public boolean updateStu(Student student);

	/**查找一条数据*/
	public Student findStuById(String StuId);
	
	/**根据条件查询数据*/
	public List<Student> searchStu(String sql);
	
	/**查找自己的信息*/
	public List<Student> findMyInfo(String sql);
}
