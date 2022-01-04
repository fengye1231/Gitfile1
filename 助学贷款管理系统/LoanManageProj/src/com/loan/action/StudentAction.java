/**
 * 
 * @Title: StudentAction.java
 * @Package com.loan.action
 * @Description: 学生信息功能处理
 * @author He ChangYan
 * @date 2012-3-1 上午08:21:25
 * @copyright STARIT   
 */
package com.loan.action;

import java.util.List;
import java.util.Map;

import javax.swing.JOptionPane;

import org.apache.struts2.ServletActionContext;

import com.loan.entity.Student;
import com.loan.service.StudentService;

public class StudentAction {

	private Student student;// student实例对象
	private Student delStudent;
	private Student addStudent;
	private Student updateStudent;
	private List<Student> studentList;
	private List<Student> myInfoList;
	private Map<String, Object> session;
	private StudentService studentService;// 实例化service对象

	/* get和set方法 */
	public Student getStudent() {
		return student;
	}

	public void setStudent(Student student) {
		this.student = student;
	}

	public Student getDelStudent() {
		return delStudent;
	}

	public void setDelStudent(Student delStudent) {
		this.delStudent = delStudent;
	}

	public Student getAddStudent() {
		return addStudent;
	}

	public void setAddStudent(Student addStudent) {
		this.addStudent = addStudent;
	}

	public Student getUpdateStudent() {
		return updateStudent;
	}

	public void setUpdateStudent(Student updateStudent) {
		this.updateStudent = updateStudent;
	}

	public List<Student> getStudentList() {
		return studentList;
	}

	public void setStudentList(List<Student> studentList) {
		this.studentList = studentList;
	}

	public List<Student> getMyInfoList() {
		return myInfoList;
	}

	public void setMyInfoList(List<Student> myInfoList) {
		this.myInfoList = myInfoList;
	}

	public Map<String, Object> getSession() {
		return session;
	}

	public void setSession(Map<String, Object> session) {
		this.session = session;
	}

	public StudentService getStudentService() {
		return studentService;
	}

	public void setStudentService(StudentService studentService) {
		this.studentService = studentService;
	}

	/**
	 * 
	 * @Title: list
	 * @Description: 查找所有贷款学生的信息
	 * @return
	 * @return String
	 * @throws
	 */
	public String list() {
		studentList = studentService.findAll();
		return "list";
	}

	/**
	 * 
	* @Title: findMyInfo
	* @Description: 查找个人信息
	* @return    
	* @return String 
	* @throws
	 */
	public String findMyInfo() {
		String mg = "myInfoList";
		String userName = (String)ServletActionContext.getRequest().getSession().getAttribute("name");
		String sql = "from Student s where  stuName = '" + userName + "'";
		myInfoList = studentService.findMyInfo(sql);
		if (myInfoList.size() == 0) {
			String msg = "您的信息不存在，请添加个人信息!";
			JOptionPane.showMessageDialog(null, msg, "警告", 0);// 弹出提示信息对话框
			mg = "addMyInfo";
		}
		return mg;
	}

	/**
	 * 
	 * @Title: addStu
	 * @Description: 添加贷款学生信息
	 * @return
	 * @return String
	 * @throws
	 */
	public String addStu() {
		studentService.addStu(addStudent);
		return list();
	}

	/**
	 * 
	 * @Title: addStu
	 * @Description: 添加贷款学生信息
	 * @return
	 * @return String
	 * @throws
	 */
	public String addMyStu() {
		studentService.addStu(addStudent);
		return findMyInfo();
	}
	
	/**
	 * 
	 * @Title: delStu
	 * @Description: 删除贷款学生信息
	 * @return
	 * @return String
	 * @throws
	 */
	public String delStu() {
		Student studentDel = studentService.findStuById(delStudent.getStuId());
		studentService.delStu(studentDel);
		JOptionPane.showMessageDialog(null, "数据删除成功。", "提示", 2);
		return list();
	}

	/**
	 * 
	 * @Title: updateInput
	 * @Description: 从数据库中找到一条数据
	 * @return
	 * @return String
	 * @throws
	 */
	public String updateInput() {
		updateStudent = studentService.findStuById(updateStudent.getStuId());
		return "updateInput";
	}
	
	/**
	 * 
	 * @Title: updateInput
	 * @Description: 从数据库中找到一条数据
	 * @return
	 * @return String
	 * @throws
	 */
	public String updateInputMy() {
		updateStudent = studentService.findStuById(updateStudent.getStuId());
		return "updateInputMy";
	}

	/**
	 * 
	 * @Title: updateStu
	 * @Description: 修改贷款学生信息
	 * @return
	 * @return String
	 * @throws
	 */
	public String updateStu() {
		studentService.updateStu(updateStudent);
		JOptionPane.showMessageDialog(null, "数据修改成功。", "提示", 2);
		return list();
	}
	
	/**
	 * 
	 * @Title: updateStu
	 * @Description: 修改贷款学生信息
	 * @return
	 * @return String
	 * @throws
	 */
	public String updateMyInfo() {
		studentService.updateStu(updateStudent);
		JOptionPane.showMessageDialog(null, "数据修改成功。", "提示", 2);
		return findMyInfo();
	}

	/**
	 * 
	 * @Title: selectStu
	 * @Description: 根据条件查询数据
	 * @return
	 * @return String
	 * @throws
	 */
	public String searchStu() {
		String sql = "from Student s where stuId= '" + student.stuId + "'"
				+ " and stuName = '" + student.stuName + "'"
				+ " and stuIdentity = '" + student.stuIdentity + "'"
				+ " and stuSex = '" + student.stuSex + "'" + " and academy = '"
				+ student.academy + "'";
		studentList = studentService.searchStu(sql);
		if (studentList.size() == 0) {
			String msg = "您输入的查询条件不全面，不能找到相匹配的学生信息!请检查输入是否有误。";
			JOptionPane.showMessageDialog(null, msg, "警告", 0);// 弹出提示信息对话框
		}
		return "searchStu";
	}
}
