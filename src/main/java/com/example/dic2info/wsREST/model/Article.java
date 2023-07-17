package com.example.dic2info.wsREST.model;


import com.fasterxml.jackson.annotation.JsonIgnore;
import jakarta.persistence.*;
import jakarta.xml.bind.annotation.XmlAccessType;
import jakarta.xml.bind.annotation.XmlAccessorType;
import jakarta.xml.bind.annotation.XmlRootElement;
import lombok.*;
import org.springframework.web.bind.annotation.CrossOrigin;

import javax.validation.constraints.NotEmpty;
import java.io.Serializable;
import java.util.Date;


@Entity
@Table(name = "articles")
@AllArgsConstructor @NoArgsConstructor
@XmlRootElement(name = "artciles")
@XmlAccessorType(XmlAccessType.FIELD)
@CrossOrigin("http://localhost:80")
public class Article implements Serializable {
    @Id
    @GeneratedValue(strategy = GenerationType.IDENTITY)
    private Long id;

    private String titre;
    @Column(length = 2000)
    @NotEmpty(message = "Veuiller renseigner une description")
    @NonNull
    private String description;

    @Temporal(TemporalType.DATE)
    @Column(name = "dateCreation")
    private Date dateCreation;

    @Transient
    private transient String nomCategorie;

    @ManyToOne
    @JoinColumn(name = "categories_id")
    private Categorie categorie;

    public Long getId() {
        return id;
    }

    public void setId(Long id) {
        this.id = id;
    }

    public String getTitre() {
        return titre;
    }

    public void setTitre(String titre) {
        this.titre = titre;
    }

    public String getDescription() {
        return description;
    }

    public void setDescription(String description) {
        this.description = description;
    }

    public Date getDateCreation() {
        return dateCreation;
    }

    public void setDateCreation(Date dateCreation) {
        this.dateCreation = dateCreation;
    }

    public String getNomCategorie() {
        return nomCategorie;
    }

    public void setNomCategorie(String nomCategorie) {
        this.nomCategorie = nomCategorie;
    }

    public Categorie getCategorie() {
        return categorie;
    }

    public void setCategorie(Categorie categorie) {
        this.categorie = categorie;
    }

    @Override
    public String toString() {
        return "Article{" +
                "id=" + id +
                ", titre='" + titre + '\'' +
                ", description='" + description + '\'' +
                ", dateCreation=" + dateCreation +
                ", nomCategorie='" + nomCategorie + '\'' +
                '}';
    }
}
