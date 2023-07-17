package com.example.dic2info.wsREST.service;

import com.example.dic2info.wsREST.model.Article;
import com.example.dic2info.wsREST.model.Categorie;
import com.example.dic2info.wsREST.repository.CategorieRepository;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

import java.util.List;
import java.util.Optional;

@Service
public class CategorieService {
    @Autowired
    public CategorieRepository categorieRepository;

    @Autowired
    public  ArticleService articleService;

    public Categorie saveOneCategorie(Categorie categorie){
        Categorie savedCategorie   = categorieRepository.save(categorie);
        return savedCategorie;
    }

    public List<Categorie> listCategories(){
        return categorieRepository.findAll();
    }

    public Optional<Categorie> getOneCategorieById(Long id){
        return categorieRepository.findById(id);
    }

    public Categorie getCategorieById(Long id) {
        return categorieRepository.findById(id).orElse(null);
    }

}
