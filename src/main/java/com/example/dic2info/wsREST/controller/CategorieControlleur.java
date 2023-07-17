package com.example.dic2info.wsREST.controller;

import com.example.dic2info.wsREST.model.Article;
import com.example.dic2info.wsREST.model.Categorie;
import com.example.dic2info.wsREST.repository.ArticleRepository;
import com.example.dic2info.wsREST.service.ArticleService;
import com.example.dic2info.wsREST.service.CategorieService;
import jakarta.transaction.Transactional;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.http.ResponseEntity;
import org.springframework.stereotype.Controller;
import org.springframework.web.bind.annotation.*;

import java.util.List;
import java.util.Optional;

@RestController
@RequestMapping("/api/")
public class CategorieControlleur {
    @Autowired
    private CategorieService categorieService;

    @Autowired
    private ArticleService articleService;

    @Autowired
    private ArticleRepository articleRepository;

//    @GetMapping("")
//    public String home(){
//        return "hello";
//    }

    @GetMapping("/categories")
    public List<Categorie> allCategorie(){
        return categorieService.listCategories();
    }

    @GetMapping("/categorie/{id}")
    public Optional<Categorie> getCategorieBydId(@PathVariable(name = "id") Long id){
        return categorieService.getOneCategorieById(id);
    }

    @PostMapping("/categorie")
    public Categorie saveOneCategorie(@RequestBody Categorie categorie){
        System.out.println(categorie);
        return  categorieService.saveOneCategorie(categorie);
    }

    @GetMapping("/categorie/{id}/articles")
    public List<Article> articlesOfOneCategorie(@PathVariable(name = "id") Long id){
        return articleRepository.findByCategorie_Id(id);
    }

    @DeleteMapping("/categorie/{id}")
    public ResponseEntity<Void> deleteOneCategorie(@PathVariable(name = "id")Long id){
        articleService.deleteOneCategorie(id);
        return ResponseEntity.noContent().build();
    }

    @PutMapping("/categorie/{id}")
    public ResponseEntity<String> modifierCategorie(@PathVariable("id") Long id, @RequestBody Categorie categorie) {
        Categorie categorieExistante = categorieService.getCategorieById(id);

        if (categorieExistante == null) {
            return ResponseEntity.notFound().build();
        }

        // Mettre à jour les propriétés de la catégorie existante avec les nouvelles valeurs
        categorieExistante.setNom(categorie.getNom());
        categorieService.saveOneCategorie(categorieExistante);

        return ResponseEntity.ok("Catégorie modifiée avec succès");
    }
}
