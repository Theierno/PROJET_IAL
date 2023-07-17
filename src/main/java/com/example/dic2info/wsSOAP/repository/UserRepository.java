package com.example.dic2info.wsSOAP.repository;

import com.example.dic2info.wsSOAP.model.User;
import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.stereotype.Repository;

@Repository
public interface UserRepository extends JpaRepository<User, Long> {
}
