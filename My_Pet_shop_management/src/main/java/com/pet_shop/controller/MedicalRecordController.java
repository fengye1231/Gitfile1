package com.pet_shop.controller;

import com.pet_shop.entity.Customer;
import com.pet_shop.entity.MedicalRecord;
import com.pet_shop.entity.Pet;
import com.pet_shop.service.MedicalRecordService;
import com.pet_shop.service.PetService;
import com.pet_shop.util.PageUtil;
import com.pet_shop.util.StringUtil;
import org.springframework.stereotype.Controller;
import org.springframework.web.bind.annotation.PathVariable;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.servlet.ModelAndView;

import javax.annotation.Resource;
import javax.servlet.http.HttpSession;
import java.util.HashMap;
import java.util.List;
import java.util.Map;

/**
 * 前台病历单Controller层
 *
 * @author pet_shop
 * @company
 * @create 2020-03-19 19:21
 */
@Controller
@RequestMapping("/medicalRecord")
public class MedicalRecordController {

    @Resource
    private MedicalRecordService medicalRecordService;

    @Resource
    private PetService petService;

    /**
     * 我的病例单
     *
     * @param page
     * @param session
     * @return
     */
    @RequestMapping("/myMedicalRecord/list/{id}")
    public ModelAndView myMedicalRecord(@PathVariable(value = "id", required = false) Integer page, HttpSession session) {
        ModelAndView mav = new ModelAndView();
        Map<String, Object> map = new HashMap<>(16);
        int pageSize = 4;
        map.put("start", (page - 1) * pageSize);
        map.put("size", pageSize);
        Customer currentCustomer = (Customer) session.getAttribute("currentCustomer");
        map.put("customerName", StringUtil.formatLike(currentCustomer.getContact()));
        List<MedicalRecord> medicalRecordList = medicalRecordService.list(map);
        for (MedicalRecord medicalRecord : medicalRecordList) {
            Pet pet = petService.findByName(medicalRecord.getPetName());
            medicalRecord.setPet(pet);
        }
        Long total = medicalRecordService.getCount(map);
        mav.addObject("medicalRecordList", medicalRecordList);
        mav.addObject("total", total);
        mav.addObject("pageCode", PageUtil.genPagination2("/medicalRecord/myMedicalRecord/list", total, page, pageSize));
        mav.addObject("title", "我的病例单");
        mav.addObject("mainPage", "page/medicalRecord/myMedicalRecord");
        mav.addObject("mainPageKey", "#b");
        mav.setViewName("index");
        return mav;
    }

    /**
     * 查看病历单详情
     *
     * @param medicalRecordId
     * @return
     */
    @RequestMapping("/medicalRecordDetails")
    public ModelAndView medicalRecordDetails(Integer medicalRecordId) {
        MedicalRecord medicalRecord = medicalRecordService.findById(medicalRecordId);
        ModelAndView mav = new ModelAndView();
        mav.addObject("medicalRecord", medicalRecord);
        mav.addObject("title", "查看病历单详情");
        mav.addObject("mainPage", "page/medicalRecord/medicalRecordDetails");
        mav.addObject("mainPageKey", "#b");
        mav.setViewName("index");
        return mav;
    }
}
