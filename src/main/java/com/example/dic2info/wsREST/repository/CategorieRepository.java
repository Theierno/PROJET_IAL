package com.example.dic2info.wsREST.repository;

import com.example.dic2info.wsREST.model.Article;
import com.example.dic2info.wsREST.model.Categorie;
import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.stereotype.Repository;

import java.util.List;

@Repository
public interface CategorieRepository extends JpaRepository<Categorie, Long> {
    Categorie findByNom(String nom);


}
