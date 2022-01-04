/**
 * 
 * @Title: News.java
 * @Package com.loan.entity
 * @Description: 新闻实体
 * @author He ChangYan
 * @date 2012-3-3 上午10:20:49
 * @copyright STARIT   
 */
package com.loan.entity;


public class News {

	// Fields
	
	public int Nid;//新闻编号
	public String Ntitle;//新闻标题
	public String Ntime;//发布时间
	public String Nfromto;//出处
	
	/*get()和set()方法*/
	public int getNid() {
		return Nid;
	}
	public void setNid(int nid) {
		Nid = nid;
	}
	public String getNtitle() {
		return Ntitle;
	}
	public void setNtitle(String ntitle) {
		Ntitle = ntitle;
	}
	public String getNtime() {
		return Ntime;
	}
	public void setNtime(String ntime) {
		Ntime = ntime;
	}
	public String getNfromto() {
		return Nfromto;
	}
	public void setNfromto(String nfromto) {
		Nfromto = nfromto;
	}

	public News(){
		
	}
	
	public News(int nid,String ntitle,String ntime,String nfromto){
		this.Nid = nid;
		this.Ntitle = ntitle;
		this.Ntime = ntime;
		this.Nfromto = nfromto;
	}
}