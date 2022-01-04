/**
* 
* @Title: NewsService.java
* @Package com.loan.service
* @Description: ���Ź���ҵ��ӿ���
* @author He ChangYan
* @date 2012-3-26 ����10:36:21
* @copyright STARIT   
*/
package com.loan.service;

import java.util.List;

import com.loan.entity.News;


public interface NewsService {

	/**��ѯ��������*/
	public List<News> findAll();
	
	/**�������*/
	public boolean addNews(News addNews);
	
	
	/**ɾ������*/
	public boolean delNews(News delNews);
	
	/**�����ݿ� �в��Ҷ�Ӧ��������Ϣ*/
	public News findNewsById(int nid);
}
