package com.example.dic2info.wsSOAP;

import javax.jws.WebService;
import javax.jws.WebMethod;
import javax.swing.text.html.Option;
import javax.xml.namespace.QName;

import com.example.dic2info.wsSOAP.model.Role;
import com.example.dic2info.wsSOAP.model.User;
import com.example.dic2info.wsSOAP.repository.RoleRepository;
import com.example.dic2info.wsSOAP.repository.UserRepository;
import jakarta.xml.bind.JAXBElement;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;
import org.springframework.web.bind.annotation.RequestBody;
import org.springframework.ws.server.endpoint.annotation.Endpoint;

import org.springframework.ws.server.endpoint.annotation.PayloadRoot;
import org.springframework.ws.server.endpoint.annotation.ResponsePayload;

import java.util.List;
import java.util.Optional;

@Service
@WebService(serviceName = "UserService")
@Endpoint
public class UserService {
    @Autowired
    private UserRepository userRepository;

    @Autowired
    private RoleRepository roleRepository;

    @WebMethod
    @PayloadRoot(namespace = "http://localhost/user-schema", localPart = "GetAllUsersRequest")
    @ResponsePayload
    public List<User> getAllUsers() {
        return userRepository.findAll();
    }

    @WebMethod
    public User getUser(final Long id){
        return userRepository.findById(id).orElse(null);
    }

    @WebMethod
    public User createUser(@RequestBody User user){
        return  userRepository.save(user);
    }

    @WebMethod
    public List<Role> getAllRoles() {
        return roleRepository.findAll();
    }

    @WebMethod
    public void assignRoleToUser(Long userId, Long roleId) {
        User user = userRepository.findById(userId).orElseThrow(() -> new RuntimeException("User not found"));
        Role role = roleRepository.findById(roleId).orElseThrow(() -> new RuntimeException("Role not found"));

        user.getRoles().add(role);
        userRepository.save(user);
    }
}

