package com.yx.po;

import java.io.Serializable;
import java.util.Date;

public class BookInfo implements Serializable {
    /**
     * This field was generated by MyBatis Generator.
     * This field corresponds to the database column book_info.id
     *
     * @mbggenerated Tue Mar 30 16:30:04 CST 2021
     */
    private Integer id;

    /**
     * This field was generated by MyBatis Generator.
     * This field corresponds to the database column book_info.name
     *
     * @mbggenerated Tue Mar 30 16:30:04 CST 2021
     */
    private String name;

    /**
     * This field was generated by MyBatis Generator.
     * This field corresponds to the database column book_info.author
     *
     * @mbggenerated Tue Mar 30 16:30:04 CST 2021
     */
    private String author;

    /**
     * This field was generated by MyBatis Generator.
     * This field corresponds to the database column book_info.publish
     *
     * @mbggenerated Tue Mar 30 16:30:04 CST 2021
     */
    private String publish;

    /**
     * This field was generated by MyBatis Generator.
     * This field corresponds to the database column book_info.ISBN
     *
     * @mbggenerated Tue Mar 30 16:30:04 CST 2021
     */
    private String isbn;

    /**
     * This field was generated by MyBatis Generator.
     * This field corresponds to the database column book_info.introduction
     *
     * @mbggenerated Tue Mar 30 16:30:04 CST 2021
     */
    private String introduction;

    /**
     * This field was generated by MyBatis Generator.
     * This field corresponds to the database column book_info.language
     *
     * @mbggenerated Tue Mar 30 16:30:04 CST 2021
     */
    private String language;

    /**
     * This field was generated by MyBatis Generator.
     * This field corresponds to the database column book_info.price
     *
     * @mbggenerated Tue Mar 30 16:30:04 CST 2021
     */
    private Double price;

    /**
     * This field was generated by MyBatis Generator.
     * This field corresponds to the database column book_info.publish_date
     *
     * @mbggenerated Tue Mar 30 16:30:04 CST 2021
     */
    private Date publishDate;

    /**
     * This field was generated by MyBatis Generator.
     * This field corresponds to the database column book_info.type_id
     *
     * @mbggenerated Tue Mar 30 16:30:04 CST 2021
     */
    private Integer typeId;

    /**
     * This field was generated by MyBatis Generator.
     * This field corresponds to the database column book_info.status
     *
     * @mbggenerated Tue Mar 30 16:30:04 CST 2021
     */
    private Integer status;

    /**
     * This field was generated by MyBatis Generator.
     * This field corresponds to the database table book_info
     *
     * @mbggenerated Tue Mar 30 16:30:04 CST 2021
     */
    private TypeInfo typeInfo;//图书类型，在图书馆里中显示什么类型的书

    private Integer counts;

    public Integer getCounts() {
        return counts;
    }

    public void setCounts(Integer counts) {
        this.counts = counts;
    }

    public TypeInfo getTypeInfo() {
        return typeInfo;
    }

    public void setTypeInfo(TypeInfo typeInfo) {
        this.typeInfo = typeInfo;
    }

    private static final long serialVersionUID = 1L;

    /**
     * This method was generated by MyBatis Generator.
     * This method returns the value of the database column book_info.id
     *
     * @return the value of book_info.id
     *
     * @mbggenerated Tue Mar 30 16:30:04 CST 2021
     */
    public Integer getId() {
        return id;
    }

    /**
     * This method was generated by MyBatis Generator.
     * This method sets the value of the database column book_info.id
     *
     * @param id the value for book_info.id
     *
     * @mbggenerated Tue Mar 30 16:30:04 CST 2021
     */
    public void setId(Integer id) {
        this.id = id;
    }

    /**
     * This method was generated by MyBatis Generator.
     * This method returns the value of the database column book_info.name
     *
     * @return the value of book_info.name
     *
     * @mbggenerated Tue Mar 30 16:30:04 CST 2021
     */
    public String getName() {
        return name;
    }

    /**
     * This method was generated by MyBatis Generator.
     * This method sets the value of the database column book_info.name
     *
     * @param name the value for book_info.name
     *
     * @mbggenerated Tue Mar 30 16:30:04 CST 2021
     */
    public void setName(String name) {
        this.name = name == null ? null : name.trim();
    }

    /**
     * This method was generated by MyBatis Generator.
     * This method returns the value of the database column book_info.author
     *
     * @return the value of book_info.author
     *
     * @mbggenerated Tue Mar 30 16:30:04 CST 2021
     */
    public String getAuthor() {
        return author;
    }

    /**
     * This method was generated by MyBatis Generator.
     * This method sets the value of the database column book_info.author
     *
     * @param author the value for book_info.author
     *
     * @mbggenerated Tue Mar 30 16:30:04 CST 2021
     */
    public void setAuthor(String author) {
        this.author = author == null ? null : author.trim();
    }

    /**
     * This method was generated by MyBatis Generator.
     * This method returns the value of the database column book_info.publish
     *
     * @return the value of book_info.publish
     *
     * @mbggenerated Tue Mar 30 16:30:04 CST 2021
     */
    public String getPublish() {
        return publish;
    }

    /**
     * This method was generated by MyBatis Generator.
     * This method sets the value of the database column book_info.publish
     *
     * @param publish the value for book_info.publish
     *
     * @mbggenerated Tue Mar 30 16:30:04 CST 2021
     */
    public void setPublish(String publish) {
        this.publish = publish == null ? null : publish.trim();
    }

    /**
     * This method was generated by MyBatis Generator.
     * This method returns the value of the database column book_info.ISBN
     *
     * @return the value of book_info.ISBN
     *
     * @mbggenerated Tue Mar 30 16:30:04 CST 2021
     */
    public String getIsbn() {
        return isbn;
    }

    /**
     * This method was generated by MyBatis Generator.
     * This method sets the value of the database column book_info.ISBN
     *
     * @param isbn the value for book_info.ISBN
     *
     * @mbggenerated Tue Mar 30 16:30:04 CST 2021
     */
    public void setIsbn(String isbn) {
        this.isbn = isbn == null ? null : isbn.trim();
    }

    /**
     * This method was generated by MyBatis Generator.
     * This method returns the value of the database column book_info.introduction
     *
     * @return the value of book_info.introduction
     *
     * @mbggenerated Tue Mar 30 16:30:04 CST 2021
     */
    public String getIntroduction() {
        return introduction;
    }

    /**
     * This method was generated by MyBatis Generator.
     * This method sets the value of the database column book_info.introduction
     *
     * @param introduction the value for book_info.introduction
     *
     * @mbggenerated Tue Mar 30 16:30:04 CST 2021
     */
    public void setIntroduction(String introduction) {
        this.introduction = introduction == null ? null : introduction.trim();
    }

    /**
     * This method was generated by MyBatis Generator.
     * This method returns the value of the database column book_info.language
     *
     * @return the value of book_info.language
     *
     * @mbggenerated Tue Mar 30 16:30:04 CST 2021
     */
    public String getLanguage() {
        return language;
    }

    /**
     * This method was generated by MyBatis Generator.
     * This method sets the value of the database column book_info.language
     *
     * @param language the value for book_info.language
     *
     * @mbggenerated Tue Mar 30 16:30:04 CST 2021
     */
    public void setLanguage(String language) {
        this.language = language == null ? null : language.trim();
    }

    /**
     * This method was generated by MyBatis Generator.
     * This method returns the value of the database column book_info.price
     *
     * @return the value of book_info.price
     *
     * @mbggenerated Tue Mar 30 16:30:04 CST 2021
     */
    public Double getPrice() {
        return price;
    }

    /**
     * This method was generated by MyBatis Generator.
     * This method sets the value of the database column book_info.price
     *
     * @param price the value for book_info.price
     *
     * @mbggenerated Tue Mar 30 16:30:04 CST 2021
     */
    public void setPrice(Double price) {
        this.price = price;
    }

    /**
     * This method was generated by MyBatis Generator.
     * This method returns the value of the database column book_info.publish_date
     *
     * @return the value of book_info.publish_date
     *
     * @mbggenerated Tue Mar 30 16:30:04 CST 2021
     */
    public Date getPublishDate() {
        return publishDate;
    }

    /**
     * This method was generated by MyBatis Generator.
     * This method sets the value of the database column book_info.publish_date
     *
     * @param publishDate the value for book_info.publish_date
     *
     * @mbggenerated Tue Mar 30 16:30:04 CST 2021
     */
    public void setPublishDate(Date publishDate) {
        this.publishDate = publishDate;
    }

    /**
     * This method was generated by MyBatis Generator.
     * This method returns the value of the database column book_info.type_id
     *
     * @return the value of book_info.type_id
     *
     * @mbggenerated Tue Mar 30 16:30:04 CST 2021
     */
    public Integer getTypeId() {
        return typeId;
    }

    /**
     * This method was generated by MyBatis Generator.
     * This method sets the value of the database column book_info.type_id
     *
     * @param typeId the value for book_info.type_id
     *
     * @mbggenerated Tue Mar 30 16:30:04 CST 2021
     */
    public void setTypeId(Integer typeId) {
        this.typeId = typeId;
    }

    /**
     * This method was generated by MyBatis Generator.
     * This method returns the value of the database column book_info.status
     *
     * @return the value of book_info.status
     *
     * @mbggenerated Tue Mar 30 16:30:04 CST 2021
     */
    public Integer getStatus() {
        return status;
    }

    /**
     * This method was generated by MyBatis Generator.
     * This method sets the value of the database column book_info.status
     *
     * @param status the value for book_info.status
     *
     * @mbggenerated Tue Mar 30 16:30:04 CST 2021
     */
    public void setStatus(Integer status) {
        this.status = status;
    }
}