/**
* 
* @Title: NewsService.java
* @Package com.loan.service
* @Description: 新闻管理业务接口类
* @author He ChangYan
* @date 2012-3-26 上午10:36:21
* @copyright STARIT   
*/
package com.loan.service;

import java.util.List;

import com.loan.entity.News;


public interface NewsService {

	/**查询所有新闻*/
	public List<News> findAll();
	
	/**添加新闻*/
	public boolean addNews(News addNews);
	
	
	/**删除新闻*/
	public boolean delNews(News delNews);
	
	/**从数据库 中查找对应的新闻信息*/
	public News findNewsById(int nid);
}
