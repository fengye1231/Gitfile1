/**
 * 
 * @Title: NewsAction.java
 * @Package com.loan.action
 * @Description: 新闻管理
 * @author He ChangYan
 * @date 2012-3-26 上午10:32:25
 * @copyright STARIT   
 */
package com.loan.action;

import java.util.List;

import javax.swing.JOptionPane;

import com.loan.entity.News;
import com.loan.service.NewsService;

public class NewsAction {

	public News news;//实例化新闻对象
	public List<News> newsList;//新闻集合
	public News addNews;//添加新闻
	public News delNews;//删除新闻
	public NewsService newsService;
	
	public News getNews() {
		return news;
	}

	public void setNews(News news) {
		this.news = news;
	}

	public List<News> getNewsList() {
		return newsList;
	}

	public void setNewsList(List<News> newsList) {
		this.newsList = newsList;
	}

	public News getAddNews() {
		return addNews;
	}

	public void setAddNews(News addNews) {
		this.addNews = addNews;
	}

	public News getDelNews() {
		return delNews;
	}

	public void setDelNews(News delNews) {
		this.delNews = delNews;
	}

	public NewsService getNewsService() {
		return newsService;
	}

	public void setNewsService(NewsService newsService) {
		this.newsService = newsService;
	}

	/**
	 * 
	 * @Title: list
	 * @Description: 返回所有新闻
	 * @return
	 * @return String
	 * @throws
	 */
	public String list() {
		newsList = newsService.findAll();
		return "list";
	}
	
	/**
	 * 
	 * @Title: listStu
	 * @Description: 返回所有新闻
	 * @return
	 * @return String
	 * @throws
	 */
	public String listStu() {
		newsList = newsService.findAll();
		return "listStu";
	}
	
	/**
	 * 
	 * @Title: addNews
	 * @Description: 添加新闻
	 * @return
	 * @return String
	 * @throws
	 */
	public String addNews() {
		newsService.addNews(addNews);
		return list();
	}

	/**
	 * 
	* @Title: delNews
	* @Description: 删除新闻
	* @return    
	* @return String 
	* @throws
	 */
	public String delNews() {
		News newsDel = newsService.findNewsById(delNews.getNid());
		newsService.delNews(newsDel);
		JOptionPane.showMessageDialog(null, "数据删除成功。", "提示", 2);
		return list();
	}
	
	
}
