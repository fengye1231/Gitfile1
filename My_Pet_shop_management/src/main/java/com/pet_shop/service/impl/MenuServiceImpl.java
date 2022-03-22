package com.pet_shop.service.impl;

import com.pet_shop.entity.Menu;
import com.pet_shop.mapper.MenuMapper;
import com.pet_shop.service.MenuService;
import org.springframework.stereotype.Service;

import javax.annotation.Resource;
import java.util.List;

/**
 * 权限菜单Service实现类
 *
 * @author pet_shop
 * @company
 * @create 2020-01-16 22:42
 */
@Service("menuService")
public class MenuServiceImpl implements MenuService {

    @Resource
    private MenuMapper menuMapper;

    @Override
    public List<Menu> findByParentIdAndRoleId(Integer parentId, Integer roleId) {
        return menuMapper.findByParentIdAndRoleId(parentId, roleId);
    }

    @Override
    public List<Menu> findByRoleId(Integer roleId) {
        return menuMapper.findByRoleId(roleId);
    }

    @Override
    public Menu findById(Integer id) {
        return menuMapper.findById(id);
    }

    @Override
    public List<Menu> findByParentId(Integer parentId) {
        return menuMapper.findByParentId(parentId);
    }
}
