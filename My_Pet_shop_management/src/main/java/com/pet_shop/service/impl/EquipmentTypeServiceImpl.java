package com.pet_shop.service.impl;

import com.pet_shop.entity.EquipmentType;
import com.pet_shop.mapper.EquipmentTypeMapper;
import com.pet_shop.service.EquipmentTypeService;
import org.springframework.stereotype.Service;

import javax.annotation.Resource;
import java.util.List;
import java.util.Map;

/**
 * 设备类型Service实现类
 *
 * @author pet_shop
 * @company
 * @create 2020-01-26 00:18
 */
@Service("equipmentTypeService")
public class EquipmentTypeServiceImpl implements EquipmentTypeService {

    @Resource
    private EquipmentTypeMapper equipmentTypeMapper;

    @Override
    public List<EquipmentType> list(Map<String, Object> map) {
        return equipmentTypeMapper.list(map);
    }

    @Override
    public Long getCount(Map<String, Object> map) {
        return equipmentTypeMapper.getCount(map);
    }

    @Override
    public Integer add(EquipmentType equipmentType) {
        return equipmentTypeMapper.add(equipmentType);
    }

    @Override
    public Integer update(EquipmentType equipmentType) {
        return equipmentTypeMapper.update(equipmentType);
    }

    @Override
    public Integer delete(Integer id) {
        return equipmentTypeMapper.delete(id);
    }

    @Override
    public EquipmentType findById(Integer id) {
        return equipmentTypeMapper.findById(id);
    }

    @Override
    public List<EquipmentType> findByName(String name) {
        return equipmentTypeMapper.findByName(name);
    }
}
