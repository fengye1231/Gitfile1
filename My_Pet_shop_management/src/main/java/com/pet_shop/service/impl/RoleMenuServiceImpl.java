package com.pet_shop.service.impl;

import com.pet_shop.mapper.RoleMenuMapper;
import com.pet_shop.service.RoleMenuService;
import org.springframework.stereotype.Service;

import javax.annotation.Resource;

/**
 * 角色菜单关联Service实现类
 *
 * @author pet_shop
 * @company
 * @create 2020-01-17 13:04
 */
@Service("roleMenuService")
public class RoleMenuServiceImpl implements RoleMenuService {

    @Resource
    private RoleMenuMapper roleMenuMapper;

    @Override
    public Integer deleteByRoleId(Integer roleId) {
        return roleMenuMapper.deleteByRoleId(roleId);
    }

    @Override
    public Integer add(Integer roleId, Integer menuId) {
        return roleMenuMapper.add(roleId, menuId);
    }
}
