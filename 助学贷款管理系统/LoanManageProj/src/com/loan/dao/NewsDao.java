/**
* 
* @Title: NewsDao.java
* @Package com.loan.dao
* @Description: ���Ź������ݷ��ʽӿ�
* @author He ChangYan
* @date 2012-3-26 ����10:39:15
* @copyright STARIT   
*/
package com.loan.dao;

import java.util.List;

import com.loan.entity.News;


public interface NewsDao {

	/**��ѯ��������*/
	public List<News> findAll();
	
	/**�������*/
	public boolean addNews(News addNews);
	
	/**ɾ������*/
	public boolean delNews(News delNews);
	
	/**�����ݿ� �в��Ҷ�Ӧ��������Ϣ*/
	public News findNewsById(int nid);
}
