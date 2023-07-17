package com.example.dic2info.wsREST.repository;

import com.example.dic2info.wsREST.model.Article;
import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.data.jpa.repository.Modifying;
import org.springframework.data.jpa.repository.Query;
import org.springframework.data.repository.query.Param;
import org.springframework.stereotype.Repository;
import  java.util.List;
import java.awt.*;

@Repository
public interface ArticleRepository extends JpaRepository<Article, Long> {

    @Modifying
    @Query("delete from Article a where a.titre = :title")
    void deleteByTitle(@Param("title") String title);
    List<Article> findByCategorie_Id(Long id);
}
