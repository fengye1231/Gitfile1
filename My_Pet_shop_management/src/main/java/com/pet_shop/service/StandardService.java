package com.pet_shop.service;

import com.pet_shop.entity.Standard;

public interface StandardService {
    void update(Standard po);

    void add(Standard po);

    void deleteById(Long id);

    Object getAllByLimit(Standard po);
}
