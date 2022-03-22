package com.pet_shop.service.impl;

import com.pet_shop.entity.Supplier;
import com.pet_shop.mapper.SupplierMapper;
import com.pet_shop.service.SupplierService;
import org.springframework.stereotype.Service;

import javax.annotation.Resource;
import java.util.List;
import java.util.Map;

/**
 * 供应商Service实现类
 *
 * @author pet_shop
 * @company
 * @create 2020-01-18 13:08
 */
@Service("supplierService")
public class SupplierServiceImpl implements SupplierService {

    @Resource
    private SupplierMapper supplierMapper;

    @Override
    public List<Supplier> findByName(String name) {
        return supplierMapper.findByName(name);
    }

    @Override
    public List<Supplier> list(Map<String, Object> map) {
        return supplierMapper.list(map);
    }

    @Override
    public Long getCount(Map<String, Object> map) {
        return supplierMapper.getCount(map);
    }

    @Override
    public Integer add(Supplier supplier) {
        return supplierMapper.add(supplier);
    }

    @Override
    public Integer update(Supplier supplier) {
        return supplierMapper.update(supplier);
    }

    @Override
    public Integer delete(Integer id) {
        return supplierMapper.delete(id);
    }

    @Override
    public Supplier findById(Integer id) {
        return supplierMapper.findById(id);
    }
}
