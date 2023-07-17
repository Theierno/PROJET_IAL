package com.example.dic2info.wsREST.controller;

import com.example.dic2info.wsREST.model.Article;
import com.example.dic2info.wsREST.service.ArticleService;
import com.example.dic2info.wsSOAP.model.Role;
import com.example.dic2info.wsSOAP.model.User;
import com.example.dic2info.wsSOAP.repository.UserRepository;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.*;

import java.util.List;
import java.util.Optional;


@RestController
@RequestMapping("/api/")
public class ArticleControlleur {
    @Autowired
    private ArticleService articleService;

    @Autowired
    private UserRepository userRepository;

    @GetMapping("/articles")
    public List<Article> listAricle(){
        return  articleService.listArticles();
    }

    @PostMapping("/article")
    public Article saveArticle(@RequestBody Article article){
        System.out.println(article);
          return  articleService.saveOneArticle(article);
    }

    @GetMapping("/article/{id}")
    public Optional<Article> getOneArticle(@PathVariable(name = "id") Long id){
        return  articleService.getOneArticle(id);
    }

    @DeleteMapping("/article/{id}")
    public void deleteArticle(@PathVariable("id") final Long id){
        System.out.println("id :="+id);
        articleService.deleteOneArticle(id);
    }

    @GetMapping("/article/nb")
    public Long numberOfArticles(){
        return  articleService.numberOfArticles();
    }

    @GetMapping("/article/latest")
    public Article latest(){
        return articleService.getLatest();
    }

    @PutMapping("/article/{id}")
    public Article updatedArticle(@PathVariable(name = "id") Long id, @RequestBody Article article){
         return articleService.updateArticle(id,article);
    }

}
