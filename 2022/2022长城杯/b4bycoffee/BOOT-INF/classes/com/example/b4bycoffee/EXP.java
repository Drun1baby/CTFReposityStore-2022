package b4bycoffee;

import com.sun.org.apache.xalan.internal.xsltc.trax.TemplatesImpl;
import com.sun.org.apache.xalan.internal.xsltc.trax.TransformerFactoryImpl;

import java.lang.reflect.Field;
import java.nio.file.Files;
import java.nio.file.Paths;

public class EXP {
    public static void main(String[] args) throws Exception {
        byte[] code = Files.readAllBytes(Paths.get("E:\\JavaClass\\TemplatesBytes.class"));
    }

    public static void setFieldValue(Object o, String fieldName, Object value) throws Exception {
        Class c = o.getClass();
        Field field = c.getDeclaredField(fieldName);
        field.setAccessible(true);
        field.set(o,value);
    }


}
