package com.bugku.ez_unserialize.controller;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RequestParam;
import org.springframework.web.bind.annotation.RestController;
import java.util.Base64;
import java.io.ByteArrayInputStream;
import java.io.IOException;
import java.io.ObjectInputStream;


@RestController

public class helloController {

    @RequestMapping("/hello{name}")
    public String hello(@RequestParam("name") String serialStr){
        try {
            deserialize(Base64.getDecoder().decode(serialStr)); //模拟存在反序列化的点
        } catch (IOException e) {
            e.printStackTrace();
            return "something is wrong";
        } catch (ClassNotFoundException e) {
            e.printStackTrace();
        }
        return "2333";
    }


    public  Object deserialize(final byte[] serialized) throws IOException, ClassNotFoundException {
        ByteArrayInputStream in = new ByteArrayInputStream(serialized);
        ObjectInputStream objIn = new ObjectInputStream(in);
        return objIn.readObject();
    }

}
