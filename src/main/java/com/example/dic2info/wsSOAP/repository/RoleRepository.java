package com.example.dic2info.wsSOAP.repository;

import com.example.dic2info.wsSOAP.model.Role;
import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.stereotype.Repository;

@Repository
public interface RoleRepository extends JpaRepository<Role, Long> {
}
