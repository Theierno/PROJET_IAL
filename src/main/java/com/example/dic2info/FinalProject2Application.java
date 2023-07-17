package com.example.dic2info;

import com.example.dic2info.wsSOAP.model.Role;
import com.example.dic2info.wsSOAP.model.User;
import com.example.dic2info.wsSOAP.repository.RoleRepository;
import com.example.dic2info.wsSOAP.repository.UserRepository;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.boot.CommandLineRunner;
import org.springframework.boot.SpringApplication;
import org.springframework.boot.autoconfigure.SpringBootApplication;
import org.springframework.boot.web.servlet.ServletRegistrationBean;
import org.springframework.context.ApplicationContext;
import org.springframework.context.annotation.Bean;
import org.springframework.context.annotation.ComponentScan;
import org.springframework.core.io.ClassPathResource;
import org.springframework.transaction.annotation.EnableTransactionManagement;
import org.springframework.ws.config.annotation.EnableWs;
import org.springframework.ws.transport.http.MessageDispatcherServlet;
import org.springframework.ws.wsdl.wsdl11.DefaultWsdl11Definition;
import org.springframework.xml.xsd.SimpleXsdSchema;
import org.springframework.xml.xsd.XsdSchema;

@ComponentScan(basePackages = {"com.example.dic2info.wsSOAP"})
@SpringBootApplication
@EnableTransactionManagement
@EnableWs
public class FinalProject2Application implements CommandLineRunner {
    @Autowired
    private UserRepository userRepository;

    @Autowired
    private RoleRepository roleRepository;

    public static void main(String[] args) {
        SpringApplication.run(FinalProject2Application.class, args);
    }

    @Override
    public void run(String... args) throws Exception {
        Role visiteur = new Role("VISITEUR");
        Role editeur = new Role("EDITEUR");
        Role administrateur = new Role("ADMINISTRATEUR");
        roleRepository.save(visiteur);
        roleRepository.save(editeur);
        roleRepository.save(administrateur);
    }


   @Bean
   public ServletRegistrationBean<MessageDispatcherServlet> messageDispatcherServlet(ApplicationContext applicationContext) {
       MessageDispatcherServlet servlet = new MessageDispatcherServlet();
       servlet.setApplicationContext(applicationContext);
       servlet.setTransformWsdlLocations(true);
       return new ServletRegistrationBean<>(servlet, "/ws/*");
   }

   @Bean(name = "UserWs")
   public DefaultWsdl11Definition defaultWsdl11Definition(XsdSchema usersSchema) {
       DefaultWsdl11Definition wsdl11Definition = new DefaultWsdl11Definition();
       wsdl11Definition.setPortTypeName("UserServicePort");
       wsdl11Definition.setLocationUri("/ws");
       wsdl11Definition.setTargetNamespace("http://localhost/user-schema");
       wsdl11Definition.setSchema(usersSchema);
       return wsdl11Definition;
   }

   @Bean(name = "UserRoleWs")
   public DefaultWsdl11Definition userroleWsdlDefinition(XsdSchema userRoleSchema) {
       DefaultWsdl11Definition wsdl11Definition = new DefaultWsdl11Definition();
       wsdl11Definition.setPortTypeName("RolePort");
       wsdl11Definition.setLocationUri("/ws");
       wsdl11Definition.setTargetNamespace("http://localhost/user-role-schema");
       wsdl11Definition.setSchema(userRoleSchema);
       return wsdl11Definition;
   }

   @Bean
   public XsdSchema userRoleSchema() {
       return new SimpleXsdSchema(new ClassPathResource("UserRole.xsd"));
   }

   @Bean
   public XsdSchema usersSchema() {
       return new SimpleXsdSchema(new ClassPathResource("User.xsd"));
   }
}
