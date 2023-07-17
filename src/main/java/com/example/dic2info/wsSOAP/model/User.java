package com.example.dic2info.wsSOAP.model;


import jakarta.persistence.*;

import lombok.AllArgsConstructor;
import lombok.Data;
import lombok.NoArgsConstructor;

import java.io.Serializable;
import java.util.ArrayList;
import java.util.List;
import javax.xml.bind.annotation.XmlRootElement;

@Data
@Entity
@NoArgsConstructor @AllArgsConstructor
@Table(name = "users")
@XmlRootElement
public class User implements Serializable {
    @Id
    @GeneratedValue(strategy = GenerationType.IDENTITY)
    private Long id;
    private String username;
    private String password;

    private String token;

    @ManyToMany(fetch = FetchType.LAZY,
            cascade = {
                    CascadeType.PERSIST,
                    CascadeType.MERGE
            })
    @JoinTable(name = "user_role",
            joinColumns = @JoinColumn(name = "users_id"),
            inverseJoinColumns = @JoinColumn(name = "roles_id"))
    @Transient
    private List<Role> roles= new ArrayList<>();

    public User(String username, String password, String token, List<Role> roles) {
        this.username = username;
        this.password = password;
        this.token = token;
        this.roles = roles;
    }

    public User(String username, String password, String token) {
        this.username = username;
        this.password = password;
        this.token = token;
    }
}
