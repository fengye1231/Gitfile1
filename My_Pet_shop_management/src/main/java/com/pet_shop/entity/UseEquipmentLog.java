package com.pet_shop.entity;

import java.util.Date;

/**
 * 设备使用记录实体
 *
 * @author pet_shop
 * @company
 * @create 2020-04-04 14:47
 */
public class UseEquipmentLog {

    /**
     * 编号
     */
    private Integer id;
    /**
     * 开始使用时间
     */
    private Date beginDate;
    /**
     * 结束使用的时间
     */
    private Date endDate;
    /**
     * 使用的用户
     */
    private User user;
    /**
     * 使用的用户id
     */
    private Integer userId;
    /**
     * 使用的设备
     */
    private Equipment equipment;
    /**
     * 使用的设备id
     */
    private Integer equipmentId;
    /**
     * 使用设备的用户
     */
    private String userName;
    /**
     * 标签,用来插入结束日期
     */
    private Integer key;

    public Integer getId() {
        return id;
    }

    public void setId(Integer id) {
        this.id = id;
    }

    public Date getBeginDate() {
        return beginDate;
    }

    public void setBeginDate(Date beginDate) {
        this.beginDate = beginDate;
    }

    public Date getEndDate() {
        return endDate;
    }

    public void setEndDate(Date endDate) {
        this.endDate = endDate;
    }

    public User getUser() {
        return user;
    }

    public void setUser(User user) {
        this.user = user;
    }

    public Integer getUserId() {
        return userId;
    }

    public void setUserId(Integer userId) {
        this.userId = userId;
    }

    public Equipment getEquipment() {
        return equipment;
    }

    public void setEquipment(Equipment equipment) {
        this.equipment = equipment;
    }

    public Integer getEquipmentId() {
        return equipmentId;
    }

    public void setEquipmentId(Integer equipmentId) {
        this.equipmentId = equipmentId;
    }

    public String getUserName() {
        return userName;
    }

    public void setUserName(String userName) {
        this.userName = userName;
    }

    public Integer getKey() {
        return key;
    }

    public void setKey(Integer key) {
        this.key = key;
    }

    @Override
    public String toString() {
        return "UseEquipmentLog{" +
                "id=" + id +
                ", beginDate=" + beginDate +
                ", endDate=" + endDate +
                ", user=" + user +
                ", userId=" + userId +
                ", equipment=" + equipment +
                ", equipmentId=" + equipmentId +
                ", userName='" + userName + '\'' +
                ", key=" + key +
                '}';
    }
}
