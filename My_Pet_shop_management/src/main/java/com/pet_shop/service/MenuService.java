package com.pet_shop.service;

import com.pet_shop.entity.Menu;

import java.util.List;

/**
 * 权限菜单Service接口
 *
 * @author pet_shop
 * @company
 * @create 2020-01-16 22:42
 */
public interface MenuService {

    /**
     * 根据父节点以及用户角色id查询子节点
     *
     * @param parentId
     * @param roleId
     * @return
     */
    List<Menu> findByParentIdAndRoleId(Integer parentId, Integer roleId);

    /**
     * 根据角色id获取菜单集合
     *
     * @param roleId
     * @return
     */
    List<Menu> findByRoleId(Integer roleId);

    /**
     * 根据id查询实体
     *
     * @param id
     * @return
     */
    Menu findById(Integer id);

    /**
     * 根据父节点查找所有子节点
     *
     * @param parentId
     * @return
     */
    List<Menu> findByParentId(Integer parentId);
}