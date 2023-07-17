package com.example.dic2info.wsREST.service;

import com.example.dic2info.wsREST.model.Article;
import com.example.dic2info.wsREST.model.Categorie;
import com.example.dic2info.wsREST.repository.ArticleRepository;
import com.example.dic2info.wsREST.repository.CategorieRepository;
import org.springframework.transaction.annotation.Transactional;
import org.apache.coyote.Response;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.data.domain.Sort;
import org.springframework.http.HttpStatus;
import org.springframework.http.HttpStatusCode;
import org.springframework.http.ResponseEntity;
import org.springframework.stereotype.Service;
import org.springframework.web.ErrorResponse;
import org.springframework.web.server.ResponseStatusException;

import java.util.List;
import java.util.NoSuchElementException;
import java.util.Optional;

@Service
@Transactional
public class ArticleService {
    @Autowired
    private ArticleRepository articleRepository;
    @Autowired
    private CategorieRepository categorieRepository;

    public Article saveOneArticle(Article article) {
        Categorie categorie = categorieRepository.findByNom(article.getNomCategorie());
        if (categorie == null) {
            String message = "La catégorie " + article.getNomCategorie() + " n'existe pas.";
            ResponseEntity.status(HttpStatus.NOT_FOUND).body(message);
        } else {
            // Associez la catégorie à l'article
            article.setCategorie(categorie);

            // Ajoutez l'article à la liste des articles de la catégorie
            categorie.getArticles().add(article);

            // Enregistrez l'article en base de données
        }
        return articleRepository.save(article);

    }

    public List<Article> listArticles(){
        return articleRepository.findAll();
    }
    public Optional<Article> getOneArticle(Long id){
        return articleRepository.findById(id);
    }

    public void deleteOneArticle(final Long id){
        Article article = articleRepository.findById(id).orElse(null);
        if (article!=null){
            System.out.println("Deleting article with ID: " + id);
            articleRepository.deleteByTitle(article.getTitre());
        }else{
            System.out.println("Suppresion non effectuer");
        }

    }

    public Long numberOfArticles(){
        return articleRepository.count();
    }

    public Article updateArticle(Long articleId, Article updatedArticle) {
        Article existingArticle = articleRepository.findById(articleId)
                .orElseThrow(() -> new NoSuchElementException("Article not found with id: " + articleId));

        Categorie existingCategorie = existingArticle.getCategorie();
        Categorie newCategorie = null;

        // Vérifier si la nouvelle catégorie existe
        String newCategorieName = updatedArticle.getNomCategorie();
        if (newCategorieName != null) {
            newCategorie = categorieRepository.findByNom(newCategorieName);
        }

        if (existingCategorie != null && existingCategorie.equals(newCategorie)) {
            // L'article existe déjà dans la même catégorie, mettre à jour les attributs
            existingArticle.setTitre(updatedArticle.getTitre());
            existingArticle.setDescription(updatedArticle.getDescription());
            existingArticle.setDateCreation(updatedArticle.getDateCreation());
        } else {
            // Retirer l'article de l'ancienne catégorie s'il existe
            if (existingCategorie != null) {
                existingCategorie.getArticles().remove(existingArticle);
            }

            // Ajouter l'article à la nouvelle catégorie s'il existe
            if (newCategorie != null) {
                newCategorie.getArticles().add(existingArticle);
                existingArticle.setCategorie(newCategorie);
                existingArticle.setTitre(updatedArticle.getTitre());
                existingArticle.setDescription(updatedArticle.getDescription());
                existingArticle.setDateCreation(updatedArticle.getDateCreation());
            }
        }

        return articleRepository.saveAndFlush(existingArticle);
    }

    public void deleteOneCategorie(Long categorieId) {
        List<Article> articles = articleRepository.findByCategorie_Id(categorieId);
        for (Article article : articles) {
            articleRepository.delete(article);
        }
        categorieRepository.deleteById(categorieId);
    }


    public Article getLatest() {
        List<Article> articles = articleRepository.findAll(Sort.by(Sort.Direction.DESC, "dateCreation"));
        if (!articles.isEmpty()) {
            return articles.get(0);
        } else {
            return null;
        }
    }
}
